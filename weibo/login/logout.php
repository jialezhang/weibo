<?php
session_start();
if(!isset($_SESSION['user_id'])){
	require_once('login_function.inc.php');
	header("Location:login.php");
	exit();
	}
	else {
			session_destroy();
		//unset($_SESSION['user_id']);	
		//setcookie('user_id','',time()-3600,'/','',0,0);
		//setcookie('nickname','',time()-3600,'/','',0,0);
		}
	$page_title="Logged out";
	include('header.html');
	echo "<h1>Logged out!</h1>
	<p>you are now logged out!</p>";
	include('footer.html');
	?>
