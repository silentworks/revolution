<?php

namespace MODX\Installer;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Slim\Interfaces\RouterInterface;

class HttpResponder
{
    /**
     * @var \League\Plates\Engine
     */
    private $engine;

    /**
     * @var \Slim\Interfaces\RouterInterface
     */
    private $router;

    /**
     * HttpResponder constructor.
     * @param \League\Plates\Engine $engine
     * @param \Slim\Interfaces\RouterInterface $router
     */
    public function __construct(Engine $engine, RouterInterface $router)
    {
        $this->engine = $engine;
        $this->router = $router;
    }

    public function redirectTo(
      ResponseInterface $response,
      $to,
      array $data = [],
      array $queryParams = [],
      $status = 302
    ) {
        $url = $this->router->pathFor($to, $data, $queryParams);
        return $response->withStatus($status)->withHeader('Location', $url);
    }

    public function make($template, array $data = [])
    {
        return $this->engine->render($template, $data);
    }

    public function render(
      ResponseInterface $response,
      $template,
      array $data = []
    ) {
        return $response->getBody()->write($this->engine->render($template,
          $data));
    }
}