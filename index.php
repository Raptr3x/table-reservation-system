
<?php
require_once "./functions.php";
require_once "./constants.php";
require_once DATABASE."/db_functions.php";

test
$conn = create_conn();

$notifications=[];
$errors=[];
$warnings=[];

if(isset($_POST['name'])){


    $name = strtolower(sanitize_user_input_text($_POST['name']));
    $combinedDT = date('Y-m-d H:i:s', strtotime($_POST['date'].", ".$_POST['time']));
    $email = strtolower(sanitize_user_input_text($_POST['email']));
    $number = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
    $people = filter_var($_POST['people'], FILTER_SANITIZE_NUMBER_INT);


    $usersCol = "fullname, email, phone";
    $usersVal = "'".$name."', '".$email."', '".$number."'";
	// kad musterija ne postoji izbacuje undefined offset
	$customerID = select_cond($conn, CUST, "email='".$email."'");
	if(count($customerID)==0){
		insert($conn, CUST, $usersCol, $usersVal);
		$customerID = get_last_id($conn, CUST, "customerID");
	}else{
		$customerID = $customerID[0]['customerID'];
	}

    // get free tables
    $people1 = $people+1;
	$tableID = free_sql($conn, "SELECT * FROM tables WHERE tableID NOT IN (SELECT reservations.tableID FROM reservations WHERE DAYOFYEAR(reservationDatetime)=DAYOFYEAR('".$combinedDT."')) AND (maxPeople = {$people} or maxPeople = {$people1}) LIMIT 1");
	if(count($tableID)==0){
		array_push($errors, "Unfortinately there are no free tables at the moment for the selected date.\nPlease select another one.");
	}else{
		$tableID = $tableID[0]['tableID'];
		$resCol = "reservationDatetime, numOfPeople, tableID, customerID";
		$resVal = "'".$combinedDT."', ".$people.", ".$tableID.", ".$customerID."";
		insert($conn, RESER, $resCol, $resVal);
		array_push($notifications, "Your reservation has been successfully created! Thank you very much!");
	}
}




$foods = select_cond($conn, MENU, "itemGroup='food' AND deleted=0");
$drinks = select_cond($conn, MENU, "itemGroup='drink' AND deleted=0");


?>
<!Doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title> LuNiBo </title>
		<link rel="stylesheet" href="/css/all.css">
		<link rel="stylesheet" href="/css/fontawesome.css">
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">

		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,300&display=swap" rel="stylesheet">

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">

	</head>

<body>
<?php
if(count($errors)>0){
	foreach ($errors as $key => $value) {
		echo "<script>alert('".$errors[$key]."');</script>";
	}
}

?>
<section class="home">
	<header>
		
			<a href="#" class="brand">LuNiBo</a>
				<div class="menu">
					<div class="btn">
						<i class="fas fa-times close-btn"></i>
				</div> 
					<a href="#section-main">HOME</a></li>
					<a href="#about">ABOUT</a></li>
					<a href="#menu">MENU</a></li>
					<a href="#reserve">RESERVE</a></li>
					<a href="#contact">CONTACT</a></li>
				</div>
					<div class="btn">
						<i class="fa fa-bars menu-btn"></i>
					</div>
			

	</header>

	<section id="section-main">

	<div class="text-box">
		<h1>Das weltbeste Restaurant</h1>
		<p>
			Ja richtig gehört wir sind das weltbeste Restaurant
		</p>
		<a href="#reserve" class="hero-btn">Komm und überzeug dich !</a>
		
	
	</div>
</section>


</section>

<!-------about--------->

<section id="about">
	<h1>Über uns</h1> <br>
	
	<div class="row">
		<div class="course-col">
			<h3>Lukas</h3>
			<p>Mein Name ist Lukas Zankel und bei unserer Diplomarbeit kümmere ich mich hauptsächlich um die 
				technischen Voraussetzungen sowie das Design. Also schauen das unsere Website erreichbar ist und die Grafiken s
				owie das Erscheinungsbild ansprechend. DNS records, WINSCP aber auch Photoshop sind einige Dinge mit denen ich mich beschäftige.</p>
		</div>
		<div class="course-col">
			<h3>Nikola</h3>
			<p>Ich heiße Panic Nikola und in diesem Projekt, das unsere Diplomarbeit ist, 
				war es meine Aufgabe die Webseite zu erstellen. 
				Dies habe ich mithilfe von HTML, CSS und JavaScript umgesetzt 
				und diese Webseite auf der Sie sich gerade befinden programmiert. </p>
		</div>
		<div class="course-col">
			<h3>Bogdan</h3>
			<p>Mein Name ist Bogdan Caleta Ivkovic und in diesem Projekt, das unsere Abschlussarbeit ist, 
				war es meine Aufgabe, das Backend der Website, die Datenbank und das Dashboard zu erstellen. 
				Ich habe dies mit PHP, MySQL und JavaScript implementiert.</p>
		</div>
	</div>
</section>

<!----- Menu ----->

