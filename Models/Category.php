<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;

/**
 * Class Category
 *
 * @property int $id
 * @property string $title
 * @property string $note
 * @property string $intro
 * @property string $sub
 * @property int    $priority
 * @property string $keywords
 * @property string $description
 *
 * @package AllModels
 */
class Category implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider,IQuarkModelWithCustomCollectionName ,IQuarkModelWithBeforeExtract, IQuarkModelWithDefaultExtract, IQuarkLinkedModel {
    /**
     * @return mixed
     */
    public function Fields() {
        return array(
            'id' => 0,
            'title' => '',
            'note' => '',
            'intro' => '',
            'sub' => '',
            'priority' =>0,
            'keywords' => '',
            'description' => ''
        );
    }

    /**
     * @return mixed
     */
    public function CollectionName() {
       return 'categories';
    }

    /**
     * @return mixed
     */
    public function Rules() {
        // TODO: Implement Rules() method.
    }

    /**
     * @return mixed
     */
    public function DataProvider() {
        return MP_DATA;
    }

    /**
     * @param array $fields
     * @param bool $weak
     *
     * @return mixed
     */
    public function BeforeExtract($fields, $weak) {
        $this->id = (string)$this->id;
        $this->priority = (string)$this->priority;
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
            'note',
            'intro',
            'sub',
            'priority',
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
        return QuarkModel::FindOneById(new Category(), $raw);
    }

    /**
     * @return mixed
     */
    public function Unlink() {
        return (string)$this->id;
    }

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return QuarkCollection|Category[]
     */
    public function ChildCategories($limit = 10, $offset = 0){
        /**
         * @var QuarkCollection|Categories_has_Categories[] $links
         */
        $links = QuarkModel::Find(new Categories_has_Categories(),array(
            'parent_id' => $this->id
        ),array(
            QuarkModel::OPTION_LIMIT => $limit,
            QuarkModel::OPTION_SKIP => $offset
        ));

        $out = new QuarkCollection(new Category());
        foreach ($links as $item){
            $out[] = $item->child_id1;
        }

        return $out;
    }
    /**
     * @param int $limit
     * @param int $offset
     *
     * @return QuarkCollection|Category[]
     */
    public function ParentCategories($limit = 10, $offset = 0){
        /**
         * @var QuarkCollection|Categories_has_Categories[] $links
         */
        $links = QuarkModel::Find(new Categories_has_Categories(),array(
            'child_id1' => $this->id
        ),array(
            QuarkModel::OPTION_LIMIT => $limit,
            QuarkModel::OPTION_SKIP => $offset
        ));

        $out = new QuarkCollection(new Category());
        foreach ($links as $item){
            $out[] = $item->parent_id;
        }

        return $out;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return QuarkCollection|Article[]
     */
    public function Articles($limit = 10, $offset = 0){
       /**
        * @var QuarkCollection|Articles_has_Categories[] $links
        */
       $links = QuarkModel::Find(new Articles_has_Categories(),array(
           'category_id' => $this->id
       ),array(
           QuarkModel::OPTION_LIMIT => $limit,
           QuarkModel::OPTION_SKIP => $offset
       ));

       $out = new QuarkCollection(new Article());
       foreach ($links as $item)
           $out[]= $item->article_id;

       return $out;
    }

	/**
	 * @return QuarkCollection|Tag[] $tags
	 */
    public function getTags(){
		/**
		 * @var QuarkCollection|Category_has_Tag[] $categories
		 */
		$categories = QuarkModel::Find(new Category_has_Tag(),array(
			'category_id' => $this->id
		));

		$tags = new QuarkCollection(new Tag());

		foreach ($categories as $item) {
			$tags[] = $item->tag_id;
		}

		return $tags;
	}

	/**
	 * @param $tags
	 *
	 * @return QuarkDTO
	 */
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
			//verify is that link exist
			/**
			 * @var QuarkModel|Category_has_Tag $category_has_tag
			 */
			$category_has_tag = QuarkModel::FindOne(new Category_has_Tag(),array(
				'category_id' => $this->id,
				'tag_id' => $tag->id
			));
			if($category_has_tag != null) continue;

			//if not, we create it
			$category_has_tag = new QuarkModel(new Category_has_Tag(),array(
				'category_id' => $this->id,
				'tag_id' => $tag->id
			));

			if(!$category_has_tag->Create())
				return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);

		}
		//check if user delete some tags from category
		/**
		 * @var QuarkCollection|Category_has_Tag[] $categories
		 */

		$categories = QuarkModel::Find(new Category_has_Tag(),array(
			'category_id' => $this->id
		));
		$saved_tags = array();
		foreach ($categories as $item)
			$saved_tags[] = $item->tag_id->name;

		foreach ($saved_tags as $item) {
			/**
			 * @var QuarkModel|Tag $tag
			 */
			$tag = QuarkModel::FindOne(new Tag(), array(
				'name' => $item
			));
			if (!in_array($item, $tags)) {
				QuarkModel::Delete(new Category_has_Tag(), array(
					'category_id' => $this->id,
					'tag_id' =>$tag->id
				));
			}
		}
	}
}