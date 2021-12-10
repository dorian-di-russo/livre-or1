<?php

session_start();
$serveur = "localhost";
$dbname = "livreor";
$user =  "root";
$pass = "";
$message = "";


try {
    $pdo = new PDO("mysql:host=$serveur;dbname=$dbname", $user, $pass); // connexion bdd
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // gestion des erreurs

    @$password = sha1($_POST['password']);  // attribution des post a des variable pour les rappeler plus facilement
    @$login =  htmlspecialchars($_POST['login']);

    if (isset($_POST['submit'])) {  // si j'envoie mon formulaire
        if (empty($_POST['login']) || empty($_POST['password'])) { // et que les champs sont remplis 
            $message =  'tout les champs sont requis';
        } else {       // je selectionne tout de ma table utilisateur ou mes log et mdp correspondent
            $query = "SELECT * FROM utilisateurs WHERE login = :login AND password = :password";  // requête sql
            $statement = $pdo->prepare($query); // préparation de la requête
            $statement->execute( // exécution del a requête
                array(
                    'login' => $login,
                    'password' => $password
                )
            );


            $count = $statement->rowCount();     //   

            if ($count == 1) {

                $resultat = $statement->fetch();
                $_SESSION["login"] = $resultat['login'];
                $_SESSION['password'] = $resultat['password'];
                $_SESSION['id'] = $resultat['id'];
            } else {

                $message = "erreur";
            }
        }
    }
} catch (PDOException $e) {

    echo 'impossible de traiter les données. Erreur:' . $e->getMessage();
}





?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<title>Connexion</title>







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
                        <?php
                        if ($_SESSION == true) {
                            echo  '<li class="nav-item">
      <a class="nav-link active" aria-current="page" href="commentaire.php">commentaires</a>
  </li>';
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <?php
    if ($_SESSION == true) {

        echo '<div class="d-flex justify-content-center align-items-center container">bonjour' . '  ' . $_SESSION['login'] . '  ' . 'vous êtes la' . '   ' . $_SESSION['id'] . 'ème personne a vous êtes inscrit sur ce site</div>' . '<br/>';
    }
    ?>

    <div class="d-flex justify-content-center">
        <form action="connexion.php" method="post">

            <div class="erreur"><?php echo $message ?></div> <br>
            <div class="form-group">
                <label for="login"><b>Login</b></label> <br>

                <input type="text" placeholder="Entrer login" id="login" name="login">
            </div> <br>
            <div class="form-group">
                <label for="password"><b>Mot de passe</b></label> <br>
                <input type="password" placeholder="Entrer mot de passe" id="password" name="password"> <br><br>
            </div>

            <?php
            if ($_SESSION == true) {
                echo '<a href="logout.php">déconnexion</a>' . '<br>';
            }

            ?>

            <?php if ($_SESSION != true) {

                echo   "<button type='submit' name='submit'>Login</button><br>";
            } else {
                echo 'vous êtes connecté';
            }


            // var_dump($_SESSION);
            ?>


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