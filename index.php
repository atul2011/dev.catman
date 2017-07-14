<?php
include __DIR__ . '/loader.php';
use Models\User;
use Quark\AuthorizationProviders\Session;
use Quark\Quark;
use Quark\QuarkConfig;
use Quark\DataProviders\MySQL;

const MP_DATA = 'data';
const MP_SESSION = 'session';
$config = new QuarkConfig(__DIR__ . '/runtime/application.ini');

$config->DataProvider(MP_DATA, new MySQL());
$config->AllowIndexFallback(true);
$config->AuthorizationProvider(MP_SESSION,new Session(),new User());
$config->Localization(__DIR__.'/runtime/localization.ini');

Quark::Run($config);