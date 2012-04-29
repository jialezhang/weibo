<?php 
$page_title="Register";
include('header.html');

if(isset($_POST['submitted'])){
		require_once('connect.php');
		$trimmed=array_map('trim',$_POST);
		
		$truename=$email=$pass=FALSE;
		
		if(preg_match('/^[A-Z \' .-]{2,20}$/i',$trimmed['truename'])){
				$truename=mysql_real_escape_string($trimmed['truename'],$dbc);
				}
				else{
						echo "<p class='error'>Please enter your name!</p>";
						}
		if(preg_match('/^[\w.-]+@[\w.]+\.[A-Za-z]{2,6}$/',$trimmed['email'])){
				$email=mysql_real_escape_string($trimmed['email'],$dbc);
				}
				else{
						echo "<p class='error'>Please enter a valid email address!</p>";
						}
		if(preg_match('/^\w{4,20}$/',$trimmed['pass1'])){
				if($trimmed['pass1']==$trimmed['pass2']){
					$pass=mysql_real_escape_string($trimmed['pass1'],$dbc);
				}
				 else{
						echo "<p class='error'>Your password did not match the confirmed one!</p>";
						}
		}
				else{
						echo "<p class='error'>Please enter a valid password!</p>";
						}
		

		if($truename&&$email&&$pass){
		mysql_select_db("simple", $dbc);
		$q="SELECT user_id FROM users WHERE email='$email' ";
		$r=mysql_query($q,$dbc) or trigger_error("Query:$q\n<br/>MYSQL Error:".mysql_error($dbc));
		define('BASE_URL','http://localhost/weibo/login/');

		if (mysql_num_rows($r)==0){
				$a=md5(uniqid(rand(),true));
				
		    $q="INSERT INTO users(email,pass,truename,active,regist_date) VALUES ('$email','$pass','$truename','$a',NOW())";
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
				echo "<p class='error'>The email address has already been registed!If you forgotten your password ,use the link at right to have your password sent to you.</p>";
				}
		mysql_close($dbc);
}	
}
?>
<div id='registnew'>
<h1>Regist<h1/>
<form action='registnew.php' method=post>
	<fieldset>

   <p><big>E-mail:<input type="text" name="email" id="email"  size="20"  value="<?php if(isset($trimmed['email'])) echo $trimmed["email"];?>"/></big></p>

   <p><big>Truename:<input type="text" name="truename" id="truename"  size="20"  value="<?php if(isset($trimmed['truename'])) echo $trimmed["truename"];?>"/></big></p>

   <p><big>Password:<input type="password" name="pass1" id="pass1"  size="20"></big><small>Use only letters,numbers,and underscroe.Must between 4 and 20 characters long.</small></p>

   <p><big>Confirm Password:<input type="password" name="pass2" size=20 /></big></p>

    </fieldset>
	
 <div align="center"><input type="submit" name="submit" value="Regist" /></div>
 <input type='hidden' name="submitted" value=true />

</form>
</div>
<?php

 include('footer.html');
 ?>






















