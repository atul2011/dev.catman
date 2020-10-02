<?php
namespace ViewModels\Admin;

use Models\User;
use Quark\IQuarkViewResource;
use Quark\QuarkGenericViewResource;
use Quark\QuarkModel;
use Quark\ViewResources\jQuery\jQueryCore;
use Quark\ViewResources\Quark\QuarkControls\QuarkControls;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControlComponent;
use ViewModels\Admin\Behaviors\ILoader;
use ViewModels\Admin\Behaviors\INavigationBar;
use ViewResources\Fonts\OpenSans;

/**
 * Class ViewBehavior
 *
 * @package ViewModels\Admin
 */
trait ViewBehavior {
	use QuarkPresenceControlComponent;

	/**
	 * @return string
	 */
	public function PresenceOverlaidContainer () {
		// TODO: Implement PresenceOverlaidContainer() method.
	}

	/**
	 * @return string
	 */
	public function PresenceLogo () {
		return 'Universal Path Admin Panel';
	}

	/**
	 * @return string
	 */
	public function PresenceMenuHeader () {
		return $this->MenuHeaderWidget(array());
	}

	/**
	 * @return string
	 */
	public function PresenceMenuSide () {
		return $this->MenuSideWidget(array(
			$this->MenuWidgetItem('/admin/', 'Dashboard', 'fa-bars')
		, $this->MenuWidgetItem('/admin/structures/categories', 'Structures', 'fa-align-left ')
		, $this->MenuWidgetItem('/admin/article/list', 'Article', 'fa-file-text-o')
		, $this->MenuWidgetItem('/admin/author/list', 'Author', 'fa-user-secret')
		, $this->MenuWidgetItem('/admin/banner/list', 'Banner', 'fa-cc-discover')
		, $this->MenuWidgetItem('/admin/category/list', 'Category', 'fa-list-ul')
		, $this->MenuWidgetItem('/admin/contact', 'Contact us', 'fa-phone')
		, $this->MenuWidgetItem('/admin/event/list', 'Event', 'fa-birthday-cake')
		, $this->MenuWidgetItem('/admin/link/list', 'Link', 'fa-share-square')
		, $this->MenuWidgetItem('/admin/news/list', 'News', 'fa-bullhorn')
		, $this->MenuWidgetItem('/admin/notification/list', 'Notification', 'fa-bell')
		, $this->MenuWidgetItem('/admin/photo/list', 'Gallery', 'fa-file-photo-o')
		, $this->MenuWidgetItem('/admin/term/list', 'Terms', 'fa-bold')
		, $this->MenuWidgetItem('/admin/token/list', 'Token', 'fa-key')
		, $this->MenuWidgetItem('/admin/user/list', 'User', 'fa-users')
		, $this->MenuWidgetItem('/admin/settings/list', 'Settings', 'fa-cog')
		));
	}

	/**
	 * @param QuarkModel $user = null
	 *
	 * @return string
	 */
	public function PresenceUser (QuarkModel $user = null) {
		/**
		 * @var QuarkModel|User $user
		 */
		if ($this->User() == null)
			return '';

		return $this->UserWidget( $user->email, '', 'Logout', '/admin/user/logout');
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewLayoutResources () {
		return array(
			new jQueryCore(),
			new QuarkControls(),
			new OpenSans(),
			$this instanceof INavigationBar ? QuarkGenericViewResource::CSS(__DIR__ . '/../../static/Admin/Mechanisms/NavigationBar/index.css') : null,
			$this instanceof INavigationBar ? QuarkGenericViewResource::JS(__DIR__ . '/../../static/Admin/Mechanisms/NavigationBar/index.js') : null,
			$this instanceof ILoader ? QuarkGenericViewResource::CSS(__DIR__ . '/../../static/Admin/Mechanisms/Loader/index.css') : null,
			$this instanceof ILoader ? QuarkGenericViewResource::JS(__DIR__ . '/../../static/Admin/Mechanisms/Loader/index.js') : null
		);
	}


	/**
	 * @param int $number_of_pages
	 * @param int $current_page
	 *
	 * @return string
	 */
	public function NavigationBar ($number_of_pages = 1, $current_page = 1) {
		if ($number_of_pages <= 1)
			return '';

		$dots_link = '<a class="navbar-page navbar-static-page navbar-page-disabled"> . . . </a>';//set default dots-page
		$dots_page_before = $current_page > 3 ? ($number_of_pages > 5 ? $dots_link : '') : ''; //dots before num.pages
		$dots_page_after = $current_page < ($number_of_pages - 3)  ? ($number_of_pages > 5 ? $dots_link : '') : '';//dots after
		$first_page_class = $current_page == 1 ? 'navbar-page-disabled' : '';//set navbar first-page link css-class
		$last_page_class = $current_page == $number_of_pages ? 'navbar-page-disabled' : '';//set navbar last-page link css-class

		$first_numbered_page = $current_page <= 5 && $number_of_pages <= 5
			? 1
			: (($current_page - 2) >= 1 ? $current_page - 2 : 1);//set numbered pages delimitation for first numbered page

		$last_numbered_page = $current_page <= 5 && $number_of_pages <= 5
			? $number_of_pages
			:(($current_page + 2) <= $number_of_pages ? $current_page + 2 : $number_of_pages);//set numbered pages delimitation for last numbered page

		//----------------------------------------------------------------------------------------------------
		//create navigation bar
		$navbar = '<a class="navbar-page navbar-static-page navbar-first-page '. $first_page_class .' fa-angle-double-left"><input type="hidden" class="cm-list-page" value="1"></a>';//set first-page-link
		$navbar .= $dots_page_before;//set dots-page-link between last-page-link and numbered-page-link

		for ($iterator = $first_numbered_page; $iterator <= $last_numbered_page; $iterator++) {//set numbered-page-links
			$button_class = $iterator == $current_page ? 'current-page navbar-page-disabled' : '';
			$navbar .= '<a class="navbar-page navbar-numbered-page '. $button_class .'"><input type="hidden" class="cm-list-page" value="' . $iterator . '">' . $iterator . '</a>';
		}

		$navbar .= $dots_page_after;//set dots-page-link between last-page-link and numbered-page-link
		$navbar .= '<a class="navbar-page navbar-static-page navbar-last-page '. $last_page_class .' fa-angle-double-right"><input type="hidden" class="cm-list-page" value="' . $number_of_pages . '"></a>';//set last-page-link

		return $navbar;
	}
}
