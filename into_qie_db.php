<?php
// 2016/04/29 22:16:12

include_once('rand_uniqid.php');
// include_once('C:\htdocs\doc\acclog.php');


class insert_qe{
	public $db_name = 'qie.db';
	public function title_qie($qeid,$q_title){
		if(file_exists($this->db_name)){
			$db = new sqlite3($this->db_name);
			$db->busyTimeout(10000);
			if($this->find_qeid($qeid) and $qeid != ''){
				$temp = $db->prepare('insert into items(link_my, qeid, title)values(:a, :b, :c)');
				$x = new m_rand();
				$qid = $x->uniqid();
				$temp->bindValue(':a', $qid, SQLITE3_TEXT);
				// $temp->bindValue(':b', htmlspecialchars($qeid), SQLITE3_TEXT);
				$temp->bindValue(':b', $qeid, SQLITE3_TEXT);
				// $temp->bindValue(':c', htmlspecialchars($q_title), SQLITE3_TEXT);
				$temp->bindValue(':c', $q_title, SQLITE3_TEXT);
				$temp->execute();
			}
			$db->close();
		}
	}

	public function find_qeid($qeid){
		$db = new sqlite3($this->db_name);
		$db->busyTimeout(10000);
		$sql = "select qeid from items where qeid = '{$qeid}'";
		if($db->querySingle($sql)){
			$db->close();
			return false;
		}else{
			$db->close();
			return true;
		}
	}
}
?>