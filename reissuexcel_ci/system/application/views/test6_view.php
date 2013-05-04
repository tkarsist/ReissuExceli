
<?php 
echo form_open('trip/test6');
echo form_submit("generate", 'Generoi velat');
echo form_close();
?>
<table border="1px" width="1000px">
<tr>
<td>
<b>Generoidut Laskut</b>
</td>
<td>
<b>Generoidun materiaalin velat</b>
</td>
<td>
<b>Transaktiot</b>
</td>
</tr>
<tr>
<td>
<?php 
if(isset($paid_array)){
	foreach($paid_array as $key=>$row){
		echo $row[0]." : ".round($row[1],2)."<br>";
	}
	
}
?>
</td>
<td>
<?php 
if(isset($debt)){
	foreach($debt as $key=>$row){
		echo $row[0]." : ".round($row[1],2)."<br>";
	}
	
}
?>
</td>
<td>
<?php 
if(isset($debt_transact)){
foreach($debt_transact as $row){
			echo $row[0]. " maksaa: ".round($row[1],2)." to  ".$row[2]."<br>";
}
}
?>
</td>
</tr>
<tr>
<td>
<?php 
if(isset($sum_avg)){
echo "Osuus per naama: ".round($sum_avg,2);
}
?>
</td>
<td>
<?php 
if(isset($saatavat)&&isset($velat)){
echo "Saatavia yhteensä: ".round($saatavat,2);
echo "<br>";
echo "Velkoja yhteensä: ".round($velat,2)."<br>";
}
?>
</td>
<td>
<?php 
if(isset($saatavat)&&isset($transaktiosumma)){
$erotus=$saatavat-$transaktiosumma;
echo "Transaktiomaksujen summa: ".round($transaktiosumma,2)." on verrattuna saataviin: ".round($saatavat,2)." - ".round($transaktiosumma,2)." = ".round($erotus,2);
echo "<br>";
echo "Transaktioita : ".count($debt_transact);
}

?>
</td>
</tr>
</table>



