<?php
session_start();

// Si id_technicien arrive via l'URL, on le stocke une fois pour toutes
if (isset($_GET['id_technicien'])) {
    $_SESSION['id_technicien'] = $_GET['id_technicien'];

    // Redirige vers la même page sans les paramètres pour éviter les soucis au refresh
    header("Location: form_publication.php");
    exit;
}

// Vérifie que l’id est bien en session
if (!isset($_SESSION['id_technicien'])) {
    die("Erreur : identifiant technicien manquant.");
}

$id_profil = $_SESSION['id_technicien'];
// Définir la page de retour si fournie
if (isset($_GET['retour'])) {
    $_SESSION['retour'] = $_GET['retour'];
}

$retour = $_SESSION['retour'] ?? 'monCompte.php';

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="publication.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">
    
    </head>
    <body>
        <header>
             <!-- Icône de retour avec le lien vers menu.php -->
    <div class="retour-container">
    
   <a  href="<?php echo $retour . '?id_technicien=' . $id_profil; ?>"><img src="icônes/flech.svg.svg" alt="" class="retour" id="retour"></a> 
    </div>

        </header>
        <main>
            <div class="form">
           <form method="post" enctype="multipart/form-data" class="form_publication">

    <!-- Upload stylisé -->
    <div class="dix">
        <!-- Input file caché -->
        <input type="file" name="photo" id="photoInput" accept="image/*" style="display:none;">

        <!-- Bouton custom -->
        <button type="button" id="btn-upload" class="btn-upload">📷 Sélectionner une photo</button>

        <!-- Aperçu -->
        <div id="preview">
            <img id="imagePreview" src="#" alt="Prévisualisation" style="display:none;">
        </div>
    </div>

    <div class="champ">
        <div class="box">
            <label for="description"><b>Description</b></label>
            <textarea name="description"></textarea>

            <input type="hidden" name="id_technicien" value="<?php echo $_SESSION['id_technicien']; ?>">

            <input type="submit" id="submit-publication" name="valider" value="Enregistrer">
        </div>
    </div>

</form>

             <div class="modal" id="message_publication">
        <div class="modal-content" id="messageContent"></div>
    </div>
            </div>
            
<script>
const btnUpload = document.getElementById('btn-upload');
const inputPhoto = document.getElementById('photoInput');
const previewImage = document.getElementById('imagePreview');

// Ouvrir l'input file
btnUpload.addEventListener('click', () => {
    inputPhoto.click();
});

// Prévisualisation
inputPhoto.addEventListener('change', function() {
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
        };

        reader.readAsDataURL(file);
    } else {
        previewImage.src = "#";
        previewImage.style.display = "none";
    }
});
</script>

        </main>
        <?php
        include 'footer.php';

        ?>
        <script src="script.js"></script>
    </body>

</html>
