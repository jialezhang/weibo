<?php
$email=$_GET["email"];


require_once("connect.php");
	if (!$dbc)
 		{
 			die('Could not connect: ' . mysql_error());
 			}

	mysql_select_db('simple',$dbc);

		$q="SELECT user_id FROM users WHERE email = '".$email."'";
	//	$q="SELECT user_id FROM users WHERE email = $email";

		$r=mysql_query($q,$dbc) or trigger_error("Query:$q\n<br/>MYSQL Error:".mysql_error($dbc));

if(mysql_num_rows($r)==1){
		echo "This email has been registed!";
		}
 else{
		 echo"Now ，you can use it!";}

mysql_close($dbc);
?>
