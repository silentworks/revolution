<?php

namespace MODX\Installer;

use MODX\Installer\Action\LanguageAction;
use MODX\Installer\Action\LanguageStoreAction;
use MODX\Installer\Action\OptionsAction;
use MODX\Installer\Action\WelcomeAction;
use MODX\Installer\Action\WelcomeStoreAction;
use Slim\Helper\Set;

class ActionFactory
{
    /**
     * @var \Slim\Helper\Set
     */
    private $container;

    /**
     * ControllerFactory constructor.
     * @param \Slim\Helper\Set $container
     */
    public function __construct(Set $container)
    {
        $this->container = $container;
    }

    public function newLanguageAction()
    {
        $action = new LanguageAction(
            $this->container->get('MODX\Installer\HttpResponder'),
            $this->container->get('MODX\Installer\Util')
        );
        return $action();
    }

    public function newLanguageStoreAction()
    {
        $action = new LanguageStoreAction(
            $this->container->get('MODX\Installer\HttpResponder'),
            $this->container->get('MODX\Installer\Services\Settings'),
            $this->container->get('request')
        );
        return $action();
    }

    public function newWelcomeAction()
    {
        $action = new WelcomeAction(
            $this->container->get('MODX\Installer\HttpResponder'),
            $this->container->get('MODX\Installer\Util'),
            $this->container->get('request')
        );
        return $action();
    }

    public function newWelcomeStoreAction()
    {
        $action = new WelcomeStoreAction(
            $this->container->get('MODX\Installer\HttpResponder'),
            $this->container->get('MODX\Installer\Util'),
            $this->container->get('request')
        );
        return $action();
    }

    public function newOptionsAction()
    {
        $action = new OptionsAction(
            $this->container->get('MODX\Installer\HttpResponder'),
            $this->container->get('MODX\Installer\Util'),
            $this->container->get('request')
        );
        return $action();
    }
}