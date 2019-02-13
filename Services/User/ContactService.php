<?php
namespace Services\User;

use Models\Article;
use Models\User;
use Quark\Extensions\Mail\Mail;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkModel;
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
		$mail = new Mail(CM_MAIL);

		$user_name = htmlspecialchars($request->name);
		$user_email = htmlspecialchars($request->email);
		$message_subject = htmlspecialchars($request->subject);
		$message_text = htmlspecialchars($request->text);
		$message_log = $user_name . ': ' . $user_email . ';\\n  [subject]=> ' . $message_subject .';\\n [content] => ' . $message_text . '\\n\\n';

		foreach (QuarkModel::Find(new User(), array('rights' => User::RIGHTS_ADMIN)) as $user){
			/**
			 * @var QuarkModel|User $user
			 */
			$mail->To($user->email);
			$mail->Subject($message_subject);

			$message =//mail content
				'<div style="font-size:16px; font-family: Verdana,sans-serif;color: #000000 !important; ">'.
				'Привет, '. $user->name.
				'<br/>'.
				'Пользователь <u><i>'. $user_name . ': ' . $user_email . '</i></u> отправил коментарий к сайту Universal Path.'.
				'<br/>'.
				'<br/>'.
				'<div style="border: 1px solid #CCCCCC; border-radius: 5px; padding: 5px"><i>' . $message_text . '</i></div>' .
				'</pre>';

			$mail->Content($message);

			if (!$mail->Send())
				Quark::Log('Cannot send message to email:' . $user->email);
		}

		Quark::Log($message_log, Quark::LOG_INFO, 'messages');

		return QuarkDTO::ForRedirect('/');
	}


}