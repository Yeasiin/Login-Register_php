<?php
    include_once "session.php";
    include "database.php";

    class user{
        private $db;
        public function __construct(){
             $this->db = new database(); 
        }

        public function registration($data){
            $name = $data["name"];
            $username = $data["username"];
            $email = $data["email"];
            $pass =  $data["pass"];
            $passenc = md5($data["pass"]);
            $chk_email = $this->emailCheck($email);

            if($name == "" || $username == "" || $email == "" || $pass == ""){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> Field Must Be Not Empty </div>";
                return $msg;
            }elseif(strlen($username) < 3){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> Username Is Too Short. </div>";
                return $msg;
            }elseif(preg_match("/[^a-z0-9_-]+/i",$username)){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> Username must only contain alphanumerical, dashes, and Underscores!. </div>";
                return $msg;
            }elseif(filter_var($email,FILTER_VALIDATE_EMAIL) === false){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> The Email Address Is Not Valid. </div>";
                return $msg;
            }elseif(strlen($pass) < 6){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> Password Is Too Short </div>";
                return $msg;
            }

            if($chk_email == true){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> The Email Address already Exist.</div>";
                return $msg;
            }
            $sql = "INSERT INTO tbl_lr(name,username,email,password) VALUES(:name,:username,:email,:password)";
            $query =  $this->db->pdo->prepare($sql);
            $query->bindValue(":name",$name);
            $query->bindValue(":username",$username);
            $query->bindValue(":email",$email);
            $query->bindValue(":password",$passenc);
            $result = $query->execute();

            if($result){
                $msg = "<div class='alert alert-success'> <strong>Success! </strong> Thank You.You have been Registrated</div>";
                return $msg;
            }else{
                $msg = "<div class='alert alert-danger'> <strong>Sorry! </strong> Something Is Wrong.</div>";
                return $msg;
            }

        }
        
        //Finding email Form Database
        public function emailCheck($email){
            $sql = "SELECT email FROM tbl_lr WHERE email = :email";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(":email",$email);
            $query->execute();

            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }
        // Checking Password Form Database
        public function passCheck($password){
            $sql = "SELECT password FROM tbl_lr WHERE password = :password";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(":password",$password);
            $query->execute();

            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
            }

        }

        public function getLoginUser($email, $pass){
            $sql = "SELECT * FROM tbl_lr WHERE email = :email AND password = :password ";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(":email",$email);
            $query->bindValue(":password",$pass);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
            
        }

        public function userLogin($data){
            $email = $data["email"];
            $pass = md5($data["pass"]);

            $chk_pass = $this->passCheck($pass);
            $chk_email = $this->emailCheck($email);


            if($email == "" || $pass == ""){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> Field Must Be Not Empty </div>";
                return $msg;
            }elseif(filter_var($email,FILTER_VALIDATE_EMAIL) === false){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> The Email Address Is Not Valid. </div>";
                return $msg;
            }elseif(strlen($pass) < 6){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> Password Is Too Short </div>";
                return $msg;
            }elseif($chk_pass == false){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong>Wrong Password.</div>";
                return $msg;
            }elseif($chk_email == false){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> Email Address Not Exist.</div>";
                return $msg;
            }

            $result = $this->getLoginUser($email,$pass);
            if($result){
                session::init();
                session::set("login", true);
                session::set("id",$result->id);
                session::set("name",$result->name);
                session::set("username",$result->username);
                session::set("loginmsg","<div class='alert alert-success'> <strong>Success! </strong> Your are Loggedin.</div>");
                header("Location: index.php");
            }else{
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> Data Not Found!.</div>";
                return $msg;
            }

        }

        public function getUserData(){
            $sql = "SELECT * FROM tbl_lr ORDER BY id DESC";
            $query = $this->db->pdo->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

        public function getUserById($id){
            $sql = "SELECT * FROM tbl_lr WHERE id=:id LIMIT 1";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(":id",$id);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        }

        public function updateUserData($id, $data){
            $name = $data["name"];
            $username = $data["username"];
            $email = $data["email"];
            

            if($name == "" || $username == "" || $email == ""){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> Field Must Be Not Empty </div>";
                return $msg;
            }elseif(filter_var($email,FILTER_VALIDATE_EMAIL) === false){
                $msg = "<div class='alert alert-danger'><strong> Error! </strong> The Email Address Is Not Valid. </div>";
                return $msg;
            }elseif(preg_match("/[^a-z0-9_-]+/i",$username)){
                $msg = "<div class= 'alert alert-danger'><strong>Errror!</strong> Username Must Only Contain alphanumerical,dashes,and Underscores!. </div>";
                return $msg;
            }



            elseif(preg_match("/[^a-z0-9_-]+/i",$username)){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> Username must only contain alphanumerical, dashes, and Underscores!. </div>";
                return $msg;
            }

            $sql = "UPDATE tbl_lr set name =:name, username = :username, email = :email WHERE id=:id";
            $query =  $this->db->pdo->prepare($sql);
            $query->bindValue(":name",$name);
            $query->bindValue(":username",$username);
            $query->bindValue(":email",$email);
            $query->bindParam(":id",$id);
            $result = $query->execute();


            if($result){
                $msg = "<div class='alert alert-success'> <strong>Success! </strong> User Data Updated Successfully!.</div>";
                return $msg;
            }else{
                $msg = "<div class='alert alert-danger'> <strong>Sorry! </strong> Something Is Wrong.</div>";
                return $msg;
            }
            
        }

        private function checkPassword($id, $old_pass){
            $password = md5($old_pass);

            $sql = "SELECT password FROM tbl_lr WHERE id= :id AND password = :pass";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(":id", $id);
            $query->bindValue(":pass", $password);
            $query->execute();

            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
            }

        }

        public function updatePassword($id, $data){
            $old_pass = $data["old_password"];
            $new_pass = $data["password"];
            $chk_pass = $this->checkPassword($id, $old_pass);

            if($old_pass == "" || $new_pass == ""){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> Field Must Not Be Empty.</div>";
                return $msg;
            }elseif(strlen($new_pass) < 6){
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong> Password Is Too Short</div>";
                return $msg;
            }

            if($chk_pass == false){
                $msg = "<div class='alert alert-danger'><strong>Error! </strong> Old Password Not Exist </div>";
                return $msg;
            }elseif(strlen($new_pass) < 6){
                $msg = "<div class='alert alert-danger'><strong>Error! </strong> Password Is Too short </div>";
                return $msg;
            }



            $password = md5($new_pass);

            $sql = "UPDATE tbl_lr SET password = :pass WHERE id=:id";
            $query =  $this->db->pdo->prepare($sql);
            $query->bindValue(":pass",$password);
            $query->bindValue(":id",$id);
            $result = $query->execute();

            if($result){
                $msg = "<div class='alert alert-success'> <strong>Success! </strong> Password Updated Successfully!.</div>";
                return $msg;
            }else{
                $msg = "<div class='alert alert-danger'> <strong>Sorry! </strong> Something Is Wrong.</div>";
                return $msg;
            }
            


        }


    }

?>