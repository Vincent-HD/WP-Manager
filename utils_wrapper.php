<?php

use Slim\Psr7\Response;
use WPM\Utils\WPM_Utils;

/**
 * Procedural form of WPM_Utils\to_json_response()
 *
 * @param Response $response
 * @return Response
 */
function json_response(Response $response) {
    return WPM_Utils::json_response($response);
}

function is_wpm_error($error) {
    return WPM_Error::is_wpm_error($error);
}