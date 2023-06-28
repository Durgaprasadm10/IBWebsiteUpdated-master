<?php /* Template Name: MANAGER TEAM */ ?>
<?php
   global $wpdb;
get_header();
ob_start();
?>
<?php global $current_user;
      get_currentuserinfo();
$name = $current_user->user_firstname;
$username = $current_user->user_login;
$mgrcode = $current_user->mgr_code;
$idu = $current_user->ID;
$rid = $current_user->emp_code;
//echo $username;
?>

<div class="container">
<div class="row-fluid">
<?php //echo get_calendar(); ?>
<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();

if(($roll) == 'author'){

?>

<form id="form_id" method="post" enctype="multipart/form-data">
<div width="800px">
Select Manager : <!--<input type="text" class="custom_date" name="empcode" id="empcode" value="" required/>-->

<?php
$sqlmey = mysql_query("SELECT *FROM wp_users WHERE role = 'Manager'"); ?>
<select name="empcode" id="empcode" class="dropdown" required="">
<option value="" selected="selected">Select Manager</option>
<?php while($sqrt = mysql_fetch_array($sqlmey)){ 
$mgrn = $sqrt['mgr_name'];
$mgid = $sqrt['emp_code'];
 ?>
<option value="<?php echo $mgid; ?>"><?php echo $mgrn; ?></option>
<?php } ?>
</select>
  <input type="hidden" name="addr1" value="<?php echo $mgrn; ?>" />
</div>

<br />
<input type="submit" name="submit" value="SEARCH" />
</form>

<?php

 ?>

<br />

<?php

if(isset($_POST['submit'])){
$ecod = $_POST['empcode'];

$mymn = ("SELECT *FROM wp_users WHERE emp_code = '$ecod'");
$list_r = $wpdb->get_results($mymn);

foreach($list_r as $list_emp){
$mid = $list_emp->ID;
echo '<h3> MANAGER : '.$list_emp->mgr_name.'</h3><br />';
}

  $user_id = $mid;
  $key = 'mgrid';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 //echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
//echo $ecod;
//echo $user_id;
$semp = mysql_query("SELECT *FROM wp_attendance WHERE ECode IN ($user_last) GROUP BY Name,ECode");

while($empsele = mysql_fetch_array($semp)){

$enam = $empsele['Name'];
$ecod = $empsele['ECode'];
//echo $ecod;
echo $ecod.'&nbsp;&nbsp;&nbsp;&nbsp;'. $enam ."<br />";

}

}
}
}
?>

</div></div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php get_footer(); ?>
