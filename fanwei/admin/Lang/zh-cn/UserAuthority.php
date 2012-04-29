<?php
return array(
	'USERAUTHORITY'	=>	'会员权限',
	'USERAUTHORITY_EDIT'=>'设置会员权限',
	'MODULE_NAME'=>'模块',
	'ACTION_NAME'=>'操作',
	
	'ACTION_BEST'=>'推荐',
	'ACTION_TOP'=>'置顶',
	'ACTION_EDIT'=>'编辑',
	'ACTION_DELETE'=>'删除',
	
	'AUTHORITYS'=>array(
		'share'=>array(
			'name'=>'分享',
			'actions'=>array('best','edit','delete')
		),
		'club'=>array(
			'name'=>'论坛',
			'actions'=>array('best','top','edit','delete')
		),
		'ask'=>array(
			'name'=>'问答',
			'actions'=>array('best','top','edit','delete')
		),
	),
);
return $array;
?>