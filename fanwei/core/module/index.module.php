<?php
class IndexModule
{
	public function index()
	{
		global $_FANWE;
		include template('page/index_index');
		display();
	}
}
?>