<?php

//To open the session

session_start();          
require_once('api/user-pdo.php');

$user = new Userpdo();

// To include the config and have an acces to data base 


if(isset($_GET['deco'])){
    $user->disconnect();
    header('Location: index.php');
}


if ($user->isConnected()) {
    header('Location: todolist.php');
    exit();
}


if(isset($_POST['envoi'])){
    // $user->connect($_POST['']);
    if(!empty($_POST['login']) && !empty($_POST['password'])){


        $login=htmlspecialchars($_POST['login']);  //htmlspecialchar to secure the data

        $password=htmlspecialchars($_POST['password']); 
        //$hashPassword=password_hash($password, PASSWORD_DEFAULT); // password_hash(encoding) to secure the password
        
        $user->connect($login, $password);

        // if ($user->isConnected()) {
        //     header('Location: todolist.php');
        // }else{
        //     echo "Error";
        // }
      



   
       
        // if($res){

        //     $id = $res['id'];

        //     if(password_verify($password, $res['password'])) {
                
        //         echo "connection reussi! ";

        //         $_SESSION['id'] = $id;  // To add an id to the session
        //         $_SESSION['login'] = $login;  // To add an id to the session

        //         if($login == "admin"){
        //             header('Location: admin.php');
        //         }else {
        //             header('Location: index.php'); // To redirect  to home page
        //         }

        //     } else {
        //         echo "<p class='err-msg'>Votre mot de passe ou login est incorrecte</p>";
        //     }


        // }  else {
        //     echo "<p class='err-msg'>Utilisateur n'existe pas</p>";
        // }

        
    } else {
       echo "<p class='err-msg'>Veuillez completer tous les champs... </p>";
    }

}
?>



<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href=style.css>
        <title>Connexion</title>
    </head>

<body>

    <header>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="connexion.php" active>Se connecter</a>
            <a href="inscription.php">Créer un compte</a>
        </nav>
    </header>

    <main> 
    <form action="" method="post" id="form" class="topBefore">  <!--The form with method "post" ---->
        <input id="login" name="login" placeholder="Login" type="text" ><br> 
        <input id="password" name="password" placeholder="Password" type="password" ><br>
        <input id="submit" type="submit" name="envoi" value="Envoi"><br>

    </form>

    </main>

</body>
</html>