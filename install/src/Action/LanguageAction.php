<?php

namespace MODX\Installer\Action;

use MODX\Installer\HttpResponder;
use MODX\Installer\Util;
use Slim\Http\Request;
use Slim\Http\Response;

class LanguageAction
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
     * WelcomeAction constructor.
     * @param \MODX\Installer\HttpResponder $responder
     * @param \MODX\Installer\Util $util
     */
    public function __construct(HttpResponder $responder, Util $util)
    {
        $this->responder = $responder;
        $this->util = $util;
    }

    public function __invoke(Request $request, Response $response, $args = null)
    {
        return $this->responder->render($response, 'language', [
            'restarted' => false,
            'currentLang' => $_COOKIE['modx_setup_language'] ?: 'en',
            'languages' => $this->util->getAvailableLanguages()
        ]);
    }
}