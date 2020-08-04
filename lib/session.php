<?php 
    class session {
        public static function init(){
                if(session_id() == '') {
                    session_start();
                }elseif(session_status() == PHP_SESSION_NONE ) {
                        session_start();
                }else{
                    session_start();
                }

 
        }

        public static function set($key, $val){
            $_SESSION[$key] = $val;
        }
        
        public static function get($key){
            if(isset($_SESSION[$key])) {
                return $_SESSION[$key];
            }else{
                return false;
            }
        }

        public static function checkSession(){
            if(self::get("login") == false){
                self::distroy();
                header("Location: login.php");
            }
        }

        public static function checkLogin(){
            if(self::get("login") == true){
                header("Location: index.php");
            }
        }

        public static function distroy(){
            session_destroy();
            session_unset();
            header('Location: login.php');
        }


    }


?>