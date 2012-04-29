<?php
   session_start();
if(!isset($_SESSION['user_id'])){
	header("Location:login.php");
	exit();
	                               }
$page_title="Logged in";
include('header.html');
	//<p>you are now logged in ,{$_COOKIE['user_id']}!</p>
	echo "<h1>Logged in!</h1>
	<p>you are now logged in ,{$_SESSION['user_id']}!</p>
	<p><a href=\"../uniquepage/uniquepage.php\">Click to your Own-Page</a></p>";
include('footer.html');
?>
