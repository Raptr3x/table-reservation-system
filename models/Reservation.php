<?php

class Reservation
{

    private $database_con;

    public function __construct($database_connection)
    {
        $this->database_con = $database_connection;
    }

    public function getReservation($reservation_id)
    {
        $resp = $this->database_con->select('reservations', '*', 'resID = ? AND deleted = ?', array($reservation_id, '0'));
        if ($resp) {
            return $resp[0];
        }
        return false;
    }

    public function addReservation($reservation_id, $data)
    {
        if ($this->database_con->insert('reservations', $data)) {
            return true;
        }
        return false;
    }

    public function deleteReservation($reservation_id){
        if($this->database_con->updateSingleColumn('reservations', 'deleted', '1', 'resID = ?', array($reservation_id))) {
            return true;
        }
        return false;
    }

    public function updateReservation($reservation_id, $data){
        if($this->database_con->updateMultipleColumns('reservations', $data, 'resID = ?', array($reservation_id))) {
            return true;
        }
        return false;
    }

}

?>