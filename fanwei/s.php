<?php
define('MODULE_NAME','Daren');
$actions = array('index');
$action = 'index';

if(isset($_REQUEST['action']))
{
	$action = strtolower($_REQUEST['action']);
	if(!in_array($action,$actions))
		$action = 'index';
}

define('ACTION_NAME',$action);

require dirname(__FILE__).'/core/fanwe.php';
$fanwe = &FanweService::instance();
$fanwe->cache_list[] = 'citys';
$fanwe->initialize();

require fimport('module/s');

switch(ACTION_NAME)
{
	case 'index':
		SModule::index();
		break;
}
?>