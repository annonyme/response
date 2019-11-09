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

        if($response->getContentType()) {
            try{
                header('Content-Type: ' . $response->getContentType());
            }
            catch(\Exception $e){

            }            
        }

        if($response->getCode()) {
            http_response_code((int) $response->getCode());
        }

        if($response->getDownloadFilename()) {
            header('Content-Disposition: attachment; filename="' . $response->getDownloadFilename() . '"');
        }

        if(isset($this->processors[$response->getContentType()])) {
            $response->setBody($this->processors[$response->getContentType()]($response->getBody()));
        }
        echo $response->getBody();       

        if($this->callbackFunction) {
            $f = $this->callbackFunction;
            $f(($response));
        }
        else {
            die();
        }
    }
}