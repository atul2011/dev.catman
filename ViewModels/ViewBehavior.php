<?php

namespace ViewModels;

use Quark\IQuarkViewResource;
use Quark\QuarkGenericViewResource;
use Quark\QuarkModel;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControlComponent;
use ViewModels\Content\Behaviors\ICreateView;
use ViewModels\Content\Behaviors\IListView;
<<<<<<< HEAD
=======
use ViewModels\Content\Behaviors\ILoader;
use ViewModels\Content\Behaviors\INavigationBar;
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4

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
			)) . $this->SearchWidget('/articles/link', 'POST', 'search', '')
			. $this->MenuWidgetItem('/admin/logout', 'SignOut', ' fa-sign-ou');
	}

	/**
	 * @return string
	 */
	public function PresenceMenuSide () {
		return $this->MenuSideWidget(array(
			$this->MenuWidgetItem('/admin/', 'Dashboard', 'fa-bars')
		, $this->MenuWidgetItem('/structures/categories', 'CategoryStructure', 'fa-align-left ')
		, $this->MenuWidgetItem('/article/list', 'Article', 'fa-edit')
		, $this->MenuWidgetItem('/category/list', 'Category', 'fa-edit')
		, $this->MenuWidgetItem('/author/list', 'Author', 'fa-edit')
		, $this->MenuWidgetItem('/event/list', 'Event', 'fa-edit')
		, $this->MenuWidgetItem('/user/list', 'User', 'fa-edit')
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
			$this instanceof ICreateView ? QuarkGenericViewResource::CSS(__DIR__ . '/../static/Content/Create/style.css') : null,
			$this instanceof ICreateView ? QuarkGenericViewResource::JS(__DIR__ . '/../static/Content/Create/script.js') : null,
			$this instanceof IListView ? QuarkGenericViewResource::CSS(__DIR__ . '/../static/Content/List/style.css') : null,
<<<<<<< HEAD
			$this instanceof IListView ? QuarkGenericViewResource::JS(__DIR__ . '/../static/Content/List/script.js') : null
=======
			$this instanceof IListView ? QuarkGenericViewResource::JS(__DIR__ . '/../static/Content/List/script.js') : null,
			$this instanceof INavigationBar ? QuarkGenericViewResource::CSS(__DIR__ . '/../static/Content/Mechanisms/NavigationBar/style.css') : null,
			$this instanceof INavigationBar ? QuarkGenericViewResource::JS(__DIR__ . '/../static/Content/Mechanisms/NavigationBar/script.js') : null,
			$this instanceof ILoader ? QuarkGenericViewResource::CSS(__DIR__ . '/../static/Content/Mechanisms/Loader/style.css') : null,
			$this instanceof ILoader ? QuarkGenericViewResource::JS(__DIR__ . '/../static/Content/Mechanisms/Loader/script.js') : null
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
			//$this instanceof IListView ? $this->GenericCSS() : null,
		);
	}
}