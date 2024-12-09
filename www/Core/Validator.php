<?php

namespace App\Core;

class Validator
{
    private array $errors = [];

    /**
     * Vérifie si une valeur est vide.
     */
    public function required(string $field, $value): self
    {
        if (empty(trim($value))) {
            $this->errors[$field][] = "Le champ $field est requis.";
        }
        return $this;
    }

    /**
     * Vérifie si une adresse email est valide.
     */
    public function email(string $field, $value): self
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "Le champ $field doit contenir une adresse email valide.";
        }
        return $this;
    }

    /**
     * Vérifie si une valeur est unique dans une base de données.
     */
    public function unique(string $field, $value, callable $existsCallback): self
    {
        if ($existsCallback($value)) {
            $this->errors[$field][] = "Le champ $field doit être unique.";
        }
        return $this;
    }

    /**
     * Vérifie si deux champs correspondent.
     */
    public function match(string $field, $value, string $compareField, $compareValue): self
    {
        if ($value !== $compareValue) {
            $this->errors[$field][] = "Le champ $field doit correspondre au champ $compareField.";
        }
        return $this;
    }

    /**
     * Vérifie si une valeur respecte une longueur minimale.
     */
    public function minLength(string $field, $value, int $min): self
    {
        if (strlen($value) < $min) {
            $this->errors[$field][] = "Le champ $field doit contenir au moins $min caractères.";
        }
        return $this;
    }

    /**
     * Vérifie si une valeur respecte une longueur maximale.
     */
    public function maxLength(string $field, $value, int $max): self
    {
        if (strlen($value) > $max) {
            $this->errors[$field][] = "Le champ $field ne peut pas dépasser $max caractères.";
        }
        return $this;
    }

    /**
     * Vérifie si une chaîne ne contient que des lettres.
     */
    public function alpha(string $field, $value): self
    {
        if (!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $value)) {
            $this->errors[$field][] = "Le champ $field ne doit contenir que des lettres.";
        }
        return $this;
    }

    /**
     * Vérifie si un mot de passe est fort.
     */
    public function strongPassword(string $field, $value): self
    {
        $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{8,}$/';
        if (!preg_match($pattern, $value)) {
            $this->errors[$field][] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
        }
        return $this;
    }

    /**
     * Ajoute une validation personnalisée via une closure.
     */
    public function custom(string $field, $value, callable $callback, string $errorMessage): self
    {
        if (!$callback($value)) {
            $this->errors[$field][] = $errorMessage;
        }
        return $this;
    }

    /**
     * Retourne les erreurs.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Vérifie si la validation est réussie.
     */
    public function passes(): bool
    {
        return empty($this->errors);
    }
}
