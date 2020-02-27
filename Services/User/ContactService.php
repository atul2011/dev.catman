<?php
namespace Services\User;

use Models\Article;
use Quark\Extensions\Mail\Mail;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkFormIOProcessor;
use Quark\QuarkHTTPClient;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkServiceBehavior;
use Quark\QuarkSession;
use Quark\QuarkView;
use ViewModels\LayoutView;
use ViewModels\User\ContactView;

/**
 * Class ContactService
 *
 * @package Services\User
 */
class ContactService implements IQuarkGetService, IQuarkPostService {
	use QuarkServiceBehavior;
	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new ContactView(), new LayoutView(), array(
			'item' => QuarkModel::FindOne(new Article(), array(
				'type' => Article::TYPE_SYSTEM,
				'keywords' => Article::KEYWORDS_CONTACT_US
			))
		));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		$token = $_POST['g-recaptcha-response'];
		$http_request = QuarkDTO::ForPOST(new QuarkFormIOProcessor());
		$http_request->Data(array(
			'secret' => $this->LocalSettings(GOOGLE_CAPTCHA_SECRET),
			'response' => $token
		));
		$http_response = QuarkHTTPClient::To(
			'https://www.google.com/recaptcha/api/siteverify',
			$http_request,
			new QuarkDTO(new QuarkJSONIOProcessor())
		);

		if ($http_response->success == true) {
			$mail = new Mail(CM_MAIL);

			$user_name = htmlspecialchars($request->name);
			$user_email = htmlspecialchars($request->email);
			$message_subject = htmlspecialchars($request->subject);
			$message_text = htmlspecialchars($request->text);
			$message_log = $user_name . ': ' . $user_email . ';\\n  [subject]=> ' . $message_subject .';\\n [content] => ' . $message_text . '\\n\\n';

			$emails = array('ain77@inbox.ru', 'pdsq2@mail.ru');
			foreach ($emails as $targetEmail) {
				$mail->To($targetEmail);
				$mail->Subject($message_subject);

				$message =//mail content
					'<div style="font-size:16px; font-family: Verdana,sans-serif;color: #000000 !important; ">'.
					'Привет,'.
					'<br/>'.
					'Пользователь <u><i>'. $user_name . ': ' . $user_email . '</i></u> отправил коментарий к сайту Universal Path.'.
					'<br/>'.
					'<br/>'.
					'<div style="border: 1px solid #CCCCCC; border-radius: 5px; padding: 5px"><i>' . $message_text . '</i></div>' .
					'</pre>';

				$mail->Content($message);

				if (!$mail->Send())
					Quark::Log('Cannot send message to email:' . $targetEmail);
			}

			Quark::Log($message_log, Quark::LOG_INFO, 'messages');
		}

		return QuarkDTO::ForRedirect('/');
	}
}