<?php

namespace Apsl\Controller;

use Apsl\Http\Request;
use Apsl\Http\Response;

abstract class Page
{
    protected Request $request;
    protected Response $response;

    abstract public function createResponse(): void;

    public function __construct(Request $request = null)
    {
        $this->request = $request ?? new Request();
        $this->response = new Response();
    }

    public function getResponse(): Response
    {
        $this->createResponse();

        return $this->response;
    }
}
