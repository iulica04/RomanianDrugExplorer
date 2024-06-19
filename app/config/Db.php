<?php
require_once('config.php');

class DB{
    protected $pdo;

    public function __construct()
    {
        try{
            $dsn = "mysql:host=".DB_SERVER.";dbname=".DB_NAME;
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo("Failed to connect to database: " . $e->getMessage());
            exit();
        }
    }

    public function __desctruct()
    {
        $this->pdo = null;
    }
}