<?php
session_start();
$freshthing_id=$_GET['fresh'];

require_once("../login/connect.php");
	if (!$dbc)
 		{
 			die('Could not connect: ' . mysql_error());
 			}

	mysql_select_db('simple',$dbc);
	  $q='DELETE  FROM freshthing WHERE freshthing_id ='.$freshthing_id;
      $r=mysql_query($q,$dbc) or trigger_error("Query:$q\n<br/>MYSQL Error:".mysql_error($dbc));
	
 if($r){
		echo "success";}
		 else { echo "failed";}

mysql_close($dbc);


?>
