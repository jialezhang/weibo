<?php
$id = intval($_FANWE['request']['id']);
$module = strtolower(trim($_FANWE['request']['module']));
if($id == 0 || empty($module))
	exit;

if(!getIsManage($module))
	exit;

$manage_lock = checkIsManageLock($module,$id);
include template('manage/menu');
display();
?>