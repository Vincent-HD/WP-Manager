<?php

namespace WPM\Utils;

use Exception;
use Slim\Psr7\Response;
use WPM_Error;

class WPM_Utils {

    const START_CMD = 'php ' . ABSPATH . DIRECTORY_SEPARATOR . "wp-cli.phar";

    public static function is_wp_package_installed($name) {
        $packages = self::get_wp_packages();
        foreach ($packages as $package) {
            if ($package->name === $name)
                return true;
        }
        return false;
    }

    public static function get_wp_packages() {
        $packages = self::runcommand('package list --format=json');
        if (empty($packages)) {
            return false;
        }
        $packages = json_decode($packages);
        return $packages;
    }

    public static function runcommand($command) {
        if (!file_exists(ABSPATH . DIRECTORY_SEPARATOR . 'wp-cli.phar')) {
            return new WPM_Error('missing_wpcli', 'Please download and install wp-cli.phar here: ' . ABSPATH);
        }
        $result = exec(self::START_CMD . " $command", $output, $result_code);
        if ($result_code > 0) {
            return new WPM_Error('non_zero_code', 'Executed command returned a non zero code');
        }
        return $result ?? '';
    }

    /**
     * Add JSON header to a response
     *
     * @param Response $response
     * @return Response
     */
    public static function json_response(Response $response) {
        return $response->withHeader('Content-Type', 'application/json');
    }
}
