<?php

namespace App\Models;

use App\Models\Model;

class User extends Model
{
    private $username;
    private $email;
    private $password;
    private $firstname;
    private $lastname;
    private $country;


    public function __construct()
    {
        parent::__construct();
    }

    public function save(): bool
    {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, firstname, lastname, country) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$this->username, $this->email, $this->password, $this->firstname, $this->lastname, $this->country]);
        }
    public function findByEmail($email): array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ?: [];
    }

    public function findById($id): array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // getters et setters...
    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->password = $hashedPassword;


    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }
}