<?php # Script activate.php
//用于激活账户
$page_title="Activate your  account";
include('header.html');
 
$x=$y=FALSE;
if(isset($_GET['x'])&&preg_match('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/',$_GET['X'])){
		$x=$_GET['X'];
		}
if(isset($_GET['y'])&&strlen($_GET['y'])==32){
		$y=$_GET['Y'];
		}
		
if($x&&$y){
		require_once(connect.php);
		$q="UPDATE users SET activate=NULL WHERE (email='".mysql_real_escape_string($x,$dbc)."' AND active='".mysql_real_escape_string($y,$dbc) . "') LIMT 1";
		$r=mysql_query($q,$dbc) or trigger_error("Query:$q\n<br/>MYSQL Error:".mysql_error($dbc));

	if (mysql_affected_rows($dbc)==1){
		echo"<h3>Your account is now active.You may now log in.</h3>";
		} else {
				echo "<p class=error>Your account could not be activated.Please recheack the link or contact jameszhang.</p>";
		}

		mysql_close($dbc);

     }
  else {
		  ob_end_clean();//删除缓存 不太懂
          header("Location:index.php");
		  exit();
		 }
		 

include('footer.html');
?>


