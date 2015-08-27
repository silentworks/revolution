<?php

use MODX\Installer\ActionFactory;
use MODX\Installer\Init;

require 'vendor/autoload.php';

define('MODX_SETUP_PATH', __DIR__ . '/');
define('MODX_INSTALL_PATH', dirname(__DIR__) . '/');

include MODX_SETUP_PATH . 'config.core.php';

$app = new Slim\Slim([
    'template.path' => __DIR__ . '/templates',
    'asset.path' => __DIR__ . '/assets/',
    'base.path' => '/install/index.php',
    'modx' => [
      'corePath' => MODX_CORE_PATH,
      'setupPath' => MODX_SETUP_PATH,
      'lexiconPath' => __DIR__ . '/lang/',
    ],
]);

$container = $app->container;

// ActionFactory
$actionFactory = new ActionFactory($container);

Init::dependencies($container);

/** @var MODX\Installer\Services\Lexicon $lexicon */
$lexicon = $container['MODX\Installer\Services\Lexicon'];
$lexicon->load('default');

/** @var MODX\Installer\Util $util */
$util = $container['MODX\Installer\Util'];

/** @var League\Plates\Engine $engine */
$engine = $container['League\Plates\Engine'];
$engine->addData([
  'app_name' => 'MODX ' . $util->getMODXVersion('code_name'),
  'app_version' => $util->getMODXVersion('full_version'),
  '_lang' => $lexicon->fetch(),
  'MODX_SETUP_KEY' => MODX_SETUP_KEY
]);

$app->get('/', function () use ($actionFactory) {
    return $actionFactory->newLanguageAction();
})->setName('language');
$app->post('/', function () use ($actionFactory) {
    return $actionFactory->newLanguageStoreAction();
})->setName('language.store');

$app->get('/welcome', function () use ($actionFactory) {
    return $actionFactory->newWelcomeAction();
})->setName('welcome');
$app->post('/welcome', function () use ($actionFactory) {
    return $actionFactory->newWelcomeStoreAction();
})->setName('welcome.store');

$app->get('/options', function () use ($actionFactory) {
    return $actionFactory->newOptionsAction();
})->setName('options');

$app->post('/options', function () use ($actionFactory) {

})->setName('options.store');

$app->run();