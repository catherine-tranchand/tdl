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
    
    // If 'id' exists...
    if (isset($_GET['id'])) {
        // ...get the id from PHP's GET 
        $id = (int) $_GET['id'];
        // create the to-do list with the $id
        $isDeleted = $tdl->deleteTodolist($id);
        
        // If the $isDelete is TRUE
        if ($isDeleted == TRUE) {
            // <- if the $deleted is FALSE...
            // ...update the response by setting 'success' to 'yes'
            $response['success'] = 'yes';
            $response['message'] = "todolist has been deleted successfully";
        } else { 
            // ...update the response by setting 'success' to 'yes'
            $response['success'] = 'no';
            $response['message'] = "failed to delete to-do list";
        }

    }

}else { // <- user is not connected
    // update the response by setting 'success' to 'no'
    $response['success'] = 'no';
    $response['message'] = "user is not connected";

}


echo json_encode($response);