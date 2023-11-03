<?php

class Reservation
{

    private $database_con;

    public function __construct($database_connection)
    {
        $this->database_con = $database_connection;
    }

    public function getMenu()
    {
        $resp = $this->database_con->select('menu', '*', 'deleted = ?', array('0'));
        if ($resp) {
            return $resp[0];
        }
        return false;
    }
    
    public function getMenuItem($item_id)
    {
        $resp = $this->database_con->select('menu', '*', 'itemID = ? AND deleted = ?', array($item_id, '0'));
        if ($resp) {
            return $resp[0];
        }
        return false;
    }

    public function addMenuItem($data)
    {
        if ($this->database_con->insert('menu', $data)) {
            return true;
        }
        return false;
    }

    public function deleteMenuItem($item_id){
        if($this->database_con->updateSingleColumn('menu', 'deleted', '1', 'itemID = ?', array($item_id))) {
            return true;
        }
        return false;
    }

    public function updateMenuItem($item_id, $data){
        if($this->database_con->updateMultipleColumns('menu', $data, 'resID = ?', array($item_id))) {
            return true;
        }
        return false;
    }

}

?>