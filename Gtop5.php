<?php 
//Gene_cc Top5;
include_once('C:\htdocs\doc\acclog.php');
date_default_timezone_set('Asia/Tokyo');

$temp = new sqlite3('C:\htdocs\doc\xshop2\QEdb.db');
$sql = "delete from qeid where strftime('%s','now')-time > 86400";
$temp->exec($sql);
$temp->exec('VACUUM');
$sql = "select * from top5";
$show = $temp->query($sql);
//sqlite> delete from qeid where strftime('%s','now')-time > 86400;

echo '<pre>';
$v = array();
while ($v = $show->fetchArray(SQLITE3_ASSOC)){
	echo '[nowt] => '.date('c');
	echo '<br>';
	echo '[time] => '.date('c',$v['time']);
	echo '<br>';
	foreach ($v as $key=>$val){
		echo '['.$key.'] = > '.urldecode($val);
		echo '<br>';
	}
	echo '<br><br><br><br>';
}

$temp->close();


include_once('C:\htdocs\doc\xshop2\sqlite3.php');
$t = new sql3();
print_r($t->topone());


echo '<br><br><br>//////////////////////////////////////////<br>';
echo '<br>アイテムのPV回数<br>';
qie_show_count();
function qie_show_count(){
		// Item PV数を確認
		$db = new sqlite3('C:\htdocs\doc\xshop2\qie.db');
		$db->busyTimeout(10000);
		$temp = $db->prepare('select * from items where show_count !=0 order by show_count desc limit 10');
		$temp2 = $temp->execute();
		echo '<pre>';
		while($val = $temp2->fetchArray(SQLITE3_ASSOC) ){
			print_r($val);
			echo '<br>';
		}
		$db->close();
	}






