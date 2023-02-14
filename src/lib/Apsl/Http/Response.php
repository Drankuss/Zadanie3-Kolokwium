<?php

namespace Apsl\Http;


use Apsl\Html\Template;

class Response
{
    const HEADER_CONTENT_TYPE = 'Content-Type';
    const HEADER_CONTENT_LENGTH = 'Content-Length';
    const HEADER_LOCATION = 'Location';
    const STATUS_CODE_200_OK = 200;
    const STATUS_CODE_301_MOVED_PERMANENTLY = 301;
    const STATUS_CODE_302_FOUND = 302;
    const STATUS_CODE_403_FORBIDDEN = 403;
    const STATUS_CODE_404_NOT_FOUND = 404;
    const STATUS_CODE_500_SERVER_ERROR = 500;

    protected array $headers = [];
    protected string $body = '';
    protected int $statusCode = self::STATUS_CODE_200_OK;

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function addHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    public function deleteHeader(string $name): void
    {
        unset($this->headers[$name]);
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function useTemplate(string $template, array $params = []): void
    {
        $template = new Template($template);
        $out = $template->render($params);
        $this->setBody($out);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function send(): void
    {
        $this->sendHeaders();

        echo $this->body;
    }

    protected function sendHeaders(): void
    {
        http_response_code($this->statusCode);

        $contentLength = strlen($this->body);
        $this->addHeader(self::HEADER_CONTENT_LENGTH, $contentLength);

        foreach ($this->headers as $header => $value) {
            $headerString = (($value === null) ? $header : "{$header}: {$value}");
            header($headerString);
        }
    }

    public function clearHeaders(): void
    {
        $this->headers = [];
    }

    /**
     * Redirect will clear all headers and body to be sent.
     */
    public function redirect(string $uri, int $code = self::STATUS_CODE_302_FOUND): void
    {
        $this->clearHeaders();
        $this->body = '';

        $this->statusCode = $code;
        $this->addHeader(self::HEADER_LOCATION, $uri);
    }

    /**
     * Sets cookie, but be aware, value can't be empty.
     */
    public function setCookie(string $name, string $value, ?int $lifetime = null): void
    {
        $expiration = time() + $lifetime;
        setcookie($name, "{$value}", $expiration);

        $_COOKIE[$name] = $value;
    }

    public function deleteCookie(string $name): void
    {
        $this->setCookie(name: $name, value: '');

        unset($_COOKIE[$name]);
    }
}
