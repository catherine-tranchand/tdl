<?php
session_start();
include_once('api/user-pdo.php');

$user = new Userpdo();

if (!$user->isConnected()) {  // if user is not connected 
    header('Location: index.php');
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=style.css href="ttps://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>My Todo list</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="todolist.css">
    
    <script src="todolist.js"></script>
</head>

<body>
    
  
<!-- PHP: If user is connected ... -->
<header>
    <nav>
        <a href="profil.php">Profil</a>
        <a href="todolist.php" active>To do list</a>
        <a href="connexion.php?deco">Déconnection</a>
        
    </nav>
</header>

    <main>
        <!-- <h1>Welcome <b><?= $user->getFirstName() . " " . $user->getLastName(); ?></b></h1> -->

        <section id="allTodos">
            <h2>All my TODOs</h2>
            <button onclick="showCompletedTodos()">Show Completed Todos</button>

            <ul class="todo-list-container">

                <li id="creator">
                    <textarea id="newList" type="text" placeholder="New List" maxlength="50"></textarea>
                    <button id="createTodolist" onclick="createTodolist()">Create Todolist</button>
                </li>

<!-- 
                <li class="todo-list">

                    <div class="bar">
                        <button onclick="deleteTodoById()"><span class="material-symbols-outlined">delete</span></button>

                        <div class="info">
                            <h2 class="todo-name">Groceries</h2>
                            <h4 class="todo-date">21/02/2023 @ 15:07</h4>
                        </div>
                    </div>


                    <ul class="content">
                        <li class="todo-data">
                            <input type="checkbox">
                            <p>Buy some bananas</p>
                            <button class="todo-delete-btn"><span class="material-symbols-outlined icon">close</span></button>
                        </li>
                    </ul>


                    <div class="input-container">
                        <input type="text" placeholder="What do you want to do?">
                        <button>Add</button>
                    </div>

                </li> -->
                
            </ul>

        </section>

        <section id="completedTodos">
            <h2>Completed Todos</h2>
            <button onclick="showAllTodos()">Show All Todos</button>
        </section>

    </main>

 
</body>

</html>
