# Projet de Gestion de Planning d'épluchage

## Description

Ce projet est une application web permettant de gérer un planning de corvées d'épluchage. Chaque utilisateur peut s'inscrire, se connecter et être assigné à des tâches hebdomadaires dans un planning. L'application utilise **MongoDB** comme base de données pour stocker les informations des utilisateurs et les données liées aux corvées.

### Fonctionnalités principales :

1. **Inscription d'un utilisateur** : L'utilisateur peut s'inscrire avec un email, un nom d'utilisateur, et un mot de passe.
2. **Connexion** : Les utilisateurs peuvent se connecter avec leurs identifiants.
3. **Gestion du planning** : Les administrateurs peuvent attribuer des utilisateurs à chaque semaine du planning.
4. **Statistiques** : L'application affiche des statistiques sur le nombre de tâches attribuées à chaque utilisateur.

### Technologies utilisées :

- **PHP** : Langage de programmation pour la logique de l'application.
- **MongoDB** : Base de données NoSQL pour le stockage des données utilisateur et des informations sur le planning.
- **Composer** : Gestionnaire de dépendances PHP, utilisé pour installer MongoDB et autres dépendances.
- **HTML/CSS** : Pour l'interface utilisateur.

## Installation

### Pré-requis :

- PHP (version 7.4 ou supérieure)
- Composer (pour la gestion des dépendances PHP)
- MongoDB (Cloud ou local)

### Étapes d'installation :

1. **Cloner le projet** ou télécharger les fichiers de l'application sur votre serveur local ou votre serveur OVH.
   
   ```bash
   git clone https://github.com/votre-utilisateur/votre-repository.git

2. **Installation des dépendances via Composer.**

Ouvrez une terminal à la racine du projet et exécutez la commande suivante pour installer les dépendances nécessaires, notamment pour MongoDB.

composer install

3. **Configuration de MongoDB** :

Si vous utilisez MongoDB Cloud, vous pouvez vous connecter via l'URL de votre cluster MongoDB Cloud. Par exemple :

$client = new MongoDB\Client("mongodb+srv://<username>:<password>@cluster.mongodb.net/");

Si vous utilisez une instance MongoDB locale, remplacez l'URL par :

    $client = new MongoDB\Client("mongodb://localhost:27017");

    Configuration du serveur OVH (si applicable) :

    Attention : À ce jour, la liaison avec le serveur OVH ne fonctionne pas correctement pour les raisons suivantes :
        Le projet utilise le package MongoDB PHP Library, mais la connexion avec MongoDB via OVH n'a pas été configurée correctement dans l'environnement de production.
        MongoDB Cloud fonctionne correctement pour cette application, donc il est fortement recommandé d'utiliser MongoDB Cloud pour l'hébergement de la base de données, plutôt que d'essayer d'héberger MongoDB directement sur OVH.

Utilisation

    Accéder à l'application :

    Ouvrez votre navigateur et accédez à l'URL de votre serveur (https://projet-web-training.ovh/licence19/Planning-Epluchage/).

    S'inscrire ou se connecter :
        Vous pouvez vous inscrire avec un email, un nom d'utilisateur et un mot de passe.
        Après l'inscription, connectez-vous pour accéder à votre planning.

    Gestion du planning :
        Les administrateurs peuvent voir le planning et assigner des utilisateurs à chaque semaine.

    Statistiques :
        Vous pouvez voir les statistiques des utilisateurs et combien de tâches chaque utilisateur a été assigné.
    
    Thanus SHANTHAKUMAR
