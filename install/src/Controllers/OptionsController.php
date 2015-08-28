<?php

namespace MODX\Installer\Controllers;

use MODX\Installer\HttpResponder;
use MODX\Installer\Util;
use Slim\Http\Request;
use Slim\Http\Response;

class OptionsController
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

    public function index()
    {
        return $this->responder->render('options', [
            'installmode' => false,
            'unpacked' => 0,
            'files_exist' => 0,
            'config_key' => $this->request->post('config_key', MODX_CONFIG_KEY),
            'writableError' => !$this->util->isSetupConfigWritable(),
        ]);
    }
}