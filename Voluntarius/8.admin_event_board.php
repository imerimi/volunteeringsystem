<?php 
	session_start();
	
	$link = mysqli_connect("localhost","root","","webappassignment2");
	if(!$link){
		die("Could not connect:".mysqli_connect_error());
		
	}
	if (isset($_POST["action"]))
	{
		if($_POST["action"]=="Remove"){
			$sql = "DELETE FROM participation WHERE event_id='".$_POST["id"]."'";
			mysqli_query($link,$sql);
			
			$sql = "DELETE FROM event WHERE event_id='".$_POST["id"]."'";
			mysqli_query($link,$sql);
			header('Location: '.$_SERVER["PHP_SELF"], true, 303);
		}
		
		else if($_POST["action"]=="Details"){
			$_SESSION['event_id'] = $_POST["id"];
			header("Location:8.admin_event_board_details.php");
			exit();
		}
	}
	

?>

<!--HTML validated using https://validator.w3.org on 6 Aug-->
<!--Version 1.0 (6 Aug)-->
<!--must have at least one "admin_dashboard_menu_content", if no record found
use javascript to append a div with "no records" text to prevent collapse -->
<!DOCTYPE html>
<html lang="en">
	<head lang="en">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Admin Event Board</title>
		<link rel="stylesheet" href="Style/reset.css" />
		<link rel="stylesheet" type="text/css" href="Style/20_admin_bulletin_board.css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
		<!--Header is the website logo-->
		<header></header>
		
		<!--Other components in container class
		1. The navigation bar
		2. The NGO application panel 
			2.1. The footer
			(Footer placed in application panel to ensure the panel stays at the bottom)-->
		
		<div class="container">
		
			<nav class="navigation_bar">
				<div class="pages_dropdown">
					<a href="#" class="navigation_dropdown">Navigation</a>
					<div class="navigation_dropdown_content">
						<a href="8.admin_approval_main.php">Admin</a>
						<a href="8.student_removal.php">Student</a>
						<a href="8.ngo_approval_main.php">NGO</a>
						<a href="8.admin_event_board.php">Event Board</a>
						<a href="8.banner_main.php">Banner</a>
					</div>
				</div>
							
				<a id="logout_anchor" href="5.login.php">Logout</a>
				<a id="profile_anchor" href="8.admin_profile.php">Profile</a>		
			</nav>
			
			
			<div class="admin_dashboard_menu">
				<h1>Admin Event Board</h1>
				
				<?php 
					$sql = "SELECT * FROM event,ngo WHERE event.ngo_email=ngo.ngo_email";
					$result=mysqli_query($link,$sql);
					
					if(mysqli_num_rows($result)!=0){
						while($row = mysqli_fetch_array($result)){?>
							<div class="admin_dashboard_menu_content">
								<div class="admin_dashboard_ngo_logo">
									<?php 
										echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['ngo_logo'] ).'" alt="Profile Picture"/>';	
									?>
								</div>
								<div class="admin_dashboard_info">
									<?php
										echo "<p><strong>Event ID:</strong><br>"
										.$row["event_id"]."</p>
										<p><strong>NGO Name: </strong><br>"
										.$row["ngo_name"]."</p>
										<p><strong>Event Title:</strong><br>"
										.$row["event_title"]."</p>
										<p><strong>Location:</strong><br>"
										.$row["event_location"]."</p>
										
										<p><strong>Date and Time(Start):</strong><br>"
										.$row["event_start_datetime"]."</p>									
										<p><strong>Date and Time(End):</strong><br>"
										.$row["event_end_datetime"]."</p>
										<p><strong>Registration Deadline:</strong><br>"
										.$row["event_reg_deadline"]."</p>
										<p><strong>Slots left:</strong><br>"
										.$row["event_max_volunteer"]."</p>";

									?>
									
								</div>
								<div class="admin_dashboard_button_panel">
									<form method="post" onsubmit="return confirm('Are you sure you want to do perform that action?')">
										<input class="button button_details" name="action" type="submit" value="Details">
										<input class="button button_reject" name="action" type="submit" value="Remove">	
										<input type="hidden" name="id" value=<?php echo $row["event_id"];?>>
									</form>
								</div>
							</div>
					<?php
						}	
					}
					else{
						echo "<div class='admin_dashboard_menu_content'>
							<div class='no_record_filler'>There are no events available.~</div>
							</div>";
					}
					
					?>
				
				
				<footer>
					<div class="footer_left">
						<a href="0.about_us.php" ><strong> About Us </strong></a>
						<a href="0.tnc.php" ><strong> Terms&nbsp;and&nbsp;Conditions </strong></a>
					</div>
					<div class="footer_mid">
					<p id="copyright"><em>Copyright &copy; 2019 Voluntarius. All Rights Reserved. </em></p>
					</div>
					<div class="footer_right">
					<strong> Connect with Us: </strong>
						<a href="https://www.facebook.com" class="footer_icon_color"><i class="fa fa-facebook big"></i></a>
							<a href="https://www.instagram.com/" class="footer_icon_color"><i class="fa fa-instagram big"></i></a>
							<a href="https://twitter.com/?lang=en" class="footer_icon_color"><i class="fa fa-twitter big"></i></a>
					</div>
				</footer>
			</div>
		</div>				
		
	</body>
</html>