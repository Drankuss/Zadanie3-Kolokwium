<?php

namespace Apsl\Http;


class Request
{
    const HEADER_ACCEPT_LANGUAGE = 'Accept-Language';
    const HEADER_ACCEPT = 'Accept';
    const HEADER_USER_AGENT = 'User-Agent';
    const METHOD_POST = 'post';
    const METHOD_GET = 'get';

    public function getUri(bool $withQueryString = true): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        if ($withQueryString === false) {
            $uriParts = explode('?', $uri);
            $uri = $uriParts[0];
        }

        return $uri;
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isMethod(string $method)
    {
        return $this->getMethod() === strtolower($method);
    }

    public function isHttps(): bool
    {
        return !empty($_SERVER['HTTPS']);
    }

    public function getHeader(string $name): ?string
    {
        $key = 'HTTP_' . str_replace('-', '_', strtoupper($name));

        return ($_SERVER[$key] ?? null);
    }

    public function getValue(string $name, $default = null)
    {
        return ($_REQUEST[$name] ?? $default);
    }

    public function getGetValue(string $name, $default = null)
    {
        return ($_GET[$name] ?? $default);
    }

    public function getPostValue(string $name, $default = null)
    {
        return ($_POST[$name] ?? $default);
    }

    public function getCookieValue(string $name, $default = null)
    {
        return ($_COOKIE[$name] ?? $default);
    }
}
