<?php

namespace App\Models;

class Login
{
    public function __construct()
    {
    }

    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login(string $document, string $password): bool
    {
        $validDocument = $_ENV['APP_LOGIN'];
        $validPassword = $_ENV['APP_PASSWORD'];

        return $document === $validDocument && $password === $validPassword;
    }

    public function setSession(string $document): void
    {
        $this->startSession();
        $_SESSION['document'] = $document;
    }

    public function logout(): void
    {
        $this->startSession();
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function isAuthenticated(): bool
    {
        $this->startSession();
        return isset($_SESSION['document']);
    }

    public function checkAuth(): void
    {
        if (!$this->isAuthenticated()) {
            header('Location: /login');
            exit;
        }
    }
}
