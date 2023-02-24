<?php
session_start();
include_once('api/user-pdo.php');

$user = new Userpdo();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=style.css href="ttps://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
    <title>Accueil</title>
</head>

<body>
    
        
<!-- PHP: If user is connected ... -->
<?php if($user->isConnected()) { ?>

    <header>
        <nav>
            <a href="profil.php">Profil</a>
            <a href="todolist.php">To do list</a>
            <a href="connexion.php?deco">Déconnection</a>
            
        </nav>
    </header>
    
    <main>
        <h1>Welcome <b><?php echo $user->getFirstName(). " " . $user->getLastName(); ?></b></h1>
    </main>

    


    <!-- PHP: If user is not connected ... -->
    <?php } else { ?>

    <header>
        <nav>
            <a href="index.php" active>Accueil</a>
            <a href="connexion.php">Se connecter</a>
            <a href="inscription.php">Créer un compte</a>
        </nav>
    </header>

    <main>
        <h1>Welcome to tdl!</h1>
       
    </main>

    <?php } ?>  

 
</body>

</html>
