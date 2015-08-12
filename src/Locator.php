<?php

namespace MODX;

use Aura\Di\Exception\ServiceNotFound;
use Interop\Container\ContainerInterface;
use xPDO\xPDO;

class Locator
{
    /**
     * @var \xPDO\xPDO
     */
    private $xPDO;

    /**
     * @var \Interop\Container\ContainerInterface
     */
    private $container;

    /**
     * Locator constructor.
     * @param \xPDO\xPDO $xPDO
     * @param \Interop\Container\ContainerInterface $container
     */
    public function __construct(xPDO $xPDO, ContainerInterface $container)
    {
        $this->xPDO = $xPDO;
        $this->container = $container;
    }

    public function getService($name, $class= '', $path= '', $params= array ())
    {
        try {
            $service = $this->container->get($name);
        } catch (ServiceNotFound $e) {
            $service = $this->xPDO->getService($name, $class, $path, $params);
        }
        return $service;
    }
}