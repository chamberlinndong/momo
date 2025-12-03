<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techniciens</title>

    <!-- Feuille de style principale -->
    <link rel="stylesheet" href="menu.css">

    <!-- Icônes Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Police Gilroy -->
    <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">
</head>

<body>

    <!-- ==================== HEADER ==================== -->
    <?php include 'header.php'; ?>

    <!-- ==================== CONTENU PRINCIPAL ==================== -->
    <main class="main-content">
        <div class="taff">

            <?php
            // Récupération de la page et du mot-clé de recherche
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
            $limit = 6;
            $offset = ($page - 1) * $limit;
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Connexion à la base
            require 'config.php';

            // Requête SQL (search + jointure)
            if (!empty($search)) {
                $afficher = "
                    SELECT 
                        technicien.id_technicien, technicien.identite, technicien.metier,
                        technicien.email, technicien.ville, technicien.localisation,
                        technicien.qualification, technicien.photo_profil, technicien.categorie,
                        publication.id_publication, publication.photo AS photo_publication,
                        publication.description AS description_publication,
                        publication.date AS date_publication
                    FROM technicien
                    LEFT JOIN publication 
                        ON technicien.id_technicien = publication.id_technicien
                    WHERE technicien.metier LIKE :search
                       OR technicien.ville LIKE :search
                       OR technicien.categorie LIKE :search
                    LIMIT :limit OFFSET :offset
                ";

                $req = $bdd->prepare($afficher);
                $req->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

            } else {

                $afficher = "
                    SELECT 
                        technicien.id_technicien, technicien.identite, technicien.metier,
                        technicien.email, technicien.ville, technicien.localisation,
                        technicien.qualification, technicien.photo_profil, technicien.categorie,
                        publication.id_publication, publication.photo AS photo_publication,
                        publication.description AS description_publication,
                        publication.date AS date_publication
                    FROM technicien
                    LEFT JOIN publication 
                        ON technicien.id_technicien = publication.id_technicien
                    LIMIT :limit OFFSET :offset
                ";

                $req = $bdd->prepare($afficher);
            }

            // Pagination params
            $req->bindValue(':limit', $limit, PDO::PARAM_INT);
            $req->bindValue(':offset', $offset, PDO::PARAM_INT);

            try {
                $req->execute();
                $techniciens = $req->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'Erreur SQL : ' . $e->getMessage();
                exit;
            }

            // Affichage
            if (count($techniciens) > 0):

                foreach ($techniciens as $user):

                    // Icones selon catégorie
                    switch ($user['categorie']) {
                        case 'BTP':
                            $icone = 'fas fa-hard-hat';
                            break;
                        case 'mecanique':
                            $icone = 'fas fa-cogs';
                            break;
                        case 'artisanat':
                            $icone = 'fas fa-hammer';
                            break;
                        case 'bois':
                            $icone = 'fas fa-tree';
                            break;
                        case 'TIC':
                            $icone = 'fas fa-laptop';
                            break;
                        default:
                            $icone = 'fas fa-question-circle';
                            break;
                    }

                    // Nom en minuscules
                    $user['identite'] = strtolower($user['identite']);
                    ?>

                    <?php if (isset($user['id_publication'])): ?>

                        <div class="container">

                            <!-- Vendeur -->
                            <div class="vendeur">
                                <a href="profil.php?photo_profil=<?php echo $user['photo_profil']; ?>
                            &id_technicien=<?php echo urlencode($user['id_technicien']); ?>
                            &identite=<?php echo urlencode($user['identite']); ?>
                            &metier=<?php echo urlencode($user['metier']); ?>
                            &qualification=<?php echo urlencode($user['qualification']); ?>
                            &photo=<?php echo isset($user['photo_publication'])
                                ? urlencode($user['photo_publication']) : ''; ?>">

                                    <div class="box-publication">
                                        <div class="photo-vendeur">
                                            <img src="<?php echo htmlspecialchars($user['photo_profil']); ?>"
                                                alt="Photo de <?php echo htmlspecialchars($user['identite']); ?>">
                                        </div>
                                        <p class="identite"><?php echo htmlspecialchars($user['identite']); ?></p>
                                    </div>

                                </a>

                                <div class="localisation">
                                    <i class="fas fa-map-marker-alt orange-icon"></i>
                                    <p><?php echo htmlspecialchars($user['localisation']); ?></p>
                                    <p class="ville"><?php echo htmlspecialchars($user['ville']); ?></p>
                                </div>
                            </div>

                            <!-- Photo publication -->
                            <div class="marsbis" style="background-image: url('<?php
                            if (!empty($user['photo_publication']) && file_exists($user['photo_publication'])) {
                                echo htmlspecialchars($user['photo_publication']);
                            } else {
                                echo 'images/default-photo.jpg';
                            }
                            ?>');">
                            </div>

                            <!-- Informations -->
                            <div class="box2">

                                <p class="metier"><?php echo htmlspecialchars($user['metier']); ?></p>

                                <div class="attributs">
                                    <p><?php echo htmlspecialchars($user['description_publication']); ?></p>
                                </div>

                                <div class="vendeur">

                                    <!-- Bouton découvrir -->
                                    <div class="email">
                                        <a href="profil.php?photo_profil=<?php echo $user['photo_profil']; ?>
                                    &id_technicien=<?php echo urlencode($user['id_technicien']); ?>
                                    &identite=<?php echo urlencode($user['identite']); ?>
                                    &metier=<?php echo urlencode($user['metier']); ?>
                                    &qualification=<?php echo urlencode($user['qualification']); ?>
                                    &photo=<?php echo isset($user['photo_publication'])
                                        ? urlencode($user['photo_publication']) : ''; ?>">
                                            <button id="découvrir">Découvrir</button>
                                        </a>
                                    </div>

                                    <!-- Catégorie -->
                                    <div class="BTP">
                                        <p>
                                            <a class="categorie-link"
                                                href="<?php echo strtolower($user['categorie']); ?>.php?categorie=<?php echo urlencode($user['categorie']); ?>">
                                                <i class="<?php echo $icone; ?>"></i>
                                                <?php echo htmlspecialchars($user['categorie']); ?>
                                            </a>
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>

                    <?php endif; endforeach;

            else:
                echo "<p>Aucun technicien trouvé.</p>";
            endif;

            ?>

        </div>
    </main>

    <!-- ==================== PAGINATION ==================== -->
    <div class="pagination">

        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>" class="page-link">
                Précédent
            </a>
        <?php endif; ?>

        <?php
        // Total pages
        if (!empty($search)) {
            $totalArticlesReq = $bdd->prepare("
                SELECT COUNT(DISTINCT technicien.id_technicien)
                FROM technicien
                LEFT JOIN publication ON technicien.id_technicien = publication.id_technicien
                WHERE technicien.metier LIKE :search
                   OR technicien.ville LIKE :search
                   OR technicien.categorie LIKE :search
            ");
            $totalArticlesReq->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        } else {
            $totalArticlesReq = $bdd->prepare("
                SELECT COUNT(DISTINCT technicien.id_technicien)
                FROM technicien
                LEFT JOIN publication ON technicien.id_technicien = publication.id_technicien
            ");
        }

        $totalArticlesReq->execute();
        $totalArticles = $totalArticlesReq->fetchColumn();
        $totalPages = ($totalArticles > 0) ? ceil($totalArticles / $limit) : 1;

        for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"
                class="page-link <?php echo ($i == $page) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>" class="page-link">
                Suivant
            </a>
        <?php endif; ?>

    </div>

    <!-- ==================== FOOTER ==================== -->
    <?php include 'footer.php'; ?>

</body>

</html>