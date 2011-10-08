<pre>
<?php 
ini_set("soap.wsdl_cache_enabled", "0");
try {
	$client = new SoapClient("todo.wsdl");
}catch (Exception $e){
	echo $e->getMessage();
}

$dateTime = new DateTime();
$dateTimeString = $dateTime->format('Y-m-d H:i:s');
$commandDetails = "bisu10, $dateTimeString, test note, 3";
print("details: $commandDetails \n <br/>");
try {
    $resultGetTodoList = $client->createTodo($commandDetails);
}catch (Exception $e){
    echo "Err ".$e->getCode().": ".$e->getMessage();
}

echo $resultGetTodoList;

?>

</pre>
