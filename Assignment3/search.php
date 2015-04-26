<!DOCTYPE html>

<html>
	<head>

		<title>Search!</title>

		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta name="author" content="Your Name" />
		<meta name="description" content="Short deacriptopn of this page" />
		<meta name="keywords" content="keywords, for, a, better, search" />

		<link rel="stylesheet" type="text/css" href="stylesheet.css" />

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




		<?php

      $query = $_POST['firstName']; // This gets the value that the user entered in the search form.

      require_once 'login.php'; // remember to change to your NetID
			$db_server = mysql_connect($db_hostname, $db_username, $db_password);
			if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
			mysql_select_db($db_database) or die("Unable to select database: " . mysql_error());


		    $min_length = 3; // We can set minimum length of the query. This is optional.

		    if(strlen($query) >= $min_length){ // If the length of the query is more or equal minimum length, then following operations will be performed:

		        $query = htmlspecialchars($query); // This changes the special characters of the query to their equivalents, for example: "<" to "&gt;"

		        $query = mysql_real_escape_string($query);
		        // makes sure nobody uses SQL injection

		        $raw_results = mysql_query("SELECT * FROM users WHERE (firstName LIKE '%".$query."%') OR (lastName LIKE '%".$query."%')") or die(mysql_error());
		        // "classics" is the name of our table
		        // * means that we select all fields. You could also write: "id", "author", "title"
		        // '%$query%' is the search term. % means "anything", for example if $query is "Jane" it will match "Jane Austen", "Jane Eyre," "Aunt Jane," etc.
		        // If you want exact match, you need to use title='$query'

		        if(mysql_num_rows($raw_results) > 0){ // If one or more rows are returned, do following:

	   				while($results = mysql_fetch_array($raw_results)){
	    				// $results = mysql_fetch_array($raw_results) puts data from the database into array, while it is valid, it performs the loop

						echo "<p><h3>".$results['author']."</h3>".$results['title']."</p>";
						// Posting the results fetched from the database("author" and "title"). We could also show id ($results['id']) or other fields.
            		}
            	}
		        else{ // If there are no matches rows do the following:
            		echo "Your search produced no results"; // You could add some CSS code here, of course.
    	    	}

    		}
    		else{ // If the length of the query is less than the minimum we assigned, do the following:
    			    echo "Minimum length is ".$min_length;
    		}
		?>

	</body>
</html>
