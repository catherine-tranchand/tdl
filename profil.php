<?php

session_start();
include('backup/db_config.php');   

if(!isset($_SESSION['id'])){
    header('Location: index.php');

}

$id = $_SESSION['id'];
$recupUser = $conn->prepare("SELECT * FROM `users` WHERE id = '$id'");
$recupUser->execute();
$user = $recupUser->fetch(PDO::FETCH_ASSOC);
$login = $user['login'];
$firstname = $user['firstname'];
$lastname = $user['lastname'];
$hashPassword = $user['password'];

//var_dump($user);


if(isset($_POST['modifier'])){
    if(!empty($_POST['login']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['newPassword']) && !empty($_POST['confirmNewPassword'])){

        $newLogin=htmlspecialchars($_POST['login']);  //htmlspecialchar to secure the data
        $newfirstname=htmlspecialchars($_POST['firstname']);
        $newlastname=htmlspecialchars($_POST['lastname']);
        $newPassword=htmlspecialchars($_POST['newPassword']); 
        $newConfirmPassword=htmlspecialchars($_POST['confirmNewPassword']);


        $recupUser = $conn->prepare('SELECT * FROM users WHERE login = ?');
        $recupUser->execute(array($newLogin));
        
        $foundUser = ($recupUser->rowCount() > 0);
        
        if($foundUser){
            echo "<p class='err-msg'>User is already exists</p>";
           
        } else {


            if($newPassword == $newConfirmPassword) {
                
                $newPassword=password_hash($newPassword, PASSWORD_DEFAULT);

                $updateUser = $conn->prepare("UPDATE `users` SET `login` = ?, `firstname` = ?, `lastname`= ?, `password`= ? WHERE id = ?");
                $updateUser->execute(array($newLogin, $newfirstname, $newlastname, $newPassword, $id));

                if($updateUser){
                    echo "<p class='success-msg'>Profile updated successfully</p>";
                }

            } else {
                    echo "<p class='err-msg'>Passwords do not match</p>";
            }
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
        <title>Module-connexion</title>
    </head>

<body>
    
    <header>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="profil.php">Profil</a>
            <a href="connexion.php?deco">Déconnection</a>
        </nav>
    </header>
   
    <main> 
    <h2>Modifiez votre profil</h2>

    <form action="" method="post" id="form" class="topBefore" >  <!--The form with method "post" ---->
        <input id="login" name="login" placeholder="Login" type="text" value="<?php echo $login; ?>" ><br> 
        <input id="email" name="email" placeholder="email" type="email"><br> 
        <input id="firstname" name="firstname" placeholder="firstname" type="text" value="<?php echo $firstname; ?>" ><br>
        <input id="lastname" name="lastname" placeholder="lastname" type="text" value="<?php echo $lastname; ?>" ><br>
        <input id="password" name="newPassword" placeholder="New Password" type="password" ><br>
        <input id="password" name="confirmNewPassword" placeholder="Confirm New Password" type="password" ><br>
        
        <input id="submit" type="submit" name="modifier" value="Modifier"><br>

    </form>

</main>

</body>
</html>