<?php 
session_start();
?><?php 

require_once 'database_connection.php';
require_once 'sunny_function.php';

?><?php 
$command = $_POST['command'];
appendFile("log.txt", "\n" . $command . "\n");
$commandSplited = explode("(", $command); //delete
// omit if
$commandSplited[1] = substr($commandSplited[1], 0, strlen($commandSplited[1]) - 1);
$commandDetailsSplited = explode(",", $commandSplited[1]);

$id = $commandDetailsSplited[0];
$query = "DELETE FROM $toDoTable WHERE $toDoTableColumnNameList[0] = '$id' ; ";
debug($query);
$recordList = mysql_query($query,$session) or die("ERR: <b>$query</b>: ".mysql_error());
?><?php 
$query = "SELECT * FROM $toDoTable WHERE $toDoTableColumnNameList[0] = '$id' ; ";
$recordList = mysql_query($query,$session) or die("ERR: <b>$query</b>: ".mysql_error());

if( mysql_num_rows($recordList) ){
	$stringToEcho = "-1";
}else {
	$stringToEcho = "$id";
}

echo $stringToEcho;
appendFile("log.txt", $stringToEcho . "\n");
