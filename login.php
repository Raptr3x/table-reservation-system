<?php 

require_once "./functions.php";
require_once DATABASE."/db_functions.php";
require_once "./constants.php";

if(isset($_GET['logout'])){
	logout();
}

if (isset($_POST['login_btn'])) {
	$errors= [];
	$conn = create_conn();

	// grab form values
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	// attempt login if no errors on form
	if (count($errors) == 0) {
		$password = md5($password);
        // echo $password;
		
		$sql = "SELECT * FROM ".USERS." WHERE email='$email' AND password='$password' AND deleted=0 LIMIT 1";
        // echo $sql;
		$stmt = $conn->query($sql);
		$results = $stmt->fetchAll();

		if(count($results)==0){
			array_push($errors, "Wrong E-Mail/password combination");
		}
		elseif ($results[0]['userID']!=null) { // user found
			$_SESSION['user'] = $results[0];
			$_SESSION['success']  = "You are now logged in";
			
			if(strpos($_SERVER['HTTP_REFERER'], '?page') !== false){
				$prev_page = explode("?", $_SERVER['HTTP_REFERER']);
				header('location: admin.php?'.$prev_page[1]);
			}else{
				header('location: admin.php');
			}
		}
 }
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Title -->
		<title>Login LuNiBo</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<!-- <link rel="shortcut icon" href="public/img/favicon.ico"> -->
		<link rel="stylesheet" href="graindashboard/css/graindashboard.css">

	</head>

	<body>
		<main class="main">
		<div class="content">
				<div class="container-fluid pb-5">
					<div class="row justify-content-md-center">
						<div class="card-wrapper py-4 col-xl-5 col-lg-8 col-md-12 px-3 px-md-4">
							<div class="brand text-center mb-3">
								<!-- <a href="/dashboard/login.php"><img class="w-60" src="public/img/logo1.png"></a> -->
                                <p class="display-2">LUNIBO</p>
							</div>
							<div class="card">
								<div class="card-body">
									<h4 class="card-title">Login</h4>
                                    <?php if(isset($errors)) echo "<p class='text-danger'>".$errors[0]."</p>"; ?>
									<form action="login.php" method="post">
										<div class="form-group">
											<label for="email">E-Mail Address</label>
											<input id="email" type="email" class="form-control" name="email" required="" autofocus="">
										</div>
										<div class="form-group">
											<label for="password">Password</label>
											<input id="password" type="password" class="form-control" name="password" required="">
											
										</div>
										<div class="form-group no-margin">
											<input type="submit" class="btn btn-info btn-block" value="Login" name="login_btn">
										</div>
									</form>
								</div>
							</div>
							<footer class="footer mt-3">
								
							</footer>
						</div>
					</div>
				</div>
			</div>
		</main>

		<script src="assets/graindashboard/js/graindashboard.js"></script>
		<script src="assets/graindashboard/js/graindashboard.vendor.js"></script>
	</body>
</html>