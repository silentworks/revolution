<?php

namespace MODX\Installer;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class PlatesExtension implements ExtensionInterface
{
    /**
     * @var \Slim\Interfaces\RouterInterface
     */
    private $router;

    /**
     * @var string|\Slim\Http\Request
     */
    private $request;

    public function __construct($router, $request)
    {
        $this->router = $router;
        $this->request = $request;
    }

    public function pathFor($name, $data = [], $queryParams = [])
    {
        return $this->router->pathFor($name, $data, $queryParams);
    }

    public function rootPath()
    {
        $uri = $this->request->getUri();
        $scheme = $uri->getScheme();
        $authority = $uri->getAuthority();

        return ($scheme ? $scheme . '://' : '') . $authority;
    }

    public function baseUrl()
    {
        if (method_exists($this->request->getUri(), 'getBaseUrl')) {
            return $this->request->getUri()->getBaseUrl();
        }
    }

    public function currentUrl()
    {
        $uri = $this->request->getUri();
        $scheme = $uri->getScheme();
        $authority = $uri->getAuthority();
        $basePath = $uri->getBasePath();
        $path = ltrim($uri->getPath(), '/');
        $query = $uri->getQuery();
        $fragment = $uri->getFragment();

        return ($scheme ? $scheme . '://' : '') . $authority . $basePath . $path . ($query ? '?' . $query : '') . ($fragment ? '#' . $fragment : '');
    }

    public function currentPath()
    {
        return $this->request->getUri()->getPath();
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('path_for', [$this, 'pathFor']);
        $engine->registerFunction('base_url', [$this, 'baseUrl']);
        $engine->registerFunction('current_url', [$this, 'currentUrl']);
        $engine->registerFunction('current_path', [$this, 'currentPath']);
        $engine->registerFunction('root_path', [$this, 'rootPath']);
    }
}