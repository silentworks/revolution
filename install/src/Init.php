<?php

namespace MODX\Installer;

use League\Plates\Engine;
use League\Plates\Extension\Asset;
use MODX\Installer\Services\Lexicon;
use MODX\Installer\Services\Settings;
use Slim\Helper\Set;

class Init
{
    public static function dependencies(Set $container)
    {
        $container['MODX\Installer\Util'] = function () use ($container) {
            return new Util($container->get('settings')['modx']);
        };

        $container['MODX\Installer\HttpResponder'] = function () use ($container) {
            return new HttpResponder(
                $container->get('League\Plates\Engine'),
                $container->get('router'),
                $container->get('response'),
                $container->get('request'),
                $container->get('settings')['base.path']
            );
        };

        $container->singleton('League\Plates\Engine', function () use ($container) {
            $engine = new Engine($container->get('settings')['template.path']);
            $engine->loadExtensions([
                new Asset($container->get('settings')['asset.path']),
                new PlatesExtension(
                    $container->get('router'),
                    $container->get('request'),
                    $container->get('settings')['base.path']
                )
            ]);

            return $engine;
        });

        $container['MODX\Installer\Services\Lexicon'] = function () use ($container) {
            return new Lexicon($container->get('settings')['modx']);
        };

        $container['MODX\Installer\Services\Settings'] = function () use ($container) {
            return new Settings();
        };
    }
}