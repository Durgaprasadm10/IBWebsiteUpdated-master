<?php /* Template Name: EMP ATTENDANCE SEARCH */ ?>
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

if(($roll) == 'subscriber' || $roll == ''){

?>

<h3>Note:You have Timesheet Attendance from 1st April 2016.</h3>

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
<table><tr><td>
<form id="form_id" method="post" enctype="multipart/form-data">
<div width="800px">From Date : <input type="text" class="custom_date" name="start_date" id="start_date" value="" required/>

To Date :<input type="text" class="custom_date" name="to_date" id="to_date" value="" required/></div>
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
//echo $enam .": <input type='checkbox' name='emp[]' value='".$ecod."' />&nbsp;&nbsp;&nbsp;&nbsp;";

}*/

?>
<!--<br><br><a href="#" onClick="select_all('emp', '1');">Check All</a> | <a href="#" onClick="select_all('emp', 
'0');">Uncheck All</a><br><br>-->
<!--Challa VN Karthik Kumar <input type="checkbox" name="emp[]" value="1115" />
Brahmam Chowdary <input type="checkbox" name="emp[]" value="1117" />
Ajith Kumar B <input type="checkbox" name="emp[]" value="1095" />
J.Anand Gopal <input type="checkbox" name="emp[]" value="1126" /><br />-->

<h2>ATTENDANCE</h2>

PRESENT : <input type="radio" name="status" value="present" />
LEAVE : <input type="radio" name="status" value="absent" />
<input type="submit" name="submit" value="Search" />
</form>

</td></tr>
</table>
<br />

<?php

if(isset($_POST['submit'])){

//$emp = $_POST['emp'];
$sdat = $_POST['start_date'];
$tda = $_POST['to_date'];
$stat = $_POST['status'];
//$emp =  implode('',$_POST['emp']); 

$emp=$_POST["emp"];
//$search_string = implode(',', $emp);

$wofon = mysql_query("SELECT * FROM wp_attendance WHERE Date = '$sdat' GROUP BY Date");

$counton = mysql_num_rows($wofon);

//echo $counton;

while($eekoon = mysql_fetch_array($wofon)){

$steon = $eekoon['idno'];
//$stek = array_count_values(array_map('strtolower', $stek));
//echo $steon .'<br />';

}

$wofla = mysql_query("SELECT * FROM wp_attendance WHERE Date = '$tda' GROUP BY Date");

//$countla = mysql_num_rows($wofla);

echo $countla;

while($eekola = mysql_fetch_array($wofla)){

$stela = $eekola['idno'];
//$stek = array_count_values(array_map('strtolower', $stek));
//echo $stela .'<br />';

}


$wofcount = mysql_query("SELECT * FROM wp_attendance WHERE idno BETWEEN '$steon' AND '$stela' AND Status = '$stat' GROUP BY Date ");

$countall = mysql_num_rows($wofcount);

//echo $countall;

while($eekola = mysql_fetch_array($wofla)){

//$stela = $eekola['idno'];
//$stek = array_count_values(array_map('strtolower', $stek));
//echo $stela .'<br />';

}

 $check = mysql_query("SELECT * FROM wp_attendance WHERE Date = '$tda'");

$check2 = mysql_num_rows($check);

if ($check2 == 0) {
    // No email found, so show an error to the user
    echo "Search results 'To date' Mismatch. Please try again!";
}
else
{

$list_q = mysql_query("select * from wp_attendance WHERE ECode = '$rid' AND Date BETWEEN '$sdat' AND '$tda' AND Status = '$stat' GROUP BY Date,ECode,Name ORDER BY idno ASC");
//$list_r = $wpdb->get_results($list_q);

echo "<h2>Details</h2>";
//echo  $search_string;
echo "<table><th>Date</th><th>Ecode</th><th>Name</th><th>A. Intime</th><th>A. Outtime</th><th>Work Dur</th><th>Status</th>";


while($list_y = mysql_fetch_array($list_q)){

$stat = $list_y['Absent'];

if(($stat) != 'Absent'){

$cour = $list_y->ID;


echo "<tr>";
echo "<td>";
echo $list_y['Date'];
echo "</td>";

echo "<td>";
echo $list_y['ECode'];
echo "</td>";

echo "<td>";
echo $list_y['Name'];
echo "</td>";

echo "<td>";
echo $list_y['AInTime'];
echo "</td>";

echo "<td>";
echo $list_y['AOutTime'];
echo "</td>";

echo "<td>";
echo $list_y['WorkDur'];
echo "</td>";

echo "<td>";
echo $list_y['Status'];
echo "</td>";
echo "</tr>";

} else {

echo "<tr><td colSpan='7'><h2>No Leave details found.</h2></td></tr>";
}
}
}
//echo $idu;
 
//echo $rid;

//$Absent = 'Absent';

//echo $key;



echo "</table>";

/*echo do_shortcode("[tablemaster sql='SELECT * from wp_attendance where Ecode IN ($search_string) AND DATE BETWEEN '$sdat' AND '$tda' AND Status = '$stat'  GROUP BY Date,ECode,Name LIMIT 1' columns='Date,ECode,Name,AInTime,AOutTime,WorkDur,Status' class='black-header-gray-alternate-rows' ]"); */
//}
?>

<?php } else { 

//echo '<h2>Sorry, You dont have permission to view this page.</h2>'; 
}  } ?>

<?php } else {

echo do_shortcode('[wp-members page=login]');

} ?>


</div></div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php get_footer(); ?>
