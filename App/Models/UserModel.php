<?php

namespace App\Models;

use MongoDB\Client;

class UserModel {
    private $collection;

    public function __construct() {
        $client = new Client("mongodb+srv://thanus:thanus@planning.17a75.mongodb.net/");
        $database = $client->selectDatabase('Planning');
        $this->collection = $database->selectCollection('users');
    }

    public function findUserByEmail($email) {
        return $this->collection->findOne(['email' => $email]);
    }

    public function createUser($email, $username, $password) {
        // Hacher le mot de passe pour la sécurité
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        // Vérifier si l'email existe déjà dans la base de données
        $existingUserByEmail = $this->collection->findOne(['email' => $email]);
        if ($existingUserByEmail) {
            return 'L\'email est déjà utilisé.';  // Retourne un message d'erreur
        }
    
        // Vérifier si le nom d'utilisateur existe déjà dans la base de données
        $existingUserByUsername = $this->collection->findOne(['username' => $username]);
        if ($existingUserByUsername) {
            return 'Le nom d\'utilisateur est déjà pris.';  // Retourne un message d'erreur
        }
    
        // Insérer le nouvel utilisateur dans la base de données
        $result = $this->collection->insertOne([
            'email' => $email,
            'username' => $username,
            'password' => $passwordHash
        ]);
        
        // Si l'insertion est réussie
        if ($result->getInsertedCount() > 0) {
            return true;  // Enregistrement réussi
        } else {
            return 'Erreur lors de l\'enregistrement de l\'utilisateur.';  // Retourne un message d'erreur si échec
        }
    }
    
}
