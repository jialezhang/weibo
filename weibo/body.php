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
	<ul class=Banner>
		<li><a href="../login/index.php">Hompage</a></li>
		<li><a href="../public_area.php">Public-Area</a></li>
		<li><a href="../unique.php">Own-information</a></li>
		<li><a href="../friends/friends.php">Friends</a></li>
		<li><?php
     			 if( (isset($_COOKIE['user_id']))&&(!strpos($_SERVER['PHP_SELF'],'login/logout.php')) ){
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
		<div id="container_remind">请文明发言，还可以时输入 不超过 <span>140</span>字</div>
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
		echo "success1111";}
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
else {
			mysql_select_db("simple", $dbc);
         $q="UPDATE freshthing SET freshthing='$fg' WHERE user_id={$_COOKIE['user_id']}";
			$r=mysql_query($q,$dbc);
			if($r){
			echo"success22222";}
			else { echo mysql_error();
			     }
			mysql_close($dbc);
		}
		}
?>
<!--提交的新鲜事表单-->
<form action=uniquepage.php method=post>
	<textarea id='fresh_out'name="freshthing" type="text"> 
	</textarea>
<!--onfocus="if(true){value=''}" onblur="if(value==''){value='说点什么吧'}"-->
	<input type=hidden name=submitted value=true />

	<div ><input type="submit" id="fabu_button" value="发布" onclick="add_fresh()"></div>
</form>
  	 </div>
 	 </div>
<!-- 暂定为有意思的链接-->
	 <div id="event"></div>
<!-- 个人信息(cookie 传值)-->
 	<div id="personal_imformation">
		<?php
			require_once('../login/connect.php');
			mysql_select_db('simple',$dbc);
			include('../login/login_function.inc.php');
		    $province = get_province($_COOKIE['province_id']);

			echo "  <p>{$_COOKIE['truename']}</p>
      		    	<p>$province</p>
     		     	<p>{$_COOKIE['gender']}</p>
      		    	<p>{$_COOKIE['age']}</p>";
			mysql_close($dbc);
		?>
     </div>
	 <div id="zone_information"></div>
	 <div id="backtotop">回到顶部</div>
<!-- 新鲜事的展示-->
 	 <div id="my_freshthings">
		<?php
		echo 'haha';
			if(isset($_COOKIE['user_id'])){
				$user_id=$_COOKIE['user_id'];
				require('../login/connect.php');
				mysql_select_db('simple',$dbc);
				$q="SELECT ('body','date') FROM freshthing WHERE user_id=".$user_id;
	    		$r=mysql_query($q,$dbc) or die(mysql_error($dbc));
				if($r){echo 'h啊哈';}
					else{
				echo mysql_error($dbc);}
	    	$freshthing_dl=<<<endhtml
					<dl>
  					 <dt>用户</dt>
endhtml;
				while($row=mysql_fetch_assoc($r)){
						extract($row);

				$freshthing_dl.=<<<endhtml
				     <dd>{$_COOKIE['truename']}</dd>
					 <dd>$freshthing</dd>
endhtml;
		
							}
			$freshthing_dl.=<<<endhtml
				</dl>
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
