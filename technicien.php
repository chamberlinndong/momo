<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techniciens</title>
    <link rel="stylesheet" href="menu.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">
</head>

<body>
<?php
require 'header.php';

// Récupération de la catégorie et de la recherche
$categorie = $_GET['categorie'] ?? '';
$search = $_GET['search'] ?? '';

// Pagination
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Construction de la requête SQL
$sql = 'SELECT * FROM technicien WHERE 1';
$params = [];

// Filtre catégorie
if ($categorie != "") {
    $sql .= " AND categorie = :categorie";
    $params[':categorie'] = $categorie;
}

// Filtre recherche
if ($search != "") {
    $sql .= " AND (metier LIKE :search OR ville LIKE :search)";
    $params[':search'] = "%$search%";
}

// Pagination
$sql .= " LIMIT :offset, :limit";

$stmt = $bdd->prepare($sql);

// Lier les paramètres
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

$stmt->execute();
$techniciens = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Comptage total pour la pagination
$countSql = "SELECT COUNT(*) FROM technicien WHERE 1";
$countParams = [];

if ($categorie != "") {
    $countSql .= " AND categorie = :categorie";
    $countParams[':categorie'] = $categorie;
}

if ($search != "") {
    $countSql .= " AND (metier LIKE :search OR ville LIKE :search)";
    $countParams[':search'] = "%$search%";
}

$countStmt = $bdd->prepare($countSql);
foreach ($countParams as $key => $value) {
    $countStmt->bindValue($key, $value);
}
$countStmt->execute();
$totalArticles = $countStmt->fetchColumn();
$totalPages = max(1, ceil($totalArticles / $limit));
?>
    <main class="main-content">
        <nav class="nav-page">

            <div class="choix-categorie" style="padding:15px;">
                <form method="GET">
                    <select name="categorie" id="categorieSelect" onchange="this.form.submit()">
                        <option value="" <?= $categorie == "" ? "selected" : ""; ?>>Catégories</option>
                        <option value="mecanique" <?= $categorie == "mecanique" ? "selected" : ""; ?>>Mécanique</option>
                        <option value="artisanat" <?= $categorie == "artisanat" ? "selected" : ""; ?>>Artisanat</option>
                        <option value="bois" <?= $categorie == "bois" ? "selected" : ""; ?>>Bois</option>
                        <option value="btp" <?= $categorie == "btp" ? "selected" : ""; ?>>BTP</option>
                        <option value="tic" <?= $categorie == "tic" ? "selected" : ""; ?>>Électronique</option>
                    </select>
                </form>
            </div>

            <form action="" method="GET" class="search-form">
                <div class="search-container">
                    <input class="container-search1" type="text" name="search" placeholder="Recherche..."
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit" name="find" class="search-button">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
        </nav>

        <!-- CHOIX DE LA CATÉGORIE -->

        <div class="afficher">
            <!-- ================= AFFICHAGE DES TECHNICIENS ================= -->
            <?php if (!empty($techniciens)): ?>
                <?php foreach ($techniciens as $user): ?>

                    <div class="box-card">
                        <div class="card">
                       
                        <a href="profil.php?
                        photo_profil=<?= urlencode($user['photo_profil']); ?>
                        &id_technicien=<?= urlencode($user['id_technicien']); ?>
                        &identite=<?= urlencode($user['identite']); ?>
                        &metier=<?= urlencode($user['metier']); ?>
                        &qualification=<?= urlencode($user['qualification']); ?>
                        &photo=<?= isset($user['photo_publication']) ? urlencode($user['photo_publication']) : ''; ?>"> 
                        <div class="box-card-img" style="background-image: url('<?= htmlspecialchars($user['photo_profil']); ?>');"></div>
                        <p class="metier"><?= htmlspecialchars($user['metier']); ?></p>
                        </a>
                        
                         <div class="box-card-reference">
                            <p class="identite"><?= htmlspecialchars($user['identite']); ?></p>
                        <p><i class="fas fa-map-marker-alt orange-icon"></i> <?= htmlspecialchars($user['localisation']) . ', ' . htmlspecialchars($user['ville']); ?></p>
                        <p class="qualification"><?= htmlspecialchars($user['qualification']); ?></p>
                        </div>
                        </div>
                        
                       
                       
                        
                                <div class="BTP">
                                    <p>
                                        <a class="categorie-link" href="?categorie=<?= urlencode($user['categorie']); ?>">
                                            <?= htmlspecialchars($user['categorie']); ?>
                                        </a>
                                    </p>
                                </div>

                            
                        </div>
            
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center;margin:40px;">Aucun technicien trouvé dans cette catégorie.</p>
            <?php endif; ?>

            <!-- ============ PAGINATION ============ -->

        </div>

    </main>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a class="page-link"
                href="?page=<?= $page - 1; ?>&categorie=<?= urlencode($categorie); ?>&search=<?= urlencode($search); ?>">
                Précédent
            </a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a class="page-link <?= ($i == $page) ? 'active' : ''; ?>"
                href="?page=<?= $i; ?>&categorie=<?= urlencode($categorie); ?>&search=<?= urlencode($search); ?>">
                <?= $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a class="page-link"
                href="?page=<?= $page + 1; ?>&categorie=<?= urlencode($categorie); ?>&search=<?= urlencode($search); ?>">
                Suivant
            </a>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
    <script src="script.js"></script>

</body>

</html>