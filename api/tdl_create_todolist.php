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
    
    // If 'title' exists...
    if (isset($_GET['title'])) {
        // ...get the title from PHP's GET 
        $title = $_GET['title'];
        // create the to-do list with the $title
        $data = $tdl->createTodoList($title);
        
        // If the $data is null
        if ($data === null) {
            // ...update the response by setting 'success' to 'yes'
            $response['success'] = 'no';
            $response['message'] = "failed to create to-do list";

        } else { // <- if the $data is not null...
            // ...update the response by setting 'success' to 'yes'
            $response['success'] = 'yes';
            $response['message'] = "todolist was created successfully";
            // add the $data to the response
            $response['data'] = $data;

        }

    }

}else { // <- user is not connected
    // update the response by setting 'success' to 'no'
    $response['success'] = 'no';
    $response['message'] = "user is not connected";

}


echo json_encode($response);