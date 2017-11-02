<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;
use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

/**
 * Class Article
 *
 * @property int $id
 * @property string $title
 * @property QuarkDate $release_date
 * @property QuarkDate $publish_date
 * @property string  $note
 * @property string  $resume
 * @property string  $txtfield
 * @property string  $copyright
 * @property int  $priority
 * @property string  $type
 * @property string  $keywords
 * @property string  $description
 * @property Author  $author_id
 * @property Event   $event_id
 *
 * @package AllModels
 */
class Article implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider,IQuarkModelWithCustomCollectionName ,IQuarkModelWithBeforeExtract, IQuarkModelWithDefaultExtract, IQuarkLinkedModel {
    use QuarkModelBehavior;

    const TYPE_ARTICLE = 'A';
    const TYPE_DECREE = 'D';
    const TYPE_ROSARY = 'R';
    const TYPE_QUESTION = 'Q';
    const TYPE_EXCERPT = 'E';

    /**
     * @return mixed
     */
    public function Fields() {
        return array(
            'id' => 0,
            'title' => '',
            'release_date' => QuarkDate::FromFormat('Y-m-d'),
            'publish_date' => QuarkDate::FromFormat('Y-m-d'),
            'note' => '',
            'resume' => '',
            'txtfield' => '',
            'copyright' => '',
            'priority' => 0,
            'type' => self::TYPE_ARTICLE,
            'keywords' => '',
            'description' => '',
			'author_id' => new Author(),
			'event_id' => new Event()
        );
    }

    /**
     * @return mixed
     */
    public function CollectionName() {
        return 'articles';
    }

    /**
     * @return mixed
     */
    public function Rules() {
	    return array(
		    $this->LocalizedAssert(in_array($this->type, array(self::TYPE_ARTICLE, self::TYPE_ROSARY, self::TYPE_DECREE, self::TYPE_QUESTION, self::TYPE_EXCERPT)), 'Catman.Validation.Article.UnsupportedType', 'type')
	    );
    }

    /**
     * @return mixed
     */
    public function DataProvider() {
        return CM_DATA;
    }

    /**
     * @param array $fields
     * @param bool $weak
     *
     * @return mixed
     */
    public function BeforeExtract($fields, $weak) {
        $this->id = (string)$this->id;
    }

    /**
     * @param array $fields
     * @param bool $weak
     *
     * @return mixed
     */
    public function DefaultExtract($fields, $weak) {
        if($fields != null) return $fields;
        return array(
            'id',
            'title',
            'release_date',
            'publish_date',
            'note',
            'resume',
            'txtfield',
            'copyright',
            'priority',
            'type',
            'keywords',
            'description'
        );
    }

    /**
     * @param $raw
     *
     * @return mixed
     */
    public function Link($raw) {
        return QuarkModel::FindOneById(new Article(), $raw);
    }

    /**
     * @return mixed
     */
    public function Unlink()    {
        return (string)$this->id;
    }
    /**
     * @param int $limit
     * @param int $offset
     *
     * @return QuarkCollection|Category[]
     */
    public function Categories($limit = 10, $offset = 0){
        /**
         * @var QuarkCollection|Articles_has_Categories[] $links
         */
        $links = QuarkModel::Find(new Articles_has_Categories(),array(
            'article_id' => $this->id
        ),array(
            QuarkModel::OPTION_LIMIT => $limit,
            QuarkModel::OPTION_SKIP => $offset
        ));

        $out = new QuarkCollection(new Category());
        foreach ($links as $item){
            $out[] = $item->category_id;
        }

        return $out;
    }

	/**
	 * @return array|QuarkCollection
	 */
    public function getTags(){
		/**
		 * @var QuarkCollection|Articles_has_Categories[] $articles
		 */
		$articles = QuarkModel::Find(new Article_has_Tag(),array(
			'article_id' => $this->id
		));

		$tags = new QuarkCollection(new Tag());

		foreach ($articles as $item) {
			$tags[] = $item->tag_id;
		}

		return $tags;
	}

	public function setTags($tags){
		foreach ($tags  as $item) {
			if(trim($item,' ') == '')continue;
			/**
			 * @var QuarkModel|Tag $tag
			 */
			$tag = QuarkModel::FindOne(new Tag(), array(
				'name' => $item
			));

			if ($tag === null) {
				$tag = new QuarkModel(new Tag());
				$tag->name = $item;

				if (!$tag->Create())
					return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);
			}
			/**
			 * @var QuarkModel|Article_has_Tag $article_has_tag
			 */
			$article_has_tag = QuarkModel::FindOne(new Article_has_Tag(),array(
				'article_id' => $this->id,
				'tag_id' => $tag->id
			));
			if($article_has_tag != null) continue;

			$article_has_tag = new QuarkModel(new Article_has_Tag(),array(
				'article_id' => $this->id,
				'tag_id' => $tag->id
			));
			if(!$article_has_tag->Create())
				return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);

		}

		//check if user delete some tags from category
		/**
		 * @var QuarkCollection|Article_has_Tag[] $articles
		 */

		$articles = QuarkModel::Find(new Article_has_Tag(),array(
			'article_id' => $this->id
		));
		$saved_tags = array();
		foreach ($articles as $item)
			$saved_tags[] = $item->tag_id->name;

		foreach ($saved_tags as $item) {
			/**
			 * @var QuarkModel|Tag $tag
			 */
			$tag = QuarkModel::FindOne(new Tag(), array(
				'name' => $item
			));
			if (!in_array($item, $tags)) {
				QuarkModel::Delete(new Article_has_Tag(), array(
					'article_id' => $this->id,
					'tag_id' =>$tag->id
				));
			}
		}
	}

	/**
	 * @param QuarkCollection|Article[] $categories
	 * @param string $field
	 *
	 * @return QuarkCollection|Article[]
	 */
	public static function Sort (QuarkCollection $categories, $field = 'priority') {
		return $categories->Select(array(), array(QuarkModel::OPTION_SORT => array($field => QuarkModel::SORT_ASC)));
	}
}