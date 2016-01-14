<?php
chdir(__DIR__."/../");
include_once("app/bootstrap.php");

use Silktide\LazyBoy\Controller\FrontController;
use Silex\Provider\ServiceControllerServiceProvider;
use Silktide\LazyBoy\Provider\CorsServiceProvider;

/** @var Silktide\Syringe\ContainerBuilder $builder */

$configDir = realpath(__DIR__ . "/../app/config");

$frontController = new FrontController(
    $builder,
    $configDir,
    "Silex\\Application",
    [
        new \Silex\Provider\SecurityServiceProvider(),
        new \Silex\Provider\TwigServiceProvider(),
        new \Silex\Provider\MonologServiceProvider(),
        new ServiceControllerServiceProvider(),
        new CorsServiceProvider(),
        new \Dolondro\Rargh\Provider\TwigGlobalProvider(),
        new \Silex\Provider\SessionServiceProvider(),
    ]
);

$frontController->runApplication();
