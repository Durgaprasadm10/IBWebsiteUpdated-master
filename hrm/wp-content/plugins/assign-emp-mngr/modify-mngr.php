<?php
function modify_mngr( $atts ) {
global $wpdb; 

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



<?php 

if ( is_user_logged_in() ) {
$roll = get_user_role();

if(($roll) == 'author'){



?>
<br />
<table><tr></td>
<form name="import" method="post" enctype="multipart/form-data">

<?php
$empmq = ("SELECT *FROM wp_users"); 

$empmq = $wpdb->get_results($empmq);


?>
<!--<select name="addr1" id="addr1" class="dropdown" required="">
<option value="" selected="selected">Select Employee</option>
<?php foreach($empmq as $empmq){ 
$empnicen = $empmq->user_nicename;
$empid = $empmq->ID;
$empname = $empmq->meta_value;
 ?>
<option value="<?php echo $empid; ?>"><?php echo $empnicen; ?></option>
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
<select name="addr1" id="addr1" class="dropdown" required="">
<option value="" selected="selected">Select Manager</option>
<?php
 foreach ($editor as $user) {
 $unam =  $user->user_nicename;
$mcod =  $user->ID;
//$mcod =  $user->emp_code;
echo '<option value="'.$mcod.'">'.$unam.'</option>';

 }
echo '</select>';
?>
<br /><br />
<!--<?php
$sqlmey = mysql_query("SELECT *FROM wp_users WHERE role = 'Manager'"); ?>
<select name="mgrname" id="mgrname" class="dropdown" required="">
<option value="" selected="selected">Select Manager</option>
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
 $editores = get_users($args1);
?>
<select name="mgrname" id="mgrname" class="dropdown" required="">
<option value="" selected="selected">Select Manager</option>
<?php
 foreach ($editores as $users) {
 $unamans =  $users->user_nicename;
//$mcodans =  $users->ID;
$mcodans =  $users->emp_code;
echo '<option value="'.$mcodans.'">'.$unamans.'</option>';

 }
echo '</select>';
?>   	




<!--<input type="text" name="addr1" />-->


<br /><br />
        <input type="submit" name="submit" value="Submit" /></form>

<?php } else { echo '<h2>Sorry, You dont have permission to view this page.</h2>'; }  } ?>
<?php 

if(isset($_POST['submit'])){

$ecode = $_POST['mgrname'];
$user_idmeta = $_POST['addr1'];

$user_id = $user_idmeta;
  $key = 'mgrid';
  $single = true;
  $mgri = get_user_meta( $user_id, $key, $single ); 
  //echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
//echo $ecode;
//exit;
/*$sqlappend = mysql_query("SELECT *FROM wp_usermeta WHERE user_id = '$user_id'");

while($appen = mysql_fetch_array($sqlappend)){

}*/

//$sqlmeta = mysql_query("INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES ('$user_id','mgrid','$mgri,$ecode')");

$sqlmetappen = mysql_query("UPDATE wp_usermeta SET meta_value = '$ecode' WHERE  user_id = '$user_id' AND meta_key = 'mgrid'");

//$sqlmetappen = mysql_query("UPDATE wp_users SET assign_mgr = '$ecode' WHERE  ID = '$user_id'");
$sqlmetappen = mysql_query("UPDATE wp_users SET assign_mgr = '$ecode' WHERE  ID = '$user_idmeta'");

echo 'Record added.';//. $user_id . $ecode
}

?>

<?php //wp_insert_user( $userdata ); ?>

</div></div>

</td></tr></table>

<?php
}
add_shortcode( 'mngrmodify', 'modify_mngr' );

?>