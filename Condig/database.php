<?php 
//connexion a la base
class  database{
        public static $HOST ='localhost';
        public static $DbNAME= 'brief-3';
        public static $username ='root';
        public static $password = '';

        public static $connexion = null ;

        public  static function getConnection(){
            try {

                   self::$connexion = new PDO(
                    "mysql:host=".self::$HOST.";dbname=".self::$DbNAME,self::$username ,self::$password);
                    self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    self::$connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                   
            } catch (PDOException $e) {
                die ("Erreur de connexion : " . $e->getMessage());
            }
            return self::$connexion;
        }
        public static function disconnect(){
            self::$connexion = null;
        }

}

?>