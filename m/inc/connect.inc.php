<?php 
mysql_connect("localhost","root","") or die("Couldn't connet to SQL server");
mysql_select_db("lgbt_db") or die("Couldn't select DB");

//time formate
function formatDate($date){
	return date('g:i a', strtotime($date));
}

?>