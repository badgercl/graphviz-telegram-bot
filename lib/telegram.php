<?php
require_once('db.php');

function tgparseinput(){
	$postData = file_get_contents('php://input');
	if(!isset($postData)) return NULL;
	$json = json_decode($postData, true);
	//error_log($postData);die();
	$m = $json;
	if(isset($json['message'])) $m = $json['message'];
	else if(isset($json['location'])) $m = $json;
	else if(isset($json['inline_query'])) $m = $json['inline_query'];
	return $m;
}

function tgstart($msg, $m, $db, $token){
  $f = $m['from'];
  $uid = $db->real_escape_string($f['id']);
  $first_name = $db->real_escape_string(isset($f['first_name'])?$f['first_name']:"undefined");
  $last_name = $db->real_escape_string(isset($f['last_name'])?$f['last_name']:"undefined");
  $username = $db->real_escape_string(isset($f['username'])?$f['username']:"undefined");
  $language_code = $db->real_escape_string(isset($f['language_code'])?$f['language_code']:"AA");

  $sql = "SELECT * FROM tg_users WHERE uid = '$uid'";
  $res = DbConfig::sql($db, $sql);
  if(count($res)==0){
    $sql = "INSERT INTO tg_users (uid, first_name, last_name, username, language_code) VALUES ('$uid', '$first_name', '$last_name', '$username', '$language_code')";
    if(!DbConfig::update($db, $sql)) {
		error_log($db->error);
		die($db->error);
	}
  }
  else{
    $sql = "UPDATE tg_users SET first_name='$first_name', last_name='$last_name', username='$username', language_code='$language_code' WHERE uid='$uid'";
    if(!DbConfig::update($db, $sql)) echo 'error'.$db->error;
  }
  tgsend_msg($msg, $uid, $token);
}


function tgsend_msg($msg, $uid, $token){
	$msg = urlencode($msg);
	$cmd = "https://api.telegram.org/bot$token/sendMessage?chat_id=$uid&text=$msg&parse_mode=HTML";
	$res = file_get_contents($cmd);
}

function tgrequest_geo($msg, $uid, $token){
	$msg = urlencode($msg);
	$reply_mark = urlencode(json_encode(
		['one_time_keyboard' => TRUE, 
		 'keyboard' => [[ ['text' => 'Enviar localización', 
							'request_location' => TRUE] ]] ]));
	$cmd = "https://api.telegram.org/bot$token/sendMessage?chat_id=$uid&text=$msg&parse_mode=HTML&reply_markup=$reply_mark";
	$res = file_get_contents($cmd);
}

function tgshow_options($msg, $options, $uid, $token){
	if(!is_array($options) || count($options) <= 0) return;
	$reply_mark = [];
	$reply_mark['one_time_keyboard'] = TRUE;
	$reply_mark['keyboard'] = [];
	foreach($options as $o){
		$reply_mark['keyboard'][] = [['text'=>$o]];
	}
	$reply_mark = urlencode(json_encode($reply_mark));
    $cmd = "https://api.telegram.org/bot$token/sendMessage?chat_id=$uid&text=$msg&parse_mode=HTML&reply_markup=$reply_mark";
	$res = file_get_contents($cmd);
}

function tgchat_action($action, $uid, $token){
	$cmd = "https://api.telegram.org/bot$token/sendChatAction?chat_id=$uid&action=$action";
	file_get_contents($cmd);	
}
function tganswerinlinepic($qid, $rid, $pic, $thu, $w, $h,$token){
	$result = [[
	'type'=>'photo',
	'id'=>$rid,
	'photo_url'=>$pic,
	'thumb_url'=>$thu,
	'photo_width'=>$w,
	'photo_height'=>$h
	]];
	//error_log(json_encode($result));
	$results = urlencode(json_encode($result));
	$cmd = "https://api.telegram.org/bot$token/answerInlineQuery?inline_query_id=$qid&results=$results";
	//error_log($cmd);
	$res = file_get_contents($cmd);
	//error_log($res);
}

