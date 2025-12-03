<?php
session_start();
require 'config.php';
?>

<head>
    <link rel="stylesheet" href="menu.css">
</head>

<header>

    <!-- ====== Menu principal (version desktop) ====== -->
    <nav class="nav1">

        <!-- Logo -->
        <div class="logo">
            <img src="logo/codFichier 7.png" alt="Logo" class="c7">
        </div>

        <?php if (isset($_SESSION['id']) || isset($_SESSION['id_technicien'])): ?>

            <!-- Menu principal -->
            <ul>
                <li class="menu1">
                    <a href="index.php"
                        class="menu-link <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">
                        accueil
                    </a>
                </li>
                <li class="menu2">
                    <a href="mecanique.php"
                        class="<?= basename($_SERVER['PHP_SELF']) === 'mecanique.php' ? 'active' : '' ?>">
                        Publications
                    </a>
                </li>
                <li class="menu3">
                    <a href="technicien.php"
                        class="menu-link <?= basename($_SERVER['PHP_SELF']) === 'technicien.php' ? 'active' : '' ?>">
                        Technicien
                    </a>
                </li>
                <li class="menu4">A propos</li>
            </ul>

            <!-- Champ de recherche -->
            

            <!-- Photo utilisateur -->
            <div class="photo">
                <?php if(isset($_SESSION['id'])): ?>
                <b><p><?php echo $_SESSION['nom'] ;?></p></b>
                <?php else: ?>
                     <b><p><?php echo $_SESSION['identite'] ;?></p></b>

                <?php endif; ?>
                <img src="<?= $_SESSION['photo'] ?>" alt="Photo de profil" class="photo-img">
            </div>

            <!-- Menu déroulant -->
            <div class="dropdown" id="dropdown">
                <button class="dropdown-button" onclick="toggleDropdown()">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="dropdown-menu">
                    <?php
                    $idCompte = isset($_SESSION['id_technicien'])
                        ? $_SESSION['id_technicien']
                        : (isset($_SESSION['id']) ? $_SESSION['id'] : '');
                    ?>
                    <a href="monCompte.php?id=<?= $idCompte ?>" class="lion">Mon compte</a>
                    <a href="deconnexion.php">Déconnexion</a>
                </div>
            </div>

            <!-- Script du menu déroulant -->
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

        <!-- ====== Menu mobile ====== -->
        <nav class="navbis">
            <div class="hermy">
                <div class="flex">
                    <div class="logo">
                        <img src="logo/codFichier 7.png" alt="Logo" class="c7">
                    </div>
                </div>

                <div class="flexy">

                    <!-- Recherche mobile -->
                    <button id="bouton"><i class="fa-solid fa-magnifying-glass"></i></button>

                    <div class="recherche" id="recherche">
                        <form action="" method="GET" class="search-form">
                            <div class="search-containerbis">
                                <input class="container-search1" type="text" name="search" placeholder="Recherche..."
                                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                                <button type="submit" name="find" class="search-button">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <script>
                        const bouton = document.getElementById("bouton");
                        const div = document.getElementById("recherche");

                        bouton.addEventListener("click", function () {
                            this.style.display = "none";
                            div.style.display = "block";
                        });

                        document.addEventListener("click", function (e) {
                            if (div.style.display === "block" && !div.contains(e.target) && e.target !== bouton) {
                                div.style.display = "none";
                                bouton.style.display = "inline-block";
                            }
                        });
                    </script>

                    <!-- Menu mobile -->
                    <div class="dropdown" id="dropdown2">
                        <button class="dropdown-button" onclick="toggleDropdown2()">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="dropdown-menu" id="menu2">
                            <a href="logout.php">Déconnexion</a>
                        </div>
                    </div>

                    <!-- Photo mobile -->
                    <div class="pp">
                        <img src="<?= $_SESSION['photo'] ?>" alt="" class="photo-imgbis">
                    </div>

                </div>
            </div>
        </nav>

    <?php else: ?>

        <a href="form_connexion.php">Connexion</a>

    <?php endif; ?>

</header>