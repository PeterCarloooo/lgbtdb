<?php include ( "./inc/connect.inc.php"); ?>
<?php  
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header('location: signin.php');
}
else {
	$user = $_SESSION['user_login'];
}

//inserting lgbt  like
if (isset($_REQUEST['did'])) {
	$lgbt_id = $_REQUEST['did'];

	$insertlgbtlike = mysql_query("INSERT INTO lgbt_likes VALUES ('','$user','$lgbt_id')");
	header("location: index.php");
}else {
	header('location: index.php');
}

//deleting lgbt like
if (isset($_REQUEST['udid'])) {
	$lgbt_uid = $_REQUEST['udid'];

	$del_lgbtlike = mysql_query("DELETE FROM lgbt_likes WHERE lgbt_id='$lgbt_uid'");
	header("location: index.php");
}else {
	header('location: index.php');
}
//inserting post like
if (isset($_REQUEST['pid'])) {
	$post_id = $_REQUEST['pid'];

	$insertPostlike = mysql_query("INSERT INTO post_likes VALUES ('','$user','$post_id')");
	header("location: newsfeed.php");
}else {
	header('location: newsfeed.php');
}

//deleting post like
if (isset($_REQUEST['upid'])) {
	$post_uid = $_REQUEST['upid'];

	$del_postlike = mysql_query("DELETE FROM post_likes WHERE post_id='$post_uid'");
	header("location: newsfeed.php");
}else {
	header('location: newsfeed.php');
}

?>