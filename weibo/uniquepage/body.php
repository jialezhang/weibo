<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 <head>
  <script src="weibo.js"></script>
  <link rel="stylesheet" type="text/css" href="weibo.css">
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
		<li><?php
		session_start();
     			 if( (isset($_SESSION['user_id']))&&(!strpos($_SERVER['PHP_SELF'],'login/logout.php')) ){
					echo'<a href="../login/logout.php" >Log out</a>';
					}
				else{
					echo'<a href="../login/login.php" >Log in</a>';
					}
		
			?>
		</li>
		<div id="account"><li ><a href="../edit_account.php">Manage-Account</a></li></div>
	</ul>	
	
 </div>
<!--个性化-->
 <div class="personal">
 	<div class="freshthing">
		<div id="container_remind">请文明发言，<span id="count">还可以输入140字</span></div>
<!--下面的等号有讲究-->
	<div>
<!--php 片段用于向数据库存储新鲜事-->
<?php 
if(isset($_POST['submitted'])){
		$errors=array();
	if(empty($_POST["freshthing"])){
			$errors[]="新鲜事不能为空";}
		else{
		$fg=trim($_POST["freshthing"]);
		}
require_once('../login/connect.php');
       if (!$dbc)
       {
        die('Could not connect: ' . mysql_error());
       }
if(!empty($errors)) {
	echo"<h1>Error</h1><p class='error'>The following errors occured:<br/>";
	foreach($errors as $msg){
		echo "- $msg<br/>\n";
				}
echo "<div>please try again</p>";
}				
else if(!empty($fg)){
		    $user_id=$_SESSION['user_id'];
			mysql_select_db("simple", $dbc);
            $q="INSERT INTO freshthing (body,user_id) VALUES ('$fg','$user_id')";
			$r=mysql_query($q,$dbc);
			mysql_close($dbc);
		}
		}
?>
<!--提交的新鲜事表单-->
<form action=uniquepage.php method=post>
	<textarea id='fresh_out'name="freshthing" type="text" onkeyup="count(this.value)"> 
	</textarea>
	<input type=hidden name=submitted value=true />
	<div ><input type="submit" id="fabu_button" value="发布" ></div>
</form>
   <div id="at" > <input type="button"  id="atbtn" onclick="at_someone()" value='@'></div>
  	 </div>
 	 </div>
<!-- 暂定为有意思的链接-->
	 <div id="event"></div>
<!-- 个人信息(session 传值)-->
 	<div id="personal_imformation">
		<?php
			require('../login/connect.php');
			mysql_select_db('simple',$dbc);
			include('../login/login_function.inc.php');
			$q="SELECT nickname,gender,age,province_id FROM users WHERE user_id=".$_SESSION['user_id'];
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
 	 <div id="my_freshthings">
		<?php
			if(isset($_SESSION['user_id'])){
				$user_id=$_SESSION['user_id'];
				require('../login/connect.php');
				mysql_select_db('simple',$dbc);
				$q_parent="SELECT freshthing_id,parent_id,body,date FROM freshthing WHERE user_id='$user_id' AND parent_id=0 ORDER BY date DESC";
	    		$r_parent=mysql_query($q_parent,$dbc) or die(mysql_error($dbc));
				$num_freshthing=mysql_num_rows($r_parent);

	    	$freshthing_dl=<<<endhtml
  					 <dl>用户</dl>
				     <dl>$nickname</dl>
endhtml;
				while($row=mysql_fetch_assoc($r_parent)){
						extract($row);
						$fre_parent_id=$freshthing_id;
						//while($parent_id==0){
				$freshthing_dl.=<<<endhtml
				<form action=uniquepage.php method=post>
                <div id=$freshthing_id>
					 <dt >$body<input type='button' value="删除" onclick=delete_fre($freshthing_id)></dt>
					 <dt>$date</dt>
					***********************************
				<!--	 <p><input id=btn.rly$freshthing_id type=button value='评论' onclick='add_comment($freshthing_id)'>
					 <input type=button value='转载'></p>
	                 <input type=hidden name=submitted1 value=true />-->
					 <br>
</div>					 
				</form>
endhtml;
						//}

			$q_child="SELECT user_id, freshthing_id,body,date FROM freshthing WHERE parent_id='$fre_parent_id' ORDER BY date DESC";
			$r_child=mysql_query($q_child,$dbc) or die (mysql_error($dbc));
			$num_freshthing_child=mysql_num_rows($r_child);

				while($rowc=mysql_fetch_assoc($r_child)){
							extract($rowc);
							$q_user="SELECT nickname FROM users WHERE user_id='$user_id'";
							$r_user=mysql_query($q_user,$dbc) or die (mysql_error($dbc));
							$rowu=mysql_fetch_assoc($r_user);
							extract($rowu);
						//	echo $body;
                        
				$freshthing_dl.=<<<endhtml
                <div id=$freshthing_id>
				     <dd>reply_user
				     $nickname***$user_id</dd>
					 <dd>$freshthing_id</dd>
					 <dd>$body</dd>
					 <dd>$date<input type='button' value="删除" onclick=delete_fre($freshthing_id)>
					<!-- <input type='button' value='回复' onclick='add_comment($freshthing_id)'>
					 <input type=button value='顶' />-->
					 </dd>
					 _____________________
					 <br/>
</div>					 
endhtml;
			}
			if($num_freshthing_child>0){
			 $freshthing_dl.=<<<endhtml
	  <p>$num_freshthing_child 条回复</p>
endhtml;
} 
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

