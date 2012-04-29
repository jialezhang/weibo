<?php
if(!isset($_COOKIE['user_id'])){
	header("Location:login.php");
	exit();
	                               }
$page_title="Logged in";
include('header.html');
	echo "<h1>Logged in!</h1>
	<p>you are now logged in ,{$_COOKIE['nickname']}!</p>
	<p><a href=\"logout.php\">logout</a></p>";
include('footer.html');
?>