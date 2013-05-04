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
<td class="areaCenterCellInput"><p><br>
<?php
echo "<b>".$trip_name[0]->TRIPNAME."</b>";
?>
</p>
  <p>
<?php  
  echo auto_link(site_url("trip/trip_main/".$trip_id));
?>
  
  </p></td>
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
  <tr>
  	<td>
  		<b>Nimi</b>
  	</td>
  	<td>
  		<b>Summa</b>
  	</td>
  	<td>

    </td>
    </tr>
    <?php 

$count=1;
foreach ($members as $row){
	    echo "<tr>";
	    echo "<td>";
	    echo $row->NAME;
	    echo "</td>";
	    echo "<td>";
	    if($member_sums[$row->ID]!=0){
	    echo $member_sums[$row->ID];	
	    }
	    else{
	    echo "Ei kuluja";
	    }
	    echo "</td>";
	    echo "<td>";
	    echo form_open('trip/trip_cost');
	    if($member_sums[$row->ID]!=0){
        echo form_submit("submit", 'Muokkaa');	    	
	    }
	    else{
        echo form_submit("submit", 'Lisää');
	    }
        echo form_hidden('member', $row->ID);
        echo form_hidden('membername', $row->NAME);
        echo form_hidden('trip', $trip_id);
		echo form_close();
        echo "</td>";
        echo "</tr>";
        $count=$count+1;
       
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
echo form_open('trip/trip_calculate');
echo form_hidden('trip', $trip_id);
echo form_submit('calculate', 'Laske maksut');
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








