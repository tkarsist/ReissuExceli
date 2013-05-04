<?php
echo "Anu on herrku2";
//var_dump($query);
echo $tripname[0]->TRIPNAME;
var_dump($members);
foreach ($members as $row){
        echo "<br>";
        echo $row->NAME;
}

?>
