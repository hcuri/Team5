<?php
/*
CREATE TABLE `menu` (
`tacoFixinId` int(11) NOT NULL AUTO_INCREMENT,
`itemType` varchar(255) NOT NULL,
`name` varchar(255) NOT NULL,
`price` int(11) NOT NULL,
`heatRating` varchar(11) DEFAULT '0',
PRIMARY KEY (`tacoFixinId`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1
*/

$json = file_get_contents("taco_truck_menu.json");


$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

$outputCSV = "menu.csv";
file_put_contents($outputCSV, "itemType,name,price,heatRating\n");
foreach ($jsonIterator as $key => $val) {
    if(is_array($val)) {
    	if ($key !="menu" && !is_numeric($key))
        	$itemType=$key;
    	
    } else {
    	
    	if ($key =="name")
    		$name = $val;
    	elseif ($key=="heatRating")
    		$heatRating = $val;
    	elseif ($key=="price") {
    		$price = $val;
    		$out ="$itemType,$name,$price,$heatRating\n";
    		echo $out;
    		file_put_contents($outputCSV, $out, FILE_APPEND);
    		$name=NULL;$price=NULL;$heatRating=NULL;
    	}
        
    }
}

?>
