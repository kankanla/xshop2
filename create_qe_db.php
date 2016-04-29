<?php
// 2016/04/29 22:16:20
namespace cdb;

define('DB_NAME', 'qie.db');
// define('DEBUG','false');

echo __NAMESPACE__ ;

	if(!file_exists(DB_NAME)){
		$s = new qie_db();
		$s->create_db();
	}else{
		echo filesize(DB_NAME);
		$s = new qie_db();
		$s->show_db();
	}


class qie_db{
	public function create_db(){
		$db = new \sqlite3(DB_NAME);
		$db->busyTimeout(10000);
		$sql_create = '
			create table items(
				rowid INTEGER PRIMARY KEY AUTOINCREMENT,
				link_up text default \'0\',
				link_my text UNIQUE,
				qeid text UNIQUE,
				title text,
				active text default \'0\',
				c_date default CURRENT_TIMESTAMP
			)';

		$db->exec($sql_create);

		$sql_create = '
			create table comment(
				rowid INTEGER PRIMARY KEY AUTOINCREMENT,
				link_up text,
				link_my text UNIQUE,
				user_ip text,
				comment text,
				level text default \'5\',
				active text default \'0\',
				c_date default CURRENT_TIMESTAMP

			)';

		$db->exec($sql_create);	
		$db->close();
	}

	public function show_db(){
		$db = new \sqlite3(DB_NAME,SQLITE3_OPEN_READONLY);
		$db->busyTimeout(1000);
	}
}
?>