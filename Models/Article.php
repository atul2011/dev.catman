<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithAfterFind;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;
use Quark\IQuarkStrongModelWithRuntimeFields;
use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkLazyLink;
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
 * @property QuarkLazyLink|Author  $author_id
 * @property QuarkLazyLink|Event   $event_id
 * @property string $short_title
 * @property bool $available_on_site
 * @property bool $available_on_api
 * @property bool $master
 *
 * @property int $runtime_priority
 * @property int $runtime_category
 * @property int $runtime_link
 * @property int $master_category
 * @property string $grouped
 *
 * @package Models
 */
class Article implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithCustomCollectionName, IQuarkModelWithAfterFind ,IQuarkModelWithBeforeExtract, IQuarkModelWithDefaultExtract, IQuarkLinkedModel, IQuarkStrongModelWithRuntimeFields {
    use QuarkModelBehavior;

    const TYPE_ARTICLE = 'A';
    const TYPE_DECREE = 'D';
    const TYPE_ROSARY = 'R';
    const TYPE_QUESTION = 'Q';
    const TYPE_EXCERPT = 'E';
    const TYPE_MESSAGE = 'M';
    const TYPE_SYSTEM = 'S';

    const KEYWORDS_CONTACT_US = 'contact_us';

    /**
     * @return mixed
     */
    public function Fields() {
        return array(
            'id' => 0,
            'title' => '',
            'release_date' => QuarkDate::FromFormat('Y-m-d H:i'),
            'publish_date' => QuarkDate::FromFormat('Y-m-d'),
            'note' => '',
            'resume' => '',
            'txtfield' => '',
            'copyright' => '',
            'priority' => 0,
            'type' => self::TYPE_ARTICLE,
            'keywords' => '',
            'description' => '',
			'author_id' => $this->LazyLink(new Author(), 0),
			'event_id' => $this->LazyLink(new Event(), 0),
			'short_title' => '',
            'available_on_site' => true,
            'available_on_api' => false,
            'master' => false,
        );
    }

	/**
	 * @return mixed
	 */
	public function RuntimeFields () {
		return array(
			'runtime_priority' => 0,
			'runtime_category' => null,
			'runtime_link' => 0,
		    'master_category' => 0,
		    'grouped' => 'false',
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
		    $this->LocalizedAssert(in_array($this->type, array(self::TYPE_ARTICLE, self::TYPE_ROSARY, self::TYPE_DECREE, self::TYPE_QUESTION, self::TYPE_EXCERPT, self::TYPE_MESSAGE, self::TYPE_SYSTEM)), 'Catman.Validation.Article.UnsupportedType', 'type')
	    );
    }

    /**
     * @return mixed
     */
    public function DataProvider() {
        return CM_DATA;
    }

	/**
	 * @param $raw
	 * @param array $options
	 *
	 * @return mixed
	 */
	public function AfterFind ($raw, $options) {
		if (strlen($this->short_title) == 0)
			$this->short_title = substr($this->title, 0 , 20);
	}

	/**
     * @param array $fields
     * @param bool $weak
     *
     * @return mixed
     */
    public function BeforeExtract($fields, $weak) {
        $this->id = (string)$this->id;

	    if ($this->runtime_category != null) {
		    $this->grouped = QuarkModel::Count(new CategoryGroupItem(), array(
			    'category' => (string)$this->runtime_category,
			    'type' => CategoryGroupItem::TYPE_ARTICLE,
			    'target' => (string)$this->id
		    )) > 0 ? 'true' : 'false';
	    }
    }

