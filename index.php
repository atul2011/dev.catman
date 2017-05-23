<?php
include __DIR__ . '/loader.php';

use Quark\Quark;
use Quark\QuarkConfig;
use Quark\DataProviders\MySQL;

const MP_DATA = 'data';

$config = new QuarkConfig(__DIR__ . '/runtime/application.ini');

$config->DataProvider(MP_DATA, new MySQL());
$config->AllowIndexFallback(true);

Quark::Run($config);