<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">
    
    <link rel="stylesheet" href="vendeur.css">
</head>
<body>
    <h1>Créer un compte vendeur</h1> <br>
    <main class="">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="box">
                    <label for="vendeur">Nom du vendeur:</label>
                    <input type="text" class="champ" name="nom" id="vendeur" required placeholder="nom vendeur">
                    </div>
<div class="box">
                    <label for="ville">Ville:</label>
                    <input list="villes" class="champ" name="ville" id="ville" required placeholder="ville">
                    <datalist id="villes">
                        <option value="Oyem"></option>
                        <option value="Bitam"></option>
                        <option value="Minvoul"></option>
                        <option value="Mitzic"></option>
                        <option value="Meudouneu"></option>
                    </datalist>
                    </div>
                    <div class="box">
                    <label for="photo_vendeur">Photo du vendeur:</label>
                    <input type="file" class="champ" name="photo" id="photo" required>
                    </div>
                    <div class="box">
                        <label for="telephone">Numéro de téléphone:</label>
                        <input type="int" name="telephone" placeholder="telephone" required>
                        <label for="email">Addresse mail:</label>
                        <input type="email" name="email" placeholder="email" required>
                    </div>
                  <div class="box">
                    <label for="MDP">Mot de passe:</label>
                    <input type="password" name="MDP" placeholder="mot de passe" required="required">
                    <label for="confirmer">confirmer:</label>
                    <input type="password" name="confirmer" placeholder="confirmer" required="required">
                </div>
                <div class="box" id="bouton">
                <button type="submit" name="valider">Enregistrer</button>
                </div>
                </form>
                <?php
                $bdd = new PDO('mysql:host=localhost;dbname=boutique', 'root', '');
                if (isset($_POST['valider'])){
                    if ($_POST['MDP'] !== $_POST['confirmer']) {
                        echo "<p style='color:red;'>Les mots de passe ne correspondent pas.</p>";
                        exit;
                    }
                    $insert = 'INSERT INTO boutiques (nom,ville,photo,telephone,email,MDP) VALUES(?,?,?,?,?,?)';
                $dossier = 'vendeur/';
                $image = $_FILES['photo'];
                $image_nom= basename($image['name']);
                $chemin = $dossier . $image_nom;
                move_uploaded_file($image['tmp_name'], $chemin);
                $req = $bdd->prepare($insert);
                $req->execute(array($_POST['nom'], $_POST['ville'], $chemin, $_POST['telephone'], $_POST['email'], $_POST['MDP']));

                    echo 'insertion réussie';
                
                }
              
                
                ?>

                    </main>
</body>
</html>