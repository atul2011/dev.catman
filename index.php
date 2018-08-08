<?php
include __DIR__ . '/loader.php';
use Models\User;
use Quark\AuthorizationProviders\Session;
use Quark\Extensions\Mail\MailConfig;
use Quark\Extensions\Mail\Providers\GoogleMail;
use Quark\Extensions\PushNotification\Providers\GoogleFCM\GoogleFCM;
use Quark\Extensions\PushNotification\PushNotificationConfig;
use Quark\Quark;
use Quark\QuarkConfig;
use Quark\DataProviders\MySQL;

const CM_DATA = 'data';
const CM_SESSION = 'session';
const CM_MAIL = 'mail';
const CM_PUSH_NOTIFICATION = 'push';
$config = new QuarkConfig(__DIR__ . '/runtime/application.ini');

$config->DataProvider(CM_DATA, new MySQL());
$config->AllowIndexFallback(true);
$config->AuthorizationProvider(CM_SESSION, new Session(), new User());
$config->Localization(__DIR__.'/runtime/localization.ini');

$config->Extension(CM_MAIL, new MailConfig(new GoogleMail()));
$config->Extension(CM_PUSH_NOTIFICATION, (new PushNotificationConfig())
	->Provider(new GoogleFCM())
);

Quark::Run($config);