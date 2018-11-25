<?php include ( "./inc/connect.inc.php"); ?>
<?php  
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header('location: login.php');
}
else {
	$user = $_SESSION['user_login'];
	
	//inserting lgbt  like
	if (isset($_REQUEST['did'])) {
		$lgbt_id = $_REQUEST['did'];
	
		$insertlgbtlike = mysql_query("INSERT INTO lgbt_likes VALUES ('','$user','$lgbt_id')");
		header("location: index.php");
	}else {
		header('location: index.php');
	}
}

?>