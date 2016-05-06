<?php
namespace models;

Class Bdd
{
    private $_bdd;

    public function __construct ()
    {
        $config = include '../config.php';
        try {
            $this->_bdd = new \PDO('mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'], $config['db']['username'], $config['db']['password']);
        }
        catch (\PDOException $e) {
            die('error occurred : ' . $e->getMessage());
        }
    }

    public function getBdd () 
    {
        return $this->_bdd;
    }
    
}