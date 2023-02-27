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
    
    // get all to-do lists of this connected user
    $todolists = $tdl->getAllTodoLists();

    // get all todos / tasks of this connected user
    $todos = $tdl->getAllTodos();

    $data = array();

    foreach ($todolists as $todolist) {
        // get the todo list id
        $tdl_id = $todolist['id'];
        
        // get the tasks of this todolist id (tdl_id)
        $tasks = array_filter($todos, function($todo) use ($tdl_id) {
            return $todo['todolist_id'] == $tdl_id;
        });

        // get only the 
        $todolist['tasks'] = array_values($tasks);

        $todolist['createdAt'] = date('D d/m/Y @ H:i', strtotime($todolist['createdAt']));

        $data[] = $todolist;
        

    }

    // ...update the response by setting 'success' to 'yes'
    $response['success'] = 'yes';
    $response['message'] = "";
    // add the $data to the response
    $response['data'] = $data;

    //print_r($data);



}else { // <- user is not connected
    // update the response by setting 'success' to 'no'
    $response['success'] = 'no';
    $response['message'] = "user is not connected";

}


echo json_encode($response);