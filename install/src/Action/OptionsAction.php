<?php

namespace MODX\Installer\Action;

use MODX\Installer\HttpResponder;
use MODX\Installer\Util;
use Slim\Http\Request;
use Slim\Http\Response;

class OptionsAction
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
        return $this->responder->render($response, 'options', [
            'installmode' => false,
            'unpacked' => 0,
            'files_exist' => 0,
            'config_key' => $request->getParam('config_key', MODX_CONFIG_KEY),
            'writableError' => !$this->util->isSetupConfigWritable(),
        ]);
    }
}