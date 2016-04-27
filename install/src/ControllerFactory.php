<?php

namespace MODX\Installer;

use MODX\Installer\Controllers\LanguageController;
use MODX\Installer\Controllers\OptionsController;
use MODX\Installer\Controllers\WelcomeController;
use Slim\Helper\Set;

class ControllerFactory
{
    /**
     * @var \Slim\Helper\Set
     */
    private $container;

    /**
     * @var ControllerFactory
     */
    private static $instance = null;

    /**
     * ControllerFactory constructor.
     * @param \Slim\Helper\Set $container
     */
    public function __construct(Set $container)
    {
        $this->container = $container;

        if (empty(static::$instance)) {
            static::$instance = $this;
        }
    }

    public static function instance()
    {
        if (empty(static::$instance)) {
            throw new \RuntimeException('Controller factory was not been instantiated.');
        }
        return static::$instance;
    }

    public function newLanguageController()
    {
        return new LanguageController(
            $this->container->get('MODX\Installer\HttpResponder'),
            $this->container->get('MODX\Installer\Services\Settings'),
            $this->container->get('request'),
            $this->container->get('MODX\Installer\Util')
        );
    }

    public function newWelcomeController()
    {
        return new WelcomeController(
            $this->container->get('MODX\Installer\HttpResponder'),
            $this->container->get('MODX\Installer\Util'),
            $this->container->get('request')
        );
    }

    public function newOptionsController()
    {
        return new OptionsController(
            $this->container->get('MODX\Installer\HttpResponder'),
            $this->container->get('MODX\Installer\Util'),
            $this->container->get('request'),
            $this->container->get('MODX\Installer\Services\Settings'),
            $this->container->get('settings')['modx']
        );
    }
}