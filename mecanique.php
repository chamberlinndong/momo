<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publications</title>
    <link rel="stylesheet" href="menu.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">
</head>

<body>

<?php
// (gptonline.ai) — page corrigée pour afficher les publications
require 'header.php';

// --- paramètres de base ---
$categorie = isset($_GET['categorie']) ? trim($_GET['categorie']) : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

// Construire WHERE (les filtres utilisent la table technicien aliasée t)
$whereClauses = [];
$params = [];

if ($categorie !== '') {
    $whereClauses[] = "t.categorie = :categorie";
    $params[':categorie'] = $categorie;
}

if ($search !== '') {
    // recherche sur metier, ville, identite et description de publication si besoin
    $whereClauses[] = "(t.metier LIKE :search OR t.ville LIKE :search OR t.identite LIKE :search OR p.description LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

$whereSql = '';
if (!empty($whereClauses)) {
    $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
}

// --------------------
// Requête principale : récupérer les publications (avec infos technicien)
// --------------------
$sql = "
    SELECT 
        p.*,
        t.identite,
        t.photo_profil,
        t.metier,
        t.categorie,
        t.localisation,
        t.ville
    FROM publication p
    INNER JOIN technicien t ON t.id_technicien = p.id_technicien
    {$whereSql}
    ORDER BY p.date_publication DESC
    LIMIT " . (int)$limit . " OFFSET " . (int)$offset . "
";


try {
    $stmt = $bdd->prepare($sql);
    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v);
    }
    $stmt->execute();
    $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log('SQL Error: ' . $e->getMessage());
    $publications = [];
}

// --------------------
// Comptage des publications (pour la pagination)
// --------------------
$countSql = "
    SELECT COUNT(*)
    FROM publication p
    INNER JOIN technicien t ON t.id_technicien = p.id_technicien
    {$whereSql}
";
try {
    $countStmt = $bdd->prepare($countSql);
    foreach ($params as $k => $v) {
        $countStmt->bindValue($k, $v);
    }
    $countStmt->execute();
    $totalArticles = (int) $countStmt->fetchColumn();
} catch (Exception $e) {
    error_log('Count SQL Error: ' . $e->getMessage());
    $totalArticles = 0;
}
$totalPages = max(1, (int) ceil($totalArticles / $limit));

// helper: construire query string pour liens en conservant filtres
function buildQuery(array $overrides = []) {
    $base = [];
    if (isset($_GET['categorie'])) $base['categorie'] = $_GET['categorie'];
    if (isset($_GET['search'])) $base['search'] = $_GET['search'];
    $final = array_merge($base, $overrides);
    return http_build_query($final);
}
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
                <!-- conserver la recherche lors du changement de catégorie -->
                <input type="hidden" name="search" value="<?= htmlspecialchars($search, ENT_QUOTES) ?>">
            </form>
        </div>

        <form action="" method="GET" class="search-form">
            <div class="search-container">
                <input class="container-search1" type="text" name="search" placeholder="Recherche..."
                       value="<?= htmlspecialchars($search, ENT_QUOTES) ?>">
                <!-- conserver la catégorie lors de la recherche -->
                <input type="hidden" name="categorie" value="<?= htmlspecialchars($categorie, ENT_QUOTES) ?>">
                <button type="submit" name="find" class="search-button">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
    </nav>

    <div class="afficher">
        <!-- ================= AFFICHAGE DES PUBLICATIONS ================= -->
   <?php if (!empty($publications)): ?>
    <?php foreach ($publications as $pub): ?>

        <?php
            $href = 'profil.php?' . http_build_query([
                'photo_profil' => $pub['photo_profil'] ?? '',
                'id_technicien' => $pub['id_technicien'] ?? '',
                'identite' => $pub['identite'] ?? '',
                'metier' => $pub['metier'] ?? '',
                'photo' => $pub['photo'] ?? ''
            ]);

            $identite = htmlspecialchars($pub['identite'] ?? '', ENT_QUOTES);
            $metier = htmlspecialchars($pub['metier'] ?? '', ENT_QUOTES);
            $description = htmlspecialchars($pub['description'] ?? '', ENT_QUOTES);
            $localisation = htmlspecialchars(trim(($pub['localisation'] ?? '') . (!empty($pub['ville']) ? ', ' . $pub['ville'] : '')), ENT_QUOTES);
            $date_pub = !empty($pub['date_publication']) ? htmlspecialchars($pub['date_publication'], ENT_QUOTES) : '';
        ?>
<table>
    <tr>
        <td>
             <article class="container">
            <div class="vendeur">
                <a href="<?= htmlspecialchars($href, ENT_QUOTES) ?>">
                    <div class="box-publication">
                        <div class="photo-vendeur">
                            <img src="<?= htmlspecialchars($pub['photo_profil'] ?? 'images/default-profile.jpg', ENT_QUOTES) ?>" 
                                 alt="Photo de <?= $identite ?>">
                        </div>
                        <p class="identite-publication"><?= $identite ?></p>
                    </div>
                </a>

                <div class="localisation">
                    <p><i class="fas fa-map-marker-alt orange-icon"></i> <?= $localisation ?></p>
                </div>
            </div>

            <div class="marsbis" style="background-image: url('<?= htmlspecialchars($pub['photo'], ENT_QUOTES) ?>');"></div>

            <div class="box2">
                <p class="metier"><?= $metier ?></p>
                <p class="qualification"><?= $description ?></p>

                <?php if ($date_pub): ?>
                    <p class="date-publication" style="font-size:0.85rem;margin-top:6px;">
                        Publié le <?= $date_pub ?>
                    </p>
                <?php endif; ?>

                <div class="vendeur">
                    <div class="contact">
                        <a href="<?= htmlspecialchars($href, ENT_QUOTES) ?>">
                            <button id="decouvrir">Découvrir</button>
                        </a>
                    </div>

                    <div class="BTP">
                        <p>
                            <a class="categorie-link" 
                               href="?<?= http_build_query(['categorie' => $pub['categorie'] ?? '']) ?>">
                                <?= htmlspecialchars($pub['categorie'] ?? '', ENT_QUOTES) ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </article>

        </td>
    </tr>
</table>
       

    <?php endforeach; ?>
<?php else: ?>
    <p style="text-align:center;margin:40px;">Aucune publication trouvée.</p>
<?php endif; ?>


        <!-- ============ PAGINATION ============ -->
    </div>

</main>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a class="page-link" href="?<?= buildQuery(['page' => $page - 1]) ?>">Précédent</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a class="page-link <?= ($i == $page) ? 'active' : ''; ?>" href="?<?= buildQuery(['page' => $i]) ?>"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a class="page-link" href="?<?= buildQuery(['page' => $page + 1]) ?>">Suivant</a>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
<script src="script.js"></script>

</body>
</html>

<!-- (gptonline.ai) — fin de fichier -->
