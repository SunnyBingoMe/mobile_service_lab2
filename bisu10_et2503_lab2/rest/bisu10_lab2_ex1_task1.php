<?php 
session_start();
?><?php 

require_once 'database_connection.php';
require_once 'sunny_function.php';

?><?php 
$command = $_POST['command'];
appendFile("log.txt", "\n" . $command . "\n");
$commandSplited = explode("(", $command);
if ($commandSplited[0] != "create"){
    //echo "not create";
    exit;
}
$commandSplited[1] = substr($commandSplited[1], 0, strlen($commandSplited[1]) - 1);
$commandDetailsSplited = explode(",", $commandSplited[1]);
$newName = $commandDetailsSplited[0];
$newText = $commandDetailsSplited[1];
$newTime = $commandDetailsSplited[2];
$newPriority = $commandDetailsSplited[3];

$newTimeSplited = explode(" ", $newTime);
$newTimeSplitedMDY = explode("/", $newTimeSplited[0]);
$newTime = "$newTimeSplitedMDY[2]-$newTimeSplitedMDY[0]-$newTimeSplitedMDY[1] $newTimeSplited[1]";


$query = "INSERT INTO $toDoTable VALUES (NULL,'$newName','$newText','$newTime','$newPriority' ); ";
debugOk($query);
mysql_query($query,$session) or die("-1");

?><?php 
$query = "SELECT * FROM $toDoTable WHERE $toDoTableColumnNameList[1] = '$newName' ORDER BY `$toDoTableColumnNameList[0]` DESC ; ";
$recordList = mysql_query($query,$session) or die("ERR: <b>$query</b>: ".mysql_error());

if($record = mysql_fetch_array($recordList)){
	$stringToEcho =  $record[0];
}

echo $stringToEcho;
appendFile("log.txt", $stringToEcho . "\n");
