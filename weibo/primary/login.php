<?php
if(isset($_POST['submitted']))
{
require_once( 'connect.php');
require_once('login_function.inc.php');
	if (!$dbc)
        {
        die('Could not connect: ' . mysql_error());
        }
   else {
mysql_select_db("simple", $dbc);
list($check,$data)=check_login($dbc,$_POST['email'],$_POST['pass']);
	echo $_POST['email'];
	echo $_POST['pass'];
	echo $data;
	echo $check;
	      if($check) 
	         	{
					setcookie('user_id',$data['user_id'],time()+3600,'/','',0,0);
					setcookie('nickname',$data['nickname'],time()+3600,'/','',0,0);
					header("Location:loggedin.php");
					exit();
	  				 }
			else 
	 			 {
					$errors=$data;
					}
mysql_close($dbc);
			}
}
include('login_page.inc.php');
?>