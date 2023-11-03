<?php
require './db_config.php';

class Database {
    protected $host = DB_HOST;
    protected $username = DB_USER;
    protected $password = DB_PASS;
    protected $database = DB_NAME;
    protected $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function select($table, $columns = '*', $condition = '', $values = array(), $order = '') {
        $query = "SELECT $columns FROM $table";

        if (!empty($condition)) {
            $query .= " WHERE $condition";
        }

        if (!empty($order)) {
            $query .= " ORDER BY " . $order;
        }

        $stmt = $this->prepareAndBind($query, $values);
        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $result;
        } else {
            return false;
        }
    }

    public function insert($table, $data) {
        $columns = array_keys($data);
        $placeholders = array_fill(0, count($columns), '?');
        $sql = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->prepareAndBind($sql, array_values($data));
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }

    public function updateSingleColumn($table, $column, $value, $condition, $condition_values) {
        $query = "UPDATE $table SET $column = ? WHERE $condition";
        $values = array_merge([$value], $condition_values);
        return $this->executeQueryWithBind($query, $values);
    }

    public function updateMultipleColumns($table, $updateData, $whereCondition, $whereValues) {
        $updates = [];
        $values = [];

        foreach ($updateData as $column => $value) {
            $updates[] = "$column = ?";
            $values[] = $value;
        }

        $setValuesStr = implode(", ", $updates);
        $query = "UPDATE $table SET $setValuesStr WHERE $whereCondition";
        $values = array_merge($values, $whereValues);
        return $this->executeQueryWithBind($query, $values);
    }

    public function delete($table, $condition, $values) {
        $query = "DELETE FROM $table WHERE $condition";
        return $this->executeQueryWithBind($query, $values);
    }

    public function closeConnection() {
        $this->connection->close();
    }

    private function prepareAndBind($query, $values) {
        $stmt = $this->connection->prepare($query);
        if ($stmt) {
            $types = $this->setTypes($values);
            $stmt->bind_param($types, ...$values);
            return $stmt;
        } else {
            return false;
        }
    }

    private function executeQueryWithBind($query, $values) {
        $stmt = $this->prepareAndBind($query, $values);
        if ($stmt) {
            $stmt->execute();
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }

    private function setTypes(array $data) {
        $types = "";
        foreach ($data as $value) {
            if (is_int($value)) {
                $types .= 'i'; // 'i' for integer
            } elseif (is_float($value)) {
                $types .= 'd'; // 'd' for double
            } else {
                $types .= 's'; // 's' for string (default)
            }
        }
        return $types;
    }
}
