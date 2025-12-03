<?php
include 'config.php';
session_start();

/* =========================
   ID DU COMPTE CONNECTÉ
========================= */
$idConnecte = null;

if (isset($_SESSION['id'])) {
    $idConnecte = $_SESSION['id'];
} elseif (isset($_SESSION['id_technicien'])) {
    $idConnecte = $_SESSION['id_technicien'];
}

/* =========================
   UPLOAD PHOTO PROFIL
========================= */
if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] === 0) {

    $dossier = 'uploads/';
    $nomFichier = time() . "_" . basename($_FILES['photo_profil']['name']);
    $chemin = $dossier . $nomFichier;

    if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $chemin)) {

        $stmt = $bdd->prepare("UPDATE technicien SET photo_profil = ? WHERE id_technicien = ?");
        $stmt->execute([$chemin, $idConnecte]);

        $_SESSION['photo'] = $chemin;

       
    } else {
       
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>

    <link rel="stylesheet" href="profil.css">
    <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
        .couverture {
            background-image: url("<?php echo $_SESSION['photo']; ?>");
            background-size: cover;
            background-position-y: 35%;
            background-color: rgba(0, 0, 0, 0.5);
            background-blend-mode: overlay;
            padding-left: 1%;
            display: flex;
            align-items: center;
        }

        .profil {
            background-image: url("<?php echo $_SESSION['photo']; ?>");
            background-size: cover;
            background-position: center;
            background-position-y: 35%;
            display: flex;
            z-index: 10;
        }

        #photoInput {
            display: none;
        }

        #preview {
            max-width: 200px;
            margin: 10px auto;
            height: 40vh;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            inset: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background: #fff;
            margin: 5% auto;
            padding: 20px;
            width: 30%;
            height: 75%;
            border-radius: 10px;
        }

        .close {
            float: right;
            font-size: 28px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="couverture">

        <p><a href="mecanique.php"><img src="icônes/flech.svg.svg" alt="" class="retour"></a></p>

        <form class="profil" method="post" enctype="multipart/form-data">

            <!-- Bouton pour ouvrir la modale -->
            <button type="button" id="openModal" class="ajout">
                <i class="fas fa-camera"></i>
            </button>

            <!-- MODALE -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>

                    <input type="file" name="photo_profil" id="photoInput" accept="image/*"
                        onchange="previewImage(event)">

                    <div id="previewContainer" style="display:none;">
                        <h3>Aperçu de la photo</h3>
                        <img id="preview" src="" alt="Aperçu de l'image">
                    </div>

                    <button type="submit" class="submit">Confirmer</button>
                </div>
            </div>

        </form>

        <?php if (isset($_SESSION['id_technicien'])): ?>
            <p class="identite-compte" style="color:white"><?= $_SESSION['identite']; ?></p>
        <?php else: ?>
            <p class="identite-compte" style="color:white"><?= $_SESSION['nom']; ?></p>
        <?php endif; ?>

    </div>


    <?php if ($_SESSION['type'] == 'user'): ?>

        <div class="box">
            <p class="text"><?= $_SESSION['telephone']; ?></p>
            <p class="text"><?= $_SESSION['email']; ?></p>
        </div>

    <?php else: ?>

        <section class="box">
            <div class="container_real">

                <div class="container_profil">

                <div class="mon-metier">
                    <p class="metier"><?= $_SESSION['metier']; ?></p>
                    <p class="qualification"><?= $_SESSION['qualification']; ?></p>
                </div>
                    <div class="realisations">
                        <a href="form_publication.php?id_technicien=<?= $_SESSION['id_technicien']; ?>" target="_blank">
                            <i class="fas fa-plus"> Publications</i> 
                        </a>
                    </div>
                </div>

            <?php
                if (isset($_SESSION['id_technicien'])) {
                    $stmt = $bdd->prepare("SELECT * FROM publication WHERE id_technicien = ?");
                    $stmt->execute([$_SESSION['id_technicien']]);
                    $publications = $stmt->fetchAll();

                    $perRow = 4; // Nombre de td par tr
                    $count = 0;   // Compteur pour suivre les td
            
                    if ($publications) {
                        echo' <h2 class="titre-real">Mes réalisations</h2>';
                        echo '<table cellspacing="5" cellpadding="5">  <tr>'; // Début première ligne
            
                        foreach ($publications as $p) {
                            echo '<td>';
                            echo '<img src="' . htmlspecialchars($p['photo']) . '" alt="Photo"">';
                            echo '</td>';

                            $count++;

                            // Si on atteint le nombre par ligne, on ferme la ligne et on en ouvre une nouvelle
                            if ($count % $perRow == 0) {
                                echo '</tr><tr>';
                            }
                        }

                        echo '</tr></table>'; // Fermeture dernière ligne
                    } else {
                        echo '<p>Aucune réalisation pour ce technicien.</p>';
                    }
                }
                ?>



            </div>
        </section>

    <?php endif; ?>


    <script>
        const modal = document.getElementById("myModal");
        const openModalBtn = document.getElementById("openModal");
        const closeBtn = document.querySelector(".close");

        const photoInput = document.getElementById("photoInput")
        const preview = document.getElementById("preview");
        const previewContainer = document.getElementById("previewContainer");

        openModalBtn.onclick = () => {
            photoInput.click();
        };

        function previewImage(e) {
            let reader = new FileReader();
            reader.onload = () => {
                preview.src = reader.result;
                previewContainer.style.display = "block";
                modal.style.display = "block";
            };
            reader.readAsDataURL(e.target.files[0]);
        }

        closeBtn.onclick = () => modal.style.display = "none";

        window.onclick = (e) => {
            if (e.target === modal) modal.style.display = "none";
        };
    </script>
<?php include 'footer.php';?>
</body>

</html>