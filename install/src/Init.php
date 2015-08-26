<?php

namespace MODX\Installer;

use Interop\Container\ContainerInterface;
use League\Plates\Engine;
use League\Plates\Extension\Asset;
use MODX\Installer\Action\LanguageAction;
use MODX\Installer\Action\LanguageStoreAction;
use MODX\Installer\Action\OptionsAction;
use MODX\Installer\Action\WelcomeAction;
use MODX\Installer\Action\WelcomeStoreAction;
use MODX\Installer\Services\Lexicon;
use MODX\Installer\Services\Settings;

class Init
{
    public function controllers(ContainerInterface $container)
    {
        $container[LanguageAction::class] = function () use ($container) {
            return new LanguageAction(
                $container->get(HttpResponder::class),
                $container->get(Util::class)
            );
        };

        $container[LanguageStoreAction::class] = function () use ($container) {
            return new LanguageStoreAction(
                $container->get(HttpResponder::class),
                $container->get(Settings::class)
            );
        };

        $container[WelcomeAction::class] = function () use ($container) {
            return new WelcomeAction(
                $container->get(HttpResponder::class),
                $container->get(Util::class)
            );
        };

        $container[WelcomeStoreAction::class] = function () use ($container) {
            return new WelcomeStoreAction(
                $container->get(HttpResponder::class),
                $container->get(Util::class)
            );
        };

        $container[OptionsAction::class] = function () use ($container) {
            return new OptionsAction(
                $container->get(HttpResponder::class),
                $container->get(Util::class)
            );
        };
    }

    public function dependencies(ContainerInterface $container)
    {
        $container[Util::class] = function () use ($container) {
            return new Util($container->get('settings')['modx']);
        };

        $container[HttpResponder::class] = function () use ($container) {
            return new HttpResponder(
                $container->get(Engine::class),
                $container->get('router')
            );
        };

        $container[Engine::class] = function () use ($container) {
            $engine = new Engine($container->get('settings')['template.path']);
            $engine->loadExtensions([
                new Asset($container->get('settings')['asset.path']),
                new PlatesExtension(
                    $container->get('router'),
                    $container->get('request')
                )
            ]);

            return $engine;
        };

        $container[Lexicon::class] = function () use ($container) {
            return new Lexicon($container->get('settings')['modx']);
        };

        $container[Settings::class] = function () use ($container) {
            return new Settings();
        };
    }
}