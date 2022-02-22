<?php

use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use WPM\Instance\WPM_Instance;

$app = AppFactory::create();

$app->get('/', function(Request $request, Response $response) {
    $response->getBody()->write('API WP Manager');
    return $response;
});

$app->get('/getWordpressInstalled', function(Request $request, Response $response) {
    global $lcache;
    $wp_installs_path = empty($_ENV['WP_INSTALLS_PATH'])? '../': $_ENV['WP_INSTALLS_PATH'];
    $c_instances = $lcache->getItem('wp_instances');
    if (!$c_instances->isHit()) {
        $instances = WPM_Instance::parse_all_wp_instances(ABSPATH . DIRECTORY_SEPARATOR . $wp_installs_path);
        if (is_wpm_error($instances)) {
            return json_response($instances->to_api_err($response));
        }
        $c_instances->set($instances);
        $c_instances->expiresAfter(30);
        $lcache->save($c_instances);
    } else {
        $instances = $c_instances->get();
    }
    $response->getBody()->write(json_encode($instances));
    return json_response($response);
});

$app->run();