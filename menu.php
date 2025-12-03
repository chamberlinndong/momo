<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">
    


</head>

<body>
    <header>
        <nav class="nav1">
            <div class="logo">
              <img src="logo/codFichier 7.png" alt="" class="c7">
            </div>

            <ul>
                <li class="menu1"><a href="accueil.php" class="menu-link">accueil</a></li>
                <a href="menu.php">
                    <li class="menu2">boutiques<i class="fa-solid fa-chevron-down" id="fleche5"></i>
                </a>
                <ul class="list-option">
                    <a class="categorie" href="electronique.php">
                        <li><i class="fas fa-tv"></i> Électronique</li>
                    </a>
                    <a class="categorie" href="immobilier.php">
                        <li><i class="fas fa-home"></i> Immobilier</li>
                    </a>
                    <a class="categorie" href="restauration.php">
                        <li><i class="fas fa-utensils"></i> Restauration</li>
                    </a>
                    <a class="categorie" href="vetement.php">
                        <li><i class="fas fa-tshirt"></i> Vêtements</li>
                    </a>
                </ul>
                </li>
                <li class="menu3"><a href="actu_technicien.php">techniciens<i class="fa-solid fa-chevron-down" id="fleche6"></i></a>
                    <ul class="list-option">
                        <a href="btp.php">
                            <li value="BTP">
                                <i class="fas fa-hard-hat"></i> BTP
                            </li>
                        </a>
                        <a href="mecanique.php">
                            <li value="mecanique">
                                <i class="fas fa-cogs"></i> Mécanique
                            </li>
                        </a>
                        <a href="artisanat.php">
                            <li value="artisanat">
                                <i class="fas fa-hammer"></i> Artisanat
                            </li>
                        </a>
                        <a href="bois.php">
                            <li value="bois">
                                <i class="fas fa-tree"></i> Bois
                            </li>
                        </a>
                        <a href="tic.php">
                            <li value="TIC">
                                <i class="fas fa-laptop"></i> TIC
                            </li>
                        </a>
                    </ul>
                </li>

                <li class="menu4">Menu
                    <ul class="list-option">
                        <li>option</li>
                        <li>option</li>
                        <li>option</li>
                        <li>option</li>
                    </ul>
                </li>
            </ul>

            <div class="recherche">
                <form action="" method="GET" class="search-form">
                    <div class="search-container">
                        <input class="container-search1" type="text" name="search" placeholder="Recherche..."
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button type="submit" name="find" class="search-button">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="photo">
                <!-- Affichage photo utilisateur ou une image par défaut -->
                <img src="<?php echo isset($_SESSION['photo']) ? htmlspecialchars($_SESSION['photo']) : 'path/to/default/photo.jpg'; ?>"
                    alt="Photo" class="photo-img">
            </div>

            <div class="dropdown" id="dropdown">
                <button class="dropdown-button" onclick="toggleDropdown()"><i class="fas fa-bars"></i></button>
                <div class="dropdown-menu">
                    <a href="insertion.php" class="lion">Ajouter produit</a><br>
                    <a href="technicien.php">Compte technicien</a><br>
                    <a href="vendeur.php">Compte vendeur</a><br>
                    <a href="logout.php">Déconnexion</a>
                </div>
            </div>
            <script>
                function toggleDropdown() {
                    document.getElementById("dropdown").classList.toggle("active");
                }

                window.addEventListener('click', function (e) {
                    const dropdown = document.getElementById("dropdown");
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove("active");
                    }
                });
            </script>
        </nav>

        <nav class="navbis">
            <div class="hermy">
                <div class="flex">
                <div class="logo">
              <img src="logo/codFichier 7.png" alt="" class="logo">
            </div>
                  


                    <script>
                        function toggleDropdown2() {
                            const dropdown = document.getElementById("dropdown2");
                            const button = dropdown.querySelector("button");
                            dropdown.classList.toggle("active");
                            const isActive = dropdown.classList.contains("active");
                            button.setAttribute("aria-expanded", isActive);
                        }

                        // Fermer le menu si on clique en dehors
                        window.addEventListener('click', function (e) {
                            const dropdown = document.getElementById("dropdown2");
                            if (!dropdown.contains(e.target)) {
                                dropdown.classList.remove("active");
                                dropdown.querySelector("button").setAttribute("aria-expanded", false);
                            }
                        });
                    </script>
                </div>


                <div class="flexy">
                    <button id="bouton"> <i class="fa-solid fa-magnifying-glass"></i></button>

                    <div class="recherche" id="recherche">
                        <form action="" method="GET" class="search-form">
                            <div class="search-containerbis">
                                <input class="container-search1" type="text" name="search" placeholder="Recherche..."
                                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                <button type="submit" name="find" class="search-button">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <script>
                        document.getElementById("bouton").addEventListener("click", function () {
                            this.style.display = "none";
                            document.getElementById("recherche").style.display = "block";
                        })

                        document.addEventListener("click", function (e) {
                            if (div.style.display === "block" && !div.contains(e.target)
                                && e.target !== bouton) {
                                div.style.display = "none";
                                bouton.style.display = "inline-block";
                            }

                        })
                    </script>
                     <div class="dropdown" id="dropdown2">
                        <button class="dropdown-button" onclick="toggleDropdown2()" aria-haspopup="true"
                            aria-expanded="false" aria-controls="menu2">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="dropdown-menu" id="menu2" role="menu">
                            <a href="logout.php">Déconnexion</a>
                        </div>
                    </div>

                    <div class="pp">
                    <img src="<?php echo $_SESSION['photo']; ?>" alt="" class="photo-imgbis">
                    </div>
                   

                </div>
                
            </div>
            <div class="hermyx">


                <ul>
                    <li class="menu1"><a href="accueil.php" class="menu-link">accueil</a></li>

                    <a href="menu.php">
                        <li class="menu2">boutiques
                    </a>
                    <ul class="list-option">
                        <a class="categorie" href="electronique.php">
                            <li><i class="fas fa-tv"></i> Électronique</li>
                        </a>
                        <a class="categorie" href="immobilier.php">
                            <li><i class="fas fa-home"></i> Immobilier</li>
                        </a>
                        <a class="categorie" href="restauration.php">
                            <li><i class="fas fa-utensils"></i> Restauration</li>
                        </a>
                        <a class="categorie" href="vetement.php">
                            <li><i class="fas fa-tshirt"></i> Vêtements</li>
                        </a>
                    </ul>
                    </li>
                    <li class="menu3"><a href="actu_technicien.php">techniciens</a>
                        <ul class="list-option">
                            <a href="btp.php">
                                <li value="BTP">
                                    <i class="fas fa-hard-hat"></i> BTP
                                </li>
                            </a>
                            <a href="mecanique.php">
                                <li value="mecanique">
                                    <i class="fas fa-cogs"></i> Mécanique
                                </li>
                            </a>
                            <a href="artisanat.php">
                                <li value="artisanat">
                                    <i class="fas fa-hammer"></i> Artisanat
                                </li>
                            </a>
                            <a href="bois.php">
                                <li value="bois">
                                    <i class="fas fa-tree"></i> Bois
                                </li>
                            </a>
                            <a href="tic.php">
                                <li value="TIC">
                                    <i class="fas fa-laptop"></i> TIC
                                </li>
                            </a>
                        </ul>
                    </li>

                    <li class="menu4">Menu
                        <ul class="list-option">
                            <li>option</li>
                            <li>option</li>
                            <li>option</li>
                            <li>option</li>
                        </ul>
                    </li>
                </ul>

            </div>

        </nav>




    </header>

    <main class="main-content">
        <div class="taff">
            <?php
            // Connexion à la base de données
            $bdd = new PDO('mysql:host=localhost;dbname=boutique', 'root', '');

            // Nombre d'articles à afficher par page
            $limit = 10;

            // Récupérer le numéro de la page actuelle
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

            // Récupérer la requête de recherche, si elle existe
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Calculer l'OFFSET (le décalage pour la requête)
            $offset = ($page - 1) * $limit;

            // Requête SQL avec jointure entre produit et boutiques
            if (!empty($search)) {
                $profil = "SELECT produit.*, boutiques.nom AS nom_boutique, boutiques.photo AS photo_boutique, boutiques.ville AS ville_boutique 
                               FROM produit 
                               JOIN boutiques ON produit.id_boutiques = boutiques.id_boutiques 
                               WHERE produit.article LIKE :search 
                                  OR ville LIKE :search 
                                  OR produit.categorie LIKE :search 
                                  OR boutiques.nom LIKE :search 
                               LIMIT $limit OFFSET $offset";
                $req = $bdd->prepare($profil);
                $req->bindValue(':search', '%' . $search . '%');
            } else {
                $profil = "SELECT produit.*, boutiques.nom AS nom_boutique, boutiques.photo AS photo_boutique, boutiques.ville AS ville_boutique 
                               FROM produit 
                               JOIN boutiques ON produit.id_boutiques = boutiques.id_boutiques 
                               LIMIT $limit OFFSET $offset";
                $req = $bdd->prepare($profil);
            }

            $req->execute();

            // Récupérer les produits
            $produits = $req->fetchAll();

            // Affichage des produits
            foreach ($produits as $produit) {
                ?>
                <div class="container">
                    <div class="v2">
                       
                        <a href="boutique.php?photo_boutique=<?php echo urlencode($produit['photo_boutique']); ?>
    &nom_boutique=<?php echo urlencode($produit['nom_boutique']); ?>
    &id_boutiques=<?php echo urlencode($produit['id_boutiques']); ?>
    &ville_boutique=<?php echo urlencode($produit['ville_boutique']); ?>">
  
    <div class="chien">
                                <!-- Remplacement de la photo du vendeur par la photo de la boutique -->
                                <img class="photo-vendeur" src="<?php echo htmlspecialchars($produit['photo_boutique']); ?>"
                                    alt=""> 
                                    <p class="vendeur"><?php echo htmlspecialchars($produit['nom_boutique']); ?></p>
        
                        </div>
                        </a>
                        <div class="localisation">
                            <!-- Remplacement de la ville par l'adresse de la boutique -->
                            <p><i class="fa-solid fa-location-dot"></i></p>
                            <p class="ville"><?php echo htmlspecialchars($produit['ville_boutique']); ?></p>
                        </div>
                    </div>
                    <div class="marsbis" style="background-image: url('<?php echo htmlspecialchars($produit['image']); ?>');">
                       

                    </div>
                    <div class="box2">
                        <div class="vendeur">
                            <p class="produit-name"><?php echo "" . $produit['article']; ?></p>
                            <p class="produit-price"><?php echo $produit['prix'] . "FCFA"; ?> </p>
                        </div>
                        <div class="attributs">
                            <p><?php echo $produit['description']; ?></p>
                        </div>

                        <div class="vendeur">
                            <button type="button" id="openModalBtn-<?php echo $produit['id_produit']; ?>">Commander</button>
                            <div class="categorie-container">
                            <a class="categorie-link"
                                    href="<?php echo strtolower($produit['categorie']); ?>.php?categorie=<?php echo urlencode($produit['categorie']); ?>">
                                    <?php
                                        // Définir les icônes par catégorie
                                        $icons = [
                                            'immobilier' => 'fa-home',
                                            'electronic' => 'fa-tv',
                                            'restauration' => 'fa-utensils',
                                            'vetement' => 'fa-tshirt'
                                        ];

                                        // Sélectionner l'icône correspondant ou une valeur par défaut
                                        $icon = isset($icons[$produit['categorie']]) ? $icons[$produit['categorie']] : 'fa-box';
                                        ?>
                                    <i class="fas <?php echo $icon; ?>" style="align-self:center"></i>
                                    <?php echo $produit['categorie']; ?>

                                </a>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div id="myModal-<?php echo $produit['id_produit']; ?>" class="modal">
                            <div class="modal-content">
                                <span class="close" data-modal-id="<?php echo $produit['id_produit']; ?>">&times;</span>
                                <p>Êtes-vous sûr de vouloir commander ce produit : <b><?php echo $produit['article']; ?></b>
                                    ?</p>
                                <form action="achat.php" method="GET">
                                    <!-- ID du produit -->
                                    <input type="hidden" name="produit_id" value="<?php echo $produit['id_produit']; ?>">
                                    <input type="hidden" name="nom_boutique"
                                        value="<?php echo htmlspecialchars($produit['nom_boutique']); ?>">

                                    <!-- Sélecteur de quantité -->
                                    <div class="confirm">
                                        <label for="quantity-<?php echo $produit['id_produit']; ?>">Quantité :</label>
                                        <input type="number" name="quantity"
                                            id="quantity-<?php echo $produit['id_produit']; ?>" value="1" min="1" max="100">

                                        <button type="submit" class="submit">Confirmer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Lien vers la catégorie -->
                    </div>
                </div>








                <?php
            }
            ?>
        </div>
        
    </main>
    <?php
       
    // Pagination
    
