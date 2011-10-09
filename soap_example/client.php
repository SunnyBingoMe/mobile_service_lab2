<pre>
<?php 
ini_set("soap.wsdl_cache_enabled", "0");
try {
	$client = new SoapClient("scramble.wsdl");
}catch (Exception $e){
	echo $e->getMessage();
}

$origtext = "mississippi\n";
print("The original text : $origtext \n");
$scramble = $client->getRot13($origtext);

print("The scrambled text : $scramble \n");

$mirror = $client->getMirror($scramble);
print("The mirrored text : $mirror \n");
?>
</pre>