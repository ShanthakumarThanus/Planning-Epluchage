<?php
require 'vendor/autoload.php';

use App\Models\UserModel;

$message = '';

if (isset($_POST['register'])) {
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validation des mots de passe
    if ($password === $confirmPassword) {
        $userModel = new UserModel();
        
        // Créer un nouvel utilisateur avec l'email, le nom d'utilisateur et le mot de passe
        if ($userModel->createUser($email, $username, $password)) {
            $message = 'Compte créé avec succès.';
        } else {
            $message = 'Erreur lors de la création du compte.';
        }
    } else {
        $message = 'Les mots de passe ne correspondent pas.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="email"],
        input[type="text"],
        input[type="password"] {
            width: 100%; /* Utiliser toute la largeur disponible */
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1em;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .message {
            margin-top: 20px;
            color: red;
        }

        a {
            color: #5cb85c;
            text-decoration: none;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Créer un compte</h1>

    <form action="" method="post">
        <label for="email">Email :</label>
        <input type="email" name="email" required>
        
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" required>
        
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required>
        
        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" name="confirm_password" required>
        
        <button type="submit" name="register">S'inscrire</button>
    </form>

    <?php if (!empty($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <p>Déjà un compte ? <a href="index.php?page=login">Connectez-vous</a></p>
</div>

</body>
</html>
