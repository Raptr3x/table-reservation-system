<?php
require_once(DATABASE."/db_functions.php");
require_once "./constants.php";

$conn = create_conn();

if(isset($_GET['remove_menu_item'])){
    updateSql($conn, MENU, "deleted", 1, "itemID", $_GET['remove_menu_item']);
    echo "<script>window.location = './admin.php?page=menu'</script>";
}
?>

<div class="content">
        <div class="py-4 px-3 px-md-4">
            <div class="mb-3 mb-md-4 d-flex justify-content-between">
                <div class="h3 mb-0">Menu</div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-3 mb-md-4">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="font-weight-semi-bold mb-0">Recent Orders</h5>
                            <a class="btn btn-info" href="admin.php?page=addItem" type="button">Add New<i class="ml-2 gd-plus"></i></a>
                        </div>

                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table text-nowrap mb-0">
                                    <thead>
                                    <tr>
                                        <th class="font-weight-semi-bold border-top-0 py-2">#</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Name</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Description</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Group</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Price</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">KCAL</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Mehr</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php 

$rows = select_cond($conn, MENU, "deleted=0");

// $rows = array_merge($rows, $rows_old);

foreach ($rows as $row)
{
  
?>
            <tr class="<?php echo $past_date_classname ?>">
                <td class="py-3"><?php echo $row['itemID']; ?></td>
                <td class="py-3"><?php echo $row['name']; ?></td>
                <td class="py-3"><?php echo $row['description']; ?></td>
                <td class="py-3"><?php echo $row['itemGroup']; ?></td>
                <td class="py-3"><?php echo $row['price']."€"; ?></td>
                <td class="py-3"><?php echo $row['kcal']; ?></td>

                <td class="py-3">
                    <div class="dropdown">
                        <a id="dropdownPosition" class="dropdown-toggle" href="#" aria-haspopup="true" aria-expanded="false"
                        data-toggle="dropdown">
                            <i class="gd-more-alt icon-text icon-text-xs align-middle ml-3"></i>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownPosition">
                            <a class="dropdown-item" href="admin.php?page=editMenu&id=<?php echo $row['itemID']; ?>">Edit</a>
                            <a class="dropdown-item" href="admin.php?page=menu&remove_menu_item=<?php echo $row['itemID']; ?>" onclick="return  confirm('Are you really sure that you want to delete <?php echo $row['name']; ?>?')">Delete</a>
                        </div>
                    </div>

                </td>
            </tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>