<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use App\Core\SQL;
use App\Core\Validator;

class UserController
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = new SQL();
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator();

            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['passwordConfirm'] ?? '';
            $firstname = $_POST['firstname'] ?? '';
            $lastname = $_POST['lastname'] ?? '';
            $country = $_POST['country'] ?? '';

            $user = new User();

            $validator
                ->required('username', $username)
                ->required('email', $email)
                ->email('email', $email)
                ->unique('email', $email, fn($value) => $user->findByEmail($value) !== null)
                ->required('password', $password)
                ->strongPassword('password', $password)
                ->required('passwordConfirm', $passwordConfirm)
                ->match('password', $password, 'passwordConfirm', $passwordConfirm)
                ->required('firstname', $firstname)
                ->alpha('firstname', $firstname)
                ->required('lastname', $lastname)
                ->alpha('lastname', $lastname)
                ->required('country', $country);

            if ($validator->passes()) {
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setPassword($password);
                $user->setFirstname($firstname);
                $user->setLastname($lastname);
                $user->setCountry($country);
                $user->save();

                header('Location: /login');
                exit();
            } else {
                $errors = $validator->getErrors();
                $view = new View("Auth/register.php");
                $view->addData('errors', $errors);  
            }
        } else {
            $view = new View("Auth/register.php");
        }
    }


    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator();
    
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
    
            $user = new User();
    
            $validator
                ->required('email', $email)
                ->email('email', $email)
                ->required('password', $password);
    
            if ($validator->passes()) {
                $userData = $user->findByEmail($email);
                if ($userData) {

                    if (isset($userData['password']) && password_verify($password, $userData['password'])) {
                        $_SESSION['user_id'] = $userData['id'];
                        $_SESSION['username'] = $userData['username'];
    
                        header('Location: /');
                        exit();
                    } else {
                        $errors['password'][] = "Identifiants incorrects.";
                    }
                } else {
                    $errors['email'][] = "Aucun utilisateur trouvé avec cet e-mail.";
                }
            } else {
                $errors = $validator->getErrors();
            }
            $view = new View("Auth/login.php");
            $view->addData('errors', $errors);
        } else {
            $view = new View("Auth/login.php");
        }
    }
    

    public function logout(): void
    {
        session_destroy();
        header('Location: /login');
    }
}
