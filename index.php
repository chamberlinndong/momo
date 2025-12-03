<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Import des icônes Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Feuille de style principale -->
    <link rel="stylesheet" href="menu.css">

    <!-- Police personnalisée -->
    <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">
</head>

<body>
   <?php 

   include 'header.php';
   ?>

    <main class="merci">
        <div class="accueil">
            <div style="display:flex; align-items:center">
                <p class="titre" style="padding-top:2vh;">Bienvenue chez</p>
                <p style="width: 1vh;"></p>
                <img src="logo/codFichier 12.png" alt="" style="width:12rem;">
            </div>

            <p class="sous-titre">Votre solution pour des services à domicile sur mesure</p>

            <?php if (!isset($_SESSION['id']) && !isset($_SESSION['id_technicien'])): ?>

                
                <div id="creer_compte">Créer un compte</div>

                <div id="alert">
                    <div id="choix">
                        <div class="question"><p>Vous-êtes ?</p></div>

                        <a href="form_creer_compte.php">
                            <div class="liens" id="client">Visiteur</div>
                        </a>

                        <a href="form_technicien.php">
                            <div class="liens" id="technicien">Entreprise</div>
                        </a>

                    </div>
                </div>

            <?php endif; ?>

            <!-- Script ouverture/fermeture de la modale -->
            <script>
                const compte = document.getElementById('creer_compte');
                const alertBox = document.getElementById('alert');
                const liens = document.querySelectorAll('#choix a');

                if (compte) {
                    compte.addEventListener('click', () => {
                        alertBox.style.display = 'flex';
                    });
                }

                alertBox.addEventListener('click', (e) => {
                    if (e.target === alertBox) {
                        alertBox.style.display = 'none';
                    }
                });

                liens.forEach(lien => {
                    lien.addEventListener('click', () => {
                        alertBox.style.display = 'none';
                    });
                });
            </script>

        </div>

        <!-- Si connecté -->
       <?php if (isset($_SESSION['id']) || isset($_SESSION['id_technicien'])): ?>

        <div class="titre-service">
            <p class="titre" id="service">Nos services</p>
        </div>

        <div class="container_planet" id="container_planet">

            <div class="planet">
                <p>Nos services</p>
                <h3>Soins et beauté</h3>
                <div class="mars" id="mars2"></div>
                <div class="Decouvrir">
                    <p>Découvrir <a href=""><i class="fa-solid fa-arrow-right"></i></a></p>
                </div>
            </div>

            <div class="planet">
                <p>Nos services</p>
                <h3>Entretien d'espaces verts</h3>
                <div class="mars" id="mars3"></div>
                <div class="Decouvrir">
                    <p>Découvrir <a href=""><i class="fa-solid fa-arrow-right"></i></a></p>
                </div>
            </div>

            <div class="planet">
                <p>Nos services</p>
                <h3>Éducation et formation</h3>
                <div class="mars" id="mars4"></div>
                <div class="Decouvrir">
                    <p>Découvrir <a href=""><i class="fa-solid fa-arrow-right"></i></a></p>
                </div>
            </div>

            <div class="planet">
                <p>Nos services</p>
                <h3>Aide à domicile</h3>
                <div class="mars" id="mars5"></div>
                <div class="Decouvrir">
                    <p>Découvrir <a href=""><i class="fa-solid fa-arrow-right"></i></a></p>
                </div>
            </div>

            <script>
                const container = document.getElementById('container_planet');
                let direction = 1;

                setInterval(() => {
                    container.scrollBy({ left: 1 * direction, behavior: 'smooth' });

                    if (container.scrollLeft + container.clientWidth >= container.scrollWidth) {
                        direction = -1;
                    } else if (container.scrollLeft <= 0) {
                        direction = 1;
                    }
                }, 20);
            </script>

        </div>

        <div class="container-services">
            <div class="cadre"><i class="fas fa-hard-hat"></i> Techniciens qualifiés</div>
            <div class="cadre"><i class="fa-solid fa-truck"></i> Livraison de produits</div>
            <div class="cadre"><i class="fa-solid fa-credit-card"></i> Paiement en ligne</div>
            <div class="cadre"><i class="fas fa-headphones"></i> Service client</div>
        </div>

        <div class="texte">
            <p class="sous-titre">
                Chez Le Klan, nous facilitons la mise en relation entre clients et techniciens qualifiés tout
                en vous proposant une boutique en ligne riche en produits adaptés pour satisfaire toutes vos exigences.
            </p>
        </div>

        <?php endif; ?>

    </main>

    <?php include 'footer.php'; ?>

</body>
</html>
