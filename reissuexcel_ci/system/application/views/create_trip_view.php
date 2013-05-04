<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"><title>reissuexceli</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/styles.css">

<script language="Javascript" type="text/javascript">
<!--
//Add more fields dynamically.
function addField(area,field,limit) {
if(!document.getElementById) return; //Prevent older browsers from getting any further.
var field_area = document.getElementById(area);
var all_inputs = field_area.getElementsByTagName("input"); //Get all the input fields in the given area.
//Find the count of the last element of the list. It will be in the format '<field><number>'. If the // field given in the argument is 'friend_' the last id will be 'friend_4'.
var last_item = all_inputs.length - 1;
var last = all_inputs[last_item].id;
var count = Number(last.split("_")[1]) + 1;
//If the maximum number of elements have been reached, exit the function.
// If the given limit is lower than 0, infinite number of fields can be created.
if(count > limit && limit > 0) return;
if(document.createElement) { //W3C Dom method.
var li = document.createElement("li");
var div = document.createElement("div");
var input = document.createElement("input");
input.id = field+count;
input.name = field+count;
input.type = "text"; //Type of field - can be any valid input type like text,file,checkbox etc.
div.appendChild(document.createTextNode("Nimi: "));
div.appendChild(input);
field_area.appendChild(document.createTextNode("Nimi: "));
field_area.appendChild(input);

} else { //Older Method
field_area.innerHTML += "<input name='"+(field+count)+"' id='"+(field+count)+"' type='text' />";
}
}
//-->
</script> 
</head>
<body class="background">
<table class="table">
<tbody>
<tr>
<td class="sideCell"></td>
<td class="middleCell">
<table class="table">

<tbody>
<tr>
<td class="header">
<h1>Reissuexceli.com</h1>
</td>
</tr>
<tr>
<td class="area">
<table class="innerTable">
<tbody>
<tr class="spaceTR">
<td class="areaSideCell"></td>
<td class="areaCenterCell"></td>
<td class="areaSideCell"></td>
</tr>
<tr class="basicInfoTR">

<td class="areaSideCell"></td>
<td class="areaCenterCellInput">
<strong>Reissun
perustiedot</strong><br>
<br>
<?php
echo form_open('trip/createtrip');
?>
Reissun nimi:
<input name="tripname" id="tripname" size="30" type="text">

</td>
<td class="areaSideCell"></td>
</tr>
<tr class="spaceTR">
<td class="areaSideCell"></td>
<td class="areaCenterCell"></td>
<td class="areaSideCell"></td>
</tr>
<tr class="membersTR">

<td class="areaSideCell"></td>
<td class="areaCenterCellInput2">
<strong>Osallistujat</strong><br>
<div id="members_area">
Nimi: <input id="name_1" name="name_1" type="text"><br>
Nimi: <input id="name_2" name="name_2" type="text"><br>
Nimi: <input id="name_3" name="name_3" type="text"><br>
Nimi: <input id="name_4" name="name_4" type="text"><br>
Nimi: <input id="name_5" name="name_5" type="text"><br>
Nimi: <input id="name_6" name="name_6" type="text"><br>
Nimi: <input id="name_7" name="name_7" type="text"><br>
Nimi: <input id="name_8" name="name_8" type="text"><br>
Nimi: <input id="name_9" name="name_9" type="text"><br>
Nimi: <input id="name_10" name="name_10" type="text">
<!--
Nimi: <input id="name_11" name="name_11" type="text"><br>
Nimi: <input id="name_12" name="name_12" type="text"><br>
Nimi: <input id="name_13" name="name_13" type="text"><br>
Nimi: <input id="name_14" name="name_14" type="text"><br>
Nimi: <input id="name_15" name="name_15" type="text"><br>
Nimi: <input id="name_16" name="name_16" type="text">
-->
</div>


&nbsp;
</td>
<td class="areaSideCell"></td>
</tr>
<tr class="space2TR">
<td class="areaSideCell"></td>
<td class="areaCenterCell"></td>
<td class="areaSideCell"></td>
</tr>

<tr>
<td class="areaSideCell"></td>
<td class="areaCenterCell"> 
<?php 
echo form_submit('createnewtrip', 'Luo reissu');
echo form_close();
?>

</td>
<td class="areaSideCell"></td>
</tr>



</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
<td class="sideCell"></td>

</tr>
</tbody>
</table>
<br>
</body></html>




