<?php


namespace application\core\lib;

use PDO;

class Db
{
    protected $db;

    public function __construct()
    {
        $config = require '../application/configs/db.php';
        if (!$this->db) {
            try {
                $this->db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['name'] . '', $config['user'], $config['password']);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            } catch (\PDOException $e) {
                exit('Database connecting error: ' . $e->getMessage());
            }
        }
    }

    public function addRow($query, $parameters = array())
    {
        $statementHandle = $this->db->prepare($query);
        return ($statementHandle->execute((array) $parameters)) ? $this->db->lastInsertId() : 0;
    }

    public function doQuery($query, $parameters = array())
    {
        $statementHandle = $this->db->prepare($query);
        return $statementHandle->execute((array) $parameters);
    }

    public function getRow($query, $parameters = array())
    {
        $statementHandle = $this->db->prepare($query);
        $statementHandle->execute((array) $parameters);
        return $statementHandle->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll($query, $parameters = array())
    {
        $statementHandle = $this->db->prepare($query);
//        foreach ($parameters as $parameterName => $parameterValue){
//            if(is_int($parameterValue)){
//                $statementHandle->bindValue(':'.$parameterName, (int) $parameterValue, PDO::PARAM_INT);
//            }else{
//                $statementHandle->bindValue(':'.$parameterName, $parameterValue);
//            }
//        }
        $statementHandle->execute((array) $parameters);
        return $statementHandle->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getValue($query, $parameters = array(), $default = null)
    {
        $result = $this->getRow($query, $parameters);
        if (!empty($result)) {
            $result = array_shift($result);
        }

        return (empty($result)) ? $default : $result;
    }

    public function getColumn($query, $parameters = array())
    {
        $statementHandle = $this->db->prepare($query);
        $statementHandle->execute((array) $parameters);
        return $statementHandle->fetchAll(PDO::FETCH_COLUMN);
    }

}