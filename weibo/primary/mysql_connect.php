<?php
DEFINE('DB_USER','root');
DEFINE('DB_PASSWORD','zjl2826331');
DEFINE('DB_HOST','localhost');
DEFINE('DB_NAME','simple');
$dbc=@mysql_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME)OR die ('Could not connect to Mysql:'.mysql_connect_error());
?>
