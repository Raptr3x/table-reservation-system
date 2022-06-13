<?php

require_once(DATABASE."/db_functions.php");
require_once "./constants.php";
require_once "./functions.php";

$conn = create_conn();

$notifications=[];
$errors=[];
$warnings=[];


if(isset($_POST['submit'])){
    insert($conn, MENU, "name, description, itemGroup, price, kcal", "'".$_POST['name']."', '".$_POST['description']."', '".$_POST['group']."', ".$_POST['price'].", ".$_POST['kcal']);
    array_push($notifications, "Successfully added!");
}

// obavesti ako vec postoji INTEGRITY VIOLATION tako nes je error


?>

<div class="content">
    <div class="py-4 col-xl-5 col-lg-8 col-md-12 px-3 px-md-4">
    <?php
        require_once("./informations.php");
    ?>
    <div class="card">
            <div class="card-header">
                <h4>Add new item to the Menu</h4>
            </div>
            <div class="card-body pt-0">
                <form action="admin.php?page=addItem&newItem=1" method="POST">
                    <div class="form-group">
                        <label>Item Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Item Description</label>
                        <input type="textarea" name="description" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Group</label>
                            <select class="custom-select" name="group" required>
                                <option value="food" selected>Food</option>
                                <option value="drink">Drink</option>
                        </select>
                        </div>
                        <div class="form-group col-4">
                            <label>Price</label>
                            <input type="number" step="any" name="price" class="form-control" required>
                        </div>
                        <div class="form-group col-4">
                            <label>KCAL</label>
                            <input type="number" step="any" name="kcal" class="form-control" required>
                        </div>
                    </div>
                    
                    <input type="submit" name="submit" class="btn btn-info mt-5" value="Save changes">
                </form>  
            </div>
        </div>
    </div>