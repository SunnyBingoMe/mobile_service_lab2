<?php require_once 'sunny_function.php';?>
<pre>
<?php 
ini_set("soap.wsdl_cache_enabled", "0");
try {
	$client = new SoapClient("todo.wsdl");
}catch (Exception $e){
	echo $e->getMessage();
}

//$commandDetails = array('acro'=>'bisu10');
$commandDetails = 'bisu10';
debug("The get: $commandDetails \n");
try {
    $resultGetTodoList = get_object_vars($client->getTodoList($commandDetails));
}catch (Exception $e){
    echo "err ".$e->getCode().": ".$e->getMessage().$e->getTraceAsString();
}




debug($resultGetTodoList);

?>

</pre>
