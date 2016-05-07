<?php
date_default_timezone_set('Asia/Tokyo');

echo $_SERVER['HTTP_HOST'];

if($_SERVER['HTTP_HOST'] != '192.168.11.10'){
	include_once('C:\htdocs\doc\acclog.php');
}

$t = new qielist;
$t->db_info();

class qielist{
	public $db_name = 'C:\htdocs\doc\xshop2\qie.db';

	public function db_info(){
		$db = new sqlite3($this->db_name,SQLITE3_OPEN_READONLY);
		$db->busyTimeout(10000);
		$temp = $db->prepare('select * from items order by c_date desc limit 10');
		$temp2 = $temp->execute();

		while($val = $temp2->fetchArray(SQLITE3_ASSOC)){
			echo '<pre>';
			print_r($val);
		}
	}



}
?>