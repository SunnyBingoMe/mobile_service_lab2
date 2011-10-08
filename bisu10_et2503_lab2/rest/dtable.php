<?php 
session_start();
?><?php 

require_once 'database_connection.php';
require_once 'sunny_function.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>To Do</title>
	<?php require_once 'jquery/require_in_head.php'; ?>
	<?php require_once 'date_time_picker/require_in_head.php'; ?>
	<script type="text/javascript" src="http://sunnyboy.me/personal/ga.js"></script>
	<script type="text/javascript">
		function readToDoList()
		{
			var xmlhttp;
			xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
			{
				if ( xmlhttp.readyState==4 && xmlhttp.status==200){
					//document.getElementById("listContent").innerHTML=xmlhttp.responseText;
					$("#tableHead").after(xmlhttp.responseText);
				}
			};
			xmlhttp.open("GET","bisu10_lab2_ex1_task2.php",true);
			xmlhttp.send();
		};
	</script>
</head>
<center>

<table border = '0'>
<tr><th colspan='6'>To Do List <button onClick='readToDoList()'>load</button></th></tr>
<tr id='tableHead'>
	<?php 
	foreach ($toDoTableColumnNameList as $columnName){
		echo "<th>$columnName</th>";
	}
	echo "<th>delete</th>";
	?>
</tr>
<!-- div id='listContent'></div> -->
<tr><td colspan='6'>Total number of ToDo records: <?php //echo "$i"?></td></tr>
</table>

<hr />

<table border = "0" >
<tr><th colspan="2">Add New ToDo</th></tr>
<?php echo "<tr><td>".$toDoTableColumnNameList[1]."</td><td><input type='text' name='$toDoTableColumnNameList[1]' maxlength='45' /></td></tr>" ?>
<?php echo "<tr><td>".$toDoTableColumnNameList[2]."</td><td><textarea type='textarea' name='$toDoTableColumnNameList[2]' maxlength='495' ></textarea></td></tr>" ?>
<?php echo "<tr><td>".$toDoTableColumnNameList[3]."</td><td><input type='text' id='$toDoTableColumnNameList[3]' readonly='readonly' name='$toDoTableColumnNameList[3]' maxlength='40'/></td></tr>" ?>
<?php 
	$aOptionLabelPairList = array("1","2","3","4","5");
	echo "<tr><td align='center'>".$toDoTableColumnNameList[4]."</td><td>";
	input_select("priority", NULL, $aOptionLabelPairList);
	echo "</td></tr>";
	echo "<tr><td colspan='2' align='center'><center><button onClick='addEntry()'>add</button></center></td></tr>";
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


</center>

</html>