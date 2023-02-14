<?php

namespace Apsl\Controller;

use Apsl\Config\Config;
use Apsl\Http\Request;


class Application
{
    public function run(): void
    {
        $request = new Request();
        $uri = $request->getUri(withQueryString: false);
        $config = new Config('config/routing.php');
        $routing = $config->getValue('routing');

        $pageClass = $routing[$uri] ?? $config->getValue('_404');
        $page = new $pageClass($request);
        $response = $page->getResponse();
        $response->send();
    }
}
