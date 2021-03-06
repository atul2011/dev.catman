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
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;
use Quark\QuarkLazyLink;

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
 * @property string $role
 * @property string $short_title
 * @property bool $available_on_site
 * @property bool $available_on_api
 * @property bool $master
 *
 * @property int $runtime_priority
 * @property int $runtime_category
 * @property int $runtime_link
 * @property string $has_links
 * @property string $grouped
 *
 * @package Models
 */
class Category implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider,IQuarkModelWithCustomCollectionName ,IQuarkModelWithBeforeExtract, IQuarkModelWithDefaultExtract, IQuarkModelWithAfterFind, IQuarkLinkedModel, IQuarkStrongModelWithRuntimeFields {
    use QuarkModelBehavior;

    const TYPE_CATEGORY = 'F';
    const TYPE_SUBCATEGORY = 'T';
    const TYPE_ARCHIVE = 'A';
    const TYPE_QNA = 'QNA';
	const TYPE_SYSTEM_ROOT_CATEGORY = 'root-category';
	const TYPE_SYSTEM_TOP_MENU_CATEGORY = 'top-menu';
	const TYPE_SYSTEM_MAIN_MENU_CATEGORY = 'main-menu';
	const TYPE_SYSTEM_BOTTOM_MENU_CATEGORY = 'bottom-menu';
	const TYPE_NEW = 'new';

    const ROLE_SYSTEM = 'system';
    const ROLE_CUSTOM = 'custom';

    const ARCHIVE_SORT_AUTHOR = 'author_id';
    const ARCHIVE_SORT_EVENT = 'event_id';
    const ARCHIVE_SORT_DATE = 'release_date';

    /**
     * @return mixed
     */
    public function Fields() {
        return array(
            'id' => 0,
            'title' => '',
            'note' => '',
            'intro' => '',
            'sub' => self::TYPE_CATEGORY,
            'priority' => 0,
            'keywords' => '',
            'description' => '',
            'role' => self::ROLE_CUSTOM,
            'master' => false,
            'available_on_site' => true,
            'available_on_api' => false,
            'short_title' => ''
        );
    }

