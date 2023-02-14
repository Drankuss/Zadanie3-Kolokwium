<?php

namespace Apsl\Inf03\Webdev\Pages;

use Apsl\Controller\Page;

class DatabaseTestPage extends Page
{
    public function createResponse(): void
    {
        $dbConfig = require 'config/db.php';
        $pdo = new \PDO($dbConfig['dsn'], $dbConfig['user'], $dbConfig['pass']);

        $name = $this->request->getValue('name');

        $stmt = $pdo->prepare('SELECT * FROM users WHERE users.name = :name');
        $stmt->bindValue('name', $name);

        $rows = $stmt->fetchAll();

        $this->response->useTemplate('templates/index.html.php');
    }
}
