<?php
require_once("../config.php");

$m = tgparseinput();
if(!$m) httpdie(400, "1");

if(isset($m['text'])){
    $text = $m['text'];
    if(strpos(strtolower($text), '/start') === 0){
        $db = DbConfig::getConnection();
        tgstart("Hi! Check out <a href='http://www.graphviz.org/Documentation.php'>For the dot notation</a>",$m, $db, $token);
    }
}
else if(isset($m['query']) && strlen($m['query'])>0 ){
	$g = create_graph($m['id'], $m['query']);
	if(!$g) return;
	$pic = "$web_url/images/$g[1]";
	$thu = "$web_url/images/$g[1]";
	tganswerinlinepic($m['id'], $g[0], $pic, $thu,$g[2],$g[3],$token);	
}

function create_graph($id, $txt){
	$aid = md5($id.$txt);
   	$outint = "$aid.jpg";
	$out = "../images/$outint"; 
	$src = "../images/$aid.gv";
	if(!file_put_contents($src, "digraph g { $txt }")) return;
	
    $command = " dot -Tjpg -o $out $src";
    $output  = array();
    $result  = 0;
    exec($command, $output, $result);
	if($result>0) return NULL;
	list($w,$h) = getimagesize($out);
	return [
	$aid,$outint,(int)$w,(int)$h
	];
}
