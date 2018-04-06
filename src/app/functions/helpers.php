<?php


function dd($dump) {
	var_dump($dump);
	die();
}

function base_url() {
	$proto = strtolower(preg_replace("/[^a-zA-Z\s]/", '', $_SERVER["SERVER_PROTOCOL"]));
	$serve_name = $_SERVER["SERVER_NAME"];
	$port =$_SERVER["SERVER_PORT"] == "80" ? "" : ":".$_SERVER["SERVER_PORT"];
	$scriptname = str_replace("/index.php", "", $_SERVER["SCRIPT_NAME"]);
	return "{$proto}://{$serve_name}{$port}{$scriptname}";
}