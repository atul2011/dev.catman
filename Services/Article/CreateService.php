<?php
namespace Services\Article;

use Models\Article;
use Models\Articles_has_Categories;
use Models\Category;
use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\Quark;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use ViewModels\Content\ArticleEditView;

/**
 * Class CreateService
 *
 * @package Services\Article
 */
class CreateService implements IQuarkPostService,IQuarkGetService, IQuarkServiceWithCustomProcessor{
    /**
     * @param QuarkDTO $request
     * @param QuarkSession $session
     *
     * @return mixed
     */
    public function Post(QuarkDTO $request, QuarkSession $session) {
        /**
         * @var QuarkModel|Article $article
         * @var QuarkModel|Category $category
         * @var QuarkModel|Articles_has_Categories $article_category
         */
        //ceck if new article is already exist
        $article = QuarkModel::FindOne(new Article(),array(
            'title' => $request->Data()->title
        ));
        if($article != null)
        	return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);
        //create new article
        $article = new QuarkModel(new Article(),$request->Data());
        if(!$article->Create())
        	return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);

		return QuarkDTO::ForRedirect('/admin/categories?created=article');

    }

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new ArticleEditView(), new QuarkPresenceControl());
	}

	/**
     * @param QuarkDTO $request
     *
     * @return IQuarkIOProcessor
     */
    public function Processor(QuarkDTO $request) {
        return new QuarkJSONIOProcessor();
    }


}