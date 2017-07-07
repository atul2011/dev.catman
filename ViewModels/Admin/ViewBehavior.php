<?php

namespace ViewModels\Admin;

use Quark\IQuarkViewResource;
use Quark\QuarkGenericViewResource;
use Quark\QuarkModel;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControlComponent;
use ViewModels\Admin\Content\Behaviors\ICreateView;
use ViewModels\Admin\Content\Behaviors\IListView;
use ViewModels\Admin\Content\Behaviors\ILoader;
use ViewModels\Admin\Content\Behaviors\INavigationBar;

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
		return 'Admin Panel';
	}

	/**
	 * @return string
	 */
	public function PresenceMenuHeader () {
		return $this->MenuHeaderWidget(array(
				$this->MenuWidgetItem('/', ' statistic', 'fa-area-chart')
			)) . $this->SearchWidget('/admin/articles/link', 'POST', 'search', '')
			. $this->MenuWidgetItem('/admin/user/logout', 'SignOut', ' fa-sign-ou');
	}

	/**
	 * @return string
	 */
	public function PresenceMenuSide () {
		return $this->MenuSideWidget(array(
			$this->MenuWidgetItem('/admin/user/', 'Dashboard', 'fa-bars')
		, $this->MenuWidgetItem('/admin/structures/categories', 'Structures', 'fa-align-left ')
		, $this->MenuWidgetItem('/admin/article/list', 'Article', 'fa-edit')
		, $this->MenuWidgetItem('/admin/category/list', 'Category', 'fa-edit')
		, $this->MenuWidgetItem('/admin/author/list', 'Author', 'fa-edit')
		, $this->MenuWidgetItem('/admin/event/list', 'Event', 'fa-edit')
		, $this->MenuWidgetItem('/admin/user/list', 'User', 'fa-edit')
		));
	}

	/**
	 * @param QuarkModel $user = null
	 *
	 * @return string
	 */
	public function PresenceUser (QuarkModel $user = null) {
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutStylesheet () {
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutController () {
		// TODO: Implement ViewLayoutController() method.
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewLayoutResources () {
		return array(
			$this instanceof ICreateView ? QuarkGenericViewResource::CSS(__DIR__ . '/../../static/Admin/Content/Create/style.css') : null,
			$this instanceof ICreateView ? QuarkGenericViewResource::JS(__DIR__ . '/../../static/Admin/Content/Create/script.js') : null,
			$this instanceof IListView ? QuarkGenericViewResource::CSS(__DIR__ . '/../../static/Admin/Content/List/style.css') : null,
			$this instanceof IListView ? QuarkGenericViewResource::JS(__DIR__ . '/../../static/Admin/Content/List/script.js') : null,
			$this instanceof INavigationBar ? QuarkGenericViewResource::CSS(__DIR__ . '/../../static/Admin/Content/Mechanisms/NavigationBar/style.css') : null,
			$this instanceof INavigationBar ? QuarkGenericViewResource::JS(__DIR__ . '/../../static/Admin/Content/Mechanisms/NavigationBar/script.js') : null,
			$this instanceof ILoader ? QuarkGenericViewResource::CSS(__DIR__ . '/../../static/Admin/Content/Mechanisms/Loader/style.css') : null,
			$this instanceof ILoader ? QuarkGenericViewResource::JS(__DIR__ . '/../../static/Admin/Content/Mechanisms/Loader/script.js') : null
		);
	}
}