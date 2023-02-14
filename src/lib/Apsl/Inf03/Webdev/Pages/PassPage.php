<?php

namespace Apsl\Inf03\Webdev\Pages;

use Apsl\Controller\Page;
use Apsl\Http\Request;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

use PDO;
use PDOException;

class PassPage extends Page
{
    public function createResponse(): void
    {
        $templateParams = [
            'title' => 'Hello There',
            'success' => $this->request->getGetValue('success', false)
        ];

        $errors = [];
        if ($this->request->isMethod(Request::METHOD_POST)) {
            $data = $this->request->getValue('check', []);
            $email = trim($data['email'] ?? '');

            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'Zły format emaila';
            }

            if (empty($errors)) {
                $transport = Transport::fromDsn("smtp://apsl-dev@gmx.com:apslDEV2023@mail.gmx.com:587");
                $mailer = new Mailer($transport);

                $losowe = rand(10000, 99999);

                $losowezaszyfrowane = sha1($losowe);


                $host = "localhost";
                $dbname = "db700444";
                $username = "root";
                $password = "";

                try {
                    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = $connection->prepare("UPDATE user_hash JOIN user ON user_hash.user_id = user.user_id SET hash = '$losowezaszyfrowane', crated_at = now() where email = '$email'");
                    $sql->execute();
                }
                catch(PDOException $error) {
                    echo "Error: " . $error->getMessage();
                }
                $connection = null;

                $msg = new Email();
                $msg->to($email);
                $msg->from('apsl-dev@gmx.com');
                $msg->subject('Message from new password form');

                $link = "http://localhost/setpass?kod=$losowe";

                $msg->text("Message sent is:\n:$link");

                $mailer->send($msg);

                $this->response->redirect($this->request->getUri() . '?success=1');
                return;
            }

            $templateParams['data'] = $data;
            $templateParams['errors'] = $errors;
        }

        $this->response->useTemplate('templates/newpassword.html.php', $templateParams);
    }
}