<?php

require_once(DATABASE."/db_functions.php");
require_once "./constants.php";
require_once "./functions.php";

$conn = create_conn();

// or id doesn't exist
if(!isset($_GET['id']) || !id_exists($conn, MENU, "itemID", $_GET['id'])){
    require_once NOTIFICATIONS."/404.php";
    die();
}

$notifications=[];
$errors=[];
$warnings=[];

if(isset($_POST['submitted'])){
    // reservation table update
    updateMultipleSql($conn, MENU, array("name", "description", "itemGroup", "price", "kcal"), array("'".$_POST['name']."'", "'".$_POST['description']."'", "'".$_POST['group']."'", $_POST['price'], $_POST['kcal']), "itemID", $_GET['id']);
    array_push($notifications, "Successfully updated!");
}



$row = select_cond($conn, MENU, "deleted=0 AND itemID = ".$_GET['id'])[0];

switch ($row['itemGroup']) {
    case 'food':
        $drp = '<option value="food" selected>food</option><option value="drink">drink</option>';
        break;
    case 'drink':
        $drp = '<option value="drink">drink</option><option value="food">food</option>';
        break;
    default:
        $drp = '<option value="food" selected>food</option><option value="drink">drink</option>';
        break;
}
?>

<div class="content">
    <div class="py-4 col-xl-5 col-lg-8 col-md-12 px-3 px-md-4">
    <?php
        require_once("./informations.php");
    ?>
    <div class="card">
                <div class="card-header">
                <h4>Edit the Menu</h4>
            </div>
            <div class="card-body pt-0">
                <form action="admin.php?page=editMenu&id=<?php echo $_GET['id'] ?>" method="POST">
                    
                    <div class="form-group">
                        <label>Item Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $row['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Item Description</label>
                        <input type="textarea" name="description" class="form-control" value="<?php echo $row['description'] ?>" required>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Group</label>
                            <select class="custom-select" name="group" required>
                                <?php echo $drp ?>
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label>Price</label>
                            <input type="number" step="any" name="price" class="form-control" value="<?php echo $row['price'] ?>" required>
                        </div>
                        <div class="form-group col-4">
                            <label>KCAL</label>
                            <input type="number" step="any" name="kcal" class="form-control" value="<?php echo $row['kcal'] ?>" required>
                        </div>
                    </div>
                    
                    
                    <input type="submit" name="submitted" class="btn btn-info mt-5" value="Save changes">
                </form>  
            </div>
        </div>
    </div>