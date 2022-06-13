<?php

require_once "config.php";
// $mysqli = new mysqli($servername, $username, $password);
$debug = 0;

// function connectDb(){
//     if ($mysqli = @$mysqli = new mysqli($servername, $username, $password, $dbname)){
//         if($debug) echo "connected";
//         return $mysqli;
//     }
//     else{
//         if($debug) echo "not connected";
//         return false;
//     };
// }

function create_conn(){
    global $username, $password, $servername, $dbname;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        echoIt("Connected successfully");
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
}

function insert($conn, $table, $columns, $values){
    $sql = "INSERT INTO {$table}({$columns}) VALUES ({$values});";
    echoIt($sql);
    $conn->prepare($sql)->execute();
}

function updateSql($mysqli, $table, $fields, $values, $pointer, $pointer_val){
    $sql = "UPDATE `$table` SET $fields = $values WHERE $pointer = '$pointer_val' LIMIT 1;";
    echoIt($sql);
    if ($rs = $mysqli->query($sql)) return TRUE;
    else die($mysqli->error);
}

function updateMultipleSql($mysqli, $table, $fields, $values, $pointer, $pointer_val){
    $ausgabe = '';

    foreach($fields AS $key => $field) {
        $value = $values[$key];
        if(strtolower($field)=="content") $value = addslashes($value); #escaping quotes in content
        $ausgabe .= "`".$field."` = ".$value.", ";
    }

    // if ($pointer != '') $qry = "WHERE $pointer LIKE $pointer_val"; #??
    $sql = "UPDATE ".$table." SET ".rtrim($ausgabe, ', ')." WHERE $pointer = '$pointer_val' LIMIT 1;";
    if ($rs = $mysqli->query($sql)) return TRUE;
    else die($mysqli->error);
}

function deleteSql($mysqli, $table, $pointer, $pointer_val){
    if ($rs = $mysqli->query("DELETE FROM `$table` WHERE `$pointer` = '$pointer_val';")){
        
        // $res = $mysqli->query("SELECT * FROM `".$dbname."`.`$table` WHERE `$table`.`$pointer` = '$pointer_val';");
        // echo "\n $table delete \n";
        // // echo "\nDelte SQL query: "."DELETE FROM `".$dbname."`.`$table` WHERE `$table`.`$pointer` = '$pointer_val';\n";
        // while($row = $res->fetch_assoc()) {
        // 	print_r($row);
        // }

        return TRUE;
    }
    else die($mysqli->error);
}

function select($conn, $table, $order="id "){
    $sql = "SELECT * FROM {$table} ORDER BY {$order}";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll();
}

function select_cond($conn, $table, $after_where){
    $sql = "SELECT * FROM {$table} WHERE {$after_where}";
    echoIt($sql);
    
    $stmt = $conn->query($sql);
    return $stmt->fetchAll();
}

function get_last_id($conn, $table, $id){
    $sql = "SELECT {$id} FROM {$table} ORDER BY {$id} DESC LIMIT 0, 1";
    echoIt($sql);
    $stmt = $conn->query($sql);
    return $stmt->fetchAll()[0][$id];
}

function free_sql($conn, $sql){
    echoIt($sql);
    $stmt = $conn->query($sql);
    $start = strtolower(explode(" ", $sql)[0]);
    if($start=='update' || $start=='delete'){
        return $stmt;
    }
    return $stmt->fetchAll();
}

function select_count_sum($conn, $operation, $table, $var, $after_where){
    if($operation!="count" && $operation!="sum"){
        throw new Exception("Value must be 'count' or 'sum'!");
    }
    $sql = "SELECT ".$operation."($var) AS access_name FROM ".$table." WHERE ".$after_where;

    echoIt($sql);
    $stmt = $conn->query($sql);
    return $stmt->fetchAll()[0]['access_name'];
}

function id_exists($conn, $table, $id, $id_value){
    $sql = "SELECT {$id} FROM {$table} WHERE {$id}={$id_value}";
    echoIt($sql);
    
    $stmt = $conn->query($sql);
    if(count($stmt->fetchAll())>0){
        return true;
    }else{
        return false;
    }
}

function echoIt($str){
    global $debug;
    if($debug){
        echo "\n".$str;
    }
}

?>