<?php
require_once(DATABASE."/db_functions.php");
require_once "./constants.php";

$conn = create_conn();


$notifications=[];
$errors=[];
$warnings=[];

if(isset($_POST['delete'])){
    updateSql($conn, RESER, "deleted", 1, "resID", $_POST['id']);
    array_push($notifications, "Successfully removed!");
}
?>

<div class="content">
        <div class="py-4 px-3 px-md-4">
            <div class="mb-3 mb-md-4 d-flex justify-content-between">
                <div class="h3 mb-0">Reservationen</div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php
                        require_once("./informations.php");
                    ?>
                    <div class="card mb-3 mb-md-4">
                        <div class="card-header">
                            <h5 class="font-weight-semi-bold mb-0">Recent Orders</h5>
                        </div>

                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table text-nowrap mb-0">
                                    <thead>
                                    <tr>
                                        <th class="font-weight-semi-bold border-top-0 py-2">#</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Date and time</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2"># of people</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Customer name</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Table id</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">E-mail</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Telephone</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Mehr</th>
                                    </tr>
                                    </thead>
                                    <tbody>

<?php 

$rows = free_sql($conn, "SELECT r.resID, r.reservationDatetime, r.numOfPeople, c.fullname, r.tableID, c.email, c.phone FROM ".RESER." r INNER JOIN ".CUST." c ON r.customerID = c.customerID WHERE r.deleted=0 order by r.reservationDatetime desc");


foreach ($rows as $row)
{
    // start datetime (NEEDS TO BE FORMATED!!)        
    $reservationDatetime = date_format(date_create($row['reservationDatetime']),"d F Y H:i:s");

    // mark past dates
    $past_date_classname = "";
    $date = date_format(date_create($row['reservationDatetime']),"Y-m-d H:i:s");
    $today = date("Y-m-d H:i:s");
    if($date<$today){
        $past_date_classname = "disabled";
    }

    $name = $row['fullname'];
    
    $tel = $row['phone'];
  
?>
            <tr class="<?php echo $past_date_classname ?>">
                <td class="py-3"><?php echo $row['resID']; ?></td>
                <td class="py-3"><?php echo $reservationDatetime; ?></td>
                <td class="py-3"><?php echo $row['numOfPeople']; ?></td>
                <td class="py-3"><?php echo $name; ?></td>
                <td class="py-3"><?php echo $row['tableID']; ?></td>
                <td class="py-3"><?php echo $row['email']; ?></td>
                <td class="py-3"><?php echo "<a href='tel:".$tel."'>".$tel."</a>" ?></td>

                <td class="py-3">
                    <div class="dropdown">
                        <a id="dropdownPosition" class="dropdown-toggle" href="#" aria-haspopup="true" aria-expanded="false"
                        data-toggle="dropdown">
                            <i class="gd-more-alt icon-text icon-text-xs align-middle ml-3"></i>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownPosition">
                            <a class="dropdown-item" href="admin.php?page=editRes&id=<?php echo $row['resID']; ?>">Edit</a>
                            <form action="admin.php?page=reservationen" method="POST">
                                <input name="id" value="<?php echo $row['resID']; ?>" hidden>
                                <input type="submit" name="delete" class="dropdown-item" onclick="return  confirm('Are you really sure that you want to delete reservation for the table <?php echo $row['tableID']; ?> at <?php echo $reservationDatetime; ?> ?')" value="Delete" readonly>
                            </form>
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