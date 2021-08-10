<?php

namespace App\Http;

class Response
{
  private int $httpCode = 200;
  private array $headers = [];
  private string $contentType = 'text/html';
  private $content;

  public function __construct($content, int $httpCode = 200)
  {
    $this->httpCode = $httpCode;
    $this->content = $content;
  }

  public function sendHeaders()
  {
    http_response_code($this->httpCode);

    foreach ($this->headers as $key => $value) {
      header($key . ':', $value);
    }
  }

  public function sendResponse()
  {
    $this->sendHeaders();

    switch ($this->contentType) {
      case "text/html":
        echo $this->content;
        exit;
    }
  }
}
