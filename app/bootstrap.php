<?php

$appDir = dirname(__DIR__);

include_once($appDir . "/vendor/autoload.php");

use Silktide\Syringe\ReferenceResolver;
use Silktide\Syringe\ContainerBuilder;
use Silktide\Syringe\Loader\JsonLoader;
use Silktide\Syringe\Loader\YamlLoader;


// Config data should be brought in using environment variables
// Updating environment variables is a PITA when doing some quick dev, so if we have an
// env.yml file, dump it into $_SERVER, where syringe will pick it up as if it was an actual environment variable
$environmentFile = __DIR__."/../env.yml";
if (file_exists($environmentFile)) {
    $yaml = new \Symfony\Component\Yaml\Yaml();
    $array = $yaml->parse($environmentFile);
    foreach ($array as $key => $value) {
        $_SERVER[$key]=$value;
    }
}

$resolver = new ReferenceResolver();
$loaders = [
    new JsonLoader(),
    new YamlLoader()
];

$configPaths = [
    $appDir . "/app/config",
    $appDir
];

$builder = new ContainerBuilder($resolver, $configPaths);

foreach ($loaders as $loader) {
    $builder->addLoader($loader);
}
$builder->setApplicationRootDirectory($appDir);
$builder->addConfigFiles([
    "dolondro_hotstuff" => $appDir . "/vendor/dolondro/hotstuff/app/config/services.yml"
]);
$builder->addConfigFile("services.yml");

