<?php
header('Content-Type: text/html; charset=utf-8');
if(isset($_POST["submitted"])){
   $errors=array();
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
if(empty($_POST["province_id"])){
    $errors[]="you forget province_id";
             }
  else{
       $p_i=trim($_POST["province_id"]);
       }
if(empty($_POST["truename"])){
    $errors[]="you forget truename";
             }
  else{
       $te=trim($_POST["truename"]);
       }
if(empty($_POST["age"])){
    $errors[]="you forget age";
             }
  else{
       $ae=trim($_POST["age"]);
       }
if(empty($_POST["gender"])){
    $errors[]="you forget gender";
             }
  else{
       $gr=trim($_POST["gender"]);
       }
require_once('connect.php');
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
         $q="INSERT INTO users (email,pass,age,gender,province_id,truename) VALUES ('$el','$pd','$ae','$gr','$p_i','$te')";
			$r=mysql_query($q,$dbc);
			if($r){
			echo"success";}
			else { echo mysql_error();
			     }
			mysql_close($dbc);
		}
}
?>
<html>
 <head>
  <script src=regist.js></script>
  <link rel="stylesheet" type="text/css" href=regist.css>
  <body>
  <div id=main>
  <h1>Regist</h1>
  <form action="regist.php" method="post">
   <p>E-mail:<input type="text" name="email" id="email"  size="20"      value="<?php if(isset($_POST['email']))echo $_POST["email"];?>"/></p>
   <p>Truename:<input type="text" name="truename" id="truename" size="20" value="<?php if(isset($_POST['truename']))echo $_POST["truename"];?>"/></p>
   <p>Password:<input type="text" name="pass" id="pass"size="20"value="<?php if(isset($_POST['pass']))echo $_POST["pass"];?>"/></p>
   <p>Confirm Password:<input type="text" name="pass" id="cpass" size="20"value="<?php if(isset($_POST['pass']))echo $_POST["pass"];?>"/></p>

   <p>Province:
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
   </select>

<p>Gender(M/F):<select defvalue='' name="gender" id="gender">
<option value="男">男</option>
<option value="女">女</option></select></p>
<p>Age:<input type="text "name="age" size="20" id="age" value="<?php if(isset($_POST['age']))echo $_POST["age"];?>"/></p>
<p><input type="submit" name="submit" value="regist"/></p>
<p><input type="button" name="log" value="~log~" onclick="window.location.href='login.php'"/></p>
<input type="hidden" name="submitted" value="true"/>
</form>
</div>
 </body>
</html>
