<?php

namespace Apsl\Inf03\Webdev\Pages;

use Apsl\Controller\Page;
use Apsl\Http\Request;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use PDO;
use PDOException;

class SetPassPage extends Page
{
    function checkPassword($password) {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
      
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            return false;
        }else{
            return true;
        }
    }     
      
    public function createResponse(): void
    {
        $templateParams = [
            'title' => 'Hello There',
            'success' => $this->request->getGetValue('success', false)
        ];

        $errors = [];
        if ($this->request->isMethod(Request::METHOD_POST)) {
            $data = $this->request->getValue('password', []);
            $password = trim($data['pass'] ?? '');
            $rpassword = trim($data['repeatpass'] ?? '');
            $encrypted = sha1($password);

            if ($password != $rpassword) {
                $errors['pass'] = "Hasła nie są takie same";
            }
            
            $hashed = sha1($this->request->getGetValue("kod"));

            if (!$this->checkPassword($password)) {
                $errors['pass'] = "Hasło nie spełnia wymagań";
            }

            $host = "localhost";
            $dbname = "db700444";
            $username = "root";
            $password = "";

            try {
                $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = $connection->prepare("SELECT hash, crated_at FROM user_hash join user on user_hash.user_id = user.user_id where hash = '$hashed'");
                $sql->execute();
            
                $results = $sql->fetchAll(PDO::FETCH_ASSOC);

                if(sizeof($results) == 0){
                    $errors['pass'] = "Błędny kod";
                }

                foreach ($results as $row) {
                    $kodbazadanych = $row['hash'];
                    $created_at = $row['crated_at'];

                    if (time() - strtotime($created_at) >= 3600) {
                        $errors['pass'] = "Przeterminowany, minęła godzina";
                    }

                }
            }
            catch(PDOException $error) {
                echo "Error: " . $error->getMessage();
            }
            $connection = null;

            if (empty($errors)) {

                try {
                    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = $connection->prepare("UPDATE user JOIN user_hash ON user.user_id = user_hash.user_id SET password = '$encrypted' where hash = '$hashed'");
                    $sql->execute();
                }
                catch(PDOException $error) {
                    echo "Error: " . $error->getMessage();
                }
                $connection = null;

                try {
                    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = $connection->prepare("UPDATE user_hash SET hash = '---' where hash = '$hashed'");
                    $sql->execute();
                }
                catch(PDOException $error) {
                    echo "Error: " . $error->getMessage();
                }
                $connection = null;
                
                $this->response->redirect($this->request->getUri() . '?success=1');
                return;
            }

            $templateParams['data'] = $data;
            $templateParams['errors'] = $errors;
        }

        $this->response->useTemplate('templates/setpassword.html.php', $templateParams);
    }
}
