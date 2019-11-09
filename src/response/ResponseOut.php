<?php
namespace hannespries\response;

class ResponseOut {
    private $callbackFunction = null;
    private $processors = [];

    public function __construct($callbackFunction = null) {
        $this->callbackFunction = $callbackFunction;
    }

    public function addProcessor($contentType, $processorFunction) {
        $this->processors[$contentType] = $processorFunction;
    }

    public function out(Response $response) {
        try{
            ob_clean();
        }
        catch(\Exception $e) {

        }
        
        if($response->getCode()) {
            http_response_code((int) $response->getCode());
        }

        if($response->getContentType()) {
            header('Content-Type: ' . $response->getContentType());
        }

        if($response->getDownloadFilename()) {
            header('Content-Disposition: attachment; filename="' . $response->getDownloadFilename() . '"');
        }

        if(isset($this->processors[$response->getContentType()])) {
            echo $this->processors[$response->getContentType()]($response->getBody());
        }
        else {
            echo $response->getBody();
        }        

        if($this->callbackFunction) {
            $this->callbackFunction();
        }
        else {
            die();
        }
    }
}