<?php
session_start();
$userid=$_SESSION['user_id'];
$user_id=$_GET['fre'];
//echo $user_id;

require_once("../login/connect.php");
	if (!$dbc)
 		{
 			die('Could not connect: ' . mysql_error());
 			}

	mysql_select_db('simple',$dbc);

        $q="DELETE  FROM focus WHERE user_id='$userid'AND friends_id='$user_id'";

		$r=mysql_query($q,$dbc) or trigger_error("Query:$q\n<br/>MYSQL Error:".mysql_error($dbc));
 if($r){
		echo "success";}
		 else { echo "failed";}

mysql_close($dbc);
?>
