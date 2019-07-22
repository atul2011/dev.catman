<?php
namespace Services\Admin\Term;

use Models\Term;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkFile;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\Status\BadRequestView;
use ViewModels\Admin\Term\ParseView;
use ViewModels\Admin\Status\InternalServerErrorView;

/**
 * Class ParseService
 *
 * @package Services\Admin\Term
 */
class ParseService implements IQuarkGetService, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication, IQuarkServiceWithCustomProcessor {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new ParseView(), new QuarkPresenceControl());
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkFile $file
		 * @var \stdClass $file_content
		 */
		$file = $request->file->Load();

		$file_content = str_replace('\\t', '',
			str_replace('\\n', '',
				str_replace('\\r', '',
					json_encode($file->Content())
				)
		));

		$json = json_decode(json_decode($file_content));
		$items = $json->glossary;

		foreach ($items as $item) {
			if (strlen(trim($item->term)) == 0)
				continue;

			/**
			 * @var QuarkModel|Term $term
			 */
			$term = QuarkModel::FindOne(new Term(), array('title' => $item->term));

			if ($term != null) {
				$term->description = trim($item->description);

				$term->Save();
			}
			else {
				$term = new QuarkModel(new Term(), array(
					'title' => htmlspecialchars(trim($item->term)),
					'description' => htmlspecialchars(trim($item->description))
				));

				if (!$term->Validate())
					return QuarkView::InLayout(new BadRequestView(), new QuarkPresenceControl(), array(
						'errors' => $term->ValidationErrors()
					));

				if (!$term->Create())
					return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());
			}
		}

		return QuarkDTO::ForRedirect('/admin/term/list');
	}
}