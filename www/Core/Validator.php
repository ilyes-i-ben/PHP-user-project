<?php

namespace App\Core;

class Validator
{
    private array $errors = [];

    public function required(string $field, $value): self
    {
        if (empty(trim($value))) {
            $this->errors[$field][] = "Le champ $field est requis.";
        }
        return $this;
    }

    public function email(string $field, $value): self
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "L'email n'est pas valide.";
        }
        return $this;
    }

    public function unique(string $field, $value, callable $existsCallback): self
    {
        if ($existsCallback($value)) {
            $this->errors[$field][] = "Le champ $field doit être unique.";
        }
        return $this;
    }

    public function matchPassword(string $password, string $passwordConfirm): self
    {
        if ($password !== $passwordConfirm) {
            $this->errors['password'][] = "Les mots de passe ne se corresepondent pas.";
        }
        return $this;
    }

    public function validName(string $name): self
    {
        if (strlen($name) < 2) {
            $this->errors['firstName'][] = "Le nom ou prénom n'est pas valide";
        }
        return $this;
    }
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }
}
