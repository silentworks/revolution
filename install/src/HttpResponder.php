<?php

namespace MODX\Installer;

use League\Plates\Engine;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;

class HttpResponder
{
    /**
     * @var \League\Plates\Engine
     */
    private $engine;

    /**
     * @var \Slim\Router
     */
    private $router;

    /**
     * @var \Slim\Http\Response
     */
    private $response;
    /**
     * @var \Slim\Http\Request
     */
    private $request;
    private $basePath;

    /**
     * HttpResponder constructor.
     * @param \League\Plates\Engine $engine
     * @param \Slim\Router $router
     * @param \Slim\Http\Response $response
     * @param \Slim\Http\Request $request
     * @param $basePath
     */
    public function __construct(
      Engine $engine,
      Router $router,
      Response $response,
      Request $request,
      $basePath
    ) {
        $this->engine = $engine;
        $this->router = $router;
        $this->response = $response;
        $this->request = $request;
        $this->basePath = $basePath;
    }

    public function redirectTo($to, array $data = [], $status = 302)
    {
        $url = $this->basePath . $this->router->urlFor($to, $data);
        $this->response->redirect($url, $status);
    }

    public function make($template, array $data = [])
    {
        return $this->engine->render($template, $data);
    }

    public function render($template, array $data = [])
    {
        return $this->response->write($this->engine->render($template, $data));
    }
}