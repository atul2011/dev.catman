<?php
include __DIR__ . '/loader.php';
use Models\User;
use Quark\AuthorizationProviders\Session;
use Quark\Quark;
use Quark\QuarkConfig;
use Quark\DataProviders\MySQL;

const CM_DATA = 'data';
const CM_SESSION = 'session';
$config = new QuarkConfig(__DIR__ . '/runtime/application.ini');

$config->DataProvider(CM_DATA, new MySQL());
$config->AllowIndexFallback(true);
$config->AuthorizationProvider(CM_SESSION, new Session(), new User());
$config->Localization(__DIR__.'/runtime/localization.ini');

$config->Alloc(50);

Quark::Run($config);