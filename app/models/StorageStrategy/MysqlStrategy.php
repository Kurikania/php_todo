<?php

class MysqlStrategy extends Model implements StorageStrategy
{
    function __construct() {
        parent::__construct();
    }
    public function fetchAll()
    {
        $sql = 'select * from ' . $this->_table;

        $statement = $this->_dbh->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }
    public function _setTable($table)
    {
        $this->_table = $table;
    }

    public function fetchOne($id)
    {
        $res = parent::fetchOne($id);
        return (array) $res;
    }
}