<?php

class model{
    private $connection;
    private $last; //last query
    protected $table;

    public function __construct() {
        $this->dbconnect();
        $this->Execute('SET NAMES utf8');
    }

    public function dbconnect()
    {
        $this->connection = new mysqli(SERVER,DBUSER,DBPASS,DBNAME);
        if($this->connection)
            return TRUE;

        return FALSE;
    }





    public function Execute($query)
    {
        //$query = $this->connection->real_escape_string($query);
        if($result = $this->connection->query($query))
        {
            $this->last = $result;
            return TRUE;
        }
        return FALSE;
    }



    public function Execute_Multi($query)
    {
        //$query = $this->connection->real_escape_string($query);
        if($result = $this->connection->multi_query($query))
        {
            $this->last = $result;
            return TRUE;
        }
        return FALSE;
    }



    public function GetRows()
    {
        $result = array();
        $rows   = $this->AffectedRows();
        for($i = 0;$i<$rows;$i++)
        {
            $result[] = $this->last->fetch_assoc();
        }
        if(count($result) > 0)
            return $result;

        return [];
    }


    public function GetRow()
    {
        $result = array();
        $rows   = $this->AffectedRows();
        for($i = 0;$i<$rows;$i++)
        {
            $result[] = $this->last->fetch_assoc();
        }
        if(count($result) > 0)
            return $result[0];
        return [];
    }


    public function AffectedRows()
    {
        return $this->connection->affected_rows;
    }


    /**
     * Count Results in Table
     * @param type $table
     */
    public function Select_Count()
    {
        $this->Execute("SELECT COUNT(*) FROM `{$this->table}`");
        $count = $this->GetRow();
        return $count['COUNT(*)'];
    }



    /**
     * Inserting row into database
     * @param array $data
     * @return boolean
     */
    public function Insert($data)
    {
        // setup some variables for fields and values
        $fields  = '';
        $values = '';
        // populate them
        foreach ($data as $f => $v)
        {
            $fields  .= "`$f`,";
            $values .= ( is_numeric( $v ) && ( intval( $v ) == $v ) ) ? $v."," : "'$v',";
        }

        // remove our trailing ,
        $fields = substr($fields, 0, -1);
        // remove our trailing ,
        $values = substr($values, 0, -1);

        $querystring = "INSERT INTO `{$this->table}` ({$fields}) VALUES({$values})";
        //echo $querystring;
        //Check If Row Inserted
        if($this->Execute($querystring))
            return TRUE;
        return FALSE;
    }

    /**
     * @param string $where
     * @return boolean
     */
    public function Delete($where='')
    {
        $query = sprintf('DELETE FROM `%s` %s',$this->table,$where);
        $result = $this->Execute($query);
        if($result)
            return TRUE;

        return FALSE;
    }


    /**
     * @param $table
     * @param string $where
     * @return bool
     */
    public function Update($data,$where='')
    {
        //set $key = $value :)

        $query  = '';
        foreach ($data as $f => $v) {
            (is_numeric($v) && intval($v) == $v || is_float($v))? $v."," : "'$v' ,";
            $query  .= "`$f` = '{$v}' ,";
        }

        //Remove trailing ,
        $query = substr($query, 0,-1);

        $querystring = "UPDATE `{$this->table}` SET {$query} {$where}";
        //echo $querystring;
        $update = $this->Execute($querystring);
        if($update)
            return TRUE;

        return FALSE;
    }



    public function Last()
    {
        return $this->connection->insert_id;
    }
    public function getErrors()
    {
        return $this->connection->error;
    }
    /**
     * Deconstructor :)
     */
    public function __destruct() {
        $this->connection->close();
    }
}