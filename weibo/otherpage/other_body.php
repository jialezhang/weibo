<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 <head>
  <script src="other.js" ></script>
  <link rel="stylesheet" type="text/css" href="other.css">
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
 </head>
 <body>
<!-- 导航栏-->
 <div id=banner>
	<ul class=Banner>
		<li><a href="../login/index.php">Hompage</a></li>
		<li><a href="public_area.php">Public-Area</a></li>
		<li><a href="../uniquepage/uniquepage.php">Unique_page</a></li>
		<li><a href="../friends/friends.php">Friends</a></li>
		<li><?php session_start();
		echo $_SESSION['user_id'];?></li>
		<li><?php
		if(isset($_GET['user_id'])){
     			 if( (isset($_SESSION['user_id']))&&(!strpos($_SERVER['PHP_SELF'],'login/logout.php')) ){
					echo'<a href="../login/logout.php" >Log out</a>';
					}
				else{
					echo'<a href="../login/login.php" >Log in</a>';
					}
			}else{
					header("Location:../login/login.php");}		
			
			?>
		</li>
		<div id="account"><li ><a href="../edit_account.php">Manage-Account</a></li></div>
	</ul>	
	
 </div>

<!-- 好友信息(get 传值)-->
 	<div id="personal_imformation">
		<?php
			require('../login/connect.php');
			mysql_select_db('simple',$dbc);
			include('../login/login_function.inc.php');
			$user_id=$_GET['user_id'];
			$userid=$_SESSION['user_id'];
			$q="SELECT nickname,gender,age,province_id FROM users WHERE user_id=".$user_id;
			$r=mysql_query($q,$dbc) or die(mysql_error($dbc));
			$row=mysql_fetch_assoc($r);
			extract($row);
		    $province = get_province($province_id);

			echo "  <p>$nickname</p>
      		    	<p>$province</p>
     		     	<p>$gender</p>
      		    	<p>$age</p>
					<div id='focus'>
					<p><input id=$user_id type=button onclick=add_friends($user_id) value=".
					 check_focus($userid,$user_id)."></p>
					 </div>";
	
			mysql_close($dbc);
		?>
     </div>
	 <div id="zone_information"></div>
	 <div id="backtotop">回到顶部</div>
<!-- 新鲜事的展示-->
 	 <div id="friends_freshthings">
		<?php
			if(isset($_GET['user_id'])){
				$user_id=$_GET['user_id'];
				require('../login/connect.php');
				mysql_select_db('simple',$dbc);
				$q_parent="SELECT freshthing_id,parent_id,body,date FROM freshthing WHERE user_id='$user_id' AND parent_id=0 ORDER BY date DESC";
	    		$r_parent=mysql_query($q_parent,$dbc) or die(mysql_error($dbc));
				$num_freshthing=mysql_num_rows($r_parent);

	    	$freshthing_dl=<<<endhtml
  					 <dl>用户</dl>
				     <dl>$nickname</dl>
endhtml;

/*if(isset($_POST['submittedr'])){
		$errorsr=array();
	if(isset($_POST["Rly$freshthing_id"])&&empty($_POST["Rly$freshthing_id"])){
			$errorsr[]="回复不能为空";}
		else{
		$rly=trim($_POST["Rly$freshthing_id"]);
		}
require_once('../login/connect.php');
       if (!$dbc)
       {
        die('Could not connect: ' . mysql_error());
       }
if(!empty($errorsr)) {
	echo"<h1>Error</h1><p class='error'>The following errors occured:<br/>";
	foreach($errorsr as $msg){
		echo "- $msg<br/>\n";
				}
echo "<div>please try again</p>";
}				
else if(!empty($rly)){
		
		$user_id=$_SESSION['user_id'];
			mysql_select_db("simple", $dbc);
			$user_idr=$_SESSION['user_id'];
			$r=mysql_query($q,$dbc);
			mysql_close($dbc);
		}
		
}*/


				while($row=mysql_fetch_assoc($r_parent)){
						extract($row);
						$fre_parent_id=$freshthing_id;


						


				$freshthing_dl.=<<<endhtml
			
			<!--	<form action=otherpage.php?user_id=$user_id method=post>-->
                <div id=$freshthing_id>
					 <dt >$body</dt>
					 <dt>$date</dt>
                    *********************************************************
					 <p><input id=btn.rly$freshthing_id type=button value='评论' onclick='add_comment($freshthing_id,$user_id)'>
					 <input id=btn.copy$freshthing_id type=button value='转载' onclick='copy($freshthing_id,$user_id)'></p>
	                <!-- <input type="hidden" name="submittedr" value=true />-->
					 <br>
</div>					 
			<!--	</form>-->
endhtml;
             require('../login/connect.php');
             mysql_select_db('simple',$dbc);
			$q_child="SELECT user_id, freshthing_id,body,date FROM freshthing WHERE parent_id='$fre_parent_id' ORDER BY date DESC";
			$r_child=mysql_query($q_child,$dbc) or die (mysql_error($dbc));
			$num_freshthing_child=mysql_num_rows($r_child);

				while($rowc=mysql_fetch_assoc($r_child)){
							extract($rowc);
							$q_user="SELECT user_id,nickname FROM users WHERE user_id=".$user_id;
							$r_user=mysql_query($q_user,$dbc) or die (mysql_error($dbc));
							$rowu=mysql_fetch_assoc($r_user);
							extract($rowu);
                        
				$freshthing_dl.=<<<endhtml
                <div id=$freshthing_id>
				     <dd>replyer
				     $nickname</dd>
					 <dd>$body</dd>
					 <dd>$date
					 <!--<input type='button' value='回复' onclick='add_comment($freshthing_id)'>
					 <input type=button value='顶' />-->
					 </dd>
					 ___________________________
					 <br/>
</div>					 
endhtml;
			}
			 $freshthing_dl.=<<<endhtml
	  <p>$num_freshthing_child 条回复</p>
endhtml;
}				
	
			$freshthing_dl.=<<<endhtml
				<p>$num_freshthing  条新鲜事</p>
endhtml;
		echo $freshthing_dl;
				}
			else{echo "<h2>Sorry,you must log in first</h2>";
					}
 		mysql_close($dbc);
	 ?>
</div>
</body>
</html>

