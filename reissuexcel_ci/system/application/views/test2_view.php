<?php
echo "Lasku";
//var_dump($bills);

foreach ($bills as $row){
        echo "<br>";
        echo "SUM : ".$row->SUM."<br>"." Description: ".$row->DESCRIPTION;
}

foreach ($participants as $row){
        echo "<br>";
        echo "Participants : ".$row->NAME;
}
//echo $tripname[0]->TRIPNAME;
//var_dump($members);
//foreach ($members as $row){
//        echo "<br>";
//        echo $row->NAME;
//}

?>