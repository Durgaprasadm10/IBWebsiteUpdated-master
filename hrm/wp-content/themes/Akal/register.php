<?php /* Template Name: REGISTER */ ?>
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
<div class="row-fluid" style="height:500px;">

<form name="import" method="post" enctype="multipart/form-data">
    	<!--<br /><input type="text" name="name" /><br /><br />
        <input type="submit" name="submit" value="Submit" />-->

<?php 

if ( is_user_logged_in() ) {
$roll = get_user_role();

if(($roll) == 'author'){



?>
<br />
<table>
<th colspan="7"><fieldset><legend>NEW USER REGISTRATION</legend></th>
<tr><td>
<label for="user_login" class="text">Username<span class="req">*</span></label><div class="div_text"><input name="user_login" type="email" id="user_login" value="@ideabytes.com" class="textbox" required=""></div>
</td><td>
<label for="first_name" class="text">First Name<span class="req">*</span></label><div class="div_text"><input name="first_name" type="text" id="first_name" value="" class="textbox" required=""></div>
</td><td>
<label for="last_name" class="text">Last Name<span class="req">*</span></label><div class="div_text"><input name="last_name" type="text" id="last_name" value="" class="textbox" required=""></div>
</td><td>
<label for="addr1" class="text">Emp code<span class="req">*</span></label><div class="div_text"><input name="addr1" type="text" id="addr1" value="" class="textbox" required=""></div>
</td></tr>
<tr><td>
<label for="phone1" class="text">Phone No<span class="req">*</span></label><div class="div_text"><input name="phone1" type="text" id="phone1" value="" class="textbox" required=""></div>
</td><td>
<label for="user_email" class="text">Email<span class="req">*</span></label><div class="div_text"><input name="user_email" type="email" id="user_email" value="" class="textbox" required=""></div>
</td><td>
<!--<label for="mgrid" class="select">Role<span class="req">*</span></label><div class="div_select"><select name="role" id="role" class="dropdown" required=""><option value="" selected="selected">Select One </option><option value="Employee">Employee</option><option value="Manager">Manager</option></select>


</div>-->
<input name="role" type="hidden" id="user_email" value="Employee" class="textbox">
<label for="mgrid" class="select">Manager Name<span class="req">*</span></label><div class="div_select">
<!--<?php
$sqlmey = mysql_query("SELECT *FROM wp_users WHERE role = 'Manager'"); ?>
<select name="mgrid" id="mgrid" class="dropdown"><option value="" selected="selected">Select One</option>
<?php while($sqrt = mysql_fetch_array($sqlmey)){ 
$mgrn = $sqrt['mgr_name'];
$mgid = $sqrt['emp_code'];
 ?>

<option value="<?php echo $mgid; ?>"><?php echo $mgrn; ?></option>
<?php } ?>
</select>-->
<?php
$args1 = array(
 'role' => 'editor',
 'orderby' => 'user_nicename',
 'order' => 'ASC'
);
 $editor = get_users($args1);
?>
<select name="mgrid" id="mgrid" class="dropdown" required="">
<option value="" selected="selected">Select Manager</option>
<?php
 foreach ($editor as $user) {
 $unam =  $user->user_nicename;
//$mcod =  $user->ID;
$mcod =  $user->emp_code;
echo '<option value="'.$mcod.'">'.$unam.'</option>';

 }
echo '</select>';
?>
<input name="mgrid" type="hidden" id="mgrid" value="<?php echo $mgid; ?>" class="textbox">



</div></td></tr><tr><td><input name="a" type="hidden" value="register"><input name="wpmem_reg_page" type="hidden" value="http://etr.autotestscript.com/l-register/"><div class="button_div"><input name="submit" type="submit" value="Register" class="buttons"></div><div class="req-text"><span class="req">*</span>Required field</div></form></fieldset>
</td></tr></table>
<?php } else { echo '<h2>Sorry, You dont have permission to view this page.</h2>'; }  } ?>
<?php 

if(isset($_POST['submit'])){

$user_login = $_POST['user_login'];
$first_name  = $_POST['first_name'];
$last_name  = $_POST['last_name'];
$ecode  = $_POST['addr1'];
$phone  = $_POST['phone1'];
$user_email  = $_POST['user_email'];
$role  = $_POST['role'];
$mgrname  = $_POST['mgrid'];


$user_idappen = $mgrname;
  $key = 'mgrid';
  $single = true;
  $mgri = get_user_meta( $user_idappen, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 





//$website = "http://example.com";
$userdata = array(
    'user_login'  =>  $user_login,
    'user_nicename'    =>  $first_name. $last_name,
    'user_email'   =>  $user_email,
'mgr_name'   =>  $mgrname,
'emp_code'   =>  $ecode,
'assign_mgr'   =>  $mgrname,
'phone'   =>  $phone
);




$user_id = wp_insert_user( $userdata ) ;

//On success
if ( ! is_wp_error( $user_id ) ) {
    echo "User created : ". $user_id;


$sqlmeta = mysql_query("INSERT INTO `wp_usermeta`(`user_id`, `meta_key`, `meta_value`) VALUES ($user_id,'addr1',$ecode)");



$userprofile = mysql_query("INSERT INTO `wp_profile`(`ecode`, `firstname`, `email`) VALUES ('$ecode','$first_name','$user_email')");



$sqluser = mysql_query("UPDATE `wp_users` SET `mgr_name` = '$mgrname',`emp_code` = '$ecode',`phone` = '$phone' ,`role` = '$role' WHERE `ID` = '$user_id'");

$sqlmetaw = mysql_query("INSERT INTO `wp_usermeta`(`user_id`, `meta_key`, `meta_value`) VALUES ('$user_id','mgrid','$mgrname')");




//$sqlmetappen = mysql_query("INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES ('$user_idappen','mgrid','$mgri,$ecode')");


}

$sqlmetappen = mysql_query("UPDATE wp_usermeta SET meta_value = '$mgri, $ecode' WHERE  user_id = '$user_idappen' AND meta_key = 'mgrid'");
wp_insert_user( $userdata );

}

?>

<?php //wp_insert_user( $userdata ); ?>

</div></div>
<?php get_footer(); ?>