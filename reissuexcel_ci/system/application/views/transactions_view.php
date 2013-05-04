<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"><title>reissuexceli</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/styles.css">

</head>
<body class="background">
<table class="table">
<tbody>
<tr>
<td class="sideCell2"></td>
<td class="middleCell2">
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
echo "<b>".$trip_name[0]->TRIPNAME."<b>";
?>


  <br>
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
<td class="areaCenterCellInput2"><p><strong>Eritelm&auml;</strong></p>

  <div id="members_area">
  <table class="prestable">
  <?php 
  		//for($i=-0;$i<count($members);$i=$i+1){
  		//	if($i==0){
  				echo "<tr>";
  				echo "<td>";
  				echo "<b>Maksaja</b>";
  				echo "</td>";
  				echo "<td>";
  				echo "<b>Kuvaus</b>";
  				echo "</td>";
  				echo "<td>";
  				echo "<b>Laskun summa</b>";
  				echo "</td>";
  				foreach($members as $row){
  					echo "<td>";
  					echo "<b>".$row->NAME."</b>";
  					echo "</td>";
  				}
  				echo "</tr>";
  				
  			//}
  			//else{
  				 
  				foreach($eritelma as $keyZ=>$row){
  					echo "<tr>";
  					
  					for($x=0;$x<count($members)+3;$x=$x+1){
  						
  						if(!isset($eritelma[$keyZ][$x])){
  							echo "<td>";
  							echo "-";
  							echo "</td>";
  						}
  						else{
  							if($x<=2){
  								echo "<td>";
  								echo $eritelma[$keyZ][$x];
  								echo "</td>";
  							}
  							else{
  								if($eritelma[$keyZ][$x]>=0){
  									echo '<td class="blue">';
  								}
  								else{
  									echo '<td class="red">';
  								}
								
  								echo $eritelma[$keyZ][$x];
  								echo "</td>";
  							}
  						}
  					
  					}

  				echo "</tr>";	  					
  				}
  				
  				 echo "<tr>";
  				echo "<td>";
  				echo "&nbsp;";
  				echo "</td>";
  				echo "<td>";
  				echo "&nbsp;";
  				echo "</td>";
  				echo "<td>";
  				echo "<b>Saatavat yht.</b>";
  				echo "</td>";
  				foreach($members as $keyX=>$row){
  					
  					if(!isset($debt[$row->ID])){
  						echo "<td>";
  						echo "-";
  						echo "</td>";
  						
  					}
  					else{
  						if($debt[$row->ID][1]>0){
  							echo '<td class="blue">';
  						}
  						else{
  						echo '<td class="red">';
  						}
  						echo "<b>".$debt[$row->ID][1]."</b>";
  						echo "</td>";
  					}
  				}
 
  				echo "</tr>";
 
  ?>
  <!--
  <tr>
  <td><b>Maksaja</b></td>
  <td><b>Kuvaus</b></td>
  <td><strong>Summa</strong></td>
  <td><strong>Simo (+/-)</strong></td>
  <td><strong>Jaska (+/-)</strong></td></tr>
  <tr><td>
  Jaska</td>
    <td>Keittoa</td>
  <td>100</td>
  <td>50</td>
  <td>
  <form action="http://valas.veikonkala.org/testi/index.php/trip/trip_cost" method="post">
    -50
  </form>
    </td></tr>
    <tr>
      <td>Sami</td>
      <td>Kauppa</td>
      <td>32</td>
      <td>-16</td>
      <td>16</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><b>Saatavat yht.</b></td>
      <td>34</td>
      <td>
  -34
    </td></tr>
    -->
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
<td class="areaCenterCell"> </td>
<td class="areaSideCell"></td>
</tr>
<tr class="membersTR">

<td class="areaSideCell"></td>
<td class="areaCenterCellInput2"><p><strong>Maksut</strong></p>

  <div id="members_area">
  <?php 
  		
		foreach($debt_transact as $row){
			echo $row[0]. " maksaa: ".$row[1]." ".$row[2]."<br>";
		}
  ?>
  
  

</div>

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
<td class="areaCenterCell"> </td>
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






