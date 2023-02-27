<?php

require_once('database.php');


class TodoList extends Database {


    private $user;

    public function __construct($user) {
        $this->dbConnexion();

        $this->user = $user;

        // set the default timezone to "Europe/Paris"
        date_default_timezone_set("Europe/Paris");
    }


    public function createTodoList(string $title) : null|array {
        $result = null;

        // if the title is not empty...
        if (empty(trim($title)) === FALSE) {
            $title = htmlspecialchars($title);

            // get the current time as $createdAt
            $createdAt = $this->getCurrentDate();
            // get the user id
            $userId = $this->user->id;
    
            //var_dump($createdAt);
    
            $pdo_stmt = $this->pdo->prepare("INSERT INTO `todolists` (title, createdAt, user_id) values(?, ?, ?)");
            $pdo_res = $pdo_stmt->execute(array($title, $createdAt, $userId));
    
            if ($pdo_res) {
                // get the id of this to-do list
                $id = $this->getTodoListIdByDate($createdAt);

                $result = array(
                    "id" => $id,
                    "title" => $title, 
                    "createdAt" => $createdAt, 
                    "userId" => $userId
                );
            }

        }

        //$result = $pdo_stmt->fetch

        return $result;
        
    }

    public function addTask(int $todolist_id, string $description) : null|array {
        $result = null;

        // if the todolist id is greater than zero and description is not empty...
        if ($todolist_id > 0 && empty(trim($description)) === FALSE) {
            
            $description = htmlspecialchars($description);
            // get the user id
            $userId = $this->user->id;
            
            $completed = 0;
    
            //var_dump($createdAt);
    
            $pdo_stmt = $this->pdo->prepare("INSERT INTO `todos` (todolist_id, description, completed, user_id) values(?, ?, ?, ?)");
            $pdo_res = $pdo_stmt->execute(array($todolist_id, $description, $completed, $userId));
    
            if ($pdo_res) {
                // get the latest todo id
                $taskId = $this->getLatestTaskId($todolist_id);

                $result = array(
                    "id" => $taskId,
                    "description" => $description
                );
            }

        }

        //$result = $pdo_stmt->fetch

        return $result;
        
    }

    private function getLatestTaskId(int $todolist_id) {

        $pdo_stmt = $this->pdo->prepare("SELECT id FROM `todos` WHERE todolist_id = ? ORDER BY id DESC LIMIT 1"); // order by id des - from last to first/ limit 1 - pick one
        $pdo_stmt->execute(array($todolist_id));

        $taskId = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

        return $taskId['id'];
    }

    public function deleteTodoList(int $id) : bool {
        $result = false;

        // if the id is more than zero...
        if ($id > 0) {
            //var_dump($createdAt);
    
            $delete_todolist_result = $this->pdo->query("DELETE FROM `todolists` WHERE id = '$id'");
            $delete_todos_result = $this->pdo->query("DELETE FROM `todos` WHERE todolist_id = '$id'");

            if ($delete_todolist_result === TRUE && $delete_todos_result === TRUE) {
                $result = true;
            }

        }

        //$result = $pdo_stmt->fetch

        return $result;
        
    }


    public function deleteTaskById(int $taskId) : bool {
        $result = false;

        // if the id is more than zero...
        if ($taskId > 0) {
            //var_dump($createdAt);
    
            $delete_result = $this->pdo->query("DELETE FROM `todos` WHERE id = '$taskId'");

            // var_dump($delete_result->rowCount());

            if ($delete_result->rowCount() > 0) {
                $result = true;
            }

        }

        return $result;
        
    }
    public function getAllTodoLists() : array {
        $result = array();

        $userId = $this->user->id;
        $pdo_stmt = $this->pdo->query("SELECT * FROM `todolists` WHERE user_id = '$userId' ORDER BY createdAt DESC");
        $result = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getAllTodos() : array {
        $result = array();

        $userId = $this->user->id;
        $pdo_stmt = $this->pdo->query("SELECT * FROM `todos` WHERE user_id = '$userId'");
        $result = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Method used to get the id of a to-do list with the given date
     * 
     * @param $date - The DATETIME value of the todo list
     */
    private function getTodoListIdByDate($date){
        $pdo_stmt = $this->pdo->query("SELECT id FROM `todolists` WHERE createdAt = '$date'");
        $pdo_res = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

        return $pdo_res['id'];
    }


    private function getCurrentDate() {
        return date('Y-m-d H:i:s');
    }

}