<?php 
$page_title='Loginbody';
include('header.html');
if(!empty($errors)) {
	echo"<h1>Error</h1><p class='error'>The following errors occured:<br/>";
	foreach($errors as $msg){
		echo "- $msg<br/>\n";
				}
echo "<div>please try again</p>";
}
?>
<div id="content">
<form action="login.php" method="post">
<div id="email">E-mail:<input type="text"   name="email"  size="22" /></div>
<div id="password">Password:<input type="text" name="pass" size="20" /></div>
<br>
<div id="button">
<ul>
<li><input type="submit" name="submit" value="login"/></li>
<li></a><input type="button" value="regist" onclick="window.location.href='regist.php'"/></li>
</ul>
</div>
<br>
<input type="hidden" name="submitted" value="true"/>
</form>
</div>
<br>
<br>
<br>
<?php 
include('footer.html');
?>
