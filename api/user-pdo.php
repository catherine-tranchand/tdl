<?php


include_once('database.php');


class Userpdo extends Database { //Using "extends" in order to get propreties of "Database" class
    public $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    
    public function __construct() {
        $this->dbConnexion();

        if ($this->isConnected()) {
            $id = $_SESSION['id'];

            $pdo_stmt = $this->pdo->query("SELECT * FROM `users` WHERE id = '$id'");
            $user = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $user['id']; // To put an id from Database to class id proporties
            $this->login = $user['login'];
            $this->email = $user['email'];
            $this->firstname = $user['firstname'];
            $this->lastname = $user['lastname'];

        }
    }
    
    public function userExist($login){

        
        $result = $this->pdo->query("SELECT * FROM `users` WHERE login ;= '$login'");
        $count = $result->rowCount();

        // echo " count is $count";

        if ($count === 0) {
            return false;
        }
        else{
            return true;
        }


    }

    public function register($login, $email, $password, $firstname, $lastname){
      
        if($this->userExist($login) == false){
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $ins = $this->pdo->prepare("INSERT INTO `users` (login, password, email, firstname, lastname) values (?, ?, ?, ?, ?)");
            $ins->execute(array($login, $hashPassword, $email, $firstname, $lastname));

            echo "User is successfully registered  ";

            return true;
        }
        else{
            echo "User is already exists ";
            return false;
        }
        
    }


    public function connect($login, $password)
    {
        $pdo_stmt = $this->pdo->query("SELECT * FROM `users` WHERE login = '$login'");
        $foundLogin = $pdo_stmt->rowCount() > 0;

        if ($foundLogin) {

            $user = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

            $hashPassword = $user['password'];
    
            if (password_verify($password, $hashPassword)) {
    
    
                $this->id = $user['id']; // To put an id from Database to class id proporties
                $this->login = $user['login'];
                $this->email = $user['email'];
                $this->firstname = $user['firstname'];
                $this->lastname = $user['lastname'];
    
                $_SESSION['id'] = $this->id;

                echo $login .  " is connected";
    
            } else {
                echo "Password is not correct";
            }
            
        }else{
            echo "User does not exist";
        }

    }
    
            // var_dump($user);
            

      


   

    public function isConnected() {
        if(isset($_SESSION['id'])) {
            return true;
            
        }else {
            return false;
        }
    }

    public function disconnect(){

     if($this->isConnected()){
            unset($_SESSION);
            echo "$this->login is disconnected";
     }
  
    }

    public function delete(){
        $query = $this->pdo->query("DELETE FROM `users` WHERE id = '$this->id'");
        // var_dump($result);
   
    }

    /**
     * Method used to update the user's information in the database
     * 
     * @param string $login
     * @param string $email
     * @param string $password
     * @param string $firstname
     * @param string $lastname
     * 
     * @return bool - Returns TRUE if the user's info has been updated
     */
    public function update($login, $email, $password, $firstname, $lastname){
        $pdo_stmt = $this->pdo->prepare("UPDATE `users` SET login = '$login', email = '$email', password = '$password', firstname = '$firstname', lastname = '$lastname' WHERE id = '$this->id'");
        $result = $pdo_stmt->execute(array($login, $email, $password, $firstname, $lastname));

        var_dump($result);

        if($result == true){
            $this->login = $login;
            $this->email = $email;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            
            echo "User has been updated ";
        }

        return $result;
        // var_dump($result);
   
    }
    public function getLastName()
    {
        return $this->lastname;
    }

    public function getFirstName(){
        return $this->firstname;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getLogin(){
        return $this->login;
    }

   public function getAllInfos(){
    return [
        'id' => $this->id,
        'login' => $this->login, 
        'email' => $this->email,
        'firstname' => $this->firstname,
        'lastname' => $this->lastname,
    ];

    }


   }




?>