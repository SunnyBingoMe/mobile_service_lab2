<?php 
session_start();
?><?php 

require_once 'database_connection.php';
require_once 'sunny_function.php';

?><?php 
$command = getRawPostString();
appendFile("log.txt", "\n" . $command . "\n");
$commandSplited = explode("(", $command);
$commandSplited[1] = substr($commandSplited[1], 0, strlen($commandSplited[1]) - 1);
$commandDetailsSplited = explode(",", $commandSplited[1]);
$updateId = $commandDetailsSplited[0];
$newName = $commandDetailsSplited[1];
$newText = $commandDetailsSplited[2];
$newTime = $commandDetailsSplited[3];
$newPriority = $commandDetailsSplited[4];

$newTimeSplited = explode(" ", $newTime);
$newTimeSplitedMDY = explode("/", $newTimeSplited[0]);
$newTime = "$newTimeSplitedMDY[2]-$newTimeSplitedMDY[0]-$newTimeSplitedMDY[1] $newTimeSplited[1]";


$query = "UPDATE $toDoTable SET $toDoTableColumnNameList[1] = '$newName', $toDoTableColumnNameList[2] = '$newText', $toDoTableColumnNameList[3] = '$newTime', $toDoTableColumnNameList[4] = $newPriority WHERE $toDoTableColumnNameList[0] = $updateId ; ";
debugOk($query);
mysql_query($query,$session) or die("-1");

$stringToEcho = $updateId;

echo $stringToEcho;
appendFile("log.txt", $stringToEcho . "\n");
