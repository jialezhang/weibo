<?php
$id = intval($_FANWE['request']['id']);
if($id == 0)
	exit;

if(!checkAuthority('share','edit')&&FDB::resultFirst("select uid from ".FDB::table("share")." where share_id = ".$id)!=$_FANWE['uid'])
	exit;

$content = trim(addslashes($_FANWE['request']['content']));
$title = trim(addslashes($_FANWE['request']['title']));
FDB::query("update ".FDB::table("share")." set title = '".$title."',content='".$content."' where share_id = ".$id);

showSuccess("保存成功","保存成功");
?>