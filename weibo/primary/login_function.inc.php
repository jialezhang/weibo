<?php
function check_login($dbc,$email='',$pass=''){
		$errors=array();
		if(empty($_POST['email'])){
		$errors[]="your email please";
												}
		else{
			$e=trim($_POST['email']);
			}
		if(empty($_POST['pass'])){
		$errors[]="your pass please";
												}
		else{
			$p=trim($_POST['pass']);
			}
		if(empty($errors)){
		mysql_select_db("simple", $dbc);
		$q="SELECT user_id,nickname FROM users WHERE email='$e' AND pass='$p'";
		$r=mysql_query($q,$dbc);
		if(mysql_num_rows($r)==1){
			$rows=mysql_fetch_array($r,MYSQL_ASSOC);
			return array(ture,$rows);
			}
		else{
			$errors[]='The email and pass can not match';
			}
			}
return array(false,$errors);
															}
?>
