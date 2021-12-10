<?php
$serveur = "localhost";
$dbname = "livreor";
$user = "root";
$pass = "";


try {
    $pdo = new PDO("mysql:host=$serveur;dbname=livreor", $user, $pass); // connexion bdd
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // gestion des erreurs

    @$login = htmlspecialchars($_POST["login"]); // empêcher l'ajout de code dans les input
    @$password = htmlspecialchars($_POST["password"]);
    @$repassword = htmlspecialchars($_POST["repassword"]);
    @$submit =  $_POST["submit"];
    @$erreur = ""; // variable qui affiche les erreur


    if (!empty($login) and !empty($password)) {
        if (isset($submit)) {
            if (empty($login)) $erreur = "Login laissé vide ! ";
            if (empty($password)) $erreur = "Mot de passe laissé vide";
            if ($password != $repassword) $erreur = "Mots de passe non identiques";


            else {
                $req = $pdo->prepare("SELECT id FROM utilisateurs WHERE login=? limit 1");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute(array($login));
                $tab = $req->fetchAll();
                if (count($tab) > 0)
                    $erreur = "<li>Login existe </li>";

                else {
                    $ins = $pdo->prepare("INSERT INTO utilisateurs(login,password) VALUES (?,?)");
                    $ins->execute(array($login, sha1($password)));
                    header('location: connexion.php');
                }
            }
        }
    }
} catch (PDOexception $e) {
    echo 'Impossible de traiter les données. Erreur : ' . $e->getMessage();
}






?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>inscription</title>
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
        </header>
            
        <form action="" method="POST">
        <div class="mb-3"> 
            <label for=""> login : </label> <br>
            <input name="login" type="text"> <br>
        </div>
        <div class="mb-3">
            <label for="">Mot de passe :</label> <br>
            <input name="password" type="password"> <br>
        </div>
        <div class="mb-3">
            <label for="">confirmation mot de passe :</label> <br>
            <input name="repassword" type="password"> <br>
        </div>
        <div class="mb-3">
            <label name="submit" for=""> submit</label> <br>
            <input type="submit" name="submit"> <br>
        </div>
            <div class="erreur"><?php echo $erreur ?></div>
        </form>
        </div>

   
        <div class="fixed-bottom">
        <footer class="bg-dark text-center text-white">
      <!-- Grid container -->
      <div class="container p-4">
        <!-- Section: Social media -->
        <section class="mb-4">
          <!-- Facebook -->
          

          <!-- Google -->
          <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">Me contacter: <br> dorian.di-russo@laplateforme.io<i class="fab fa-google"></i></a>
      </div>
</body>

</html>