<?php /* Template Name: MANAGER AVERAGE */ ?>
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
<th>Note:You have Timesheet Attendance from 1st April 2016.</th>
<tr><td>
<?php //echo get_calendar(); ?>
<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();

if(($roll) == 'editor'){

?>

<link rel="stylesheet" href="<?php echo plugins_url(); ?>/javascripts/uijquery.css">
  <script src="<?php echo plugins_url(); ?>/javascripts/uijquery.js"></script>
  <script src="<?php echo plugins_url(); ?>/javascripts/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#start_date" ).datepicker({
dateFormat : 'yy-mm-dd',
      //defaultDate: "+1w",
defaultDate: "0",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to_date" ).datepicker({
dateFormat : 'yy-mm-dd',
     // defaultDate: "+1w",
defaultDate: "0",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>




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
LEAVE : <input type="radio" name="status" value="absent" checked />--><br />
<input type="submit" name="submit" value="Search" />
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

$wof = mysql_query("SELECT * FROM wp_attendance WHERE ECode ='$rid' AND Date BETWEEN '$sdat' AND '$tda' AND Status = '$stat' GROUP BY Date");

$count=mysql_num_rows($wof);

//echo $count;

while($eeko = mysql_fetch_array($wof)){

//$stek = array($eeko['Status']);
//$stek = array_count_values(array_map('strtolower', $stek));
//echo $stek;

}

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


//$wofcount = mysql_query("SELECT * FROM wp_attendance WHERE idno BETWEEN '$steon' AND '$stela' AND Status = '$stat' GROUP BY Date ");
$wofcount = mysql_query("SELECT * FROM wp_attendance WHERE Date BETWEEN '$sdat' AND '$tda' AND Status = '$stat' GROUP BY Date ");
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


$list_q = mysql_query("select ECode,Name,SEC_TO_TIME(AVG(TIME_TO_SEC(`WorkDur`))) AS work, SEC_TO_TIME(SUM(TIME_TO_SEC(`WorkDur`))) AS totwork, COUNT(ECode) AS cody from wp_attendance WHERE ECode = '$rid' AND Date BETWEEN '$sdat' AND '$tda' AND Status = 'Present' GROUP BY ECode,Name");
//$list_r = $wpdb->get_results($list_q);

echo "<h2>Details</h2>";
//echo  $search_string;
echo "<table><th>Date</th><th>Ecode</th><th>Name</th><th>Total<br /> Working<br /> Days</th><th>No of <br />Working <br />Hours</th><th>Week Off</th><th>Average</th>";


while($list_y = mysql_fetch_array($list_q)){

$stat = $list_y['Absent'];

if(($stat) != 'Absent'){

$cour = $list_y->ID;


echo "<tr>";
echo "<td>";
echo $sdat. '----TO----' .$tda ;
echo "</td>";

echo "<td>";
echo $list_y['ECode'];
echo "</td>";

echo "<td>";
echo $list_y['Name'];
echo "</td>";

echo "<td>";
echo $list_y['cody'];
echo "</td>";

echo "<td>";
echo $list_y['totwork'];
echo "</td>";

echo "<td>";
echo $countall;
echo "</td>";

echo "<td>";
echo $list_y['work'];
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
