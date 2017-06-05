<?php
namespace Services\Article;

use Models\Article;
use Models\Articles_has_Categories;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Exception;

/**
 * Class DeleteService
 *
 * @package Services\Articles
 */
class DeleteService implements IQuarkPostService, IQuarkServiceWithCustomProcessor{
    /**
     * @param QuarkDTO $request
     * @param QuarkSession $session
     *
     * @return mixed
     */
    public function Post(QuarkDTO $request, QuarkSession $session) {
        /**
         * @var QuarkModel|Article $article
         * @var QuarkCollection|Articles_has_Categories[] $article_links
         */
        $id = $request->URI()->Route(2);
		try {
			QuarkModel::Delete(new Article(), array(
				'id' => $id
			));
			QuarkModel::Delete(new Articles_has_Categories(), array(
				'article_id' => $id
			));
		}catch (Exception $e)
		{
			return $e;
		}
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