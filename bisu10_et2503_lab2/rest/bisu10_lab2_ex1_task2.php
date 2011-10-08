<?php 
session_start();



require_once 'database_connection.php';
require_once 'sunny_function.php';


$command = $_GET['command'];
appendFile("log.txt", "\n" . $command . "\n");
shell_exec("'$command' >> log.txt");
$commandSplited = explode("(", $command); //delete
// omit if
$commandSplited[1] = substr($commandSplited[1], 0, strlen($commandSplited[1]) - 1);
$commandDetailsSplited = explode(",", $commandSplited[1]);

$filterName = $commandDetailsSplited[0];
$query = "SELECT * FROM $toDoTable WHERE $toDoTableColumnNameList[1] = '$filterName' ORDER BY `$toDoTableColumnNameList[3]` DESC ; ";
$recordList = mysql_query($query,$session) or die("ERR: <b>$query</b>: ".mysql_error());

$stringToEcho = "";
$stringToEcho .= "(";
$i = 0;
while($record = mysql_fetch_array($recordList)){
	$i++;
	if ($i >= 2) {
		$stringToEcho .= ", ";
	}
	$time = date_parse($record[3]);
	$timeString = "($time[year], $time[month], $time[day], $time[hour], $time[minute])";
	$stringToEcho .= "($record[0]L, '$record[2]', '$record[4]', datetime.datetime{$timeString})";
}
$stringToEcho .= ")";
echo $stringToEcho;
appendFile("log.txt", $stringToEcho . "\n");
