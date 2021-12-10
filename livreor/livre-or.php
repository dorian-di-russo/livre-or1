<?php
session_start();
$serveur = "localhost";
$dbname = "livreor";
$user = "root";
$pass = "";
$message = "";

try {

  $log = new PDO("mysql:host=$serveur;dbname=$dbname", $user, $pass);
  $log->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch (Exception $e)


{
    echo 'Impossible de traiter les données. Erreur : ' . $e->getMessage();
}

                        // je selectionne tout de mon utilisateur ou son id  de la table utilisateurs et égal a son id_utilisateur de la table commentaires 
$request = $log ->prepare("SELECT * FROM utilisateurs INNER JOIN commentaires WHERE utilisateurs.id = commentaires.id_utilisateur");

$resultat = $request->execute();



?>









<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Livre-Or</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>

<header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Acceuil</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="inscription.php">Inscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="connexion.php">Connexion</a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </nav>
        </header> <br>


        <div class="d-flex justify-content-center">
<?php 

while($resultat = $request->fetch()){

  echo $resultat['login'] . ' ' . $resultat['commentaire'] . ' ' . ':' . $resultat['date'] . '<br/>'; //

}

?>


  <br>
  


<?php
 if ($_SESSION == true)

  {
   echo  '<br>'. '<a href="commentaire.php">ajout commentaires</a></li>';
  }
  else
  {
    echo '<div class="d-flex justify-content-center"><a href="inscription.php">Inscrivez vous</a> puis <a href="connexion.php">connectez vous</a>  pour voir ce contenu</div>';
  }

?>

</div>
<div class="fixed-bottom">
    <footer class="bg-dark text-center text-white">
      <!-- Grid container -->
      <div class="container p-4">
        <!-- Section: Social media -->
        <section class="mb-4">
          <!-- Facebook -->
          <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f">Me contacter: <br> dorian.di-russo@laplateforme.io</i></a>

            
      </div>
</body>


<!--  -->
</html>