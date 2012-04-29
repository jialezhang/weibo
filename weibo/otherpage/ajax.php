<?php
session_start();
$userid=$_SESSION['user_id'];
//$user_id=$_GET['userid'];
//echo $user_id;
$body=$_GET['body'];
$parent_id=$_GET['parent_id'];


require_once("../login/connect.php");
	if (!$dbc)
 		{
 			die('Could not connect: ' . mysql_error());
 			}

	mysql_select_db('simple',$dbc);

        $q="INSERT INTO freshthing (body,user_id,parent_id) VALUES ('$body','$userid','$parent_id')";

		$r=mysql_query($q,$dbc) or trigger_error("Query:$q\n<br/>MYSQL Error:".mysql_error($dbc));
 if($r){
        header("Locatoin:../login/login.php");
		echo "success";}
		 else { echo "failed";}

mysql_close($dbc);
?>
