<?php
require 'config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification de la présence des champs
    if (empty($_POST['nom']) || empty($_POST['telephone']) || empty($_POST['email']) || empty($_POST['mdp'])) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont obligatoires.']);
        exit;
    }

    // Récupération et sécurisation des données
    $nom = htmlspecialchars($_POST['nom']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $email = htmlspecialchars($_POST['email']);
    $mdp = $_POST['mdp'];

    // Vérifier si un fichier a été envoyé
    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== 0) {
        echo json_encode(['success' => false, 'message' => 'Aucune photo téléchargée ou erreur lors du téléchargement.']);
        exit;
    }

    // Traitement du fichier image
    $dossier = 'image/';
    if (!is_dir($dossier)) {
        mkdir($dossier, 0777, true);
    }

    $fichier = basename($_FILES['photo']['name']);
    $chemin = $dossier . $fichier;

    $fileInfo = getimagesize($_FILES['photo']['tmp_name']);
    if ($fileInfo === false) {
        echo json_encode(['success' => false, 'message' => 'Le fichier téléchargé n\'est pas une image.']);
        exit;
    }

    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $chemin)) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors du déplacement de l\'image.']);
        exit;
    }

    try {
        $compte = 'INSERT INTO user (nom, telephone, email, photo, mdp) VALUES (?, ?, ?, ?, ?)';
        $req = $bdd->prepare($compte);
        $req->execute([$nom, $telephone, $email, $chemin, $mdp]);

        echo json_encode(['success' => true, 'message' => 'Utilisateur ajouté avec succès !']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()]);
    }
}
?>