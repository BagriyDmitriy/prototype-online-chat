<?php

require_once __DIR__.'/App/SplClassLoader.php';
require_once __DIR__.'/config.php';

$classLoader = new SplClassLoader('App', __DIR__);
$classLoader->register();

// Registry
$registry = new \App\Registry;

// Response
$response = new \App\Response;
$response->addHeader('Content-Type: text/html; charset=utf-8');
$registry->set('response', $response);

// Loader
$loader = new \App\Loader;
$registry->set('load', $loader);

// Router
if (isset($_GET['route'])) {
    $action = new \App\Action($_GET['route']);
} else {
    $action = new \App\Action('home/index');
}

// Db
$db = new \App\Db(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
$registry->set('db', $db);

$action->execute($registry);

$response->output();