<?php /* Template Name: EDIT LEAVES */ ?>
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
<table><th>EDIT LEAVES</th><tr><td>
<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();

if(($roll) == 'author' || $roll == ''){

?>

<link rel="stylesheet" href="<?php echo plugins_url(); ?>/javascripts/uijquery.css">
  <script src="<?php echo plugins_url(); ?>/javascripts/uijquery.js"></script>
  <script src="<?php echo plugins_url(); ?>/javascripts/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#start_date" ).datepicker({
dateFormat : 'yy-mm-dd',
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to_date" ).datepicker({
dateFormat : 'yy-mm-dd',
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>




<form id="form_id" method="post" enctype="multipart/form-data">
<div width="800px">
Emp Code : <input type="text" class="custom_date" name="empcode" id="empcode" value="" required/>
<!--From Date : <input type="text" class="custom_date" name="start_date" id="start_date" value="" required/>

To Date :<input type="text" class="custom_date" name="to_date" id="to_date" value="" required/>
CL : <input type="number" class="custom_date" name="cl" id="cl" value="" required/><br />
SL : <input type="number" class="custom_date" name="sl" id="sl" value="" required/><br />
EL : <input type="number" class="custom_date" name="el" id="el" value="" required/><br />
Comp-Off : <input type="number" class="custom_date" name="comp" id="comp" value="" required/>-->

</div>
<!--<h2>Employees :</h2> -->
<?php 
  $user_id = $idu;
  $key = 'mgrid';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
?>


<br />
<input type="submit" name="submit" value="Search" />
</form>



<br />

<?php

if(isset($_POST['submit'])){

$ecode = $_POST['empcode'];
$sdat = $_POST['start_date'];
$tda = $_POST['to_date'];
$cl = $_POST['cl'];
$el = $_POST['el'];
$sl = $_POST['sl'];
$comp = $_POST['comp'];

$myStr = substr($sdat, 0, 4);
//echo $myStr;

$sempelev = ("SELECT *FROM wp_emp_leave_list WHERE Ecode = '$ecode' GROUP BY Name,ECode");
$list_elev = $wpdb->get_results($sempelev);
echo "<h2>Edit Leave Details</h2>";
//echo  $search_string;
echo "<form method='post' enctype='multipart/form-data'>";
echo "<table>";
foreach($list_elev as $list_elev){





$stat = $list_elev->Absent;

$satd = $list_elev->Date;



$cour = $list_y->ID;


echo "<tr>";
echo "<td>";
/*echo 'Date :';
echo "<input type='text' name = 'edat' value='".$sdat."'/><br />";*/

echo 'ECode : <br />';
echo "<input type='text' name = 'ecode' value='".$list_elev->ecode."' readonly/>";
echo 'Name : <br />';

echo "<input type='text' name = 'ename' value='".$list_elev->name."' readonly/>";
echo 'From : <br />';
echo "<input type='text' name = 'from' value='".$list_elev->from."'/>";
echo 'To : <br />';

echo "<input type='text' name = 'to' value='".$list_elev->to."'/>";

echo 'CL : <br />';

echo "<input type='text' name = 'cl' value='".$list_elev->cl."'/>";
echo 'SL : <br />';
echo "<input type='text' name = 'sl' value='".$list_elev->sl."'/><br />";
echo 'EL : <br />';
echo "<input type='text' name = 'el' value='".$list_elev->el."'/><br />";
echo 'Comp Off : <br />';
echo "<input type='text' name = 'compoff' value='".$list_elev->compoff."'/><br />";
echo "<input type='submit' name='updates' value='UPDATE' />";
echo "</td>";


echo "</tr>";


}
echo "</table>";
echo "</form>";

}
if(isset($_POST['updates'])){

$fro = $_POST['from'];
$ot = $_POST['to'];
$cl = $_POST['cl'];
$sl = $_POST['sl'];

$el = $_POST['el'];
$comp = $_POST['compoff'];
$ecode = $_POST['ecode'];

$updat = mysql_query("UPDATE wp_emp_leave_list SET  `from` = '$fro', `to` = '$ot', `cl` = '$cl', `sl` = '$sl', `el` = '$el', `compoff` = '$comp' WHERE `ecode` = '$ecode' ");

echo "<h2>LEAVES DATA UPDATED SUCCESSFULLY</h2>";







}

else { 
//echo '<h2>Sorry, You dont have permission to view this page.</h2>'; 
}  
}
?>


<?php } else {

echo do_shortcode('[wp-members page=login]');

} ?>

</td></tr></table>
</div></div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php get_footer(); ?>
