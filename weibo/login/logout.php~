<?php
if(!isset($_COOKIE['user_id'])){
	require_once('login_function.inc.php');
	$url=absolute_url();
	header("Location:login.php");
	exit();
	}
	else {
		setcookie('user_id','',time()-3600,'/','',0,0);
		setcookie('nickname','',time()-3600,'/','',0,0);
		}
	$page_title="Logged out";
	include('header.html');
	echo "<h1>Logged out!</h1>
	<p>you are now logged out ,{$_COOKIE['nickname']}!</p>";
	include('footer.html');
	?>