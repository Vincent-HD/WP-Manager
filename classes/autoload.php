<?php

function load_classes() {
    $files = scandir(__DIR__);
    foreach ($files as $file) {
        if ($file ===  pathinfo(__FILE__)['basename'] || $file === '.' || $file === '..') {
            continue;
        }
        require_once $file;
    }
}