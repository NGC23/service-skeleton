<?php

declare(strict_types=1);

use Neil\Config\Database\ConnectionFactoryInterface;
use Neil\Config\Database\DatabaseConnectionFactory;

$container = new League\Container\Container();

$container->add(ConnectionFactoryInterface::class,DatabaseConnectionFactory::class)
    ->addArguments([
        'host' => '127.0.0.1',
        'database' => 'event_manager',
        'username' => 'root',
        'password' => 'gymmer4Life2024#'
    ]);

$container->add( Neil\Test\Application\Controller::class)
    ->addArgument(ConnectionFactoryInterface::class);



