<?php
    class db {
        private $dbhost = 'localhost';
        private $dbuser = 'root';
        private $dbpass = 'root';
        private $dbname = 'customer_app';

        public function connect()
        {
            $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname";
            $dbConnecction = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
            $dbConnecction->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $dbConnecction;
        }
    }