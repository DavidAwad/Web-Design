<!-- <!doctype html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<center>
<header>
<h1>Web Design Assignment 2</h1>
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
-->
<?php
  include 'header.html';
?>

<?php
   $db_hostname = 'localhost';
   $db_database = 'class-2015-1-04-547-320-03_ada80';
   $db_username = 'username';
   $db_password = 'MySQLpassword';
?>


<h2>Welcome to David Awad's personal Space.</h2>
<ol>
<li><p> a place to do <strong>wonderful</strong> things for the sake of <strong>learning</strong></p></li>
<li><p> I'm actually a huge <strong>jazz</strong></p> fan to be honest.</li>
<li><p> please enjoy the smooth jazz music; the song you're listening to is Skylark by Gregory Porter.</p></li>
</ol>
<br>
<br>
<br>
<br>

<video width="400" controls autoplay alt="Skylark Gregory Porter">
  <source src="video/Skylark - Gregory Porter.mp4" type="video/mp4"/>
  <source src="video/Skylark - Gregory Porter.ogg" type="video/mp4"/>
  Your browser does not support HTML5 video.
</video>

<br> <br>

<p id="greeting"> </p>

<img onmouseover="this.src='img/hack_ru_logo.png'" onmouseout="this.src='img/muse.png'" id="rollover" width="800px" height="400px" src="img/muse.png"/>

<img onmouseout="this.src='img/node.svg'" onmouseover="this.src='img/mongodb.png'" id="rollover" width="800px" height="400px" src="img/node.svg"/>

<script type="text/javascript" src="js/script.js"></script>



<?php include 'footer.php';?>

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
#index{
  color:red
}
</style>
</body>
</html>

<!-- Web Design Assignment 2 By David Awad-->
