<?php 

/*
    Plugin Name: ASSIGN EMP MANAGER
    Plugin URI: ideabytes.com/
    Description: TOTAL EMP AVERAGE Developed by IB. Assign Emp [assignempmngr] Modify Manager [mngrmodify] Modify Emp [modifyemp] Emp assigned manager [empassignedmngr]
    Author: IB
    Version: 1.7.18
    Author URI: www.ideabytes.com
    Contributors: IB
        Requires at least: 3.5
    Tested up to: 4.4.2
    Text Domain: assign-emp-manager
    
    
 */
ob_start();
?>

<?php
function assign_emp_mngr( $atts ) {
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

<form name="import" method="post" enctype="multipart/form-data">
<?php
$sqlmey = mysql_query("SELECT *FROM wp_users WHERE role = 'Manager'"); ?>
<select name="mgrname" id="mgrname" class="dropdown" required="">
<option value="" selected="selected">Select Manager</option>
<?php while($sqrt = mysql_fetch_array($sqlmey)){ 
$mgrn = $sqrt['mgr_name'];
$mgid = $sqrt['ID'];
 ?>
<option value="<?php echo $mgid; ?>"><?php echo $mgrn; ?></option>
<?php } ?>
</select>
    	<br /><input type="text" name="addr1" /><br /><br />
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


/*$sqlappend = mysql_query("SELECT *FROM wp_usermeta WHERE user_id = '$user_id'");

while($appen = mysql_fetch_array($sqlappend)){

}*/

//$sqlmeta = mysql_query("INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES ('$user_id','mgrid','$mgri,$ecode')");

$sqlmetappen = mysql_query("UPDATE wp_usermeta SET meta_value = '$mgri,$ecode' WHERE  user_id = '$user_id' AND meta_key = 'mgrid'");



echo 'Record added.';//. $user_id . $ecode
}

?>

<?php //wp_insert_user( $userdata ); ?>

</div></div>
<?php
}
add_shortcode( 'assignempmngr', 'assign_emp_mngr' );
include('modify-mngr.php');
include('emp-modify.php');
include('emp-and-assigned-mngr.php');
?>