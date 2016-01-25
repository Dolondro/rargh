<?php


namespace Dolondro\Rargh\Provider;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ErrorProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {

        if ($app instanceof Application) {
            $app->error(function(\Exception $e, Request $request, $code) use ($app){
                return $app->offsetGet("error.controller")->index($e, $request, $code);
            });
        }
    }
}