<section id="menu">

	<h1>Unser wunderbares und leckeres Menü</h1> <br><br><br><br><br>
	<div class="container">
		<div class="menu">
		<h2 class="menu-group-heading">
			Hauptspeisen
		</h2>
		<div class="menu-group">
		<?php
		foreach ($foods as $food){	
		?>
			<div class="menu-item">
				<div class="menu-item-text">
					<h3 class="menu-item-heading">
						<span class="menu-item-name"><?php echo $food['name'] ?></span>
						<span class="menu-item-price"><?php echo $food['price'] ?>€</span>
					</h3>
					<div class="box">
						<div class="col-10">
							<p class="menu-item-description"><?php echo $food['description'] ?></p>
						</div>
						<div class="col-2">
							<p class="menu-item-kcal"><?php echo $food['kcal'] ?> kcal</p>
						</div>
					</div>
					</p>
				</div>
			</div>
		<?php
		}
		?>
		</div>
		<h2 class="menu-group-heading">
			Getränke
		</h2>
		<div class="menu-group">
		<?php
		foreach ($drinks as $drink){
		?>
			<div class="menu-item">
				<div class="menu-item-text">
					<h3 class="menu-item-heading">
						<span class="menu-item-name"><?php echo $drink['name'] ?></span>
						<span class="menu-item-price"><?php echo $drink['price'] ?>€</span>
					</h3>
					<div class="box">
						<div class="col-10">
							<p class="menu-item-description"><?php echo $drink['description'] ?></p>
						</div>
						<div class="col-2">
							<p class="menu-item-kcal"><?php echo $drink['kcal']?> kcal</p>
						</div>	
					</div>
				</div>
			</div>
		<?php
		}
		?>
		</div>
		</div>
	</div>

</section>

<!----- Reserve ----->

<section id="reserve" >

	<h1>Reserviere einen <br> Tisch</h1> <br><br><br><br>

	<form action="index.php#reserve" method="POST">
		<?php
		if(count($errors)>0){
			foreach ($errors as $key => $value) {
				echo "<p class='text-danger'>".$errors[$key]."</p>";
			}
		}else if(count($notifications)>0){
			foreach ($notifications as $key => $value) {
				echo "<p class='text-success'>".$notifications[$key]."</p>";
			}
		}
		?>
		<div>
			<span>Your full name ?</span>
			<input type="text" name="name" id="name" placeholder="Write your name here..." required>
		</div>
		<div>
			<span>Your email address ?</span>
			<input type="email" name="email" id="name" placeholder="Write your email here..." required> 
		</div>
		<div>
			<span>Your phone number ?</span>
			<input type="number" name="number" id="number" placeholder="Write your number here..." required>
		</div> 
		<br> 
		<div class="fuerReservation">
			<!-- <---this is the select option--->
				<div>
					<div> <span>How many people ?</span></div>

				<select name="people" id="people" required>
				<option value=""> <---People---></option>
				<option value="1">1 People</option>
				<option value="2">2 People</option>
				<option value="3">3 People</option>
				<option value="4">4 People</option>
				<option value="4">5 People</option>
				<option value="4">6 People</option>
				<option value="4">7 People</option>
				<option value="4">8 People</option>
				<option value="4">9 People</option>
			</select> 
			</div>
			
			<!-- <---this is the select option--->
			<div><span>What time ?</span>

			 <input type="time" name="time" id="time"  min="10:00" max="23:00" required> 
		</div>
			
			
		
		<div> <span>What is the date ?</span>
			<input type="date" name="date" id="date" placeholder="date" required>
		</div>
			
		
	</div>
	
		<br>
		<div id="submit">
			<input type="submit" value="SUBMIT" id="submit">
		</div>

	</form>

</section>

<section id="contact">

	<!--alert messages start
	<div class="alert-success">
	<span>Message Sent! Thank you for contacting us.</span>
	</div>
	<div class="alert-error">
	<span>Something went wrong! Please try again.</span>
	</div>
	alert messages end-->

	<!--contact section start-->

	<div class="contact-section">
		<div class="contact-info">
		<div><i class="fas fa-map-marker-alt"></i>
			Thaliastraße 125, 1160 Wien, Österreich</div>
		<div><i class="fas fa-envelope"></i>panic.n99@htlwienwest.at</div>
		<div><i class="fas fa-phone"></i>+43 660 253 732 33</div>
		<div><i class="fas fa-clock"></i>Mo - SO 10:00 AM to 1:00 PM</div>
		</div>
		<div class="contact-form">
		<h2>Contact Us</h2> 
		<form class="contact" action="" method="post">
			<input type="text" name="name1" class="text-box1" placeholder="Your Name" required>
			<input type="email" name="email1" class="text-box1" placeholder="Your Email" required>
			<textarea name="message" rows="5" placeholder="Your Message" required></textarea>
			<input type="submit"  id="send-btn" value="Send">
		</form>
		</div>
	</div>
	
	<!--contact section end-->
	
</section>

<script src="main.js"></script>

</body>

</html>