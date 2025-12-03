<?php
require 'config.php';

// ID du technicien connecté
$idConnecte = $_SESSION['id_technicien'] ?? 0;

// ID du profil affiché dans le formulaire
$idProfil = $_POST['id_technicien'] ?? 0;

// Vérification de sécurité
if ($idConnecte !== (int) $idProfil) {
    die("Action non autorisée.");
}

// Si le fichier est envoyé
if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] === 0) {
    $dossier = 'uploads/';
    $nomFichier = basename($_FILES['photo_profil']['name']);
    $chemin = $dossier . $nomFichier;

    if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $chemin)) {
        // Mettre à jour la base de données
        $stmt = $bdd->prepare("UPDATE technicien SET photo_profil = ? WHERE id_technicien = ?");
        $stmt->execute([$chemin, $idConnecte]);
        echo "Photo mise à jour avec succès !";
    } else {
        echo "Erreur lors de l'upload.";
    }
}
