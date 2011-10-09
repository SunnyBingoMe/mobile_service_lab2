<?php 
session_start();
?><?php 

require_once 'database_connection.php';
require_once 'sunny_function.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>ToDo</title>
	<?php require_once 'jquery/require_in_head.php'; ?>
	<?php require_once 'date_time_picker/require_in_head.php'; ?>
	<script type="text/javascript" src="http://sunnyboy.me/personal/ga.js"></script>
	<script type="text/javascript" src="sunny_function.js"></script>
	<script type="text/javascript" > //global
	var lastId = 0;
	var lineNr = 0;
	var updateId = 0;
	var tableIsShown = 0;
	function showAsWholeTable(responseContent){
		var taskListContent = responseContent.substr(2, responseContent.length - 4);
		if (taskListContent.length != 0) {
			var taskList = taskListContent.split("), (");
			for (var ltTaskList = 0; ltTaskList <= taskList.length - 1; ltTaskList ++){
				var oneTaskDetailList = taskList[ltTaskList].split(", ");
				oneTaskDetailList[0] = oneTaskDetailList[0].substr(0, oneTaskDetailList[0].length - 1);
				oneTaskDetailList[1] = oneTaskDetailList[1].substr(1, oneTaskDetailList[1].length - 2);
				oneTaskDetailList[2] = oneTaskDetailList[2].substr(1, oneTaskDetailList[2].length - 2);
				oneTaskDetailList[3] = oneTaskDetailList[3].substr(18) + "-" + oneTaskDetailList[4] + "-" + oneTaskDetailList[5] + " " + oneTaskDetailList[6] + ":" + oneTaskDetailList[7].substring(0, oneTaskDetailList[7].length - 1);
				var oneRow = "<tr align='center' class='toDoEntry' id='" + oneTaskDetailList[0] + "' bgcolor='" + ((lineNr % 2) ? '' : 'lavender') + "' >";
				oneRow += "<td id='"+oneTaskDetailList[0]+"_columnId' >" + oneTaskDetailList[0] + "</td>"; //id
				oneRow += "<td id='"+oneTaskDetailList[0]+"_columnName' >" + $("#filterName").val() + "</td>"; //name
				oneRow += "<td id='"+oneTaskDetailList[0]+"_columnText' >" + oneTaskDetailList[1] + "</td>"; //text
				oneRow += "<td id='"+oneTaskDetailList[0]+"_columnTime' >" + oneTaskDetailList[3] + "</td>"; //time
				oneRow += "<td id='"+oneTaskDetailList[0]+"_columnPriority' >" + oneTaskDetailList[2] + "</td>"; //priority
				oneRow += "<td>" + "<button id='button_" + oneTaskDetailList[0] + "' onClick='deleteEntry(" + oneTaskDetailList[0]  + ") '>delete</button>" + "</td>"; //del button
				oneRow += "<td>" + "<button onClick='preUpdate(" + oneTaskDetailList[0] + ")'>update</button>" + "</td>"; //pre update button
				oneRow += "</tr>";
				lastId = oneTaskDetailList[0];
				lineNr += 1;
				$("#tableHead").after(oneRow);
			}
			$("#toDoNr").text("Total number of ToDo records: " + lineNr + ".");
			tableIsShown = 1;
		}
	}
	</script>
	<script type="text/javascript"> //del
		function deleteEntry(idToDelete)
		{
			var nameToDelete = $("#filterName").val();
			changeVisibility("button_" + idToDelete, "N");
			var xmlhttp;
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function()
			{
				if ( xmlhttp.readyState == 4 && xmlhttp.status == 200){
					if (xmlhttp.responseText.length != 0) {
						//alert (xmlhttp.responseText);
						var returnedValue = xmlhttp.responseText.valueOf();
						if (returnedValue != -1){
							$("#"+idToDelete).remove();
							lineNr --;
							$("#toDoNr").text("Total number of ToDo records: " + lineNr + ".");
							changeVisibility("button_" + idToDelete, "Y");
						}
					}
				}
			};
			xmlhttp.open("POST", "bisu10_lab2_ex2_task2.php", true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("delete(" + idToDelete + "," + nameToDelete + ")");
		};
	</script>
	<script type="text/javascript"> //add or update
		function addOrUpdateEntry(){
			changeVisibility("buttonAddOrUpdateEntry","N");
			var xmlhttp;
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function()
			{
				if ( xmlhttp.readyState == 4 && xmlhttp.status == 200){
					if (xmlhttp.responseText.length != 0) {
						if (xmlhttp.responseText != "-1"){
							//showAsWholeTable (xmlhttp.responseText);
							//alert ("lastId=" + lastId);
							//alert (xmlhttp.responseText);
							if (updateId > 0){
								$("#"+updateId).remove();
							}
							if (lastId != 0){
								//alert ("lastId != 0");
								lastId = xmlhttp.responseText.valueOf();
								var oneRow = "<tr align='center' class='toDoEntry' id='" + lastId + "' bgcolor='" + ((lineNr % 2) ? '' : 'lavender') + "' >";
								oneRow += "<td id='"+lastId+"_columnId' >" + lastId + "</td>"; //id
								oneRow += "<td id='"+lastId+"_columnName' >" + new<?php echo $toDoTableColumnNameList[1] ?> + "</td>"; //name
								oneRow += "<td id='"+lastId+"_columnText' >" + new<?php echo $toDoTableColumnNameList[2] ?> + "</td>"; //text
								oneRow += "<td id='"+lastId+"_columnTime' >" + dateTime_slashMmDdYyyy_2_dashYyyyMmDd (new<?php echo $toDoTableColumnNameList[3] ?>.substr(0, 16)) + "</td>"; //time
								oneRow += "<td id='"+lastId+"_columnPriority' >" + new<?php echo $toDoTableColumnNameList[4] ?> + "</td>"; //priority
								oneRow += "<td>" + "<button onClick='delEntry(" + lastId + ")'>delete</button>" + "</td>"; //del button
								oneRow += "<td>" + "<button onClick='preUpdate(" + lastId + ")'>update</button>" + "</td>"; //pre update button
								oneRow += "</tr>";
								lineNr += 1;
								$("#tableHead").after(oneRow);
								$("#toDoNr").text("Total number of ToDo records: " + lineNr + ".");
								changeVisibility("buttonAddOrUpdateEntry","Y");
							}else {
								//alert ("lastId=0");
								readToDoList();
							}
						}else {
							//alert ("-1");
						}
					}else {
						//alert ("len = 0");
					}
				}else {
					//alert ("xmlhttp.readyState = " + xmlhttp.readyState + ", xmlhttp.status = " + xmlhttp.status);
				}
			};
			if (updateId > 0){
				xmlhttp.open("POST","bisu10_lab2_ex2_task1.php",true);
			}else {
				xmlhttp.open("POST","bisu10_lab2_ex1_task1.php",true);
			}
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			var new<?php echo $toDoTableColumnNameList[1] ?> = $("#<?php echo $toDoTableColumnNameList[1] ?>").val();
			var new<?php echo $toDoTableColumnNameList[2] ?> = $("#<?php echo $toDoTableColumnNameList[2] ?>").val();
			var new<?php echo $toDoTableColumnNameList[3] ?> = $("#<?php echo $toDoTableColumnNameList[3] ?>").val();
			var new<?php echo $toDoTableColumnNameList[4] ?> = $("#<?php echo $toDoTableColumnNameList[4] ?>").val();
			var postContent = "";
			if (updateId > 0){
				postContent += "update(" + updateId + ",";
			}else{
				postContent += "create(";
			}
			postContent += new<?php echo $toDoTableColumnNameList[1] ?>;
			postContent += "," + new<?php echo $toDoTableColumnNameList[2] ?>;
			postContent += "," + new<?php echo $toDoTableColumnNameList[3] ?>;
			postContent += "," + new<?php echo $toDoTableColumnNameList[4] ?>;
			postContent += ")";
			//alert (postContent);
			xmlhttp.send(postContent);
		}
	</script>
	<script type="text/javascript"> //pre update
		function preUpdate (id){
			updateId = id;
			
			$("#buttonAddOrUpdateEntry").text("update");
			$("#rowOfUpdateId").remove();
			rowOfUpdateId = "<tr id='rowOfUpdateId' ><td>id to update</td><td><input type='text' id='idToUpdate' value='" + updateId + "' /></td></tr>";
			$("#addOrUpdateFormTableHead").after(rowOfUpdateId);
			$("#name").text($("#"+updateId+"_columnName").text());
			$("#text").text($("#"+updateId+"_columnText").text());
			$("#time").text("");
			$("#priority").attr({value: $("#"+updateId+"_columnPriority").text()});
			
			
    		
		}
	
	</script>
	<script type="text/javascript"> //read
		function readToDoList()
		{
			$(".toDoEntry").remove();
			lastId = 0;
			lineNr = 0;
			var xmlhttp;
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function()
			{
				if ( xmlhttp.readyState == 4 && xmlhttp.status == 200){
					if (xmlhttp.responseText.length != 0) {
						//alert (xmlhttp.responseText);
						showAsWholeTable (xmlhttp.responseText);
						changeVisibility("buttonAddOrUpdateEntry","Y");
					}
				}
			};
			var filterName = $("#filterName").val();
			xmlhttp.open("GET", "bisu10_lab2_ex1_task2.php?read(" + filterName + ")", true);
			xmlhttp.send();
		};
	</script>
</head>
<center>

<table border = '0'>
<tr><th colspan='7'>ToDo List (<button onClick='readToDoList()'>load</button> by name: <input value='bisu10' id='filterName' type="text" maxlength='45'></input>)</th></tr>
<tr id='tableHead'>
	<?php 
	foreach ($toDoTableColumnNameList as $columnName){
		echo "<th>$columnName</th>";
	}
	?>
	<th>delete</th>
	<th>edit below</th>
	
</tr>
<!-- here is the ToDo entrys -->
<tr><td id='toDoNr' colspan='7'></td></tr>
</table>

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


</center>

</html>