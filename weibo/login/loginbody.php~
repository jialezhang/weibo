<?php
if(isset($_POST['submitted1'])){
	require_once('login_fuction_inc.php');
	require_once( 'connect.php');
	mysql_select_db("simple", $dbc);
	list($check,$data)=check_login($dbc,$_POST['email'],$_POST['pass']);
	if($check) {
		setcookie('user_id',$data['user_id'],time()+3600,'/','',0,0);
		setcookie('nickname',$data['nickname'],time()+3600,'/','',0,0);
		$url=absolute_url('loggedin.php');
		header("Location:$url");
		exit();}
		else {
			$errors=$data;
			}
			mysql_close($dbc);
			}
			include('login_page.inc.php');
			?>
<?php 
$page_title='Loginbody';
if(!empty($errors)) {
	echo"<h1>Error</h>
	<p class="error">The following errors occured:<br/>";
	foreach($error as $msg){
		echo "- $msg<br/>\n";
				}
echo "<div>please try again</p>";
}
?>
<h1>Log in</h1>
<form action="loginbody.php" method="post">
<div>E-mail:<input type="text"   name="email"  size="20"      value="<?php if(isset($_POST['email']))echo $_POST["email"];?>"/></div>
<p>Password:<input type="text" name="pass" size="20" value="<?php if(isset($_POST['pass']))echo $_POST["pass"];?>"/></p>
<p><input type="submit" name="submit" value="login"/></p>
<p><a href='regist/regist.php' /></a><input type="submit" name="submit" value="regist"/></a></p>
<input type="hidden" name="submitted1" value="true"/>
</from>


