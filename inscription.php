<?php

session_start();
include('api/user-pdo.php');

$user = new Userpdo();


if(isset($_POST['envoi'])){
    if(!empty($_POST['login']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['password']) && !empty($_POST['confirmPassword'])){
        $login=htmlspecialchars($_POST['login']);  //htmlspecialchar to secure the data
        $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : "";
        $firstname=htmlspecialchars($_POST['firstname']);
        $lastname=htmlspecialchars($_POST['lastname']);
        $password=htmlspecialchars($_POST['password']);
        $hashPassword=password_hash($_POST['password'], PASSWORD_DEFAULT); // password_hash(encoding) to secure the password
        $confirmPassword=htmlspecialchars($_POST['confirmPassword']);

        if ($password == $confirmPassword) {
            $user->register($login, $email, $password, $firstname, $lastname);

        } else {
            echo "<p class='err-msg'>passwords do not match</p>";
        }

        
    } else {
        echo "<p class='err-msg'>Veuillez completer tous les champs...</p>";
        
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
        <title>tdl</title>
    </head>

<body>
    <header>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="connexion.php">Se connecter</a>
            <a href="inscription.php" active>Créer un compte</a>
        </nav>
    </header>

   
    <main> 
        <h2>Inscription</h2>
        <form action="" method="post" id="form" class="topBefore">  <!--The form with method "post" ---->
            <input id="login" name="login" placeholder="Login" type="text" required><br> 
            <input id="email" name="email" placeholder="email (optional)" type="email" ><br> 
            <input id="firstname" name="firstname" placeholder="firstname" type="text"  required><br>
            <input id="lastname" name="lastname" placeholder="lastname" type="text"  required><br>
            <input id="password" name="password" placeholder="Password" type="password"  required><br>
            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" type="password"  required><br>
            
            <input id="submit" type="submit" name="envoi" value="Envoi"><br>

        </form>

    </main>

</body>

</html>
