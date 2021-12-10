<?php
session_start();
if (!isset($_SESSION['id']))

 {
     header('Location: connexion.php');
 }
$serveur = 'localhost';
$dbname = 'livreor';
$user= 'root';
$pass= '';





try {
    $pdo = new PDO ("mysql:host=$serveur;dbname=$dbname",$user,$pass); // co bdd
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); // gestion erreur


    

 if(isset($_SESSION['id'])) { // si ma session existe
    @$id = $_SESSION['id']; // je lui attribu une variable
    $user = $pdo->prepare('SELECT * FROM  utilisateurs WHERE id = ? '); //requête permettant de savoir si  l'id de mon utilisateur est égal a celui de ma bdd
    $user->execute(array($id)); // comparaison des id 
    $user = $user->fetch(); // 


        if(isset($_POST['submit'])) // si mon formulaire est envoyé
        {
            if(isset($_SESSION['id'],$_POST['commentaire']) AND !empty($_POST['commentaire'])) // si j'ai une session existante et que le champ commentaire n'est pas vide
            {
                $commentaire = htmlspecialchars(($_POST['commentaire'])); // empêche l'utilisateur de rentrer du code dans le textarea

                if ($_SESSION['id']) {    // requête d'ajout de commentaires avec précision de l'heure grace a NOW ()
                    $req = $pdo->prepare('INSERT INTO commentaires(commentaire,id_utilisateur,date) VALUES (?,? ,NOW())');
                    $req->execute(array($commentaire,$id));  
                    $c_msg = "<span style='color:green'>Votre commentaire a bien été posté</span>";
                }
            }
            else{
                $erreur = 'Champ vide';
            }
        }
 }
        $commentaire = $pdo->prepare('SELECT * FROM commentaires WHERE commentaire = ? ORDER BY id DESC');
        $commentaire->execute(array(@$id));

        

      

    

    





    
} catch (PDOException $e) {
    echo 'impossible de traiter les données . erreur : ' . $e->getMessage();
}


 


// var_dump($_SESSION);
// var_dump(@$_POST['submit']);
// var_dump(@$_POST['commentaire']);


?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Ajout commentaires</title>
    
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
                            <a class="nav-link active" aria-current="page" href="logout.php">Déconnexion</a>
                        </li>


                    </ul>
                </div>
            </div>
        </nav> <br> <br>
    </header>
    
    <div class="d-flex justify-content-center align-items-center container">
    <div class="card bg-light">
    <form class="card-body" action="" method="POST">
    <label class="h4 form-control-label" for="commentaire">Envoi commentaire : <br></label> <br>
        <textarea class="form-control" name="commentaire" id="" >

        </textarea> <br>
        
        <input class="btn btn-secondary" type="submit" name="submit">
    </form>
    </div>
    </div>

    <?php if(isset($c_msg)) { echo $c_msg; } ?>
	<br /><br />
	<?php while($c = $commentaire->fetch()) { ?>
	   <?= $c['commentaire'] ?><br />
	<?php } ?>
    </div>
    <div class="fixed-bottom">
    <footer class="bg-dark text-center text-white">
      <!-- Grid container -->
      <div class="container p-4">
        <!-- Section: Social media -->
        <section class="mb-4">
          <!-- Facebook -->
          <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>

            
      </div>
</body>
</html>

