<?php

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase {
    protected $db;

    protected function setUp(): void {
        $this->db = new Database();
    }

    public function testSelect() {
        $result = $this->db->select("your_table_name", "*", "id = ?", [1]);
        $this->assertIsArray($result);
    }

    public function testInsert() {
        $data = ['column1' => 'value1', 'column2' => 42];
        $result = $this->db->insert("your_table_name", $data);
        $this->assertTrue($result);
    }

    public function testUpdateSingleColumn() {
        $result = $this->db->updateSingleColumn("your_table_name", "column1", "new_value", "id = ?", [1]);
        $this->assertTrue($result);
    }

    public function testUpdateMultipleColumns() {
        $data = ['column1' => 'new_value', 'column2' => 42];
        $result = $this->db->updateMultipleColumns("your_table_name", $data, "id = ?", [1]);
        $this->assertTrue($result);
    }

    public function testDelete() {
        $result = $this->db->delete("your_table_name", "id = ?", [1]);
        $this->assertTrue($result);
    }

    protected function tearDown(): void {
        $this->db->closeConnection();
    }
}


?>