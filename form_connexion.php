
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">
</head>
<body>
    <form  method="post" class="form_connexion">
        <p><a href="javascript:history.back()" class="reduire">&times;</a></p>
        <h1>Connectez-vous</h1>

        <div>
            <label for="nom">Email</label>
            <input type="text" name="email" required class="champ">
        </div>

        <div>
            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" required class="champ">
        </div>

        <input type="submit" name="valider" value="Connexion" class="valider" id="c2">

    </form>
     <div class="modal" id="message_connexion">
        <div class="modal-content" id="messageContent"></div>
    </div>

    <p><a class="lien" href="index.php">Retour</a></p>
    <script src="script.js"></script>
</body>
</html>
