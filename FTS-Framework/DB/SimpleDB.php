<?php

namespace FTS\DB;


use FTS\App;

class SimpleDB
{
    protected $_connection = 'default';
    private $_db = null;
    private $_statement = null;
    private $_params = array();
    private $_sql;

    public function __construct($connection = null)
    {
        if ($connection instanceof \PDO) {
            $this->_db = $connection;
        } else if ($connection != null) {
            $this->_db = App::getInstance()->getDbConnection($connection);
            $this->_connection = $connection;
        } else {
            $this->_db = App::getInstance()->getDbConnection($this->_connection);
        }
    }

    // $this for chaining
    public function prepare($sql, $params = array(), $pdoOptions = array())
    {
        $this->_statement = $this->_db->prepare($sql, $pdoOptions);
        $this->_params = $params;
        $this->_sql = $sql;

        return $this;
    }

    public function execute($params = array()){
        if ($params) {
            $this->_params = $params;
        }

        $this->_statement->execute($this->_params);
        return $this;
    }

    public function fetchAllAssoc(){
        return $this->_statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchRowAssoc(){
        return $this->_statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function getLastInsertedId(){
        return $this->_db->lastInsertId();
    }

    public function getStatement(){
        return $this->_statement;
    }
}