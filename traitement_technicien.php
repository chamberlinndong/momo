<?php
require 'config.php';

// Fonction d'upload d'image
function uploadImage($file, $dir)
{
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file['name']);
        $filePath = $dir . $fileName;

        if (!is_dir($dir))
            mkdir($dir, 0777, true);

        $imageInfo = getimagesize($file['tmp_name']);
        if ($imageInfo !== false) {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($extension, $allowedExtensions)) {
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    return $filePath;
                } else {
                    echo json_encode(['success' => false, 'message' => "Erreur lors du déplacement du fichier."]);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'message' => "Extension non autorisée. JPG, JPEG, PNG uniquement."]);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => "Le fichier n'est pas une image valide."]);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => "Erreur d'upload : " . $file['error']]);
        exit;
    }

    return null;
}

// Traitement du formulaire
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identite = htmlspecialchars($_POST['identite'] ?? '');
    $metier = htmlspecialchars($_POST['metier'] ?? '');
    $qualification = htmlspecialchars($_POST['qualification'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $ville = htmlspecialchars($_POST['ville'] ?? '');
    $categorie = htmlspecialchars($_POST['categorie'] ?? '');
    $localisation = htmlspecialchars($_POST['localisation'] ?? '');
    $mdp = htmlspecialchars($_POST['mdp'] ?? '');

    $profilPhoto = uploadImage($_FILES['profil_photo'], 'profil/');

    if ($profilPhoto) {
        try {
            $sql = "INSERT INTO technicien 
                    (photo_profil, identite, metier, qualification, email, ville, localisation, categorie, mdp)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $req = $bdd->prepare($sql);
            $req->execute([$profilPhoto, $identite, $metier, $qualification, $email, $ville, $localisation, $categorie, $mdp]);

            echo json_encode(['success' => true, 'message' => 'Technicien ajouté avec succès !']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => "Erreur d'insertion : " . $e->getMessage()]);
        }
    }
}
?>
