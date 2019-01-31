<?php
namespace Services;

use Models\Article;
use Models\Breadcrumb;
use Models\Category;
use Quark\Quark;
use Quark\QuarkModel;

trait ServicesBehavior {
	/**
	 * @param $content
	 * @param string $target_type = 'c' => category & 'a' => article
	 *
	 * @return mixed
	 */
	public function GetRelatedItems ($content, $target_type = 'c') {
		$target = $target_type == 'c' ? 'category' : 'article';
		preg_match_all('#href=\"\/' . $target . '\/([0-9]+)\"#Uis', $content, $values);

		if (sizeof($values) != 2)
			return array();

		return $values[1];
	}

	/**
	 * @param QuarkModel|Breadcrumb $breadcrumb
	 * @param string $content
	 */
	public function SetFutureBreadcrumbs (QuarkModel $breadcrumb, $content) {
		$related_categories = $this->GetRelatedItems($content, 'c');
		$related_articles = $this->GetRelatedItems($content, 'a');

		foreach ($related_categories as $key => $item) {
			if (!$breadcrumb->FindItem('c', 'c', $item))
				$breadcrumb->SetChild('c', $item);
		}

		foreach ($related_articles as $key => $item) {
			if (!$breadcrumb->FindItem('c', 'a', $item))
				$breadcrumb->SetChild('a', $item);
		}

		$breadcrumb->Save();
	}

	/**
	 * @param string $user
	 * @param QuarkModel|Category $category
	 * @param QuarkModel|Article $article
	 *
	 * @return bool
	 */
	public function SetUserBreadcrumb ($user, QuarkModel $category = null, QuarkModel $article = null) {
		if ($category == null && $article == null)
			return false;

		/**
		 * @var QuarkModel|Category $master
		 * @var QuarkModel|Breadcrumb $breadcrumb
		 */
		$is_in_master = false;
		$master = $category != null ? $category->GetMasterCategory() : $article->GetMasterCategory();
		$content = $category != null ? $category->intro : $article->txtfield;
		$id = $category != null ? $category->id : $article->id;
		$type = $category != null ? 'c' : 'a';

		if ($master != null) {
			$is_in_master  = true;
			Breadcrumb::Set($user, $master->id, $type, $id);
		}
		else {
			$breadcrumb = Breadcrumb::Get($user);

			if (isset($breadcrumb) && $breadcrumb->FindItem('c', $type, $id)) {
				$is_in_master = true;
				Breadcrumb::Set($user, -1, $type,  $id);
			}
		}

		if ($is_in_master)
			$this->SetFutureBreadcrumbs(Breadcrumb::Get($user), $content);
	}
}