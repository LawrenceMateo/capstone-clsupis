<?php

    class Database {
        // DB PARAMS
        private $db_uname = 'root';
        private $password = '';
        private $server_name = 'localhost';
        private $database_name = 'db_project_information_system';
        private $conn;

        // DB CONNECT
        public function connect(){
            $this->conn = null;

            try{
                $this->conn = new PDO('mysq');
            } catch(PDOException $e) {
                echo 'Connection Error ' . $e->getMessage();
            }
        }
    }