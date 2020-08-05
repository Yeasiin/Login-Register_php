<?php 
    class database{
        private $hostdb = "sql301.epizy.com";
        private $userdb = "epiz_25147164";
        private $passdb = "3VyemvlB565tjB";
        private $namedb = "epiz_25147164_db_lr";
        public $pdo;

        public function __construct(){

            if(!isset($this->pdo)){
                try{
                    $link = new PDO("mysql:host=".$this->hostdb.";dbname=".$this->namedb,$this->userdb,$this->passdb);
                    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $link->exec("SET CHARACTER SET utf8");
                    $this->pdo = $link;

                }catch(PDOException $e){
                    die("Failled To Connect With Database".$e->getMessage());
                }
            }
        
        }


    }

?>