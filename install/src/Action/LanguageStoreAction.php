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
     * WelcomeAction constructor.
     * @param \MODX\Installer\HttpResponder $responder
     * @param \MODX\Installer\Services\Settings $settings
     */
    public function __construct(HttpResponder $responder, Settings $settings)
    {
        $this->responder = $responder;
        $this->settings = $settings;
    }

    public function __invoke(Request $request, Response $response, $args = null)
    {
        $language = $request->getParam('language', 'en');
        $cookiePath = preg_replace('#[/\\\\]$#', '', dirname(dirname($request->getRequestTarget())));
        setcookie('modx_setup_language', $language, 0, $cookiePath . '/');
        /*$settings = $install->request->getConfig();
        $settings = array_merge($settings,$_POST);*/
        $settings = $request->getParsedBody();
        $this->settings->store($settings);

        return $response->withRedirect('/install/welcome');
    }
}