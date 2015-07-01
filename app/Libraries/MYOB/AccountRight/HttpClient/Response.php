<?php

namespace MYOB\AccountRight\HttpClient;

/*
 * Response object contains the response returned by the client
 */
class Response
{
    public function __construct($body, $code, $headers) {
        $this->body = $body;
        $this->code = $code;
        $this->headers = $headers;
    }
}