// Exemple de paramètres
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 10; // éléments par page

// Connexion PDO (à adapter)
$bdd = new PDO('mysql:host=localhost;dbname=boutique', 'root', '');

// Récupérer le total des éléments selon la recherche
    if (!empty($search)) {
        $totalArticlesReq = $bdd->prepare("SELECT COUNT(*) 
        FROM produit 
        JOIN boutiques ON produit.id_boutiques = boutiques.id_boutiques
        WHERE produit.article LIKE :search 
           OR ville LIKE :search 
           OR produit.categorie LIKE :search 
           OR boutiques.nom LIKE :search");
        $totalArticlesReq->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    } else {
        $totalArticlesReq = $bdd->prepare("SELECT COUNT(*) 
        FROM produit 
        JOIN boutiques ON produit.id_boutiques = boutiques.id_boutiques");
    }
    $totalArticlesReq->execute();
    $totalArticles = $totalArticlesReq->fetchColumn();

    $totalPages = ($totalArticles > 0) ? ceil($totalArticles / $limit) : 1;

// Calcul pagination
$maxPagesToShow = 5;
$startPage = max(1, $page - floor($maxPagesToShow / 2));
$endPage = min($totalPages, $startPage + $maxPagesToShow - 1);
if ($endPage - $startPage + 1 < $maxPagesToShow) {
    $startPage = max(1, $endPage - $maxPagesToShow + 1);
}
$startPage = max(1, $startPage);
?>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>" class="page-link">&laquo; Précédent</a>
    <?php endif; ?>

    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" 
           class="page-link <?php echo $i == $page ? 'active' : ''; ?>">
           <?php echo $i; ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>" class="page-link">Suivant &raquo;</a>
    <?php endif; ?>
</div>



    <footer>
        <div class="bac">
        <div class="footer1">
            <ul>
            <div class="logo">
              <img src="logo/codFichier 12.png" alt="" class="c7">
            </div>
       
                <li><i class="fab fa-facebook-f"></i> FACEBOOK</li>
                <li><i class="fab fa-x-twitter"></i> X</li>
                <li><i class="fab fa-linkedin-in"></i> LINKEDIN</li>
                <li><i class="fab fa-tiktok"></i> TIKTOK</li>
                <li><i class="fab fa-instagram"></i> INSTAGRAM</li>
            </ul>

        </div>
        <div class="footer2" >
            <ul>Partenaires
                <li>CFEPTIC Nkok</li>
                <li>CIMFEP</li>
                <li>Cyberschool</li>
                <li>Lycée technique de Bikélé</li>
                <li>Restaurant youssouf</li>
            </ul>
        </div>
        <div class="footer2" >
            <ul>Partenaires
                <li>CFEPTIC Nkok</li>
                <li>CIMFEP</li>
                <li>Cyberschool</li>
                <li>Lycée technique de Bikélé</li>
                <li>Restaurant youssouf</li>
            </ul>
        </div>
        </div>
    </footer>
    <script>
        var modalBtns = document.querySelectorAll('[id^="openModalBtn-"]');
        var closeBtns = document.querySelectorAll('.close');

        modalBtns.forEach(function (btn) {
            btn.onclick = function () {
                var modalId = this.id.replace('openModalBtn-', 'myModal-');
                document.getElementById(modalId).style.display = 'block';
            };
        });

        closeBtns.forEach(function (btn) {
            btn.onclick = function () {
                var modalId = 'myModal-' + this.getAttribute('data-modal-id');
                document.getElementById(modalId).style.display = 'none';
            };
        });

        window.onclick = function (event) {
            modalBtns.forEach(function (btn) {
                var modalId = btn.id.replace('openModalBtn-', 'myModal-');
                var modal = document.getElementById(modalId);
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
        };
    </script>
</body>

</html>