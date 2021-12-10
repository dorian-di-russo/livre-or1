<?php
session_start();
$bdd = new PDO ("mysql:host=localhost;dbname=livreor", "root","");



if (isset($_SESSION['id'])) {
    $requet = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $requet->execute(array($_SESSION['id']));
    $user = $requet->fetch();


    if (isset($_POST['newlogin']) && !empty($_POST['newlogin']) && $_POST['newlogin'] != $user['login']) {
        $newlogin = htmlspecialchars($_POST['newlogin']);
        $insertlogin = $bdd -> prepare("UPDATE utilisateurs SET login = ? WHERE id = ? ");
        $insertlogin->execute(array($newlogin,$_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
    }

    if (isset($_POST['newmdp1']) && !empty($_POST['newmdp1']) && isset($_POST['newmdp2']) && !empty($_POST['newmdp2'])) {
        $mdp1 = md5($_POST['newmdp1']);
        $mdp2 = md5($_POST['newmdp2']);
        if ($mdp1 == $mdp2) {
  
           $insertmdp = $bdd->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
           $insertmdp->execute(array($mdp1, $_SESSION['id']));
           header('Location: profil.php?id=' . $_SESSION['id']);
        } else {
           $msg = 'vos deux mots de passes ne correspondent pas !';
        }
     }
}

var_dump($_SESSION);


?>


<!DOCTYPE html>
<html lang="fr">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier profil</title>
</head>
<body>
         
<form action="" method="POST">

    <label for="login">Login</label>
    <input type="text" name="newlogin" placeholder="Pseudo" value="<?php echo @$_SESSION['login']; ?>" /><br /><br />
    <label for="NewPassword">Password</label>
    <label>Mot de passe :</label>
    <input type="password" name="newmdp1" placeholder="Mot de passe" /><br /><br />
    <label>Confirmation - mot de passe :</label>
    <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />
    <input type="submit" value="Mettre à jour mon profil !" />
    </form>
</body>
</html>