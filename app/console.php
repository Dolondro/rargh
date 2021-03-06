<?php
include_once("bootstrap.php");

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

/** @var Silktide\Syringe\ContainerBuilder $builder */
$container = $builder->createContainer();

// find all commands and add them to the application
$serviceNames = $container->keys();
$application = new Application("CLI", "1.0.0");
foreach ($serviceNames as $name) {
    // commands are suffixed with ".command" ...
    if (strrpos($name, ".command") == strlen($name) - 8) {
        $command = $container[$name];
        // ... and are instances of the Symfony Command class
        if ($command instanceof Command) {
            $application->add($command);
        }
    }
}

// Run the app
$application->run();
