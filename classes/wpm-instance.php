<?php

namespace WPM\Instance;

use WPM\Utils\WPM_Utils as Utils;

class WPM_Instance
{
    private $db_name;
    private $db_user;
    private $db_password;
    private $db_host;
    private $table_prefix;

    static public function parse_all_wp_instances($path)
    {
        if (!Utils::is_wp_package_installed("wp-cli/find-command")) {
            Utils::runcommand("package install wp-cli/find-command");
        }
        $instances = json_decode(Utils::runcommand("find $path --max_depth=1 --fields=version,wp_path --format=json"));
        foreach ($instances as $instance) {            
            ['basename' => $wp_name] = pathinfo($instance->wp_path);
            $instance->wp_name = $wp_name;
        }
        return $instances;
    }

    static public function is_wp_packages_installed() {
        $packages = json_decode(self::runcommand("package list --format=json"));
    }
    function __construct($path_to_parse) {
    }

    public function runcommand($command) {
        $output = shell_exec('php ' . ABSPATH . "/wp-cli.phar $command");
        return $output;
    }
}