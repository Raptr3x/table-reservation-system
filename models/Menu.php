<?php

class Menu
{

    private $database_con;

    public function __construct($database_connection)
    {
        $this->database_con = $database_connection;
    }

    public function getMenu()
    {
        return $this->database_con->select('menu', '*', 'deleted = ?', array('0'));
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
        return $this->database_con->insert('menu', $data);
    }

    public function deleteMenuItem($item_id){
        return $this->database_con->updateSingleColumn('menu', 'deleted', '1', 'itemID = ?', array($item_id));
    }

    public function updateMenuItem($item_id, $data){
        return $this->database_con->updateMultipleColumns('menu', $data, 'resID = ?', array($item_id));
    }

}

?>