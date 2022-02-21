<?php
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

define('ABSPATH', __DIR__);

require_once ABSPATH . '/classes/autoload.php';
require_once ABSPATH . '/vendor/autoload.php';

$lcache = new FilesystemAdapter();
require_once ABSPATH . '/vendor/wp-cli/wp-cli/php/utils.php';
require_once ABSPATH . '/utils_wrapper.php';
load_classes();
require_once ABSPATH . '/api/api.php';