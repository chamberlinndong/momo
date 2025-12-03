<?php
if (!empty($search)) {

    $sql = "SELECT 
                technicien.id_technicien,
                technicien.identite,
                technicien.metier,
                technicien.email,
                technicien.ville,
                technicien.localisation,
                technicien.qualification,
                technicien.photo_profil,
                technicien.categorie,
                publication.id_publication,
                publication.photo AS photo_publication,
                publication.description AS description_publication,
                publication.date AS date_publication
            FROM technicien
            LEFT JOIN publication 
                ON technicien.id_technicien = publication.id_technicien
            WHERE technicien.categorie = :categorie
              AND (technicien.metier LIKE :search OR technicien.ville LIKE :search)
            LIMIT :limit OFFSET :offset";

    $req = $bdd->prepare($sql);
    $req->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

} else {

    $sql = "SELECT 
                technicien.id_technicien,
                technicien.identite,
                technicien.metier,
                technicien.email,
                technicien.ville,
                technicien.localisation,
                technicien.qualification,
                technicien.photo_profil,
                technicien.categorie,
                publication.id_publication,
                publication.photo AS photo_publication,
                publication.description AS description_publication,
                publication.date AS date_publication
            FROM technicien
            LEFT JOIN publication 
                ON technicien.id_technicien = publication.id_technicien
            WHERE technicien.categorie = :categorie
            LIMIT :limit OFFSET :offset";

    $req = $bdd->prepare($sql);
}

$req->bindValue(':categorie', $categorie, PDO::PARAM_STR);
$req->bindValue(':limit', $limit, PDO::PARAM_INT);
$req->bindValue(':offset', $offset, PDO::PARAM_INT);

try {
    $req->execute();
    $techniciens = $req->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
    exit;
}

/* ====================================
   ======== AFFICHAGE DES FICHES =======
   ==================================== */

if (count($techniciens) > 0):
    foreach ($techniciens as $user):

        // Icône par défaut
        $icone = "fas fa-cogs";

        // Ici commence l’affichage HTML de chaque fiche,
        // la page principale ajoute le HTML juste après ce PHP.
        ?>

        <!-- TON HTML CONTINUE ICI -->

        <?php
    endforeach; // ← FERMETURE DE LA BOUCLE
endif; // ← FERMETURE DU IF PRINCIPAL
?>