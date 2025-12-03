<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire technicien</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">

    <!-- Inclure Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Inclure Select2 (facultatif, si tu veux améliorer l'interface de sélection) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
</head>

<body>



    <form action="" method="post" enctype="multipart/form-data" class="form_technicien">
        <p><a href="javascript:history.back()" class="reduire">&times;</a></p>
        <h1>Technicien</h1>

        <label for="profil_photo">Photo</label>
        <input type="file" name="profil_photo" required>

        <label for="identite">Nom & prénom</label>
        <input type="text" class="champ" name="identite" required>



        <label for="categorie">Catégorie</label>
        <select name="categorie" class="champ" required>
            <option value="BTP">BTP</option>
            <option value="mecanique">Mécanique</option>
            <option value="artisanat">Artisanat</option>
            <option value="bois">Bois</option>
            <option value="TIC">TIC</option>
        </select>

        <label for="metier">Métier</label>
        <input type="text" class="champ" name="metier" required>

        <label for="qualification">Vos compétences :</label>
        <input type="text" class="champ" name="qualification" required>



        <label for="contact">Email</label>
        <input type="text" class="champ" name="email" required>

        <label for="ville">Ville</label>
        <input list="villes" class="champ" name="ville" required>
        <datalist id="villes">
            <option value="Oyem"></option>
            <option value="Bitam"></option>
            <option value="Minvoul"></option>
            <option value="Mitzic"></option>
            <option value="Meudouneu"></option>
        </datalist>
        <label for="localisation">Quartier ou village</label>
        <input class="champ" name="localisation" required>
        <label for="localisation">Mot de passe</label>
        <input type="password" class="champ" name="mdp" required>

        <input type="submit" name="valider" value="Enregistrer" class="valider">

    </form>
    <div class="modal" id="message_technicien">
        <div class="modal-content" id="messageContent"></div>
    </div>

    <script src="script.js"></script>
</body>

</html>