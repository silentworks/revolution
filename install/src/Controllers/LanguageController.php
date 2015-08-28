<?php

namespace MODX\Installer\Controllers;

use MODX\Installer\HttpResponder;
use MODX\Installer\Services\Settings;
use MODX\Installer\Util;
use Slim\Http\Request;

class LanguageController
{
    /**
     * @var \MODX\Installer\HttpResponder
     */
    private $responder;

    /**
     * @var \MODX\Installer\Util
     */
    private $util;

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
     * @param \MODX\Installer\Util $util
     */
    public function __construct(
      HttpResponder $responder,
      Settings $settings,
      Request $request,
      Util $util
    ) {
        $this->responder = $responder;
        $this->util = $util;
        $this->settings = $settings;
        $this->request = $request;
    }

    public function index()
    {
        return $this->responder->render('language', [
          'restarted' => false,
          'currentLang' => $_COOKIE['modx_setup_language'] ?: 'en',
          'languages' => $this->util->getAvailableLanguages()
        ]);
    }

    public function store()
    {
        $language = $this->request->post('language', 'en');
        $cookiePath = preg_replace('#[/\\\\]$#', '', dirname(dirname($_SERVER['REQUEST_URI'])));
        setcookie('modx_setup_language', $language, 0, $cookiePath . '/');
        /*$settings = $install->request->getConfig();
        $settings = array_merge($settings,$_POST);*/
        $settings = $this->request->post();
        $this->settings->store($settings);

        return $this->responder->redirectTo('welcome');
    }
}