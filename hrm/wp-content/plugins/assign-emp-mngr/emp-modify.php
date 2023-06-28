<?php
function emp_modify( $atts ) {
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
<table><tr><td>
<form name="import" method="post" enctype="multipart/form-data">
<!--<?php
$sqlmey = mysql_query("SELECT *FROM wp_users WHERE role = 'Manager'"); ?>
<select name="mgrname" id="mgrname" class="dropdown" required="">
<option value="" selected="selected">Select Manager</option>
<?php while($sqrt = mysql_fetch_array($sqlmey)){ 
$mgrn = $sqrt['mgr_name'];
$mgid = $sqrt['ID'];
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
<select name="mgrname" id="mgrname" class="dropdown" required="">
<option value="" selected="selected">Select Manager</option>
<?php
 foreach ($editor as $user) {
 $unam =  $user->user_nicename;
$mcod =  $user->ID;
echo '<option value="'.$mcod.'">'.$unam.'</option>';

 }
echo '</select>';
?>

  <input type="hidden" name="addr1" value="<?php echo $mgrn; ?>" />
        <input type="submit" name="submit" value="Submit" /></form>

<?php } else { echo '<h2>Sorry, You dont have permission to view this page.</h2>'; }  } ?>
<?php 

if(isset($_POST['submit'])){

$ecode = $_POST['addr1'];
$user_idmeta = $_POST['mgrname'];

$user_id = $user_idmeta;
  $key = 'mgrid';
  $single = true;
  $mgri = get_user_meta( $user_id, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
echo "<form action='' method='POST' enctype='multipart/form-data'>";

$sqlmn = ("SELECT *FROM wp_users WHERE ID = '$user_id'");
$list_mn = $wpdb->get_results($sqlmn);
foreach($list_mn as $list_mn){
echo '<h3>Manager : '.$list_mn->mgr_name.'</h3>';

$mngrecode = $list_mn->emp_code;
echo "<input type='hidden' name='mnecode' value='$mngrecode' />";

}




$sqlappend = ("SELECT *FROM wp_usermeta WHERE user_id = '$user_id' AND meta_key = 'mgrid'");
$list_del = $wpdb->get_results($sqlappend);
foreach($list_del as $list_d){


echo "<textarea name='team'>".$list_d->meta_value."</textarea>";
echo "<input type='hidden' name='uid' value='$user_id' />";
echo "<input type='hidden' name='mgid' value='mgrid' />";
echo "<input type='submit' name='update' value='UPDATE' />";
echo "</form>";
}

$semp = ("SELECT *FROM wp_attendance WHERE ECode IN ($mgri) GROUP BY Name,ECode");
$emp_deta = $wpdb->get_results($semp);
foreach($emp_deta as $emp_deta){

$enam = $emp_deta->Name;
$ecod = $emp_deta->ECode;
//echo $ecod;
echo $ecod.'&nbsp;&nbsp;&nbsp;&nbsp;'. $enam ."<br />";

}


//echo 'Record added.';//. $user_id . $ecode
}

if(isset($_POST['update'])){

$mgriecode = $_POST['team'];
$uid = $_POST['uid'];
$mgid = $_POST['mgid'];
$mnecode = $_POST['mnecode'];

$sqlmetappen = mysql_query("UPDATE wp_usermeta SET meta_value = '$mgriecode' WHERE  user_id = '$uid' AND meta_key = 'mgrid'");
$sqlmetappen = mysql_query("UPDATE wp_users SET assign_mgr = '$mnecode' WHERE  emp_code IN ($mgriecode)");
echo "<h3>Selected Updated.</h3>";
}


?>

<?php //wp_insert_user( $userdata ); ?>
</td></tr></table>
</div></div><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<?php
}
add_shortcode( 'modifyemp', 'emp_modify' );
?>