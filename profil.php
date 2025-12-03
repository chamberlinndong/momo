<?php
session_start();
require 'config.php';

// ID du technicien connecté
$idConnecte = $_SESSION['id_technicien'] ?? 0;

// ID du profil affiché (depuis GET ou POST)
$idProfil = isset($_GET['id_technicien']) ? (int) $_GET['id_technicien'] : 0;

// Vérifier si le technicien existe
$stmt = $bdd->prepare("SELECT * FROM technicien WHERE id_technicien = ?");
$stmt->execute([$idProfil]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Technicien introuvable.");
}

// Variables pratiques
$metier = $user['metier'] ?? '';
$qualification = $user['qualification'] ?? '';


// ID du technicien connecté
$idConnecte = $_SESSION['id_technicien'] ?? 0;

// ID du profil affiché dans le formulaire
$idProfil = $_POST['id_technicien'] ?? 0;

// Vérification de sécurité


// Si le fichier est envoyé
if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] === 0) {
    $dossier = 'uploads/';
    $nomFichier = basename($_FILES['photo_profil']['name']);
    $chemin = $dossier . $nomFichier;

    if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $chemin)) {
        // Mettre à jour la base de données
        $stmt = $bdd->prepare("UPDATE technicien SET photo_profil = ? WHERE id_technicien = ?");
        $stmt->execute([$chemin, $idConnecte]);
        echo "Photo mise à jour avec succès !";
    } else {
        echo "Erreur lors de l'upload.";
    }
    // ID du profil affiché
    $idProfil = isset($_GET['id_technicien']) ? (int) $_GET['id_technicien'] : 0;

    // Récupérer les infos du technicien
    if ($idProfil > 0) {
        $stmt = $bdd->prepare("SELECT * FROM technicien WHERE id_technicien = ?");
        $stmt->execute([$idProfil]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // S'il n'existe pas, on bloque
        if (!$user) {
            die("Technicien introuvable.");
        }

        // Variables pratiques
        $metier = $user['metier'] ?? '';
        $qualification = $user['qualification'] ?? '';
    } else {
        die("ID technicien invalide.");
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
            background-image: url("<?php echo htmlspecialchars($user['photo_profil']); ?>");
            background-size: cover;
            background-position: center;
            background-position-y: 35%;
            background-blend-mode: overlay;
            background-color: rgba(0, 0, 0, 0.5);
            padding-left: 1%;
            display: flex;
            align-items: center;
        }

        .profil {
            background-image: url("<?php echo htmlspecialchars($user['photo_profil']); ?>");
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
            display: block;
            max-width: 200px;
            margin: 10px auto;
            height: 50vh;
        }

        .modal {
            display: none;
            position: fixed;
            float: right;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            height: 75%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="couverture">
           <p><a href="javascript:history.back()"><img src="icônes/flech.svg.svg" alt="" class="retour"></a></p>

        <?php
        // ID du profil affiché
        $idProfil = isset($_GET['id_technicien']) ? (int) $_GET['id_technicien'] : 0;
        // ID de l’utilisateur connecté
        $idConnecte = $_SESSION['id_technicien'] ?? 0;
        ?>
        <div class="profil">
            
            </div>

      <?php ?>
            <p class="identite-compte" style="color:white"><?php echo $user['identite']; ?></p>
        

    </div>

    <section class="box">
        <div class="container_real">
            <div class="container_profil">
                <div>
                    <p class="text" id="metier"><?php echo htmlspecialchars($metier); ?></p>
                    <p class="text" id="qualification"><?php echo htmlspecialchars($qualification); ?></p>
                </div>
            </div>

            
            <?php
           
                $stmt = $bdd->prepare("SELECT * FROM publication WHERE id_technicien = ?");
                $stmt->execute([$idProfil]);
                $publications = $stmt->fetchAll();

                $perRow = 4; // Nombre de td par tr
                $count = 0;   // Compteur pour suivre les td
            
                if ($publications) {
                    echo ' <h2 class="titre-real">Mes réalisations</h2>';
                    echo '<table cellspacing="5" cellpadding="5"><tr>'; // Début première ligne
            
                    foreach ($publications as $p) {
                        echo '<td>';
                        echo '<img class="real" src="' . htmlspecialchars($p['photo']) . '" alt="Photo"">';
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
            
            ?>
    <div class="modal" id="modal">
            <img src="" alt="Aperçu" id="modalImg">
        </div>
    </div>
</section>

<script>
    // Sélection de toutes les images
    const images = document.querySelectorAll('.real');
    const modal = document.getElementById('modal');
    const modalImg = document.getElementById('modalImg');

    images.forEach(img => {
        img.addEventListener('click', () => {
            modal.style.display = 'block';
            modalImg.src = img.src;
        });
    });

    // Fermer la modale en cliquant en dehors de l'image
    modal.addEventListener('click', e => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>

    <?php include 'footer.php'; ?>

</body>

</html>