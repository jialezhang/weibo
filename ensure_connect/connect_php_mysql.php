<?php
$link = mysql_connect("localhost", "root", "zjl2826331")
or die("Could not connect: " . mysql_error());
print ("Connected successfully");
mysql_close($link);
?>
