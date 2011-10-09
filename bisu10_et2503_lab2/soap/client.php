<?php 
require_once 'sunny_function.php';
require_once 'database_connection.php';
?>
<!DOCTYPE pre PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>ToDo</title>
	<?php require_once 'jquery/require_in_head.php'; ?>
	<?php require_once 'date_time_picker/require_in_head.php'; ?>
	<script type="text/javascript" src="http://sunnyboy.me/personal/ga.js"></script>
	<script type="text/javascript" src="sunny_function.js"></script>
</head>

<body>

<center>

<form action="" method="post">
<table border = '0' align="center">
<tr><th colspan='7'>ToDo List (<button type="submit">load</button> by name: <input value='<?php echo (isset($_POST['filterName']) ? $_POST['filterName'] : "bisu10" )  ?>' name='filterName' id='filterName' type="text" maxlength='45'></input>)</th></tr>
<tr id='tableHead'>
	<th>id</th>
	<th>name</th>
	<th>text</th>
	<th>time</th>
	<th>priority</th>
	<th>delete</th>
	<th>edit below</th>
</tr>
    <?php 
    ini_set("soap.wsdl_cache_enabled", "0");
    try {
    	$client = new SoapClient("todo.wsdl");
    }catch (Exception $e){
    	echo $e->getMessage();
    }
    
    if (isset($_POST['filterName'])){
        $commandDetails = $_POST['filterName'];
    }else {
        $commandDetails = 'bisu10';
    }
    debugOk("The get: $commandDetails \n");
    try {
        $resultGetTodoList = get_object_vars($client->getTodoList($commandDetails));
    }catch (Exception $e){
        echo "err ".$e->getCode().": ".$e->getMessage().$e->getTraceAsString();
    }
    debugOk($resultGetTodoList);
    
    $resultGetTodoList = $resultGetTodoList['TodoData'];
    
    $lineNr = 0;
    foreach ($resultGetTodoList as $todo){
        $todo = get_object_vars($todo);
        ?>
        
        <tr align="center" bgcolor='<?php echo (($lineNr % 2) ? '' : 'lavender') ?>' >
        	<td><?php echo $todo['id']?></td>
        	<td>bisu10</td>
        	<td><?php echo $todo['note']?></td>
        	<td><?php echo $todo['date']?></td>
        	<td><?php echo $todo['prio']?></td>
        	<td></td>
        	<td></td>
        </tr>
        <?php 
        $lineNr ++;
    }
    
    ?>

<!-- here is the ToDo entrys -->
<tr><td id='toDoNr' colspan='7'></td></tr>
</table>
</form>


<hr />


<table border = "0" >
<tr id='addOrUpdateFormTableHead' ><th colspan="2">Add/Update ToDo</th></tr>
<?php echo "<tr><td>".$toDoTableColumnNameList[1]."</td><td><input type='text' id='$toDoTableColumnNameList[1]' value='bisu10' maxlength='45' /></td></tr>" ?>
<?php echo "<tr><td>".$toDoTableColumnNameList[2]."</td><td ><textarea type='textarea' id='$toDoTableColumnNameList[2]' maxlength='495' ></textarea></td></tr>" ?>
<?php echo "<tr><td>".$toDoTableColumnNameList[3]."</td><td ><input type='text' id='$toDoTableColumnNameList[3]' readonly='readonly' maxlength='40'/></td></tr>" ?>
<?php 
	$aOptionLabelPairList = array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5");
	echo "<tr ><td align='center'>".$toDoTableColumnNameList[4]."</td><td>";
	input_select("$toDoTableColumnNameList[4]", NULL, $aOptionLabelPairList, NULL, "$toDoTableColumnNameList[4]");
	echo "</td></tr>";
	echo "<tr><td colspan='2' align='center'><center><button id='buttonAddOrUpdateEntry' onClick='addOrUpdateEntry()'>add</button></center></td></tr>";
?>
</table>

<script type="text/javascript" >
	$("<?php echo '#'.$toDoTableColumnNameList[3] ?>").datetimepicker({
		showSecond: false,
		timeFormat: 'hh:mm:ss',
		stepHour: 0.1,
		stepMinute: 0.1,
		stepSecond: 0.1
	});
</script>


</center></body>

</html>