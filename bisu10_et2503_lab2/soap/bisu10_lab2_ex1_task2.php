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
print("The get: $origtext \n");
try {
    $resultGetTodoList = $client->getTodoList($commandDetails);
}catch (Exception $e){
    echo "err ".$e->getCode().": ".$e->getMessage().$e->getTraceAsString();
}

echo $resultGetTodoList;

?>

</pre>
