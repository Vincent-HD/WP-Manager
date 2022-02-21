<?php

use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

$app = AppFactory::create();

$app->get('/', function(Request $request, Response $response) {
    $response->getBody()->write('API WP Manager');
    return $response;
});

$app->get('/getWordpressInstalled', function(Request $request, Response $response) {
    global $lcache;
    $c_instances = $lcache->getItem('wp_instances');
    if (!$c_instances->isHit()) {
        $instances = WpInstance::parse_all_wp_instances(ABSPATH . DIRECTORY_SEPARATOR . '../');
        $c_instances->set($instances);
        $c_instances->expiresAfter(30);
        $lcache->save($c_instances);
    } else {
        $instances = $c_instances->get();
    }
    $response->getBody()->write(json_encode($instances));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();