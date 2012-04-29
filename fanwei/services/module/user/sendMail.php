<?php
	global $_FANWE;
	$follow_uid = intval($_FANWE['request']['follow_uid']);
	if(!$follow_uid)
		exit;
	$follow_user = FS("User")->getUserById($follow_uid);
	
	include template('services/user/sendMail');
	display();
?>