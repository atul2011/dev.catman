<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;
use Quark\IQuarkStrongModelWithRuntimeFields;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

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
 *
 * @package Models
 */
class Category implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider,IQuarkModelWithCustomCollectionName ,IQuarkModelWithBeforeExtract, IQuarkModelWithDefaultExtract, IQuarkLinkedModel, IQuarkStrongModelWithRuntimeFields {
    use QuarkModelBehavior;

    const TYPE_CATEGORY = 'F';
    const TYPE_SUBCATEGORY = 'T';
    const TYPE_ARCHIVE = 'A';
	const TYPE_SYSTEM_ROOT_CATEGORY = 'root-category';
	const TYPE_SYSTEM_TOP_MENU_CATEGORY = 'top-menu';
	const TYPE_SYSTEM_MAIN_MENU_CATEGORY = 'main-menu';
	const TYPE_SYSTEM_BOTTOM_MENU_CATEGORY = 'bottom-menu';

    const ROLE_SYSTEM = 'system';
    const ROLE_CUSTOM = 'custom';

    const SPECIALIZATION_SITE = 'site';
    const SPECIALIZATION_MOBILE = 'mobile';

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
			'runtime_category' => null
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
		    $this->LocalizedAssert(in_array($this->sub, array(self::TYPE_CATEGORY, self::TYPE_SUBCATEGORY, self::TYPE_SYSTEM_BOTTOM_MENU_CATEGORY, self::TYPE_SYSTEM_MAIN_MENU_CATEGORY, self::TYPE_SYSTEM_TOP_MENU_CATEGORY, self::TYPE_SYSTEM_ROOT_CATEGORY, self::TYPE_ARCHIVE)), 'Catman.Validation.Category.UnsupportedType', 'sub')
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
            'description',
            'role',
            'short_title',
            'master'
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
    public function ChildCategories($limit = 10, $offset = 0, $target = 'site'){
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

		    if ($target == 'site') {
		        if ($category->available_on_site != true)
		            continue;
		    } elseif ($target == 'api')
		        if ($category->available_on_api != true)
		            continue;

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
     * @param string $sort_field
     * @param int $limit
     * @param int $offset
     * @return QuarkCollection|Article[]
     */
    public function Articles($limit = 10, $offset = 0, $sort_field = 'title') {
	    $options = array();

	    if ($limit != 0) {
		    $options[QuarkModel::OPTION_LIMIT] = $limit;
		    $options[QuarkModel::OPTION_SKIP] = $offset;
	    }

	    /**
	     * @var QuarkCollection|Articles_has_Categories[] $links
	     */
	    $links = QuarkModel::Find(new Articles_has_Categories(), array('category_id' => $this->id), $options);
	    $out = new QuarkCollection(new Article());

	    foreach ($links as $item)
		    $out[] = $item->article_id->Retrieve();

	    return Article::Sort($out, $sort_field);
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
	 * @param QuarkCollection|Category[] $categories
	 * @param string $field
	 *
	 * @return QuarkCollection|Category[]
	 */
	public static function Sort (QuarkCollection $categories, $field = 'runtime_priority') {
		return $categories->Select(array(), array(
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

	public function GetMasterCategoryChilds () {
		/**
		 * @var QuarkModel|Category $master
		 */
		$master = $this->master ? $this : $this->GetMasterCategory();

		if ($master == null)
			return new QuarkCollection(new Category());

		return $master->ChildCategories(0);
	}
}