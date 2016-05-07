<?php
// 2016/05/03 16:33:45
// qie_add_cmd_server

date_default_timezone_set('Asia/Tokyo');

if($_SERVER['HTTP_HOST'] != '192.168.11.10'){
	include_once('C:\htdocs\doc\rand_uniqid.php');
	include_once('C:\htdocs\doc\acclog.php');
}else{
	include_once('C:\Apache\htdocs\dodofei\doc\rand_uniqid.php');
}

// create table comment(
// rowid INTEGER PRIMARY KEY AUTOINCREMENT,
// link_up text,
// link_my text UNIQUE,
// user_ip text,
// comment text,
// level text default \'5\',
// active text default \'0\',
// c_date default CURRENT_TIMESTAMP


if(array_key_exists('a', $_REQUEST) and array_key_exists('rand', $_REQUEST)){
	if($_GET['rand'] == '66'){
		$adm = new local_comment();
		$adm->in_to_qie_cmt($_POST['a']);
	}

	if($_GET['rand'] == '99'){
		$adm = new local_comment();
		$adm->del_for_qie($_POST['a']);
	}

}else{
	exit();
}

class local_comment {
	public $db_name = 'C:\htdocs\doc\xshop2\qie.db';
	// public $db_name = 'C:\Apache\htdocs\dodofei\doc\xshop2\qie.db';

	// 追加する予定のコメントの重複するかを確認します。
	public function chk_comment($link_up,$comment){
		$db = new sqlite3($this->db_name);
		$db->busyTimeout(10000);
		$sql = "select count(*) from comment where comment = '{$comment}'";
		$temp = $db->querySingle($sql);
		$db->close();
		return $temp;
	}

	// コメンドを追加します。
	public function in_to_qie_cmt($json){
		$d = json_decode($json);
		$link_up = $d->link_my;
		$comment = $d->comment;

		if($this->chk_comment($link_up,$comment) == 0){
			$db = new sqlite3($this->db_name);
			$db->busyTimeout(10000);
			$x = new m_rand();
			$link_my = $x->uniqid();
			$user_ip = $_SERVER['REMOTE_ADDR'];
			$temp = $db->prepare('insert into comment (link_up,link_my,user_ip,comment,level)values(:a,:b,:c,:d,:e)');
			$temp->bindValue(':a',$link_up,SQLITE3_TEXT);
			$temp->bindValue(':b',$link_my,SQLITE3_TEXT);
			$temp->bindValue(':c',$user_ip,SQLITE3_TEXT);
			$temp->bindValue(':d',$comment,SQLITE3_TEXT);
			$temp->bindValue(':e','10',SQLITE3_TEXT);
			$temp->execute();
			$db->close();
			//echo 'success';
			$this->sql_select_comment($comment);
		}else{
			//echo 'success2';
			$this->sql_select_comment($comment);
		}
	}

	// 書き込んだコメントを表示します、
	public function sql_select_comment($comment){
		$db = new sqlite3($this->db_name);
		$db->busyTimeout(10000);
		$temp = $db->prepare('select * from comment where comment = :a' );
		$temp ->bindValue(':a',$comment,SQLITE3_TEXT);
		$temp2 = $temp->execute();
		while($val = $temp2->fetchArray(SQLITE3_ASSOC)){
			$val['comment'] = str_replace ('%0d%0a','<br>',$val['comment']);
			// print_r($val);
			echo json_encode($val);
		}
		$db->close();
	}

	// コメントの削除
	public function del_for_qie($link_my){
		// print_r(json_decode($link_my));
		$link_my =  json_decode($link_my)->link_my;
		echo $link_my;
		$db = new sqlite3($this->db_name);
		$db->busyTimeout(10000);
		$temp = $db->prepare('update comment set active = "d" where user_ip = :a and link_my = :b');
		$temp->bindValue(':a', $_SERVER['REMOTE_ADDR'], SQLITE3_TEXT);
		$temp->bindValue(':b', $link_my, SQLITE3_TEXT);
		$temp->execute();
		$db->close();
		// echo 'success  del';
	}


	public function show_now_comment(){

	}

}

?>