<?php

require './models\Database.php';
require './models\Menu.php';
use PHPUnit\Framework\TestCase;

class MenuTests extends TestCase {
    protected $menu;
    protected $dbMock;

    protected function setUp(): void {
        // Create a mock for the Database class
        $this->db = new Database();
        $this->dbMock = $this->createMock(Database::class);
        $this->menu = new Menu($this->dbMock);
    }

    public function testGetMenu() {
        // Mock the behavior of the Database class
        $expectedData = [
            ['itemID' => 1, 'name' => 'Item 1', 'price' => 10.99, 'deleted' => 0],
            ['itemID' => 2, 'name' => 'Item 2', 'price' => 15.99, 'deleted' => 0],
        ];
        $this->dbMock->expects($this->once())
            ->method('select')
            ->with('menu', '*', 'deleted = ?', ['0'])
            ->willReturn($expectedData);

        $result = $this->menu->getMenu();
        $this->assertEquals($expectedData, $result);
    }

    public function testGetMenuItem() {
        $itemID = 1;
        $expectedData = ['itemID' => 1, 'name' => 'Item 1', 'price' => 10.99, 'deleted' => 0];

        // Mock the behavior of the Database class
        $this->dbMock->expects($this->once())
            ->method('select')
            ->with('menu', '*', 'itemID = ? AND deleted = ?', [$itemID, '0'])
            ->willReturn([$expectedData]);

        $result = $this->menu->getMenuItem($itemID);
        $this->assertEquals($expectedData, $result);
    }

    public function testGetMenuItemNotFound() {
        $itemID = 1;

        // Mock the behavior of the Database class to return an empty array
        $this->dbMock->expects($this->once())
            ->method('select')
            ->willReturn([]);

        $result = $this->menu->getMenuItem($itemID);
        $this->assertFalse($result);
    }

    public function testAddMenuItem() {
        $itemData = [
            'name' => 'New Item',
            'price' => 12.99,
            'deleted' => 0,
        ];

        // Mock the behavior of the Database class
        $this->dbMock->expects($this->once())
            ->method('insert')
            ->with('menu', $itemData)
            ->willReturn(true);

        $result = $this->menu->addMenuItem($itemData);
        $this->assertTrue($result);
    }

    public function testDeleteMenuItem() {
        $itemID = 1;

        // Mock the behavior of the Database class
        $this->dbMock->expects($this->once())
            ->method('updateSingleColumn')
            ->with('menu', 'deleted', '1', 'itemID = ?', [$itemID])
            ->willReturn(true);

        $result = $this->menu->deleteMenuItem($itemID);
        $this->assertTrue($result);
    }

    public function testUpdateMenuItem() {
        $itemID = 1;
        $itemData = [
            'name' => 'Updated Item',
            'price' => 14.99,
        ];

        // Mock the behavior of the Database class
        $this->dbMock->expects($this->once())
            ->method('updateMultipleColumns')
            ->with('menu', $itemData, 'resID = ?', [$itemID])
            ->willReturn(true);

        $result = $this->menu->updateMenuItem($itemID, $itemData);
        $this->assertTrue($result);
    }

    protected function tearDown(): void {
        // Clean up resources if needed
    }
}


?>