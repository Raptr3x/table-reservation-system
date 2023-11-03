<?php

require './models\Database.php';
use PHPUnit\Framework\TestCase;

class DatabaseTests extends TestCase
{
    protected $db;

    protected function setUp(): void
    {
        $this->db = new Database();
    }
    public function testInsert()
    {
        $data = ['reservationDatetime' => '2023-11-15 18:15:00', 'numOfPeople' => 1, 'resID' => '20', 'tableID' => 1];
        $result = $this->db->insert("reservations", $data);
        $this->assertTrue($result);
    }

    public function testSelect()
    {
        $result = $this->db->select("reservations", "*", "resID = ?", array(20));
        $this->assertIsArray($result);
    }

    public function testUpdateSingleColumn()
    {
        $result = $this->db->updateSingleColumn("reservations", "numOfPeople", 6, "resID = ?", array(20));
        $this->assertTrue($result);
    }

    public function testUpdateMultipleColumns()
    {
        $data = ['reservationDatetime' => '2023-11-15 20:00:00', 'numOfPeople' => 10];
        $result = $this->db->updateMultipleColumns("reservations", $data, "resID = ?", array(20));
        $this->assertTrue($result);
    }

    public function testDelete()
    {
        $result = $this->db->delete("reservations", "resID = ?", array(20));
        $this->assertTrue($result);
    }

    protected function tearDown(): void
    {
        $this->db->closeConnection();
    }
}


?>