<?php
class WPUtils {

    const START_CMD = 'php ' . ABSPATH . "\wp-cli.phar";

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
        $result = exec(self::START_CMD . " $command", $output, $result_code);
        if ($result_code > 0) {
            throw new Exception('An error occured during command execution at: ' . __FILE__ . ':' . __LINE__, 1);
        }
        return $result ?? '';
    }
}
