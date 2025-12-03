<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION['id_technicien'])) {
        header('Location: connexion.php');
        exit;
    }

    $id_profil = $_SESSION['id_technicien'];

    // Vérifie la présence de la description et de la photo
    if (empty($_POST['description']) || !isset($_FILES['photo'])) {
        echo "Description ou image manquante.";
        exit;
    }

    $dossier = 'image/';
    if (!is_dir($dossier)) {
        mkdir($dossier, 0777, true);
    }

    $image = $_FILES['photo'];
    $image_nom = basename($image['name']);
    $chemin = $dossier . $image_nom;

    // Vérifie si c’est bien une image
    $fileInfo = getimagesize($image['tmp_name']);
    if ($fileInfo === false) {
        echo "Le fichier n'est pas une image.";
        exit;
    }

    // Déplace l'image dans le dossier
    if (!move_uploaded_file($image['tmp_name'], $chemin)) {
        echo "Erreur lors du téléchargement de l'image.";
        exit;
    }

    // Insertion dans la base
    $insert = 'INSERT INTO publication (photo, description, id_technicien) VALUES (?, ?, ?)';
    $req = $bdd->prepare($insert);
    $req->execute([$chemin, $_POST['description'], $id_profil]);

    // Redirection vers le profil
    echo json_encode(['success' => true, 'message' => 'Nouvelle publication ajoutée avec succès !','redirect' => 'moncompte.php']);
    exit;

}
?>