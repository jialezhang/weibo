<?php
$array = array(
	'ALBUM'=>'杂志社',
	'ALBUM_INDEX'=>'杂志社列表',
	'ALBUM_EDIT'=>'编辑杂志社',
	
	'SHARE_COUNT'=>'分享数量',
	'TITLE'=>'名称',
	'CID'=>'杂志社分类',
	'IS_FLASH'=>'首页FLASH',
	'FLASH_IMG'=>'FLASH图片',
	'IS_BEST'=>'推荐',
	'BEST_IMG'=>'推荐图片',
	'ALBUM_SHARE_COUNT'=>'%d个分享',
	'CATEGORY_ALL'=>'所有分类',
	'SHOW_TYPE'=>'展现方式',
	'SHOW_TYPE_1'=>'小图',
	'SHOW_TYPE_2'=>'中图',
	'SHOW_TYPE_3'=>'大图',
	'TAGS'=>'时尚元素',
	'CONTENT'=>'介绍',
	
	'TITLE_REQUIRE'=>'名称不能为空',
	
	'CONFIRM_DELETE'=>'删除杂志社将同时删除杂志社下的分享数据\r\n\r\n你确定要删除选择项吗？',
);
return $array;
?>
INSERT INTO `fanwe_role_node` (`action`, `action_name`, `status`, `module`, `module_name`, `nav_id`, `sort`, `auth_type`, `is_show`) VALUES
('', '', 1, 'AlbumSetting', '杂志社配置管理', 10, 10, 1, 0),
('index', '设置配置', 1, 'AlbumSetting', '杂志社配置管理', 10, 10, 0, 1),
('update', '更新配置', 1, 'AlbumSetting', '杂志社配置管理', 10, 10, 0,0),
('', '', 1, 'AlbumCategory', '杂志社分类管理', 10, 10, 1, 0),
('index', '分类列表', 1, 'AlbumCategory', '杂志社分类管理', 10, 10, 0, 1),
('add', '添加分类', 1, 'AlbumCategory', '杂志社分类管理', 10, 10, 0, 1),
('update', '更新分类', 1, 'AlbumCategory', '杂志社分类管理', 10, 10, 0, 0),
('remove', '删除分类', 1, 'AlbumCategory', '杂志社分类管理', 10, 10, 0, 0),
('', '', 1, 'Album', '杂志社管理', 10, 10, 1, 0),
('index', '杂志社列表', 1, 'Album', '杂志社管理', 10, 10, 0, 1),
('update', '更新杂志社', 1, 'Album', '杂志社管理', 10, 10, 0, 0),
('remove', '删除杂志社', 1, 'Album', '杂志社管理', 10, 10, 0, 0);