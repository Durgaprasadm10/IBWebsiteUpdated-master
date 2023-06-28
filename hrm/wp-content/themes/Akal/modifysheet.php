<?php /* Template Name: MODIFY SHEET */ ?>
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
<br />
<table>
<th>MODIFY ATTENDANCE SHEET</th>
<tr><td>
<?php //echo get_calendar(); ?>
<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();

if(($roll) == 'author'){

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
<script type="text/javascript"><!--
 
var formblock;
var forminputs;
 
function prepare() {
  formblock= document.getElementById('form_id');
  forminputs = formblock.getElementsByTagName('input');
}
 
function select_all(name, value) {
  for (i = 0; i < forminputs.length; i++) {
    // regex here to check name attribute
    var regex = new RegExp(name, "i");
    if (regex.test(forminputs[i].getAttribute('name'))) {
      if (value == '1') {
        forminputs[i].checked = true;
      } else {
        forminputs[i].checked = false;
  }
    }
  }
}
 
if (window.addEventListener) {
  window.addEventListener("load", prepare, false);
} else if (window.attachEvent) {
  window.attachEvent("onload", prepare)
} else if (document.getElementById) {
  window.onload = prepare;
}
 
//--></script>




<form id="form_id" method="post" enctype="multipart/form-data">
<div width="800px">From Date : <input type="text" class="custom_date" name="start_date" id="start_date" value=""/>

<!--To Date :<input type="text" class="custom_date" name="to_date" id="to_date" value=""/>--></div>
<!--<h2>Employees :</h2> -->
<?php 
  $user_id = $idu;
  $key = 'mgrid';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
?>

<?php 

/*$semp = mysql_query("SELECT *FROM wp_attendance WHERE Ecode IN ($user_last) GROUP BY NAME,ECODE LIMIT 20");

while($empsele = mysql_fetch_array($semp)){

$enam = $empsele['Name'];
$ecod = $empsele['ECode'];
//echo $ecod;
echo $enam .": <input type='checkbox' name='emp[]' value='".$ecod."' />&nbsp;&nbsp;&nbsp;&nbsp;";

}*/
//echo "<br />All : <input type='checkbox' name='emp[]' value='".$ecod."' />";
?>
<!--<br><br><a href="#" onClick="select_all('emp', '1');">Check All</a> | <a href="#" onClick="select_all('emp', 
'0');">Uncheck All</a><br><br>-->
<!--Challa VN Karthik Kumar <input type="checkbox" name="emp[]" value="1115" />
Brahmam Chowdary <input type="checkbox" name="emp[]" value="1117" />
Ajith Kumar B <input type="checkbox" name="emp[]" value="1095" />
J.Anand Gopal <input type="checkbox" name="emp[]" value="1126" /><br />

<h2>ATTENDANCE</h2>

PRESENT : <input type="radio" name="status" value="present" />
LEAVE : <input type="radio" name="status" value="absent" />--><br />
<input type="submit" name="submit" value="DELETE" />
</form>



<br />

<?php

if(isset($_POST['submit'])){

//$emp = $_POST['emp'];
$sdat = $_POST['start_date'];
$tda = $_POST['to_date'];
$stat = 'WeeklyOff';
//$emp =  implode('',$_POST['emp']); 

$emp=$_POST["emp"];
//$search_string = implode(',', $emp);


//ECode,Name,SEC_TO_TIME(AVG(TIME_TO_SEC(`WorkDur`))) AS work

$wof = mysql_query("SELECT * FROM wp_attendance WHERE ECode ='$rid' AND DATE BETWEEN '$sdat' AND '$tda' AND Status = '$stat' GROUP BY Date");

$count=mysql_num_rows($wof);

//echo $count;

while($eeko = mysql_fetch_array($wof)){

//$stek = array($eeko['Status']);
//$stek = array_count_values(array_map('strtolower', $stek));
//echo $stek;

}

$wofde = mysql_query("DELETE FROM wp_attendance WHERE Date = '$sdat'");

echo '<h2>The selected data deleted.</h2>';  

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
