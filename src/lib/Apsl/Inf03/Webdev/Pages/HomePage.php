<?php

namespace Apsl\Inf03\Webdev\Pages;

use Apsl\Controller\Page;
use Apsl\Http\Response;

class HomePage extends Page
{
    public function createResponse(): void
    {
        $this->response->addHeader(Response::HEADER_CONTENT_TYPE, 'text/html');
        $this->response->useTemplate('templates/index.html.php', [
            'title' => 'Hello!'
        ]);
    }
}
