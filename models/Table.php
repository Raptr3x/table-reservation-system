<?php

class Table
{
    private $database_con;

    public function __construct($database_connection)
    {
        $this->database_con = $database_connection;
    }

    /**
     * Retrieves a table from the database by its ID
     * Returns false if the table doesn't exist
     */
    public function getTable($table_id)
    {
        $resp = $this->database_con->select('tables', '*', 'tableID = ?', array($table_id));
        if ($resp) {
            return $resp[0];
        }
        return false;
    }

    /**
     * Retrieves all tables from the database
     * Returns false when no tables are found
     */
    public function getAllTables()
    {
        return $this->database_con->select('tables', '*');
    }

    /**
     * Retrieves all tables from the database with capacity equal to or greater than $minCapacity
     * Returns false when no tables are found
     */
    public function getTablesByCapacity($minCapacity)
    {
        return $this->database_con->select('tables', '*', 'maxPeople >= ?', array($minCapacity));
    }

    public function addTable($data)
    {
        if ($this->database_con->insert('tables', $data)) {
            return true;
        }
        return false;
    }

    /**
     * Deletes a table from the database
     * Returns false on failed delete attempt
     */
    public function deleteTable($table_id)
    {
        if ($this->database_con->delete('tables', 'tableID = ?', array($table_id))) {
            return true;
        }
        return false;
    }

    public function updateTable($table_id, $data)
    {
        if ($this->database_con->updateMultipleColumns('tables', $data, 'tableID = ?', array($table_id))) {
            return true;
        }
        return false;
    }
}

?>
