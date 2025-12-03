<?php
const DB_NAME = "boutique";
const DB_USER = "root";
const DB_MDP = "";
const DB_HOST = "localhost";
try {
    $bdd = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_MDP);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base']);
    exit;
}

?>