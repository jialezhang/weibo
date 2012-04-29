<?php
if(!isset($_FILES['image']) || empty($_FILES['image']))
	exit;
		
$result = array();
$pic = $_FILES['image'];
include_once fimport('class/image');
$image = new Image();
if(intval($_FANWE['setting']['max_upload']) > 0)
	$image->max_size = intval($_FANWE['setting']['max_upload']);
$image->init($pic);

if($image->save())
{
	$result['src'] = $image->file['target'];
	$info = array('path'=>$image->file['local_target'],'type'=>'default');
	$result['info'] = authcode(serialize($info), 'ENCODE');
	$result['status'] = 1;
}
else
{
	$result['status'] = 0;
}

outputJson($result);
?>