<?php
//验证登陆信息
function check_login($dbc,$nickname='',$pass=''){
		$errors=array();
		if(empty($_POST['nickname'])){
		$errors[]="your nickname please";
			}
		else{
			$n=trim($_POST['nickname']);
			}
		if(empty($_POST['pass'])){
		$errors[]="your pass please";
			}
		else{
			$p=trim($_POST['pass']);
			}
		if(empty($errors)){
		mysql_select_db("simple", $dbc);
		$q="SELECT user_id,gender,age,province_id,nickname,regist_date,friends_id FROM users WHERE nickname='$n' AND pass='$p'";
		$r=mysql_query($q,$dbc);
		if(mysql_num_rows($r)==1){
			$rows=mysql_fetch_array($r,MYSQL_ASSOC);
			return array(ture,$rows);
			}
		else{
			$errors[]='The nickname and pass can not match';
			}
			}
return array(false,$errors);
        }

	//获取省份	
function get_province($province_id){
		
		global $dbc;
		
		$q='SELECT province FROM province WHERE province_id='.$province_id;
		$r=mysql_query($q,$dbc) or die (mysql_error($dbc));
		$row=mysql_fetch_assoc($r);
		extract($row);
		return $province;
}

//获取个人的新鲜事
function get_freshthing($user_id){
		
		global $dbc;
		
		$q="SELECT ('body','date') FROM freshthing WHERE user_id=".$user_id;
		$r=mysql_query($q,$dbc) or die (mysql_error($dbc));
		$row=mysql_fetch_assoc($r);
		extract($row);
		return $body;
}

function get_blog($user_id){
		
		global $dbc;
		
		$q='SELECT ("body","date") FROM blog WHERE user_id='.$user_id;
		$r=mysql_query($q,$dbc) or die (mysql_error($dbc));
		$row=mysql_fetch_assoc($r);
		extract($row);
		return $province;
}
//验证关注
function check_focus($userid,$user_id){
			global $dbc;
		
		$q="SELECT focus_id FROM focus WHERE  user_id='$userid' AND friends_id ='$user_id'";
		$r=mysql_query($q,$dbc);
		if(mysql_num_rows($r)==1){
				return "已关注";}
				elseif(mysql_num_rows($r)>1){
						echo "you have focus this one";}
				else{
						return "+关注";}
		}

?>
