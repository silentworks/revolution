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
     * @var \Slim\Http\Request
     */
    private $request;

    /**
     * WelcomeAction constructor.
     * @param \MODX\Installer\HttpResponder $responder
     * @param \MODX\Installer\Util $util
     * @param \Slim\Http\Request $request
     */
    public function __construct(HttpResponder $responder, Util $util, Request $request)
    {
        $this->responder = $responder;
        $this->util = $util;
        $this->request = $request;
    }

    public function __invoke()
    {
        $this->util->updateSetupConfigKey($this->request->params('config_key', 'config'));
        $this->responder->redirectTo('options');
    }
}