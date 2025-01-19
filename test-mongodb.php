<?php

require 'vendor/autoload.php'; // Assurez-vous que vous avez installé MongoDB via Composer

use MongoDB\Client;

try {
    // Se connecter à MongoDB
    $client = new Client("mongodb://localhost:27017");
    echo "Connexion à MongoDB réussie !<br>";
} catch (Exception $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

// Sélectionner la base de données 'Gymnases'
$database = $client->Gymnases;

// Sélectionner la collection 'gymnases'
$collection = $database->gymnases;

// Récupérer tous les documents de la collection
$documents = $collection->find()->toArray();

// Vérifier s'il y a des documents
if (empty($documents)) {
    echo "Aucun document trouvé dans la collection.<br>";
} else {
    echo "Documents récupérés avec succès.<br>";

    // Afficher chaque document
    echo "Liste des gymnases :<br>";
    foreach ($documents as $document) {
        // Afficher le document dans un format lisible
        echo "<pre>";
        echo "ID : " . (string)$document['_id'] . "<br>"; // Convertir _id en chaîne
        echo "IdGymnase : " . $document['IdGymnase'] . "<br>";
        echo "NomGymnase : " . $document['NomGymnase'] . "<br>";
        echo "Adresse : " . $document['Adresse'] . "<br>";
        echo "Ville : " . $document['Ville'] . "<br>";
        echo "Surface : " . $document['Surface'] . " m²<br><br>";
        echo "</pre>";
    }
}
?>
