<?php

namespace MODX\Installer\Action;

use MODX\Installer\HttpResponder;
use MODX\Installer\Services\Settings;
use MODX\Installer\Util;
use Slim\Http\Request;
use Slim\Http\Response;

class LanguageStoreAction
{
    /**
     * @var \MODX\Installer\HttpResponder
     */
    private $responder;

    /**
     * @var \MODX\Installer\Services\Settings
     */
    private $settings;

    /**
     * @var \Slim\Http\Request
     */
    private $request;

    /**
     * WelcomeAction constructor.
     * @param \MODX\Installer\HttpResponder $responder
     * @param \MODX\Installer\Services\Settings $settings
     * @param \Slim\Http\Request $request
     */
    public function __construct(HttpResponder $responder, Settings $settings, Request $request)
    {
        $this->responder = $responder;
        $this->settings = $settings;
        $this->request = $request;
    }

    public function __invoke()
    {
        $language = $this->request->post('language', 'en');
        $cookiePath = preg_replace('#[/\\\\]$#', '', dirname(dirname($_SERVER['REQUEST_URI'])));
        setcookie('modx_setup_language', $language, 0, $cookiePath . '/');
        /*$settings = $install->request->getConfig();
        $settings = array_merge($settings,$_POST);*/
        $settings = $this->request->post();
        $this->settings->store($settings);

        $this->responder->redirectTo('welcome');
    }
}