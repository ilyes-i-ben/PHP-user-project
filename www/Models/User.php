<?php

namespace App\Models;

use App\Models\Model;

class User extends Model
{
    private $username;
    private $email;
    private $password;

    public function __construct()
    {
        parent::__construct();
    }

    public function save(): bool
    {
        $stmt = $this->db->prepare(query: "INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$this->username, $this->email, $this->password]);
    }

    public function findByEmail($email): array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
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
}