<?php
// error_reporting(0);
date_default_timezone_set('Asia/Tokyo');
// error_reporting(0);
include_once('into_qie_db.php');
include_once('C:\htdocs\doc\acclog.php');
/* 
 *  [oauth_token] => 1453928912-05D7JSAISmqn6Oi9tEDwYxsmdKf2x1xFeNAG0dK
 *  [oauth_token_secret] => ll0C33vVbYglaWOYl9lkgqsOt7ShgSYgWTAwxnyU3xEE9
 *  [user_id] => 1453928912
 *  [screen_name] => Xshop2
 * 
 * 新着質問リスト取得API
 * http://developer.yahoo.co.jp/webapi/chiebukuro/chiebukuro/v1/getnewquestionlist.html
 * http://list.chiebukuro.yahoo.co.jp/dir/dir_list.php
 * 2078297514	ゲーム   
 * 2078523512	おもちゃ、ホビー
 * 
 * 
 */

 $x=new getNewQuestionList();
 $x->xml();
 
 class getNewQuestionList{
	
	public $re_url;
	
	public function getNewQuestionList(){
		$apiurl='http://chiebukuro.yahooapis.jp/Chiebukuro/V1/getNewQuestionList';
		//$para['appid']='dj0zaiZpPXVUTThlTks2dklTbCZkPVlXazljek5STVZCaE4yY21jR285TUEtLSZzPWNvbnN1bWVyc2VjcmV0Jng9ZDc-'; //gene_cc
		$para['appid']='dj0zaiZpPUEzYW1rNjE3NGMxcSZzPWNvbnN1bWVyc2VjcmV0Jng9OTA-';	//xshop2
		$para['condition']='open';
		$para['sort']='-updateddate';
		$para['category_id']='2078297514';
		$para['start']='';
		$para['results']='1';
		$para['mobile_flg']='';
		$para['image_flg']='';
		$para['output']='json';
		$paraurl=http_build_query($para);
		$this->re_url=$apiurl.'?'.$paraurl;
	}
	
	public function xml(){
		
		$urls = array(//'http://loto6.pa.land.to/q.php?q=',
					'http://www.yahoo.com/q.php?q=',
					//'http://asus.sitemix.jp/q.php?q='
					);
		
		$json = json_decode(file_get_contents($this->re_url));
		$qqid = $json->ResultSet->Result[0]->QuestionId;
		$qitm = $json->ResultSet->Result[0]->Content;

		$temp = new insert_qe();
		$temp->title_qie($qqid, mb_strimwidth($qitm,0,3000,',','UTF-8'));

		$qid = $urls[array_rand($urls)].$qqid;
		$data = array(mb_strimwidth($qitm,0,175,',','UTF-8')."...\n\n".$qid);

		if(stristr($json->ResultSet->Result[0]->Content, 'http')){
			exit();
		}
		
		echo json_encode($data);
		exit();
	}
 }
 ?>
