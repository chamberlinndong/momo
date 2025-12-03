<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">
  
</head>
<body>
      
   
      
        <form  action="" method="post" enctype="multipart/form-data" class="form_creer_compte">
            <p><a href="javascript:history.back()" class="reduire">&times;</a></p>
            <h1>Créer un compte</h1>
            <label for="nom">Nom</label>
            <input type="text" name="nom" required  class="champ">

            <label for="telephone">Téléphone</label>
            <input type="text" name="telephone" required  class="champ">

            <label for="email">E-mail</label>
            <input type="email" name="email"  class="champ">

            <label for="photo">Photo</label>
            <input type="file" name="photo" required >

            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" required  class="champ">
               <label for="mdp">Confirmer</label>
            <input type="password" name="mdp" required  class="champ">

            <br>
            <input type="submit" name="valider" value="Enregistrer" class="valider">

            
        </form>
         <div class="modal" id="message_compte">
        <div class="modal-content" id="messageContent"></div>
    </div>
   
  <script src="script.js"></script>
</body>
</html>

