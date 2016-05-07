<?php
// 2016/04/30 9:36:58 
// 例
// http://www.dodofei.com/qn.php?q=11158789006	複数の答え
// http://www.dodofei.com/q.php?q=11158806151
// http://www.dodofei.com/qn.php?q=11158772306	ベストアンサー



date_default_timezone_set('Asia/Tokyo');
if($_SERVER['HTTP_HOST'] != '192.168.11.10'){
	include_once('C:\htdocs\doc\acclog.php');
}

class new_qie{
	public $question_id;
	public $qie_item;
	public $db_name = 'C:\htdocs\doc\xshop2\qie.db';

	public function answer(){
		// 知恵袋上の回答
		if(!$this->qie_item->Message){
			if($this->qie_item->Result->BestAnswerContent){
				// echo 'bestanswer';
				return $this->qie_item->Result->BestAnswerContent;
			}
			$temp = array();
			foreach($this->qie_item->Result->AnswerList->Answer as $val){
				$temp[] = urldecode($val->Content);
			}
			return $temp;
		}else{

			// echo '質問が無いため、ここに何か問題リストを作成します。';
			return false;
		}	
	}

	public function content(){
		// 知恵袋の本問題
		return $this->qie_item->Result->Content;
	}

	public function local_db_anawer($link_up){
// 2016/05/05 18:28:32
		// ローカルに投稿した回答
		$db = new sqlite3($this->db_name);
		$db->busyTimeout(10000);
		$temp = $db->prepare('select * from comment where link_up = :a AND active = \'0\' order by c_date desc');
		$temp->bindValue(':a', $link_up , SQLITE3_TEXT);
		$temp2 = $temp->execute();
		$data = array();
		while($val = $temp2->fetchArray(SQLITE3_ASSOC) ){
			$data[] = $val;
		}
		$db->close();
		return $data;
	}


	public function local_db(){
		// サーバーに記録した本問題
		$db = new sqlite3($this->db_name);
		$db->busyTimeout(10000);
		$temp = $db->prepare('select * from items where qeid = :a');
		$temp->bindValue(':a',$this->question_id,SQLITE3_TEXT);
		$temp2 = $temp->execute();
		$val = $temp2->fetchArray(SQLITE3_ASSOC);
		return $val;
	}

	public function qieid($qid){
		// 知恵袋のAPIプログラム
		$this->question_id = $qid;
		$this->qieurl['a']='http://www.dodofei.com/aq.php?q='.$qid;
		$this->qieurl['b']='http://www.dodofei.com/q.php?q='.$qid;
		$this->QuestionId = $qid;
		$confs=0;
		do{
				$requestURL = 'http://chiebukuro.yahooapis.jp/Chiebukuro/V1/detailSearch?';
				$aids = array('dj0zaiZpPXVUTThlTks2dklTbCZkPVlXazljek5STVZCaE4yY21jR285TUEtLSZzPWNvbnN1bWVyc2VjcmV0Jng9ZDc-',
							   'dj0zaiZpPUEzYW1rNjE3NGMxcSZzPWNvbnN1bWVyc2VjcmV0Jng9OTA-',
							   'RPY9gGexg64j_ZEhK55_EXci3ngjKGGnPHv5NwVFrm0wh0Gr7b3YuDy7XQwwLE.X',
							   'EtSiY_qxg65bU40Gb9mZTm3iJBao3u44LKppHGczZByAKUOyb9g9IdNNx_pkuvCr');
				$para['appid'] = $aids[array_rand($aids)];
				$para['question_id'] = $qid;
				$para['results'] = '10';
				$para['image_type'] = '1';
			
				$xmlurl = $requestURL.http_build_query($para);
				$this->qie_item = @simplexml_load_file($xmlurl,$class_name = "SimpleXMLElement",LIBXML_NOCDATA);
				$confs++;
					if ($confs == 10){
						$this->error='error';
						break;
					}
		} while ($this->qie_item == null);
				// echo '<pre>';						/////
				// echo print_r($this->qie_item);	
				// echo json_encode($this->qie_item);	/////
		// DEBUG
		// echo '<pre>';
		// print_r($this->qie_item);
		if (!empty($this->qie_item->Message)){
			$this->error='error';
		}
	}
}


$sps4=<<<EOD
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Gene_cc -->
<ins class="adsbygoogle"
style="display:inline-block;width:300px;height:250px"
data-ad-client="ca-pub-0547405774182700"
data-ad-slot="5057346461"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
EOD;


