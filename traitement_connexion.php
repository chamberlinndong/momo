<?php
session_start();
header('Content-Type: application/json');


require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $mdp = trim($_POST['mdp']);

    // 🔹 Recherche dans user
    $sqlUser = "SELECT * FROM user WHERE email = :email AND mdp = :mdp";
    $reqUser = $bdd->prepare($sqlUser);
    $reqUser->execute(['email' => $email, 'mdp' => $mdp]);
    $user = $reqUser->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Session pour utilisateur
        $_SESSION['id'] = $user['id_user'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['telephone'] = $user['telephone'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['photo'] = $user['photo'];
        $_SESSION['type'] = 'user';

        echo json_encode([
            'success' => true,
            'message' => 'Connexion réussie',
            'redirect' => 'index.php' // redirection selon type
        ]);
        exit;
    }

    // 🔹 Recherche dans technicien
    $sqlTech = "SELECT * FROM technicien WHERE email = :email AND mdp = :mdp";
    $reqTech = $bdd->prepare($sqlTech);
    $reqTech->execute(['email' => $email, 'mdp' => $mdp]);
    $tech = $reqTech->fetch(PDO::FETCH_ASSOC);

    if ($tech) {
        // Session pour technicien
        $_SESSION['type'] = 'technicien';
        $_SESSION['id_technicien'] = $tech['id_technicien'] ?? '';
        $_SESSION['identite'] = $tech['identite'] ?? '';
        $_SESSION['metier'] = $tech['metier'] ?? '';
        $_SESSION['qualification'] = $tech['qualification'] ?? '';
        $_SESSION['email'] = $tech['email'] ?? '';
        $_SESSION['ville'] = $tech['ville'] ?? '';
        $_SESSION['localisation'] = $tech['localisation'] ?? '';
        $_SESSION['photo_profil'] = $tech['photo_profil'] ?? '';
        $_SESSION['photo'] = $tech['photo_profil'] ?? '';

        echo json_encode([
            'success' => true,
            'message' => 'Connexion réussie',
            'redirect' => 'index.php' // redirection pour technicien
        ]);
        exit;
    }

    // 🔹 Si aucun résultat
    echo json_encode(['success' => false, 'message' => 'Nom ou mot de passe incorrect']);
}
?>