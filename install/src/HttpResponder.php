<?php

namespace MODX\Installer;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;

class HttpResponder
{
    /**
     * @var \League\Plates\Engine
     */
    private $engine;

    /**
     * HttpResponder constructor.
     * @param \League\Plates\Engine $engine
     */
    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
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
        return $response->getBody()->write($this->engine->render($template, $data));
    }
}