$sps5=<<<EOD
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Gene_cc2 -->
<ins class="adsbygoogle"
style="display:inline-block;width:320px;height:100px"
data-ad-client="ca-pub-0547405774182700"
data-ad-slot="7354110468"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
EOD;


$sps6=<<<EOD
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- q.php.new -->
<ins class="adsbygoogle"
style="display:block"
data-ad-client="ca-pub-0547405774182700"
data-ad-slot="1166257660"
data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
EOD;

$sps7=<<<EOD
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({
google_ad_client: "ca-pub-0547405774182700",
enable_page_level_ads: true
});
</script>
EOD;


if ($_SERVER['REMOTE_ADDR'] == '220.1.8.32' ){
	//指定IP 広告無表示
	//echo $_SERVER['REMOTE_ADDR'];
	$sps4 = '';
	$sps5 = '';
	$sps6 = '';
	$sps7 = '';
	$sps8 = '';
}

if ($_SERVER['REMOTE_ADDR'] != '220.1.8.32'){
    include_once("analyticstracking.php");
}

?>
<?php
// html ページ部分
	include_once('C:\htdocs\doc\xshop2\sqlite3.php');
	$xxx = new sql3;
	$x = new new_qie;
		// echo '<pre>';
		if(array_key_exists('q',$_REQUEST)){
			$x->qieid($_GET['q']);
			$xxx -> insert ($_GET['q'],mb_substr($x->content()['b'],0,80,"utf-8"));
			// print_r($x->content()[0]);
			// echo '<br>';
			// print_r($x->local_db());
			// echo '<br>';
			// $x->answer();
			// echo '<br>';
		}else{
			exit();
		}

echo '<!DOCTYPE html>';
echo '<head>';
echo $sps7;
echo '<meta charset="utf-8">';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

// 画面サイズをチャックし、CSSを適応
if(stristr($_SERVER['HTTP_USER_AGENT'],'Mobile')){
	echo '<link rel="stylesheet" type="text/css" href="qiev2.css" media="screen,all" />';
}else{
	echo '<link rel="stylesheet" type="text/css" href="qiev2.css" media="screen,all" />';
	// echo 'disktop';
}



