<!DOCTYPE html>
<html>

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<link rel="stylesheet" href="./css/styles.css" type="text/css"/>
	<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
	<title>RUclassboard</title>
</head>

<body>
<header role="banner">
	<div class="title">
		<div class="login" onclick="openLogin();">Login</div>
		<p>RUclassboard</p>
		<nav>
			<ul>
				<li>
					<a href="index.html">Home</a>
				</li>
				<li>
					<a href="about.html">About</a>
				</li>
				<li>
					<a href="#" style="color:#FFCC00;">Create an Account</a>
				</li>
			</ul>
		</nav>
	</div>
</header>

<main role="main">
	<div id="loginbox" style="display:none">
		<form method="post" action="userpanel.php">
			<p class="logintitle">Username:</p>
			<input name="username" class="login" type="text" placeholder="Username" required />
			<p class="logintitle" style="margin-top:15px;">Password:</p>
			<input name="password" class="login" type="password" placeholder="Password" required />
			<input name="userid" type="hidden" value="0"/>
			<input name="class" type="hidden" value=""/>
			<input name="message" type="hidden" value="NONE"/>
			<input class="signin" type="submit" value="Sign in"/>
			<div class="login" style="float:none;width:280px;" onclick="closeLogin();">Cancel</div>
		</form>
	</div>
	<script type="text/javascript" src="./scripts/login.js"></script>
	
	<div class="content">
		<h1 class="pagetitle">Create an Account</h1>
		
		<?php
			$account_created = true; //If this variable changes to false, that means the user entered something wrong and the form will be displayed again
			$username = $_POST['createusername']; //User entered in username
			$password = $_POST['createpassword']; //User entered in password
			$password_confirm = $_POST['createpasswordconfirm']; //Confirming password again
			
			echo "<div class='description'>";
			
			if(strlen($username) < 5) {
				echo "Username must be at least 5 characters long.<br/>";
				$account_created = false;
			}
			else {
				$check = preg_replace('/[^A-Za-z0-9_]/', '', $username); //This command means that all characters OTHER (denoted by ^) than letters, numbers and underscore are removed.  Also called regular expression in computer science.
				if($check != $username) {
					echo "Username can only use letters and numbers (no spaces or special characters).<br/>";
					$account_created = false;
				}
			}
			
			if(strlen($password) < 5 || strlen($password_confirm) < 5) {
				echo "Password must be at least 5 characters long.<br/>";
				$account_created = false;
			}
			else {
				$check = preg_replace('/[^A-Za-z0-9_]/', '', $password);
				if($check != $password) {
					echo "Password can only use letters and numbers (no spaces or special characters).<br/>";
					$account_created = false;
				}
				else if($check != $password_confirm) {
					echo "Passwords entered are not the same.<br/>";
					$account_created = false;
				}
			}
			
			if($account_created == false) {
				echo "</div><br/>";
				displayForm();
			}
			else {
				require_once 'login_nlc73.php';
				$db_server = mysql_connect($db_hostname, $db_username, $db_password);
				if(!$db_server) die("Unable to connect to MySQL: " . mysql_error());
				mysql_select_db($db_database) or die ("Unable to select database: " . mysql_error());
				$query = "SELECT * FROM accounts WHERE username='$username'";  //The purpose of this query is to check if this username exists already.
				$result = mysql_query($query);
				if(!$result) due ("Database access failed: " . mysql_error());
				$rows = mysql_num_rows($result);
				
				if($rows == 1) {
					echo 'This username has been taken.  Please use another username!</div><br/>';
					displayForm();
				}
				else {			
					$query = "INSERT INTO accounts(username, password) VALUES ('$username', '$password')";  //We are adding the account to the table
					mysql_query($query);
					echo 'Your account has been created! You may now login.<br/><br/>Thank you for registering with RUclassboard.</div>';
				}
			}			
			
			function displayForm() {
				echo '<form method="post" action="create_account.php">';
					echo '<label>';
						echo '<span class="logintitle">Username:</span>';
						echo '<input name="createusername" type="text" class="createacc" style="margin-left:62px" placeholder="Username" required />';
					echo '</label>';
					echo '<br/><br/>';
					echo '<label>';
						echo '<span class="logintitle">Password:</span>';
						echo '<input name="createpassword" type="password" class="createacc" style="margin-left:66px" placeholder="Password" required />';
					echo '</label>';
					echo '<br/><br/>';
					echo '<label>';
						echo '<span class="logintitle">Confirm Password:</span>';
						echo '<input name="createpasswordconfirm" type="password" class="createacc" style="margin-left:5px" placeholder="Password" required />';
					echo '</label>';
					echo '<br/>';
					echo '<input class="button" type="submit" value="Create Account"/>';
				echo '</form>';
			}
		?>
	</div>
</main>

<footer role="contentinfo">
	<p class="credits">&copy; 2015 | Created by: Nicholas Cristiano, Abanoub David Awad, and Philip AhKao</p>
</footer>

</body>

</html>
