<?php 
$page_title='Loginbody';
include('includes/header.html')
if(!empty($errors)) {
	echo"<h1>Error</h>
	<p class="error">The following errors occured:<br/>";
	foreach($error as $msg){
		echo "- $msg<br/>\n";
				}
echo "<div>please try again</p>";
}
?><h1>Log in</h1>
<form action="login.php" method="post">
<div>E-mail:<input type="text"   name="email"  size="20" maxlength="80"/></div>
<p>Password:<input type="text" name="pass" size="20" maxlength="20"/></p>
<p><input type="submit" name="submit" value="login"/></p>
<input type="hidden" name="submitted" value="true"/>
</from>
<?php
include('includes/footer.html');
?>
