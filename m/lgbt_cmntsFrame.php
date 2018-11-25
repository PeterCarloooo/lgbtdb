<?php
include ( "./inc/connect.inc.php" );
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header('location: index.php');
}
else {
	$user = $_SESSION['user_login'];
}
?>


<style type="text/css">
hr {
    background-color: #B5B2B2;
    height: 1px;
    margin: 4px 52px;
    border: 0px;
}
.lgbt_by {
	color: #0B810B; 
	text-decoration: none;
}
.lgbt_by:hover {
	text-decoration: underline;
}
/* commentBody styel from here*/

.commentPostText { 
	font-family: helvetica, arial, sans-serif; 
	font-size: 13px; 
	font-weight: normal; 
	color: #141823; 
}
.commentSubmit {
    background-color: #0B810B;
    color: #ECF6EC;
    float: right;
    height: 25px;
    width: 24%;
    font-size: 12px;
    border-radius: 2px;
    border: 1px solid #5C5E5C;
}
.commentSubmit:hover {
  background-color: rgba(11, 129, 11, 0.82);
}
</style>

<script language="javascript">
	function toggle() {
		var ele = document.getElementById("toggleComment");
		var text = document.getElementById("displayComment");
		if (ele.style.display == "block") {
			ele.style.display = "none"
		}else {
			ele.style.display = "block";
		}
	}
</script> 

<?php 

$getid = $_GET['id'];

$lgbt_body = htmlspecialchars(@$_POST['lgbt_body'], ENT_QUOTES);
$lgbt_body = trim($lgbt_body);
if ($lgbt_body != "") {
if (isset($_POST['lgbtComment' . $getid . ''])) {
	$lgbt_body = $_POST['lgbt_body'];
	$date_added = date("Y-m-d");
	$query = mysql_query("SELECT id,added_by  FROM lgbt WHERE id='$getid'");
	$query_row = mysql_fetch_assoc($query);
	$lgbt_to = $query_row['added_by'];
	$insertPost = mysql_query("INSERT INTO lgbt_comments VALUES ('','$lgbt_body','$date_added',NOW(),'$user','$lgbt_to','no','$getid')");
}
}
//post query
	$query = mysql_query("SELECT id,added_by  FROM lgbt WHERE id='$getid'");
	$query_row = mysql_fetch_assoc($query);
	$lgbt_to = $query_row['added_by'];
	//getting post by gender
	$lgbtby_query = mysql_query("SELECT * FROM users WHERE username='$lgbt_to'");
	$lgbtby_gender_row = mysql_fetch_assoc($lgbtby_query);
	$lgbtby_gender_value = $lgbtby_gender_row['gender'];
	//getting user gender
	$usergender_query = mysql_query("SELECT * FROM users WHERE username='$user'");
	$user_gender_row = mysql_fetch_assoc($usergender_query);
	$user_gender_value = $user_gender_row['gender'];
?>

<?php 
	if ($lgbtby_gender_value == 2) {
		if (($lgbt_to == $user) || ($user_gender_value == 2)) {
			echo "
			<div>
			<form action='lgbt_cmntsFrame.php?id=".$getid."' method='POST' name='lgbtComment".$getid."'>
				<input style='padding: 10px 3px; min-width: 60px; width: 73%; margin: 0 0 5px 0; border: 1px solid #0B810B;' name='lgbt_body' placeholder= 'Leave your comment here!' autofocus>
				<input type='submit' name='lgbtComment".$getid."' class='commentSubmit' value='Comment'>
			</form>
			</div>
		";
	}else {
		$get_msg_num = mysql_query("SELECT * FROM pvt_messages WHERE user_from='$lgbt_to' AND user_to='$user' LIMIT 2");
			$female_msg = mysql_num_rows($get_msg_num);
			if ($female_msg >=1 ) {
				echo "
					<div>
					<form action='lgbt_cmntsFrame.php?id=".$getid."' method='POST' name='lgbtComment".$getid."'>
						<input style='padding: 10px 3px; min-width: 60px; width: 73%; margin: 0 0 5px 0; resize: none; border: 1px solid #0B810B;' name='lgbt_body' placeholder= ''>
						<input type='submit' name='lgbtComment".$getid."' class='commentSubmit' value='Comment'>
					</form>
					</div>
				";
			}else {
				echo "<p style=' text-align: center; font-size: 18px; color: #7B7B7B; font-weight: bold;'>Sorry! You can not leave comment here.</p>";
			}
		}
	}else {
		echo "
			<div>
			<form action='lgbt_cmntsFrame.php?id=".$getid."' method='POST' name='lgbtComment".$getid."'>
				<input style='padding: 10px 3px; min-width: 60px; width: 73%; margin: 0 0 5px 0; resize: none; border: 1px solid #0B810B;' name='lgbt_body' placeholder= ''>
				<input type='submit' name='lgbtComment".$getid."' class='commentSubmit' value='Comment'>
			</form>
			</div>
		";
	}
	?>


<?php
//Get relevant lgbt
$get_comments = mysql_query("SELECT * FROM lgbt_comments WHERE lgbt_id='$getid' ORDER BY id DESC");
$count = mysql_num_rows($get_comments);
if ($count != 0) {
while ($comment = mysql_fetch_assoc($get_comments)) {
	$lgbt_body = $comment['lgbt_body'];
	$date_added = $comment['date_added'];
	$lgbt_to = $comment['lgbt_to'];
	$dawat_by = $comment['lgbt_by'];
	$get_user_info = mysql_query("SELECT * FROM users WHERE username='$dawat_by'");
	$get_info = mysql_fetch_assoc($get_user_info);
	$profile_pic_db= $get_info['profile_pic'];
	$lgbt_by = $get_info['first_name'];
	$lgbt_user_info = mysql_query("SELECT * FROM users WHERE username='$lgbt_by'");
	$fname_info = mysql_fetch_assoc($lgbt_user_info);
	
	//check for propic delete
						$pro_changed = mysql_query("SELECT * FROM posts WHERE added_by='$dawat_by' AND (discription='changed his profile picture.' OR discription='changed her profile picture.') ORDER BY id DESC LIMIT 1");
						$get_pro_changed = mysql_fetch_assoc($pro_changed);
		$pro_num = mysql_num_rows($pro_changed);
		if ($pro_num == 0) {
			$profile_pic = "http://www.lgbt.com/img/default_propic.png";
		}else {
			$pro_changed_db = $get_pro_changed['photos'];
		if ($pro_changed_db != $profile_pic_db) {
			$profile_pic = "http://www.lgbt.com/img/default_propic.png";
		}else {
			$profile_pic = "http://www.lgbt.com/userdata/profile_pics/".$profile_pic_db;
		}
		}
	
		echo "
	<div class='commentPostText'>
	<div style='float: left; margin: 0 10px 0 0;'><img src='$profile_pic' style= 'border-radius: 22px'; title=\"$lgbt_by\" height='38' width='38'  /></div>
	<div style='margin-left: 48px;'>
	<b><a href='profile.php?u=$dawat_by' title=\"Go to $lgbt_by's Profile\" target='_top' class='lgbt_by'>$lgbt_by</a></b><p style='font-size: 10px; margin: 0;'>".$date_added."</p>
	".nl2br($lgbt_body)."
	
	</div>
	</div><br>";
	
}
}else {
	echo "<center><br><br><br>Opps! There is no comment to view.</center>";
}

?>