<?php
    class connexionBD {
        private $host = 'localhost';
        private $name = 'bd_boutique';
        private $user = 'root';
        private $password = '';
        private $connexion;

        function __construct($host = null, $name = null, $user = null, $password = null)
        {
            if($host != null){
                $this->host = $host;
                $this->name = $name;
                $this->user = $user;
                $this->password = $password;
            }
            try{
                $this->connexion = new PDO('mysql:host='. $this->host . ';dbname=' . $this->name, 
                $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8MB4', 
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

            }catch (PDOException $e){
                echo 'Erreur : Impossible de se connecter à la Base de données';
                die();
            }
        }

        public function DB(){
            return $this->connexion;
        }
    }

    $DBB = new connexionBD();

    $DB = $DBB->DB();
?>