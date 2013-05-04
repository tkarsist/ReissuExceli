<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"><title>reissuexceli</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/styles.css">

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
<td class="areaCenterCellInput2"><p>
<b>Laskujen lisääminen
<?php 
echo ": ".$membername;
?>
</b></p>
  <?php 
  echo form_open('trip/trip_cost');
  ?>
  <table class="toptable"><tr>
  <td><b>Summa</b></td>
  <td><b>Kuvaus</b></td>
  <td><b>Osallistujat</b></td>
  <td>
  </td>
  </tr>
  <tr>
 
  <td>
  <?php 
  echo form_input('sum', '');
  ?>

   
   &nbsp; 
   </td>
   <td>
   <?php 
   echo form_input('description', '');
   ?>
   
   &nbsp; 
   </td>
   <td>
  <?php 
  		echo form_hidden('member', $member);
  		echo form_hidden('membername', $membername);
		echo form_hidden('trip', $trip);
			foreach($trip_members as $row){
				$options[$row->ID]=$row->NAME;
				$selected[]=$row->ID;
		}
	
        echo form_multiselect('participants[]',$options,$selected);
  ?>

  &nbsp; 
    </td>
    <td>
    <?php 
            echo form_submit("cost", 'Lisää kulu');
    ?>

    </td>
    </tr>
    </table>
    <?php 
    echo form_close();
    ?>
      
  <br>
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
<td class="areaCenterCellInput2"><p><strong>Kulujen kirjaus</strong></p>

  <div id="members_area">
  <table class="prestable">
  <tr><td>
  <b>Summa</b></td><td><b>Kuvaus</b></td>
  <td><strong>Osallistujat</strong></td>
  <td>

    </td>
  </tr>
<?php 
if(isset($bills)){
foreach ($bills as $rowX){
	echo "<tr>";
	echo "<td>";
	echo $rowX[1];
	echo "</td>";
	echo "<td>";
	echo $rowX[2];
	echo "</td>";
	echo "<td>";
	echo $rowX[3];
	echo "</td>";
	echo "<td>";
	echo form_open('trip/trip_cost');
	echo form_hidden('member', $member);
	echo form_hidden('membername', $membername);
	echo form_hidden('trip', $trip);
	echo form_hidden('bill', $rowX[0]);
	echo form_submit("delete", 'Poista');
	echo form_close();
	echo "</td>";
	echo "</tr>";
	
}
}
?>  

    </table>
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
 
	    echo form_open('trip/trip_main/'.$trip);
	    
	    echo form_submit("submit", 'Kulut valmiit');
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

