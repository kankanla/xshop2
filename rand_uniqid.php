<?php
// 2016/04/29 22:42:13



class m_rand{

  public $db_name = 'sqlite3_rand.db';
  public $db_length = 11;
  
  public function m_rand(){
         if(!file_exists($this->db_name)){
           $this->create_db();
         }
  }

  public function uniqid(){
         $db = new sqlite3($this->db_name);
         $db->busyTimeout(10000);
         $temp_id = $this->mf_rand();
         $array_shuffle_count = 0;

         do{
            shuffle($temp_id);
            $temp_id_str = implode($temp_id);
            $array_shuffle_count ++;
            $sql_select = "select * from uniqid where uniqids = \"{$temp_id_str}\"";
            // $id_check = $db->querySingle($sql_select,true);
            $id_check = $db->querySingle($sql_select);
          }while($id_check);
      
          $sql_insert = "insert into uniqid(uniqids,shuffle_count)VALUES(\"{$temp_id_str}\",{$array_shuffle_count})";
          $db->exec($sql_insert);
          $db->close();
          
          return $temp_id_str;
      }

  public function mf_rand(){
          $str = array(range('z','a'),range('Z','A'),range('9','0'));
          $length = $this->db_length;
          $str_r =array();
          for ($i=0; $i<$length ;$i++){
              $temp = $str[array_rand($str)];
              $str_r[count($str_r)] = $temp[array_rand($temp)];
            }
          return($str_r); 
  }

  public function create_db(){
          $db = new sqlite3($this->db_name);
          $db->busyTimeout(10000);
          $sql_create = 
                  "create table uniqid(
                  rowid INTEGER PRIMARY KEY AUTOINCREMENT,
                  uniqids text UNIQUE,
                  shuffle_count integer
                )";
          $db->exec($sql_create);
          $db->close();
    }
  }

?>