$temp = mb_substr($x->content()['0'],0,64,"utf-8");
echo "<title>{$temp}</title>";
echo "<meta name=\"description\" content=\"{$temp}\">";
//echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0" />';
echo '<meta name="viewport" content="initial-scale=1, maximum-scale=1">';
echo '<script src=".\xshop2\qiev2.js" type="text/javascript" charset="utf-8"></script>';
echo '</head>';
echo '<body>';
echo '<div id = "main">';
	if($x->local_db()){
		// Localに記載した場合。
		echo '<div id = "type1">';
			echo '<div id ="page_top_title" class ="page_top_footerpr_color">';
			echo '<p>詳細内容</p>';
			echo '</div>';

			// 詳細内容エリア
			$tt = str_replace("\n",'<br>',$x->local_db()['title']);
			echo "<div id = \"title_txt\" link_my = \"{$x->local_db()['link_my']}\">";
				if($x->content()){
					echo "<p>{$tt}</p>";
				}else{
					echo "<p>{$tt}<br>...</p>";
				}
			echo '</div>'; 	// "<div id = \"title_txt\" link_my = \"{$x->local_db()['link_my']}\">";

			// ここだけの話し編集エリア
			echo '<div id = "local_cmd">';
			echo '<div class="local_icon_img"><img src="./xshop2/90.png"></div>';
			echo '<textarea id ="textarea" name="xxxxx"></textarea>';
			echo '</div>';	// '<div id = "local_cmd">';
			echo '<div id = "help">';
			echo '<p>#投稿はリツイートしません。</p>';
			echo '<p>#画面をリフレッシュ後に削除できます。</p>';
			echo '</div>';
			

			// ここだけの話し編集エリア 送信ボタン
			echo '<div id = "reg_text">';
				echo '<input type="button" id = "reg_button" name="xxxxx" value=" 回答投稿 ">';
			echo '</div>'; //'<div id = "reg_text">';

			// アドセスエリア
			echo '<div id = "adse_5">';
				echo $sps5;
			echo '</div>'; //'<div id = "adse_1">'

			// 回答エリア
			echo '<div id = "answer_texts">';

				$i=2;
			// ここだけの回答表示エリア
				foreach($x->local_db_anawer($x->local_db()['link_my']) as $val){
						$i++;
						if($i%2 ==1){
							$color_type =  'color_1';
						}else{
							$color_type =  'color_2';
						}
					echo "<div class = \"an_items {$color_type}\">";
						echo '<div class="an_icon_img"><img src="./xshop2/90.png"></div>';
						echo "<div class=\"an_list\" link_my = \"{$val['link_my']}\">";
							echo str_replace("\n", '<br>', urldecode($val['comment']));
						if($_SERVER['REMOTE_ADDR'] == $val['user_ip']){
							echo "<div class = \"del_my\" link_my = \"{$val['link_my']}\"><p>[削除]</p></div>";
						}
						echo '</div>';
					echo '</div>';
				}

// 広告スベース
			// echo '<div id = "adse_6">';
			// 	echo $sps6;
			// echo '</div>'; //'<div id = "adse_6">'
			// echo '<div id = "adse_4">';
			// 	echo $sps4;
			// echo '</div>'; //'<div id = "adse_4">'


			// 知恵袋上の回答
			if($x->answer()){
				// print_r($x->answer());
				foreach($x->answer() as $val){
						$i++;
						if($i%2 ==1){
							$color_type =  'color_1';
						}else{
							$color_type =  'color_2';
						}
					echo "<div class = \"an_items {$color_type}\">";
						echo '<div class="an_icon_img"><img src="./xshop2/90.png"></div>';
						echo '<div class="an_list">';
						echo str_replace("\n",'<br>',$val);
						echo '</div>';
					echo '</div>';  //"<div class = \"an_items {$color_type}\">";
				}
			}




			echo '</div>';
		echo '</div>';
	}else{

// type2 Local に記載されていない場合
// http://www.dodofei.com/qn.php?q=14130992844  削除された例 Localの記録がない
// http://www.dodofei.com/qn.php?q=14150683159  localに記録されていない例
// http://www.dodofei.com/qn.php?q=10159034205	Local記録あり、サーバーから削除された例
		echo '<div id = "type2">';
			echo '<div id ="page_top_title" class ="page_top_footerpr_color">';
			echo '<p>詳細の内容</p>';
			echo '</div>';

			// タイトル 
			if($x->content()){
				$tt = str_replace("\n",'<br>',$x->content());
				echo "<div id = \"title_txt\" link_my = \"{$x->local_db()['link_my']}\">";
					echo "<p>{$tt}<br>(-_-)<br>Server_only</p>";
				echo '</div>'; 	// "<div id = \"title_txt\" link_my = \"{$x->local_db()['link_my']}\">";
			}else{
				echo '<div id = "top5_area">';
					echo '<div class="top5_link">';
					echo '<p>この質問の詳細内容は表示することできません、別の質問をご連ください</p>';
					echo '</div>';
					foreach ($xxx->top5() as $key=>$val){
						echo '<div class="top5_link">';
						echo '<p class="hb">';
						echo sprintf('<a href="http://www.dodofei.com/q.php?q=%s" rel="nofollow">%s</a>',$key,$val);
						echo '</p>';
						echo '</div>';	//ans
					}
				echo '</div>';  //'<div id = "top5_area">'
			}

			$i=2;
			// 知恵袋上の回答
			if($x->answer()){
				// print_r($x->answer());
				foreach($x->answer() as $val){
						$i++;
						if($i%2 ==1){
							$color_type =  'color_1';
						}else{
							$color_type =  'color_2';
						}
					echo "<div class = \"an_items {$color_type}\">";
						echo '<div class="an_icon_img"><img src="./xshop2/90.png"></div>';
						echo '<div class="an_list">';
						echo str_replace("\n",'<br>',$val);
						echo '</div>';
					echo '</div>';  //"<div class = \"an_items {$color_type}\">";
				}
			}


		echo '</div>';
	}	// end type2;

		echo '<div id = "adsense_foot">';
		echo $sps4;
		echo '</div>'; 	'<div id = "adsense_foot">';
	echo '<div id = "page_footerpr_title" class ="page_top_footerpr_color">';
		echo '<p>Twitter Platform</p>';
	echo '<!-- Begin Yahoo! JAPAN Web Services Attribution Snippet -->';
	echo '<a href="http://developer.yahoo.co.jp/about" rel="nofollow">';
	echo '<img src="http://i.yimg.jp/images/yjdn/yjdn_attbtn2_105_17.gif" title="Webサービス by Yahoo! JAPAN" alt="Webサービス by Yahoo! JAPAN"></a>';
	echo '<!-- End Yahoo! JAPAN Web Services Attribution Snippet -->';
	echo '</div>'; // '<div id = "page_footerpr_title" class ="page_top_footerpr_color">';
echo '</div>';	// '<div id = "main">';
echo '</body>';
echo '</html>';


?>