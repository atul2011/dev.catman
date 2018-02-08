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
		, $this->MenuWidgetItem('/admin/category/list', 'Category', 'fa-list-ul')
		, $this->MenuWidgetItem('/admin/author/list', 'Author', 'fa-user-secret')
		, $this->MenuWidgetItem('/admin/event/list', 'Event', 'fa-birthday-cake')
		, $this->MenuWidgetItem('/admin/news/list', 'News', 'fa-bullhorn')
		, $this->MenuWidgetItem('/admin/user/list', 'User', 'fa-users')
		, $this->MenuWidgetItem('/admin/banner/list', 'Banner', 'fa-cc-discover')
		, $this->MenuWidgetItem('/admin/token/list', 'Token', 'fa-key')
		, $this->MenuWidgetItem('/admin/photo/list', 'Gallery', 'fa-file-photo-o')
		, $this->MenuWidgetItem('/admin/contact', 'Contact us', 'fa-phone')
		, $this->MenuWidgetItem('/admin/link/list', 'Link', 'fa-share-square')
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
			$this instanceof INavigationBar ? QuarkGenericViewResource::CSS(__DIR__ . '/../../static/Admin/Mechanisms/NavigationBar/index.css') : null,
			$this instanceof INavigationBar ? QuarkGenericViewResource::JS(__DIR__ . '/../../static/Admin/Mechanisms/NavigationBar/index.js') : null,
			$this instanceof ILoader ? QuarkGenericViewResource::CSS(__DIR__ . '/../../static/Admin/Mechanisms/Loader/index.css') : null,
			$this instanceof ILoader ? QuarkGenericViewResource::JS(__DIR__ . '/../../static/Admin/Mechanisms/Loader/index.js') : null
		);
	}
}