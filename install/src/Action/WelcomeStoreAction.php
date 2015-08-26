<?php

namespace MODX\Installer\Action;

use MODX\Installer\HttpResponder;
use MODX\Installer\Util;
use Slim\Http\Request;
use Slim\Http\Response;

class WelcomeStoreAction
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
        $this->util->updateSetupConfigKey($request->getParam('config_key', 'config'));
        return $this->responder->redirectTo($response, 'options');
    }
}