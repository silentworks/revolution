<?php

namespace MODX\Installer\Action;

use MODX\Installer\HttpResponder;
use Slim\Http\Request;
use Slim\Http\Response;

class WelcomeAction
{
    /**
     * @var \MODX\Installer\HttpResponder
     */
    private $responder;

    /**
     * WelcomeAction constructor.
     * @param \MODX\Installer\HttpResponder $responder
     */
    public function __construct(HttpResponder $responder)
    {
        $this->responder = $responder;
    }

    public function __invoke(Request $request, Response $response, $args = null)
    {
        return $this->responder->render($response, 'welcome', [
            'config_key' => 'config',
            'writableError' => '',
        ]);
    }
}