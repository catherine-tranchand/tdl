<?php

session_start();

require_once("user-pdo.php");
require_once("TodoList.php");

$user = new Userpdo();
$tdl = new TodoList($user);

// create a response array
$response = array(
    "success" => 'no',
    "message" => ""
);

// if the user is connected
if ($user->isConnected()) {
    
    // If 'todolist_id' and 'description' exists...
    if (isset($_GET['todolist_id']) && isset($_GET['description'])) {
        // ...get the todolistId from PHP's GET 
        $todolistId = (int) $_GET['todolist_id'];
        // ...get the description from PHP's GET 
        $description = $_GET['description'];

        // add the  the to-do list with the $title
        $task = $tdl->addTask($todolistId, $description);
        
        // If the $task is null
        if ($task === null) {
            // ...update the response by setting 'success' to 'yes'
            $response['success'] = 'no';
            $response['message'] = "failed to add new task";

        } else { // <- if the $task is not null...
            // ...update the response by setting 'success' to 'yes'
            $response['success'] = 'yes';
            $response['message'] = "task was add successfully";
            // add the $data to the response
            $response['data'] = $task;

        }

    }

}else { // <- user is not connected
    // update the response by setting 'success' to 'no'
    $response['success'] = 'no';
    $response['message'] = "user is not connected";

}


echo json_encode($response);