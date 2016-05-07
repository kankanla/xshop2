

window.addEventListener('load', t_size, false);
window.addEventListener('load', t_events, false);
window.addEventListener('load', reg_button, false);
window.addEventListener('load', del_my_comment, false);


function t_size(){
	var j = document.getElementById("textarea");
	j.style.width = screen.availWidth-50 + 'px';
	j.style.height = "50px";
}

function t_events(){
	var j = document.getElementById("textarea");
	j.addEventListener('click', function(){
		j.style.height = screen.availHeight /3 + 'px';
	}, false);

	j.addEventListener('blur', function(){
		if(j.value ==""){
			j.style.height = "50px";
		}
	}, true);
}

function reg_button(){
	// コマンド書き込み送信ボタン
	var j = document.getElementById("reg_button");
	j.addEventListener("click", function(){
		var t =  fn_replace(document.getElementById("textarea").value);
		var link_up = document.getElementById("title_txt").getAttribute("link_my");

		if(t !== '' && link_up !== ''){
			send_ajax(JSON.stringify({link_my:link_up, comment:t}),'66');
		}else{
			alert('回答内容を入力してください。');
		}
	},false);
}

function del_my_comment(){
	// 書き込んだコメントを削除します
	var j = document.getElementsByClassName('del_my');
	for(var i = 0 ; i < j.length; i++){
		j[i].firstElementChild.addEventListener('click', function (){
			// console.log(this.parentElement.getAttribute('link_my'));
			send_ajax(JSON.stringify({link_my:this.parentElement.getAttribute('link_my')}),99);
			this.parentElement.parentElement.parentElement.style.display = 'none';

		}, false);
	}
}




function send_ajax(j,rand){
	var ajax = new XMLHttpRequest();
	var url = '../xshop2/qie_local_comment.php?rand='+ rand;
	var send_data = encodeURIComponent(j);
	ajax.onreadystatechange = function (){
		if(ajax.readyState == 4 && ajax.status == 200){
			// console.info(ajax.responseText);
			if(rand == '66'){
				page_show_comment(JSON.parse(ajax.responseText));
			}
			if(rand == '99'){
				// console.log(ajax.responseText);
				// alert('削除済み');
			}
		}
	}

	ajax.open('POST',url,true);
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send('a='+ send_data);
}


function page_show_comment(e){
	// 書き込んだコメントを表示します。
	console.log(e);
	var t = document.getElementById('answer_texts');
	var c1 = document.createElement('div');
		c1.setAttribute('class', 'an_items color_2');

	var c2 = document.createElement('div');
		c2.setAttribute('class', 'an_icon_img');

	var c3 = document.createElement('img');
		c3.setAttribute('src', './xshop2/90.png');

	var c4 = document.createElement('div');
		c4.setAttribute('class', 'an_list');
		c4.setAttribute('link_my', e['link_my']);
		c4.innerHTML = decodeURIComponent(e['comment']);

	c1.appendChild(c2);
	c2.appendChild(c3);
	c1.appendChild(c4);
	t.insertBefore(c1, t.firstChild);

	document.getElementById("textarea").style.height = "50px";
	document.getElementById("textarea").value = "";
}


function fn_replace(q){
	var x = {'\&'	:	'%26', 
			 '\"'	:	'%22',
			 '\''	:	'%27%27',
			 ' '	:	'%20',
			 '\n'	:	'%0d%0a'
			 };
	for(var i in x){
		q= q.replace(RegExp(i,'g'),x[i]);
	}
	return q;
}