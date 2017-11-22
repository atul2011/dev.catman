<?php
namespace Services\Admin\Category\Relation;

use Models\Article;
use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class ArticlesService
 *
 * @package Services\Admin\Category\Relation
 */
class ArticlesService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Category $category
		 */
		$category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(4));

		if ($category == null)
			return array('status' => 404);

		/**
		 * @var QuarkCollection|Article[] $articles
		 */
		$articles = $category->Articles();
		$out = new QuarkCollection(new Article());

		foreach ($articles as $article) {
			$article->SetRuntimePriority($category);

			$out[] = $article;
		}

		return array(
			'status' => 200,
			'category' => $category->Extract(),
			'articles' => $out->Extract(array(
	                'id',
	                'title',
	                'priority',
	                'release_date',
	                'runtime_priority',
	                'runtime_category'
	            )
			)
		);
	}
}