<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\User;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Main
{
    public function __construct()
    {
    }

    public function home(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $userModel = new User();
        $user = $userModel->findById($userId);

        if ($user) {
            $view = new View("Main/home.php");
            $view->addData("username", $user['username']);
            $view->addData("email", $user['email']);
        } else {
            header('Location: /login');
        }
    }
}