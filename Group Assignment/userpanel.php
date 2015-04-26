<!DOCTYPE html>
<html>

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<link rel="stylesheet" href="./css/styles.css" type="text/css"/>
	<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
	<title>RUclassboard</title>
</head>

<body>

<?php
	$username = $_POST['username'];
	$password = $_POST['password'];
	$class = $_POST['class'];
	$message = $_POST['message'];
	$userid = $_POST['userid'];

	//This if statement below prevents the user entering weird characters for the class.  If they enter weird characters, they must try again.
	//On first login, this wouldn't execute because the default value is nothing.
	if(strlen($class) > 0) {
		$check = preg_replace('/[^A-Za-z0-9_]/', '', $class);
		if($check != $class) {
			$class = "";
		}
	}
	
	require_once 'login_nlc73.php';
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	if(!$db_server) die("Unable to connect to MySQL: " . mysql_error());
	mysql_select_db($db_database) or die ("Unable to select database: " . mysql_error());
	$query = "SELECT * FROM accounts WHERE username='$username'";
	$result = mysql_query($query);
	$rows = mysql_num_rows($result);
				
	if($rows == 1) {
		$row = mysql_fetch_assoc($result);
		if($row['username'] == $username && $row['password'] == $password) {
			DisplayPosts($row['username'], $row['id'], $class, $message);
		}
		else if($row['id'] == $userid) {
			DisplayPosts($row['username'], $row['id'], $class, $message);
		}
		else {
			DenyUser();
		}
	}
	else {
		DenyUser();
	}
	
	function DisplayPosts($name, $id, $class, $msg) {
		//If the person has entered a message and has entered a class, a new message is added to the posts table
		if(strlen($msg) > 0 && $msg != "NONE" && strlen($class) > 0 ) {
			$time = round(microtime(true));
			$msg = htmlspecialchars($msg);
			$msg = mysql_real_escape_string($msg);
			$query = "INSERT INTO posts(id, time, message, classid) VALUES ('$id', '$time', '$msg', '$class')";
			mysql_query($query);
		}
		
		echo '<header role="banner">';
			echo '<div class="title">';
				echo '<div class="login" onclick="logout();">Logout</div>';
					echo '<p>RUclassboard</p>';
					echo '<nav>';
						echo '<ul>';
							echo '<li>';
								echo "<div class='menutext'>Welcome $name.</div>";
							echo '</li>';
						echo '</ul>';
					echo '</nav>';
			echo '</div>';
		echo '</header>';
		
		echo '<main role="main">';
			echo '<div class="content">';
				echo '<h1 class="pagetitle">New Post</h1>';
				echo '<form method="post" action="userpanel.php">';
					echo '<input name="username" type="hidden" value="'.$name.'"/>';
					echo '<input name="password" type="hidden" value="SECUREPASS"/>';
					echo '<input name="userid" type="hidden" value="'.$id.'"/>';
					echo '<input name="class" type="hidden" value="'.$class.'"/>';
					echo '<textarea class="userpost" name="message" style="float:left;"></textarea>';
					echo '<input class="button" type="submit" style="margin:10px 0px 0px 10px;" value="Post"/>';
				echo '</form>';
				echo '<div style="clear:both;"></div>';
			echo '</div>';
			echo '<div class="postsarea">';
				if(strlen($class) == 0) {
					echo '<div class="post" style="width:80%;margin-left:auto;margin-right:auto;text-align:center;color:#000000;">';
					echo 'Please enter in your class name keyword below:';
					echo '<form method="post" action="userpanel.php">';
					echo '<input name="class" type="text" class="createacc" placeholder="webdesign, bio101, writing201, etc." required />';
					echo '<input name="username" type="hidden" value="'.$name.'"/>';
					echo '<input name="password" type="hidden" value="SECUREPASS"/>';
					echo '<input name="userid" type="hidden" value="'.$id.'"/>';
					echo '<input name="message" type="hidden" value="NONE"/>';
					echo '<input class="button" type="submit" style="margin:10px 0px 0px 10px;" value="Load class posts"/>';
					echo '</form>';
					echo '</div>';
				}
				else {
					$query = "SELECT posts.postnum,posts.time,accounts.username,posts.message FROM accounts INNER JOIN posts ON posts.id=accounts.id WHERE classid='$class' ORDER BY posts.postnum DESC";
					$result = mysql_query($query);
					$rows = mysql_num_rows($result);
					if($rows > 0) {
						$uniqueusers = mysql_query("SELECT * FROM posts WHERE classid='$class' GROUP BY id");
						echo '<div class="post" style="margin:0px;float:right;width:280px;text-align:center;"><h2 class="posttitle" style="text-align:left;border:0px;">Class name: '.$class.'<br/>Total Posts: '.$rows.'<br/>Unique Users: '.mysql_num_rows($uniqueusers).'</h2>';
						echo '<form method="post" action="userpanel.php">';
						echo '<input name="username" type="hidden" value="'.$name.'"/>';
						echo '<input name="password" type="hidden" value="SECUREPASS"/>';
						echo '<input name="userid" type="hidden" value="'.$id.'"/>';
						echo '<input name="class" type="hidden" value=""/>';
						echo '<input class="button" type="submit" style="margin:10px 0px 0px 10px;" value="Change Class"/>';
						echo '</form>';
						echo '</div>';
						
						while($postinfo = mysql_fetch_array($result)) {
							echo '<div class="post">';
								echo '<h2 class="posttitle">'.$postinfo['username'].'</h2>';
								echo $postinfo['message'];
								echo '<h2 class="posttitle" style="margin:0px;border:0px;text-align:right;font-size:15px;">'.date('n/j/Y - g:ia', $postinfo['time']).'</h2>';
							echo '</div>'; 
						}
						
						//Provide extra space so there's enough height for first post.
						if($rows == 1) {
							echo "<div style='margin:100px;'></div>";
						}
					}
					else {
						echo '<div class="post" style="width:80%;margin-left:auto;margin-right:auto;text-align:center;color:#000000;">';
						echo 'No posts have been added to: '.$class.'.  Add a post now or go to a different class!';
						echo '<form method="post" action="userpanel.php">';
						echo '<input name="class" type="text" class="createacc" placeholder="webdesign, bio101, writing201, etc." required />';
						echo '<input name="username" type="hidden" value="'.$name.'"/>';
						echo '<input name="password" type="hidden" value="SECUREPASS"/>';
						echo '<input name="userid" type="hidden" value="'.$id.'"/>';
						echo '<input name="message" type="hidden" value="NONE"/>';
						echo '<input class="button" type="submit" style="margin:10px 0px 0px 10px;" value="Load class posts"/>';
						echo '</form>';
						echo '</div>';
					}
				}
			echo '</div>';
		echo '</main>';
	}
	
	function DenyUser() {
		echo '<header role="banner">';
			echo '<div class="title">';
				echo '<div class="login" onclick="openLogin();">Login</div>';
					echo '<p>RUclassboard</p>';
					echo '<nav>';
						echo '<ul>';
							echo '<li>';
								echo '<a href="index.html">Home</a>';
							echo '</li>';
							echo '<li>';
								echo '<a href="about.html">About</a>';
							echo '</li>';
							echo '<li>';
								echo '<a href="create.html">Create an Account</a>';
							echo '</li>';					
						echo '</ul>';
					echo '</nav>';
			echo '</div>';
		echo '</header>';

		echo '<main role="main">';
			echo '<div id="loginbox" style="display:none;">';
				echo '<form method="post" action="userpanel.php">';
					echo '<p class="logintitle">Username:</p>';
					echo '<input name="username" class="login" type="text" placeholder="Username" required />';
					echo '<p class="logintitle" style="margin-top:15px;">Password:</p>';
					echo '<input name="password" class="login" type="password" placeholder="Password" required />';
					echo '<input class="signin" type="submit" value="Sign In"/>';
					echo '<div class="login" style="float:none;width:280px;" onclick="closeLogin();">Cancel</div>';
				echo '</form>';
			echo '</div>';
			echo '<div class="content">';
				echo "<h1 class='pagetitle'>Invalid login</h1>";
				echo '<div class="description">This login is invalid.  Please try again.</div>';
			echo '</div>';
		echo '</main>';
		
		echo '<script type="text/javascript" src="./scripts/login.js"></script>';
	}
?>

<footer role="contentinfo">
	<p class="credits">&copy; 2015 | Created by: Nicholas Cristiano, Abanoub David Awad, and Philip AhKao</p>
</footer>

<script type="text/javascript">
<!-- START
function logout() {
	window.location.href = "index.html";
}
// END-->
</script>
</body>

</html>
