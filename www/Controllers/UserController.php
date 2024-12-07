<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use App\Core\SQL;


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
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordConfirm = $_POST['passwordConfirm'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $country = $_POST['country'];

            $errors = [];

            if ($password !== $passwordConfirm) {
                $errors[] = "Les mots de passe ne correspondent pas.";
            }

            if (empty($username) || empty($email) || empty($password) || empty($firstname) || empty($lastname) || empty($country)) {
                $errors[] = "Tous les champs sont requis.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'email n'est pas valide.";
            }

            $user = new User();
            if ($user->findByEmail($email)) {
                $errors[] = "L'email est déjà utilisé.";
            }

            if (empty($errors)) {

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
                foreach ($errors as $error) {
                    echo "<p>$error</p>";
                }
            }
        } else {
            $view = new View("Auth/register.php");
        }
    }


    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];


            $errors = [];

            if (empty($email) || empty($password)) {
                $errors[] = "Veuillez remplir tous les champs.";
            }

            if (empty($errors)) {
                $user = new User();
                $userData = $user->findByEmail($email);

                if ($userData && isset($userData['password']) && password_verify($password, $userData['password'])) {
                    $_SESSION['user_id'] = $userData['id'];
                    $_SESSION['username'] = $userData['username'];

                    header('Location: /home');
                    exit();
                } else {
                    $errors[] = "Identifiants incorrects.";
                }
            }
            foreach ($errors as $error) {
                echo "<p>$error</p>";  // Afficher les erreurs
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

