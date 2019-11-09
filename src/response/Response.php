<?php
namespace hannespries\response;

class Response {
    private $code = 200;
    private $contentType = 'text/html';
    private $body = '';
    private $downloadFilename = null;

    public function __construct($body, $code = null, $contentType = null) {
        $this->body = $body;
        if($code) {
            $this->code = $code;
        }
        if($contentType) {
            $this->contentType = $contentType;
        }
    }
 
    public function getContentType()
    {
        return $this->contentType;
    }
 
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }
 
    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function setJsonBody($body)
    {
        $this->body = json_encode($body);
    }

    public function getDownloadFilename()
    {
        return $this->downloadFilename;
    }

    public function setDownloadFilename($downloadFilename)
    {
        $this->downloadFilename = $downloadFilename;
    }
}