<?php

use hannespries\response\Response;
use hannespries\response\ResponseOut;

class Test extends  \PHPUnit\Framework\TestCase{
    public function test_object() {
        $resp = new Response('test');

        $this->assertEquals(200, $resp->getCode());
        $this->assertEquals('test', $resp->getBody());
    }

    public function test_jsonResponse() {
        $body = ['test' => 'value'];
        $resp = new Response();
        $resp->setJsonBody($body);

        $this->assertEquals(200, $resp->getCode());
        echo $resp->getBody();
        $this->assertEquals('{"test":"value"}', $resp->getBody());
    }

    public function test_callback() {
        $value = null;
        $resp = new Response('test');

        //override die()
        $out = new ResponseOut(function ($response) use (&$value) {
            $value = $response->getBody();
        });
        $out->out($resp);

        $this->assertEquals('test', $value);
    }

    public function test_process() {
        $value = null;
        $resp = new Response('test');

        //override die()
        $out = new ResponseOut(function ($response) use (&$value) {
            $value = $response->getBody();
        });
        //change response body
        $out->addProcessor($resp->getContentType(), function($b) {
            $b .= '_23';
            return $b;
        });
        $out->out($resp);

        $this->assertEquals('test_23', $value);
    }
}    