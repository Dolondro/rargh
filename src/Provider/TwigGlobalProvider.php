<?php


namespace Dolondro\Rargh\Provider;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class TwigGlobalProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        if ($app instanceof Application) {
            $app->before(function (Request $request, Application $app) {
                /**
                 * @var \Twig_Environment
                 */
                $app["twig"]->addGlobal("request_path", $request->getPathInfo());
            }, Application::LATE_EVENT);
        }
    }
}