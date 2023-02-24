<?php

class Database {
    
    private $db_hostname = "localhost";
    private $db_username = "root";
    private $db_password = "root";
    private $db_database = "tdl";

    protected $pdo;


    public function dbConnexion()
    {
        try {

            $this->pdo = new PDO("mysql:host=$this->db_hostname;dbname=$this->db_database", $this->db_username, $this->db_password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo "Connection is failed " . $e->getMessage();
            exit;
        }


    }


    }





?>