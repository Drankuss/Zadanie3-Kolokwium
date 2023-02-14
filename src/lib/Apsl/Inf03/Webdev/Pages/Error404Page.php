<?php

namespace Apsl\Inf03\Webdev\Pages;

use Apsl\Controller\Page;
use Apsl\Http\Response;

class Error404Page extends Page
{
    public function createResponse(): void
    {
        $this->response->setStatusCode(Response::STATUS_CODE_404_NOT_FOUND);
        $this->response->useTemplate('templates/404.html.php');
    }
}
