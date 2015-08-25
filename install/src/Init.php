<?php

namespace MODX\Installer;

use Interop\Container\ContainerInterface;
use League\Plates\Engine;
use MODX\Installer\Action\LanguageAction;
use MODX\Installer\Action\LanguageStoreAction;
use MODX\Installer\Action\WelcomeAction;
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
            return new WelcomeAction($container->get(HttpResponder::class));
        };
    }

    public function dependencies(ContainerInterface $container)
    {
        $container[Util::class] = function () use ($container) {
            return new Util($container->get('settings')['lexicon']);
        };

        $container[HttpResponder::class] = function () use ($container) {
            return new HttpResponder($container->get(Engine::class));
        };

        $container[Engine::class] = function () use ($container) {
            return new Engine($container->get('settings')['template.path']);
        };

        $container[Lexicon::class] = function () use ($container) {
            return new Lexicon($container->get('settings')['lexicon']);
        };

        $container[Settings::class] = function () use ($container) {
            return new Settings();
        };
    }
}