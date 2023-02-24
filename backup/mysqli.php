<?php

class Database {
    
    private $db_hostname = "localhost";
    private $db_username = "root";
    private $db_password = "root";
    private $db_database = "classes";

    protected $mysqli;


    public function dbConnexion() {
        
        // $mysqli = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
        $conn = new mysqli($this->db_hostname, $this->db_username, $this->db_password, $this->db_database);
        
        if($conn->connect_errno){
            echo "failed DB connection " . $conn->connect_error;
            exit();
        }
        
        echo "Connection successful "; 

        // update the `mysqli` protected variable with our `$conn` so we can 
        // use it (i.e. mysqli) in th User class
        $this->mysqli = $conn;
    }
}




?>