	/**
	 * @return mixed
	 */
	public function RuntimeFields () {
		return array(
			'runtime_priority' => null,
			'runtime_category' => null,
			'runtime_link' => 0,
		    'has_links' => 'false',
		    'grouped' => 'false'
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
	    return array(
		    $this->LocalizedAssert(in_array($this->role, array(self::ROLE_CUSTOM, self::ROLE_SYSTEM)), 'Catman.Validation.Category.UnsupportedRole', 'role'),
		    $this->LocalizedAssert(in_array($this->sub, array(self::TYPE_CATEGORY, self::TYPE_QNA, self::TYPE_NEW, self::TYPE_SUBCATEGORY, self::TYPE_SYSTEM_BOTTOM_MENU_CATEGORY, self::TYPE_SYSTEM_MAIN_MENU_CATEGORY, self::TYPE_SYSTEM_TOP_MENU_CATEGORY, self::TYPE_SYSTEM_ROOT_CATEGORY, self::TYPE_ARCHIVE)), 'Catman.Validation.Category.UnsupportedType', 'sub')
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
        $this->priority = (string)$this->priority;
        $this->has_links = $this->HasLinks() ? 'true' : 'false';

        if ($this->runtime_category != null) {
	        $this->grouped = QuarkModel::Count(new CategoryGroupItem(), array(
                'category' => (string)$this->runtime_category,
                'type' => CategoryGroupItem::TYPE_CATEGORY,
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
        if ($fields != null) return $fields;

        return array(
            'id',
            'title',
            'note',
            'intro',
            'sub',
            'priority',
            'keywords',
            'description',
            'role',
            'short_title',
            'master',
            'available_on_api',
            'runtime_priority',
            'runtime_category',
            'runtime_link',
            'has_links'
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
     * @param string $target
     *
     * @return QuarkCollection|Category[]
     */
    public function ChildCategories($limit = 0, $offset = 0, $target = 'site'){
        $options = array();

        if ($limit != 0) {
	        $options[QuarkModel::OPTION_LIMIT] = $limit;
	        $options[QuarkModel::OPTION_SKIP] = $offset;
        }

	    $options[QuarkModel::OPTION_SORT] = array('priority' => QuarkModel::SORT_ASC);

        /**
         * @var QuarkCollection|Categories_has_Categories[] $links
         */
        $links = QuarkModel::Find(new Categories_has_Categories(), array('parent_id' => (string)$this->id), $options);
	    $out = new QuarkCollection(new Category());

	    foreach ($links as $link) {
		    /**
		     * @var QuarkModel|Category $category
		     */
		    $category = $link->child_id1->Retrieve();
		    $category->SetRuntimePriority(new QuarkModel($this));
		    $category->runtime_link = $link->id;

		    if ($target == 'site') {
		        if ($category->available_on_site != true)
		            continue;
		    }
		    elseif ($target == 'api') {
		        if ($category->available_on_api != true)
		            continue;
		    }

		    $out[] = $category;
	    }

	    return Category::Sort($out);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $target
     *
     * @return QuarkCollection|Category[]
     */
    public function ParentCategories($limit = 10, $offset = 0, $target = 'site') {
	    $options = array();

	    if ($limit != 0) {
		    $options[QuarkModel::OPTION_LIMIT] = $limit;
		    $options[QuarkModel::OPTION_SKIP] = $offset;
	    }

        /**
         * @var QuarkCollection|Categories_has_Categories[] $links
         */
        $links = QuarkModel::Find(new Categories_has_Categories(), array('child_id1' => $this->id), $options);

        $out = new QuarkCollection(new Category());

        foreach ($links as $item) {
	        /**
	         * @var QuarkModel|Category $category
	         */
	        $category = $item->parent_id->Retrieve();

	        if ($target == 'site') {
		        if ($category->available_on_site != true)
			        continue;
	        } elseif ($target == 'api')
		        if ($category->available_on_api != true)
			        continue;

	        $out[] = $category;
        }
        return $out;
    }

    /**
     * @param array $options
     *
     * @return QuarkCollection|Article[]
     */
    public function Articles($options = array()) {
	    /**
	     * @var QuarkCollection|Articles_has_Categories[] $links
	     */
	    $links = QuarkModel::Find(new Articles_has_Categories(), array('category_id' => $this->id));
		//$links = QuarkModel::Find(new Articles_has_Categories(), array('new_' => 1));
//echo "id ".$this->id;
//echo "<br>";	    
//print_r($links);
	    $articles = new QuarkCollection(new Article());
		//echo "aaa";
		//print_r($articles);
		//exit;
	    foreach ($links as $item) {
		    /**
		     * @var QuarkModel|Article $article
		     */
		    $article = $item->article_id->Retrieve();
		    $article->SetRuntimePriority($this);
		    $article->runtime_link = $item->id;
		    $articles[] = $article;
	    }

	    return Article::Minimize($articles)->Select(array(), $options);
    }

	/**
	 * @param QuarkCollection|Article[] $articles
	 *
	 * @return QuarkCollection|Article[] $articles
	 */
    public function ApiArticles (QuarkCollection $articles) {
        $out = new QuarkCollection(new Article());

        foreach ($articles as $article)
            if ($article->available_on_api)
                $out[] = $article;

	    return $out;
    }

	/**
	 * @return QuarkCollection|Article[]
	 */
    public function MasterArticles () {
    	return $this->Articles(array(
    		QuarkModel::OPTION_SORT => array('runtime_priority' => QuarkModel::SORT_ASC)
	    ))->Select(array('master' => true));
    }

	/**
	 * @param QuarkCollection|Category[] $categories
	 *
	 * @return QuarkCollection|Category[] $categories
	 */
    public function ApiCategories (QuarkCollection $categories) {
        $out = new QuarkCollection(new Category());

        foreach ($categories as $category)
            if ($category->available_on_api)
                $out[] = $category;

	    return $out;
    }

	/**
	 * @return QuarkCollection|Tag[] $tags
	 */
    public function Tags() {
		/**
		 * @var QuarkCollection|Category_has_Tag[] $categories
		 */
		$categories = QuarkModel::Find(new Category_has_Tag(), array('category_id' => $this->id));

		$tags = new QuarkCollection(new Tag());

		foreach ($categories as $item)
			$tags[] = $item->tag_id->Retrieve();

		return $tags;
	}

	/**
	 * @return QuarkCollection|Photo
	 */
	public function Photos () {
		/**
		 * @var QuarkCollection|Category_has_Photo[] $links
		 */
		$links = QuarkModel::Find(new Category_has_Photo(), array('category' => $this->id));

		$photos = new QuarkCollection(new Photo());

		foreach ($links as $item)
			$photos[] = $item->photo->Retrieve();

		return $photos;
	}

	/**
	 * @return mixed
	 */
	public static function RootCategory () {
		return QuarkModel::FindOne(new Category(), array('sub' => self::TYPE_SYSTEM_ROOT_CATEGORY));
	}

	/**
	 * @return mixed
	 */
	public static function TopMenuCategory () {
		return QuarkModel::FindOne(new Category(), array('sub' => self::TYPE_SYSTEM_TOP_MENU_CATEGORY));
	}

	/**
	 * @return QuarkCollection|Category[]
	 */
	public static function TopMenuSubCategories () {
		return self::TopMenuCategory()->ChildCategories(0);
	}

	/**
	 * @return mixed
	 */
	public static function MainMenuCategory () {
		return QuarkModel::FindOne(new Category(), array('sub' => self::TYPE_SYSTEM_MAIN_MENU_CATEGORY));
	}

	/**
	 * @return QuarkCollection|Category[]
	 */
	public static function MainMenuSubCategories () {
		return self::MainMenuCategory()->ChildCategories(0);
	}

	/**
	 * @return mixed
	 */
	public static function BottomMenuCategory () {
		return QuarkModel::FindOne(new Category(), array('sub' => self::TYPE_SYSTEM_BOTTOM_MENU_CATEGORY));
	}

	/**
	 * @return QuarkCollection|Category[]
	 */
	public static function BottomMenuSubCategories () {
		return self::BottomMenuCategory()->ChildCategories(0);
	}

	/**
	 * @return QuarkModel|Category
	 */
	public static function NewCategory () {
		/**
		 * @var QuarkModel|Category $category
		 */
		$category = QuarkModel::FindOne(new Category(), array('sub' => self::TYPE_NEW));

		if ($category == null) {
			$category = new QuarkModel(new Category());
			$category->title = 'new';
			$category->sub = self::TYPE_NEW;
			$category->role = self::ROLE_SYSTEM;
			$category->available_on_api = true;
			$category->available_on_site = true;

			if (!$category->Create())
				return null;
		}

		return $category;
	}

	/**
	 * @return QuarkCollection|Article[]
	 */
	public static function NewCategorySubArticles() {
		/**
		 * @var QuarkCollection|Article[] $articles
		 */
		//echo $this->id;
		$articles = QuarkModel::Find(new Article(), array(
			'release_date' => array('$gte' => QuarkDate::GMTNow()->Offset('-183 days')->Format('Y-m-d')),
		), array(
			QuarkModel::OPTION_FIELDS => array('id', 'title', 'short_title', 'release_date', 'publish_date'),
			QuarkModel::OPTION_SORT => array(
				'release_date' => QuarkModel::SORT_DESC,
				'publish_date' => QuarkModel::SORT_DESC,
				'title' => QuarkModel::SORT_ASC
			)
		));

		return $articles;
	}
	public static function NewCategoryNewArticles($cid) {
                /**
                 * @var QuarkCollection|Article[] $articles
                 */
		$type = '';
		if($cid==462){
			$type = "A";
		}else if($cid==461){
			$type = "Q";
		}else if($cid==460){
			$type = "M";
		}else{
			//$type = "";
		}
                $articles = QuarkModel::Find(new Article(), array(
                        'publish_date' => array('$gte' => QuarkDate::GMTNow()->Offset('-730 days')->Format('Y-m-d')),
			'new_' => '1',
			'type' => $type
                ), array(
                        QuarkModel::OPTION_FIELDS => array('id', 'title', 'short_title', 'release_date', 'publish_date', 'event_id', 'type', 'author_id'),
                        QuarkModel::OPTION_SORT => array(
                                'release_date' => QuarkModel::SORT_ASC,
                                //'publish_date' => QuarkModel::SORT_DESC,
                                //'title' => QuarkModel::SORT_ASC
                        )
                ));
		//print_r($articles);exit;
                return $articles;
        }
	/**
	 * @param QuarkCollection|Category[] $categories
	 * @param string $field
	 *
	 * @return QuarkCollection|Category[]
	 */
	public static function Sort (QuarkCollection $categories, $field = 'runtime_priority') {
		return $categories->Select(array(), array(
			QuarkModel::OPTION_FIELDS => array(
				'id'
			),
			QuarkModel::OPTION_SORT => array(
				$field => QuarkModel::SORT_ASC,
				'title' => QuarkModel::SORT_ASC
			)
		));
	}


	/**
	 * @param QuarkModel|Category $category
	 *
	 * @return bool
	 */
	public function SetRuntimePriority (QuarkModel $category) {
		/**
		 * @var QuarkModel|Categories_has_Categories $relation
		 */
		$relation = QuarkModel::FindOne(new Categories_has_Categories(), array(
			'child_id1' => $this->id,
			'parent_id' => $category->id
		), array(
            QuarkModel::OPTION_SORT => array('priority' => QuarkModel::SORT_ASC)
        ));

		if ($relation == null)
			return false;

		if ($relation->priority != null)
			$this->runtime_priority = $relation->priority;
		elseif ($this->priority != null)
			$this->runtime_priority = $this->priority;
		else
			$this->runtime_priority = 0;

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
		$parents = $this->ParentCategories();
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
		$master = $this->master ? $this : $this->GetMasterCategory();

		if ($master == null) {
			$bc = Breadcrumb::Get($user);

			if ($bc != null && $bc->FindItem('p', 'c', $this->id))
				$master = QuarkModel::FindOneById(new Category(), $bc->GetMasterId());
			else
				$master = new QuarkModel(new Category());
		}

		return $master->ChildCategories(0);
	}

	/**
	 * @return array|QuarkCollection
	 */
	public function Groups () {
		return QuarkModel::Find(new CategoryGroup(), array('category' => (string)$this->id), array(
			QuarkModel::OPTION_SORT => array('priority' => QuarkModel::SORT_DESC)
		));
	}

	/**
	 * @return bool
	 */
	public function HasLinks () {
		return (QuarkModel::Count(new Categories_has_Categories(), array('parent_id' => (string)$this->id)) > 0) || (QuarkModel::Count(new Articles_has_Categories(), array('category_id' => (string)$this->id)) > 0);
	}
}
