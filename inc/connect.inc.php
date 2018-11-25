<?php 
mysql_connect("ftp.gear.host","gtt-lgbtcommunity-github\$gtt-lgbtcommunity-github","R1hCMa4wsXSnCzqWw3HHHBJrp53cqMzZ83QNSoM4huuePzlyQnyzprt5Wa99") or die("Couldn't connet to SQL server");
mysql_select_db("lgbtdb") or die("Couldn't select DB");

//time formate
function formatDate($date){
	return date('F j, Y, g:i a', strtotime($date));
}
 ?>