    /**
     * @param array $fields
     * @param bool $weak
     *
     * @return mixed
     */
    public function DefaultExtract($fields, $weak) {
        if ($fields != null)
            return $fields;

        return array(
            'id',
            'title',
            'release_date',
            'publish_date',
            'note',
            'resume',
            'copyright',
            'txtfield',
            'priority',
            'type',
            'keywords',
            'description',
            'event_id',
            'author_id',
            'short_title',
            'available_on_site',
            'available_on_api',
            'master',
            'runtime_priority',
            'runtime_category',
            'runtime_link',
            'grouped'
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
     * @return QuarkCollection|Category[]
     */
    public function Categories(){

        /**
         * @var QuarkCollection|Articles_has_Categories[] $links
         */
        $links = QuarkModel::Find(new Articles_has_Categories(), array('article_id' => $this->id));

        $out = new QuarkCollection(new Category());

        foreach ($links as $item)
            $out[] = $item->category_id->Retrieve();

        return $out;
    }

	/**
	 * @return QuarkCollection|Tag[] $tags
	 */
    public function Tags(){
		/**
		 * @var QuarkCollection|Article_has_Tag[] $links
		 */
	    $links = QuarkModel::Find(new Article_has_Tag(), array('article_id' => $this->id));

		$tags = new QuarkCollection(new Tag());

		foreach ($links as $item)
			$tags[] = $item->tag_id->Retrieve();

		return $tags;
	}

	/**
	 * @return QuarkCollection|Photo
	 */
	public function Photos () {
		/**
		 * @var QuarkCollection|Article_has_Photo[] $links
		 */
		$links = QuarkModel::Find(new Article_has_Photo(), array('article' => $this->id));
		$photos = new QuarkCollection(new Photo());

		foreach ($links as $item)
			$photos[] = $item->photo->Retrieve();

		return $photos;
	}

	/**
	 * @param QuarkCollection|Article[] $articles
	 *
	 * @return QuarkCollection|Article[]
	 */
	public static function Minimize (QuarkCollection $articles) {
		return $articles->Select(array(), array(
			QuarkModel::OPTION_FIELDS => array(
				'id',
				'title',
				'release_date',
				'publish_date',
				'resume',
				'copyright',
				'priority',
				'type',
				'keywords',
				'description',
				'event_id',
				'author_id',
				'short_title',
				'available_on_api',
				'runtime_priority',
				'runtime_category',
				'runtime_link'
			)
		));
	}

	/**
	 * @return array
	 */
	public static function ArchiveSortTypes () {
		return array(
			'author_id' => 'Catman.Localization.Article.ArhiveSortType.Author',
			'event_id' => 'Catman.Localization.Article.ArhiveSortType.Event',
			'release_date' => 'Catman.Localization.Article.ArhiveSortType.RealeaseDate'
		);
	}

	public function RevealAll () {
		if ($this->event_id != null)
			$this->event_id = $this->event_id->Retrieve();

		if ($this->author_id != null)
			$this->author_id = $this->author_id->Retrieve();
	}

	/**
	 * @param int $year
	 *
	 * @return mixed
	 */
	public static function SearchByYearQuery ($year = 2017) {
		$query = array(
			'$and' => array(
				array('release_date' => array(
					'$gte' => $year . '-01-01'
				)),
				array('release_date' => array(
					'$lte' => ($year + 1) . '-01-01'
				))
			)
		);

		return $query;
	}

	/**
	 * @param QuarkModel|Category $category
	 *
	 * @return bool
	 */
	public function SetRuntimePriority ($category) {
		/**
		 * @var QuarkModel|Articles_has_Categories $relation
		 */
		$relation = QuarkModel::FindOne(new Articles_has_Categories(), array(
			'article_id' => $this->id,
			'category_id' => $category->id
		));

		if ($relation == null)
			return false;

		if ($relation->priority != null)
			$this->runtime_priority = $relation->priority;

		$this->runtime_category = $category->id;

		return true;
	}

	/**
	 * @return QuarkModel|Category $parent
	 */
	public function GetMasterCategory () {
		/**
		 * @var QuarkCollection|Category[] $parents
		 * @var QuarkModel|Category $master
		 */
		$parents = $this->Categories();

		$master = null;

		foreach ($parents as $parent)
			if ($parent->master) {
				$master = $parent;
				break;
			}

		if ($master == null) {
			foreach ($parents as $category) {
				/**
				 * @var QuarkCollection|Category[] $parent_categories
				 */
				$parent_categories = $category->ParentCategories();

				foreach ($parent_categories as $parent_category)
					if ($parent_category->master) {
						$master = $parent_category;
						break;
					}
			}
		}

		if ($master == null && $this->master_category > 0) {
			$master = QuarkModel::FindOneById(new Category(), $this->master_category);
		}

		return $master;
	}

	/**
	 * @param string $user
	 *
	 * @return QuarkCollection|Category[]
	 */
	public function GetMasterCategoryChildes ($user = '') {
		/**
		 * @var QuarkModel|Category $master
		 */
		$master = $this->GetMasterCategory();

		if ($master == null) {
			$bc = Breadcrumb::Get($user);

			if ($bc != null && $bc->FindItem('p', 'a', $this->id))
				$master = QuarkModel::FindOneById(new Category(), $bc->GetMasterId());
			else
				$master = new QuarkModel(new Category());
		}


		return $master->ChildCategories(0);
	}

	/**
	 * @return QuarkCollection|Article[]
	 */
	public function MasterArticles () {
		/**
		 * @var QuarkModel|Category $category
		 */
		$category = $this->GetMasterCategory();

		if ($category == null)
			return new QuarkCollection(new Article());

		return $category->Articles(array(
			QuarkModel::OPTION_SORT => array('runtime_priority' => QuarkModel::SORT_ASC)
		))->Select(array('master' => true));
	}

	/**
	 * @param int $id
	 */
	public function SetMasterCategory ($id = 0) {
		$this->master_category = $id;
	}
}