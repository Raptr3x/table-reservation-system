<?php
class Database {
    // private $host = "127.0.0.1";
    // private $username = "root";
    // private $password = "";
    // private $database = "lunibo";
    
    private $host = "192.168.0.124";
    private $username = "root";
    private $password = "nemanjina12";
    private $database = "lunibo";
    

    private $connection;


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

        if (!empty($order)){
            $query .= " ORDER BY ".$order;
        }
    
        $stmt = $this->connection->prepare($query);
    
        if (!$stmt) {
            return false;
        }
    
        // If values are provided, bind parameters
        if (!empty($values)) {
            $types = $this->setTypes($values);
            $stmt->bind_param($types, ...$values);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    
        // Fetch the result into an array
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        return $data;
    }
    public function insert($table, $data) {
        // Create arrays for column names and placeholders
        $columns = array_keys($data);
        $placeholders = array_fill(0, count($columns), '?');
        
        // Generate the SQL statement
        $sql = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        
        // Prepare the SQL statement
        $stmt = $this->connection->prepare($sql);
        
        if (!$stmt) {
            echo "Error: " . $this->connection->error; // Return the error message
            return false;
        }
        
        $types = $this->setTypes($data);
        
        // Bind parameters
        if ($stmt->bind_param($types, ...$values)) {
            // Execute the query
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            echo "Error: " . $stmt->error; // Return the error message
            return false;
        }
    }
    
    
    

    public function updateSingleColumn($table, $column, $value, $condition, $condition_values) {
        $stmt = $this->connection->prepare("UPDATE $table SET $column = ? WHERE $condition");

        if (!$stmt) {
            return false; // Error in the prepared statement
        }

        // Combine $value and $values arrays
        $bindValues = [$value];
        $bindValues = array_merge($bindValues, $condition_values);

        $types = $this->setTypes($bindValues);
        
        // Bind parameters
        if ($stmt->bind_param($types, ...$values)) {
            // Execute the query
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            echo "Error: " . $stmt->error; // Return the error message
            return false;
        }
    }

    public function updateMultipleColumns($table, $updateData, $whereCondition, $whereValues) {
        $updates = [];
        $bindValues = [];
        $setValues = [];
    
        foreach ($updateData as $column => $value) {
            $updates[] = "$column = ?";
            $bindValues[] = $value;
        }
    
        $setValuesStr = implode(", ", $updates);
    
        $whereStr = "";
        if (!empty($whereCondition)) {
            $whereStr = "WHERE $whereCondition";
            // Add the values for the WHERE condition to the bindValues array
            $bindValues = array_merge($bindValues, $whereValues);
        }
    
        $query = "UPDATE $table SET $setValuesStr $whereStr";
        $stmt = $this->connection->prepare($query);
    
        if (!$stmt) {
            return false; // Error in the prepared statement
        }

        $types = $this->setTypes($bindValues);
        
        // Bind parameters
        if ($stmt->bind_param($types, ...$values)) {
            // Execute the query
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            echo "Error: " . $stmt->error; // Return the error message
            return false;
        }
    }
    

    public function delete($table, $condition, $values) {
        $stmt = $this->connection->prepare("DELETE FROM $table WHERE $condition");

        if (!$stmt) {
            return false; // Error in the prepared statement
        }
        
        $types = $this->setTypes($values);
        
        // Bind parameters
        if ($stmt->bind_param($types, ...$values)) {
            // Execute the query
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            echo "Error: " . $stmt->error; // Return the error message
            return false;
        }
    }

    public function closeConnection() {
        $this->connection->close();
    }

    private function setTypes(array $data) {
        
        // Extract values from the $data array
        $values = array_values($data);
        $types = "";
        
        foreach ($values as $value) {
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
?>