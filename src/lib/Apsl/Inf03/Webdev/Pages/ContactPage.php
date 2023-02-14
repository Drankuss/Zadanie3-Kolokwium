<?php

namespace Apsl\Inf03\Webdev\Pages;

use Apsl\Controller\Page;
use Apsl\Http\Request;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class ContactPage extends Page
{
    public function createResponse(): void
    {
        $templateParams = [
            'title' => 'Contact',
            'success' => $this->request->getGetValue('success', false)
        ];

        $errors = [];
        if ($this->request->isMethod(Request::METHOD_POST)) {
            $data = $this->request->getValue('contact', []);
            $email = trim($data['email'] ?? '');
            $message = trim($data['message'] ?? '');

            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'Wrong e-mail format';
            }
            if (strlen($message) === 0) {
                $errors['message'] = "Message can't be empty";
            }

            if (empty($errors)) {
                $transport = Transport::fromDsn("smtp://apsl-dev@gmx.com:apslDEV2023@mail.gmx.com:587");
                $mailer = new Mailer($transport);

                $msg = new Email();
                $msg->to($email);
                $msg->from('apsl-dev@gmx.com');
                $msg->subject('Message from contact form');
                $sanitizedMessage = htmlentities($message);
                $msg->text("Message sent is:\n:$sanitizedMessage");
                $mailer->send($msg);

                $this->response->redirect($this->request->getUri() . '?success=1');
                return;
            }

            $templateParams['data'] = $data;
            $templateParams['errors'] = $errors;
        }

        $this->response->useTemplate('templates/contact.html.php', $templateParams);
    }
}
