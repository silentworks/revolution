<?php

namespace MODX\Installer;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use Slim\Http\Request;
use Slim\Router;

class PlatesExtension implements ExtensionInterface
{
    /**
     * @var \Slim\Router
     */
    private $router;

    /**
     * @var \Slim\Http\Request
     */
    private $request;
    /**
     * @var
     */
    private $basePath;

    public function __construct(Router $router, Request $request, $basePath)
    {
        $this->router = $router;
        $this->request = $request;
        $this->basePath = $basePath;
    }

    public function pathFor($name, $data = [])
    {
        return $this->basePath . $this->router->urlFor($name, $data);
    }

    public function rootPath()
    {
        return $this->request->getUrl();
    }

    public function baseUrl($withUri = true)
    {
        $uri = $this->request->getUrl();
        if ($withUri) {
            $uri .= $this->request->getRootUri();
        }
        return $uri;
    }

    public function currentUrl()
    {
        $req = $this->request;
        $uri = $req->getUrl() . $req->getPath();
        /*if ($withQueryString) {
            $env = $app->environment();
            if ($env['QUERY_STRING']) {
                $uri .= '?' . $env['QUERY_STRING'];
            }
        }*/
        return $uri;
    }

    public function currentPath()
    {
//        return $this->request->getUrl()->getPath();
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('url_for', [$this, 'pathFor']);
        $engine->registerFunction('base_url', [$this, 'baseUrl']);
        $engine->registerFunction('current_url', [$this, 'currentUrl']);
        $engine->registerFunction('current_path', [$this, 'currentPath']);
        $engine->registerFunction('root_path', [$this, 'rootPath']);
    }
}