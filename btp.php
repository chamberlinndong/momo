
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techniciens BTP</title>
    <link rel="stylesheet" href="menu.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">
</head>

<body>

<!-- ================= HEADER ================= -->
<?php
require 'config.php';
include 'header.php';

?>
<!-- ================= MAIN CONTENT ================= -->
<main class="main-content">
    <div class="taff">
        <?php
        // Pagination et recherche
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Requête techniciens BTP
        if (!empty($search)) {
            $sql = "SELECT t.*, p.id_publication, p.photo AS photo_publication, p.description AS description_publication, p.date AS date_publication
                    FROM technicien t
                    LEFT JOIN publication p ON t.id_technicien = p.id_technicien
                    WHERE t.categorie = 'BTP' AND (t.metier LIKE :search OR t.ville LIKE :search)
                    LIMIT :limit OFFSET :offset";
            $req = $bdd->prepare($sql);
            $req->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        } else {
            $sql = "SELECT t.*, p.id_publication, p.photo AS photo_publication, p.description AS description_publication, p.date AS date_publication
                    FROM technicien t
                    LEFT JOIN publication p ON t.id_technicien = p.id_technicien
                    WHERE t.categorie = 'BTP'
                    LIMIT :limit OFFSET :offset";
            $req = $bdd->prepare($sql);
        }
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);

        $req->execute();
        $techniciens = $req->fetchAll(PDO::FETCH_ASSOC);

        if ($techniciens):
            foreach ($techniciens as $user):
                $icone = 'fas fa-hard-hat'; // Icône BTP
                ?>
                        <div class="container">
                            <div class="vendeur">
                                <a href="profil.php?photo_profil=<?php echo urlencode($user['photo_profil']); ?>&id_technicien=<?php echo urlencode($user['id_technicien']); ?>&identite=<?php echo urlencode($user['identite']); ?>&metier=<?php echo urlencode($user['metier']); ?>&qualification=<?php echo urlencode($user['qualification']); ?>&photo=<?php echo isset($user['photo_publication']) ? urlencode($user['photo_publication']) : ''; ?>">
                                    <div class="box-publication">
                                        <div class="photo-vendeur">
                                            <img src="<?php echo htmlspecialchars($user['photo_profil']); ?>" alt="Photo de <?php echo htmlspecialchars($user['identite']); ?>">
                                        </div>
                                        <p class="identite"><?php echo htmlspecialchars($user['identite']); ?></p>
                                    </div>
                                </a>
                                <div class="localisation">
                                    <p><i class="fas fa-map-marker-alt orange-icon"></i> <?php echo htmlspecialchars($user['localisation']); ?></p>
                                    <p class="ville"><?php echo htmlspecialchars($user['ville']); ?></p>
                                </div>
                            </div>

                            <div class="marsbis" style="background-image: url('<?php echo (!empty($user['photo_publication']) && file_exists($user['photo_publication'])) ? htmlspecialchars($user['photo_publication']) : 'images/default-photo.jpg'; ?>');"></div>

                            <div class="box2">
                                <p class="metier"><?php echo htmlspecialchars($user['metier']); ?></p>
                                <div class="attributs">
                                    <p><?php echo htmlspecialchars($user['qualification']); ?></p>
                                </div>
                                <div class="vendeur">
                                    <div class="contact">
                                        <a href="profil.php?photo_profil=<?php echo urlencode($user['photo_profil']); ?>&id_technicien=<?php echo urlencode($user['id_technicien']); ?>&identite=<?php echo urlencode($user['identite']); ?>&metier=<?php echo urlencode($user['metier']); ?>&qualification=<?php echo urlencode($user['qualification']); ?>&photo=<?php echo isset($user['photo_publication']) ? urlencode($user['photo_publication']) : ''; ?>">
                                            <button id="découvrir">Découvrir</button>
                                        </a>
                                    </div>
                                    <div class="BTP">
                                        <p>
                                            <a class="categorie-link" href="<?php echo strtolower($user['categorie']); ?>.php?categorie=<?php echo urlencode($user['categorie']); ?>">
                                                <i class="<?php echo $icone; ?>"></i> <?php echo htmlspecialchars($user['categorie']); ?>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
            endforeach;
        else:
            echo "<p>Aucun technicien BTP trouvé.</p>";
        endif;
        ?>
    </div>
</main>

<!-- ================= PAGINATION ================= -->
<div class="pagination">
    <?php
    $totalReq = !empty($search)
        ? $bdd->prepare("SELECT COUNT(*) FROM technicien WHERE categorie='BTP' AND (metier LIKE :search OR ville LIKE :search)")
        : $bdd->prepare("SELECT COUNT(*) FROM technicien WHERE categorie='BTP'");
    if (!empty($search))
        $totalReq->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $totalReq->execute();
    $totalArticles = $totalReq->fetchColumn();
    $totalPages = ($totalArticles > 0) ? ceil($totalArticles / $limit) : 1;

    if ($page > 1)
        echo '<a href="?page=' . ($page - 1) . '&search=' . urlencode($search) . '" class="page-link">Précédent</a>';
    for ($i = 1; $i <= $totalPages; $i++)
        echo '<a href="?page=' . $i . '&search=' . urlencode($search) . '" class="page-link ' . ($i == $page ? 'active' : '') . '">' . $i . '</a>';
    if ($page < $totalPages)
        echo '<a href="?page=' . ($page + 1) . '&search=' . urlencode($search) . '" class="page-link">Suivant</a>';
    ?>
</div>

<!-- ================= FOOTER ================= -->
<?php
include 'footer.php';

?>

</body>
</html>
