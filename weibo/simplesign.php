<?php
$page_title='Register';
if(isset($POST_['submitted'])){
$errors=array();
if(empty($_POST['Email'])){
$errors[]="You forget to enter your Email.";
}
else{
$El=trim($_POST['Email']);}
}
if(empty($errors)){
require_once('mysqli_connect.php');
$q="INSERT INTO user (email) VALUES ('$El')";
$r=@mysqli_query($dbc,$q);
if($r){
echo '<h1>Thank you!</h1>
<p>You are now registed</p><p><br/></p>';
}
else{
echo '<h1>System Errors!</h1>
<p class="error">You could not be registed due to a system error.We apologize for any inconvenience.</p>';
echo '<p>'.mysqli_error($dbc).'<br/><br/>Query:'.$q.'</p>'}
mysqli_close($dbc);
exit();
}
else{
echo'<h1>Error</h1>
<p class="error">The folowing errors occurred:<br/>';
foreach($errors[] as $msg){
echo "-$msg<br/>\n";
}
echo '</p><p>Please try again.</p><p><br/></p>';
}
?>
<h1>Register</h1>
<form action="simplesign.php" method="post">
<p><input type="text" name=Email size="20" value="<?php if(isset($_POST['Email'])) echo $_POST['Email'];?>"/></p>
<p><input type="submit" name="submit" value="Register"/><p>
<input type="hidden" name="submitted" value="Ture"/>
</form>


		
		
		
		
		
		
	
		
