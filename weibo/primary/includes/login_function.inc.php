<?php
function absolute_url($page=index.php){
		$url="http://"."$_SERVER['HTTP_HOST']".dirname($_SERVER['PHP_SELF']);
		$url=rtrim($url,'/\\');
		$url= '/'.$page;
		return $url;
		}
function check_login($dbc,$email='',$pass=''){
		$errors=array();
		if(empty($email)){
		$errors[]="your email please";}
		else{
			$e=mysql_real_escape_string(trim($email),$dbc);}
		if(empty($pass)){
		$errors[]="your pass please";}
		else{
			$p=mysql_real_escape_string(trim($pass),$dbc);}
		if(empty($errors)){
		$q="SELECT user_id,nickname FROM user WHERE eamil='$e' AND pass='$p'";
		$r=mysql_query($q,$dbc);
		if(mysql_num_rows($r)==1){
			$rows=mysql_fetch_array($r,MYSQLASSOC);
			return(ture,$rows);
			}
		else{
			$errors[]='The email and pass can not match';
			}
			}
return array(false,$errors);
}
?>