<?php
namespace Services\Admin\Settings;

use Models\Settings;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Settings\CreateView;
use ViewModels\Admin\Status\ConflictView;
use ViewModels\Admin\Status\InternalServerErrorView;

/**
 * Class CreateService
 *
 * @package Services\Admin\Term
 */
class CreateService implements IQuarkGetService, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl(), array('settings' => new QuarkModel(new Settings())));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Term $term
		 */
		$settings = QuarkModel::FindOne(new Settings(), array('name' => $request->setting_name));

		if ($settings !== null)
			return QuarkView::InLayout(new ConflictView(), new QuarkPresenceControl());

		$settings = new QuarkModel(new Settings(), array(
			'setting_name' => htmlspecialchars(trim($request->setting_name)),
			'setting_description' => htmlspecialchars(trim($request->setting_description)),
		    'setting_value' => htmlspecialchars(trim($request->setting_value))
		));

		if (!$settings->Validate())
			return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl(), array('settings' => $settings));

		if (!$settings->Create())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/settings/list');
	}
}
