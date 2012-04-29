<?php
session_start();
$userid=$_SESSION['user_id'];
$freshthing_id=$_GET['fre_id'];

require_once("../login/connect.php");
	if (!$dbc)
 		{
 			die('Could not connect: ' . mysql_error());
 			}

	mysql_select_db('simple',$dbc);
	  $qb='SELECT body FROM freshthing WHERE freshthing_id ='.$freshthing_id;
      $rb=mysql_query($qb,$dbc) or trigger_error("Query:$q\n<br/>MYSQL Error:".mysql_error($dbc));
		$row=mysql_fetch_assoc($rb);

		extract($row);
			$bodya="[转]".$body;
		
        $q="INSERT INTO freshthing (user_id,body) VALUES ('$userid','$bodya')";

		$r=mysql_query($q,$dbc) or trigger_error("Query:$q\n<br/>MYSQL Error:".mysql_error($dbc));
 if($r){
		echo "success";}
		 else { echo "failed";}

mysql_close($dbc);


?>
