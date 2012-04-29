<?php 
header('Content-Type: text/html; charset=utf-8');
$page_title="Register";

if(isset($_POST['submitted'])){
		require_once('connect.php');
		$errors=array();
		$trimmed=array_map('trim',$_POST);
		
		$nickname=$email=$pass=FALSE;
		
	/*	if(preg_match('/^[A-Z \' .-]{2,20}$/i',$trimmed['nickname'])){
				$nickname=mysql_real_escape_string($trimmed['nickname'],$dbc);
				}
				else{
					$errors[]='Please enter your nickname!';
						}
	*/					
		if(preg_match('/^[\w.-]+@[\w.]+\.[A-Za-z]{2,6}$/',$trimmed['email'])){
				$email=mysql_real_escape_string($trimmed['email'],$dbc);
				}
				else{
						$errors[]='Please enter a valid email address!';
						}
		if(preg_match('/^\w{4,20}$/',$trimmed['pass1'])){
				if($trimmed['pass1']==$trimmed['pass2']){
					$pass=mysql_real_escape_string($trimmed['pass1'],$dbc);
				}
				 else{
						$errors[]='Your password did not match the confirmed one!';
						}
		}
				else{
						$errors[]='Please enter a valid password!';
						}
		if(empty($_POST["nickname"])){
    			$errors[]="you forget nickname!";
           		  }
			  else{
				$nickname=mysql_real_escape_string($trimmed['nickname'],$dbc);
     				  }
		if(empty($_POST["province_id"])){
    			$errors[]="you forget provinc";
           		  }
			  else{
				$p_i=mysql_real_escape_string($trimmed['province_id'],$dbc);
     				  }
		if(empty($_POST["age"])){
   				 $errors[]="you forget age";
          		   }
  			else{
				$age=mysql_real_escape_string($trimmed['age'],$dbc);
       				}
		if(empty($_POST["gender"])){
   					 $errors[]="you forget gender";
            	 }
			  else{
				$gender=mysql_real_escape_string($trimmed['gender'],$dbc);
      		 }



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
         $q="INSERT INTO users (email,pass,age,gender,province_id,nickname) VALUES ('$email','$pass','$age','$gender','$p_i','$nickname')";
			$r=mysql_query($q,$dbc);
			if($r){
			echo"success";}
			else { echo mysql_error();
			     }
			mysql_close($dbc);
		}
}








// 用于激活的代码
	/*	if($nickname&&$email&&$pass){
		mysql_select_db("simple", $dbc);
		$q="SELECT user_id FROM users WHERE email='$email' ";
		$r=mysql_query($q,$dbc) or trigger_error("Query:$q\n<br/>MYSQL Error:".mysql_error($dbc));
		define('BASE_URL','http://localhost/weibo/login/');

		if (mysql_num_rows($r)==0){
				$a=md5(uniqid(rand(),true));
				
		    $q="INSERT INTO users(email,pass,nickname,active,regist_date) VALUES ('$email','$pass','$nickname','$a',NOW())";
			$r=mysql_query($q,$dbc) or trigger_error("Query:$q\n<br/>MYSQL Error:".mysql_error($dbc));
			  
	    if (mysql_affected_rows($dbc)==1){
				$to=$trimmed['email'];
				$subject="Registration Confirmatoin";
				$message="Thank you for registing at 
				        <jameszhang>. To activate your account,please click on this link:\n\n";
				$message.='BASE_URL'.'activate.php?x='.urlencode($email)."&y=$a";
				$headers = 'From: jialezhang@hustunique.com' . "\r\n" . 
							'Reply-To:jialezhang@hustunique.com' . "\r\n" . 
							'X-Mailer: PHP/' . phpversion(); 
				mail($to, $subject, $message, $headers);
			
				echo '<h3>Thank you for registing .A confirmation has been sent to your address.Please 
				click on this link in that email to activate your acount.</h3>';
				include('footer.html');
				exit();
	    	}
			else{
					echo"<p class='error'>You could not be registed due to a system error.We apologize for any inconvinience.</p>";
					}
		}
		else {
				$errors[]=The email address has already been registed!If you forgotten your password ,use the link at right to have your password sent to you.</p>";
				}
		mysql_close($dbc);
}	
}*/





?>
<html>
 <head>
  <script src="regist.js"></script>
  <link rel="stylesheet" type="text/css" href=regist.css>
  <body>
  <div id=main>
  <div id=main2>
  <h1>Regist</h1>
<form action='regist.php' method=post>

   <p><big>E-mail:<input type="text" name="email" id="email" onkeyup="check_email(this.value)"  size="20"  value="<?php if(isset($trimmed['email'])) echo $trimmed["email"];?>"/></big></p>

   <span id="txtHint"></span>

   <p><big>Nickname:<input type="text" name="nickname" id="nickname"  size="20"  value="<?php if(isset($trimmed['nickname'])) echo $trimmed["nickname"];?>"/></big></p>

   <p><big>Password:<input type="password" name="pass1" id="pass1"  size="20"></big></p>
   <p><small>*Use only letters,numbers,and underscroe.Must between 4 and 20 characters long.</small></p>

   <p><big>Confirm Password:<input type="password" id='pass2' name="pass2" size=20 /></big></p>

   <p><big>Age:<input type="text" id="age" name="age" size=20 /></big></p>
	
   <p id='p_i'><big>Province:
    <select id="province" defvalue=0 name="province_id">
    <option value="1">安徽</option>
    <option value="2">北京</option>
    <option value="3">重庆</option>
	 <option value="4">福建</option>
	 <option value="5">甘肃</option>
	 <option value="6">广东</option>
	<option value="7">广西</option>
	<option value="8">贵州</option>
	<option value="9">海南</option>
	<option value="10">河北</option>
	<option value="11">黑龙江</option>
	<option value="12">河南</option>
	<option value="13">湖北</option>
	<option value="14">湖南</option>
	<option value="15">内蒙古</option>
	<option value="16">江苏</option>
	<option value="17">江西</option>
	<option value="18">吉林</option>
	<option value="19">辽宁</option>
	<option value="20">宁夏</option>
	<option value="21">青海</option>
	<option value="22">山西</option>
	<option value="23">山东</option>
	<option value="24">上海</option>
	<option value="25">四川</option>
	<option value="26">天津</option>
	<option value="27">西藏</option>
	<option value="28">新疆</option>
	<option value="29">云南</option>
	<option value="30">浙江</option>
	<option value="31">陕西</option>
	<option value="32">台湾</option>
	<option value="33">香港</option>
	<option value="34">澳门</option>
	<option value="35">海外</option>
	<option value="100" selected="selected">其他</option>
   </select></big></p>

<p id='gender'><big>Gender(M/F):<select defvalue='' name="gender" id="gender">
<option value="男">男</option>
<option value="女">女</option></select></big></p>
   <p><input type="submit" name="submit" value="regist"/></p>
   <p><input type="button" name="log" value="~log~" onclick="window.location.href='login.php'"/></p>
   <input type="hidden" name="submitted" value="true"/>
  </form>
 </div>
  </div>
 </body>
</html>























