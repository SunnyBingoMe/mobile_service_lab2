<?php 
function getTodoList($input){
	$output =  "get to do";
	return($output);
}

function createTodo($input){
	$output = "create todo";
	return($output);
}

// turn off the wsdl cache
ini_set("soap.wsdl_cache_enabled", "0");

$server = new SoapServer("todo.wsdl");

$server->addFunction("getTodoList");
$server->addFunction("createTodo");

$server->handle();
