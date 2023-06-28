<?php /* Template Name: ENTER LEAVES */ ?>
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
From Date : <input type="text" class="custom_date" name="start_date" id="start_date" value="" required/>

To Date :<input type="text" class="custom_date" name="to_date" id="to_date" value="" required/>
CL : <input type="number" class="custom_date" name="cl" id="cl" value="" required/><br />
SL : <input type="number" class="custom_date" name="sl" id="sl" value="" required/><br />
EL : <input type="number" class="custom_date" name="el" id="el" value="" required/><br />
Comp-Off : <input type="number" class="custom_date" name="comp" id="comp" value="" required/>

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
<input type="submit" name="submit" value="Add" />
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
$sempelev = ("SELECT *FROM wp_attendance WHERE Ecode = '$ecode' GROUP BY Name,ECode");
$list_elev = $wpdb->get_results($sempelev);
foreach($list_elev as $list_elev){

$enam = $list_elev->Name;
$ecod = $list_elev->ECode;
//echo '<h3>Successfully leaves list added to '.$enam.'</h3>';

}

$sempelevlist = ("SELECT *FROM wp_emp_leave_list WHERE ecode = '$ecode' ");//
$list_elevlist = $wpdb->get_results($sempelevlist);
foreach($list_elevlist as $list_elevlist){

$enamlist = $list_elevlist->name;
$ecodlist = $list_elevlist->ecode;
$fromlist = substr($list_elevlist->from, 0, 4);
//echo '<h3>Successfully leaves list added to '.$enam.'</h3>';

}
//echo $fromlist;
//echo $ecodlist;
if(($ecode) == $ecodlist && $fromlist == $myStr  ){

echo '<h3>Already leaves list added to '.$enam.'</h3>';
} else {

$wpdb->insert('wp_emp_leave_list',
array(
'ecode'=>$ecode,
'name'=>$enam,
'from'=>$sdat,
'to'=>$tda,
'cl'=>$cl,
'sl'=>$sl,
'el'=>$el,
'compoff'=>$comp
),
array(
'%s','%s','%s','%s','%s','%s','%s','%s'));
echo '<h3>Successfully leaves list added to '.$enam.'</h3>';


}



}

else { 
//echo '<h2>Sorry, You dont have permission to view this page.</h2>'; 
}  
}
?>


<?php } else {

echo do_shortcode('[wp-members page=login]');

} ?>


</div></div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php get_footer(); ?>
