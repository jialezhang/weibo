<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 <head>
  <script src="other.js"></script>
  <link rel="stylesheet" type="text/css" href="other.css">
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
 </head>
 <body>
<!-- 导航栏-->
 <div id=banner>
	<ul>
		<li><a href="../login/index.php">Hompage</a></li>
		<li><a href="../otherpage/public_area.php">Public-Area</a></li>
		<li><a href="../uniquepage/uniquepage.php">Unique_page</a></li>
		<li><a href="../friends/friends.php">Friends</a></li>
		<li><li><?php 
		session_start();
		echo $_SESSION['user_id'];?></li>
		<li><?php
		if(isset($_SESSION['user_id'])){
     			 if( (isset($_GET['user_id']))&&(!strpos($_SERVER['PHP_SELF'],'login/logout.php')) ){
					echo'<a href="../login/logout.php" >Log out</a>';
					}
				else{
					echo'<a href="../login/login.php" >Log in</a>';
					}
		}else {
				header("Location:../login/login.php");}
		
			?>
		</li>
		<div id="account"><li ><a href="../edit_account.php">Manage-Account</a></li></div>
	</ul>	
	
 </div>

<!--好友信息(session 传值)-->
 	<div id="personal_imformation">
		<?php
			require('../login/connect.php');
			mysql_select_db('simple',$dbc);
			include('../login/login_function.inc.php');
		//	$user_id=$_GET['user_id'];
			$user_id=$_SESSION['user_id'];
			$q="SELECT nickname,gender,age,province_id FROM users WHERE user_id=".$user_id;
			$r=mysql_query($q,$dbc) or die(mysql_error($dbc));
			$row=mysql_fetch_assoc($r);
			extract($row);
		    $province = get_province($province_id);

			echo "  <p>$nickname</p>
      		    	<p>$province</p>
     		     	<p>$gender</p>
      		    	<p>$age</p>";
		//	if($_SESSION['user_id']=$user_id){
		//			echo"<form action='uniquepage.php' method=post>
		//			<p><input type=submit value='关注' name=focus></p>
		//			</form>";}
			mysql_close($dbc);
		?>
     </div>
	 <div id="zone_information"></div>
	 <div id="backtotop">回到顶部</div>
<!-- 新鲜事的展示-->
 	 <div id="friends_freshthings">
		<?php
			if(isset($_SESSION['user_id'])){
				$user_id=$_SESSION['user_id'];
				require('../login/connect.php');
				mysql_select_db('simple',$dbc);
				$q_parent="SELECT friends_id FROM focus WHERE user_id='$user_id'";
	    		$r_parent=mysql_query($q_parent,$dbc) or die(mysql_error($dbc));
				$num_freshthing=mysql_num_rows($r_parent);

	    	$freshthing_dl=<<<endhtml
endhtml;
				while($row=mysql_fetch_assoc($r_parent)){
						extract($row);
				$q_fri="SELECT user_id,nickname FROM users WHERE user_id=".$friends_id;
				$r_fri=mysql_query($q_fri,$dbc) or die (mysql_error($dbc));

						while($row_fri=mysql_fetch_assoc($r_fri)){
								extract($row_fri);
								$q_fre="SELECT * FROM freshthing WHERE user_id=".$user_id." AND parent_id=0 ORDER BY date DESC";
								$r_fre=mysql_query($q_fre,$dbc) or die (mysql_error($dbc));	

				$freshthing_dl.=<<<endhtml
				<dd><a href='../otherpage/other_page.php?user_id=$friends_id'>$nickname</a></dd>
endhtml;
				while($rowf=mysql_fetch_assoc($r_fre)){
						extract($rowf);
						echo $freshthing_id;
				$freshthing_dl.=<<<endhtml
                <div id=$freshthing_id>
				    <dl> $nickname</dl>
					 <dt>$body</dt>
					 <dt>$date
					<!-- <input type='button' value='回复' onclick='add_comment($freshthing_id)'>
					 <input type=button value='顶' />-->
					 </dt>
					********************
					<br/>
</div>					 
endhtml;
			$q_child="SELECT * FROM freshthing WHERE parent_id='$freshthing_id' ORDER BY date DESC";
			$r_child=mysql_query($q_child,$dbc) or die (mysql_error($dbc));
			$num_freshthing_child=mysql_num_rows($r_child);

				while($rowc=mysql_fetch_assoc($r_child)){
							extract($rowc);
							$q_user="SELECT user_id,nickname FROM users WHERE user_id=".$user_id;
							$r_user=mysql_query($q_user,$dbc) or die (mysql_error($dbc));
							$rowu=mysql_fetch_assoc($r_user);
							extract($rowu);
                        
				$freshthing_dl.=<<<endhtml
                <div id='R'+$freshthing_id>
				     <dt>replyer
				     $nickname</dt>
					 <dd>$body</dd>
					 <dd>$date
					 <input type='button' value='回复' onclick='add_comment($freshthing_id)'>
					 <input type=button value='顶' />
					 </dd>
					 ___________________________
					 <br/>
</div>					 
endhtml;
   
				}
	
 }
			}
}	
			$freshthing_dl.=<<<endhtml
				<p>$num_freshthing  个关注</p>
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
