<!doctype html>
<head>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
  <script type="text/javascript" src="js/script.js"></script>

  <link rel="apple-touch-icon" sizes="57x57" href="favicons/apple-touch-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="favicons/apple-touch-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="favicons/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="favicons/apple-touch-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="favicons/apple-touch-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="favicons/apple-touch-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="favicons/apple-touch-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="favicons/apple-touch-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon-180x180.png">
  <link rel="icon" type="image/png" href="favicons/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="favicons/android-chrome-192x192.png" sizes="192x192">
  <link rel="icon" type="image/png" href="favicons/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/png" href="favicons/favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="favicons/manifest.json">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="msapplication-TileImage" content="/mstile-144x144.png">
  <meta name="theme-color" content="#ffffff">

</head>
<body>
<center>
<header>
<h1>Web Design Assignment 3</h1>
<nav>
  <ul>
      <li><a id="index" href="index.html">index</a></li>
      <li><a id="faq" href="faq.html">faq</a></li>
      <li><a id="about" href="about.html">about me</a></li>
      <li><a id="table" href="table.html">Page with table</a></li>
      <li><a id="lorem" href="lorem.html">lorem ipsum</a></li>
  </ul>
</nav>
</header>

<div style="text-align:center">

  <form>

    First Name: <input type="text" name="firstName" required>
    Last Name: <input type="text" name="lastName" required>
    Email: <input type="text" name="email" required>
    City: <input type="text" name="city" required>
    Zip Code:<input type="text" name="zipcode" required>
    <input type="submit">

  </form>

  <br> <br>

  <img onmouseover="this.src='img/hack_ru_logo.png'" onmouseout="this.src='img/muse.png'" id="rollover" width="800px" height="400px" src="img/muse.png"/>

  <br> <br>

  <footer>
    <a href="http://davidawad.github.io">Website by David Awad</a>
  </footer>

  </div>

  <style>
  /* change the background image page by page */
  html, body{
  background-image: url("img/beach.jpeg");
  }
  h1{
    color:orange
  }
  p{
    font-size:1.9em;
  }

  </style>
  </body>
</html>

  <!-- Web Design Assignment 3 By David Awad-->
  <?php

  	require_once 'login.php';
  	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
  	if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
  	mysql_select_db($db_database) or die("Unable to select database: " . mysql_error());

  	$firstName = mysql_fix_string(   $_POST['firstName'] );
  	$lastName = mysql_fix_string($_POST['lastName']);
  	$email = mysql_fix_string($_POST['email']);
  	$city = mysql_fix_string($_POST['city']);
  	$zipcode = mysql_fix_string($_POST['zipcode']);
  	$operatingSystem = mysql_fix_string(implode(",", $_POST['os']));

  	$query = "INSERT INTO users (firstName, lastName, email, city, zipcode, operatingSystem)
  					     VALUES ('$firstName','$lastName','$email','$city', '$zipcode','$operatingSystem')";

  	$result = mysql_query($query) or die(" ". mysql_error());

  	if($result)
  		echo "Data Saved Successfully!";
  	else
  		echo "There was a problem while saving the data.";

  	function mysql_fix_string($string){ // This function "sanitizes" data to prevent malcious code.

  		if (get_magic_quotes_gpc())
  			$string = stripslashes($string);
  		return mysql_real_escape_string($string);
  	}
  ?>
