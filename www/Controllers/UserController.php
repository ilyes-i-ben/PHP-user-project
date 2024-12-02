<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\User;

class UserController
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->save();

            header('Location: /login');
        } else {
            $view = new View("Auth/register.php");
        }
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = new User();
            $user = $user->findByEmail($email);
            if ($user && password_verify($password, hash: $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location:  /');
            } else {
                header('Location: /login');
            }
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

