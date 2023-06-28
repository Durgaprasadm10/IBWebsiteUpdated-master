<?php /* Template Name: CPASSWORD */ ?>
<?php
   global $wpdb;
get_header();

?>
<?php global $current_user;
      get_currentuserinfo();
$name = $current_user->user_firstname;
$username = $current_user->user_login;
$mgrcode = $current_user->mgr_code;
$idu = $current_user->ID;
//$rid = $current_user->emp_code;
//echo $username;

?>
<div class="container">
<div class="row-fluid" style="height:700px;">
<br />
<table><th>CHANGE PASSWORD</th>
<tr><td>
<form method="post" enctype="multipart/form-data">
New Password:
<br /><input type="password" name="pass" /><br />
Confirm Password:
<br /><input type="password" name="cpass" /><br />
        <input type="submit" name="submit" value="Submit" />


</form>


<?php

if(isset($_POST['submit'])){

$password = $_POST['pass'];
$cpass = $_POST['cpass'];

if(($password) == $cpass){ 

$user_id = $idu;
$password = $_POST['pass'];
$webserp = md5($_POST['pass']);
wp_set_password( $password, $user_id );

$sqlmetappen = mysql_query("UPDATE wp_users SET web_pass = '$webserp' WHERE  ID = '$user_id'");
echo '<h2>Password changed Successfully.</h2>';
} else {

echo '<h2>Password Dont Matches.</h2>';

} 
}
?>
</td></tr></table>
</div></div>
<?php get_footer(); ?>