<?php

use League\Plates\Engine;
use MODX\Installer\Init;
use MODX\Installer\Services\Lexicon;
use MODX\Installer\Util;

require 'vendor/autoload.php';

define('MODX_SETUP_PATH', __DIR__ . '/');
define('MODX_INSTALL_PATH', dirname(__DIR__) . '/');

include MODX_SETUP_PATH . 'config.core.php';

$app = new Slim\App([
    'settings' => [
        'template.path' => __DIR__ . '/templates',
        'lexicon' => [
            'lexiconPath' => __DIR__ . '/lang/'
        ]
    ]
]);

$container = $app->getContainer();
$init = new Init();
$init->controllers($container);
$init->dependencies($container);

/** @var MODX\Installer\Services\Lexicon $lexicon */
$lexicon = $container->get(Lexicon::class);
$lexicon->load('default');

/** @var MODX\Installer\Util $util */
$util = $container->get(Util::class);

/** @var League\Plates\Engine $engine */
$engine = $container->get(Engine::class);
$engine->addData([
  'app_name' => 'MODX ' . $util->getMODXVersion('code_name'),
  'app_version' => $util->getMODXVersion('full_version'),
  '_lang' => $lexicon->fetch(),
  'MODX_SETUP_KEY' => MODX_SETUP_KEY
]);

$app->get('/', MODX\Installer\Action\LanguageAction::class);
$app->post('/', MODX\Installer\Action\LanguageStoreAction::class);

$app->get('/welcome', MODX\Installer\Action\WelcomeAction::class);

$app->run();