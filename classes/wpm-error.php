<?php

use Slim\Psr7\Response;

class WPM_Error {

    private $code;
    private $message;
    private $data;

    function __construct(String $code, String $message = '', array $data = []) {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    function to_api_err(Response $response) {
        $response->getBody()->write(json_encode([
            "success"    => false,
            "data"      => [
                'code'      => $this->code,
                'message'   => $this->message,
                'data'      => empty($this->data)? null : $this->data
            ]
        ]));
    }

    static function is_wpm_error($error) {
        if (empty($error)) return false;
        return $error instanceof WPM_Error;
    }
}
