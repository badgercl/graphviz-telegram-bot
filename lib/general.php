<?php
function httpdie($code, $msg){
	http_response_code($code);
	die($msg);
}
