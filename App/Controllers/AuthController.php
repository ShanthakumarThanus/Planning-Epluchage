<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController {
    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new UserModel();
            $user = $userModel->findUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = $user['_id'];
                header('Location: index.php?page=planning');
                exit;
            } else {
                $error = 'Identifiants incorrects.';
            }
        }
        include __DIR__ . '/../Views/auth/login.php';
    }

    public function register() {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $username = $_POST['username'];
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if ($password === $confirmPassword) {
                $userModel = new UserModel();
                if ($userModel->createUser($email, $username, $password)) {
                    $message = 'Compte créé avec succès.';
                } else {
                    $message = 'Erreur lors de la création du compte.';
                }
            } else {
                $message = 'Les mots de passe ne correspondent pas.';
            }
        }
        include __DIR__ . '/../Views/auth/register.php';
    }
}
