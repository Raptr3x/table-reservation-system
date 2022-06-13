<?php
foreach ($notifications as $key => $value) {
    echo "<div class='alert alert-success' role='alert'><p>{$notifications[$key]}</p></div>";
}
foreach ($warnings as $key => $value) {
    echo "<div class='alert alert-warning' role='alert'><p>{$warnings[$key]}</p></div>";
}
foreach ($errors as $key => $value) {
    echo "<div class='alert alert-danger' role='alert'><p>{$errors[$key]}</p></div>";
}
?>