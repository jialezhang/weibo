<?php
if(isset($_POST["submitted"])){
   $errors[]="email null!";
  if(empty($_POST["email"])){
    $errors[]="you forget email";
             }
  else{
       $el=trim($_POST["email"]);}
   if(empty($_POST["pass"])){
    $errors[]="you forget password";
             }
  else{
       $pd=trim($_POST["pass"]);}
	if(empty($_POST["nickname"])){
    $errors[]="you forget nickname";
             }
  else{
       $ne=trim($_POST["nickname"]);}
	if(empty($_POST["age"])){
    $errors[]="you forget age";
             }
  else{
       $ae=trim($_POST["age"]);}
	if(empty($_POST["gender"])){
    $errors[]="you forget gender";
             }
  else{
       $gr=trim($_POST["gender"]);}
	  require_once('connect.php');
       if (!$dbc)
       {
        die('Could not connect: ' . mysql_error());
       }

       else{
       	mysql_select_db("simple", $dbc);
           	$q="INSERT INTO users (email,pass,nickname,age,gender) VALUES ('$el','$pd','$ne','$ae','$gr')";
			$r=mysql_query($q,$dbc);
			if($r){
			echo"success";}
			mysql_close($dbc);
			}
}
?>
<h1>Regist</h1>
<form action="regist.php" method="post">
<div>E-mail:<input type="text"   name="email"  size="20"      value="<?php if(isset($_POST['email']))echo $_POST["email"];?>"/></div>
<p>Password:<input type="text" name="pass" size="20"value="<?php if(isset($_POST['pass']))echo $_POST["pass"];?>"/></p>
<p>Nickname:<input type="text" name="nickname" size="20" value="<?php if(isset($_POST['nickname']))echo $_POST["nickname"];?>"/></p>
<p>Gender(M/F):<input type="text" name="gender" size="20" value="<?php if(isset($_POST['gender']))echo $_POST["gender"];?>"/></p>
<p>Age:<input type="text "name="age" size="20" value="<?php if(isset($_POST['age']))echo $_POST["age"];?>"/></p>
<p><input type="submit" name="submit" value="register"/></p>
<input type="hidden" name="submitted" value="true"/>
</from>
