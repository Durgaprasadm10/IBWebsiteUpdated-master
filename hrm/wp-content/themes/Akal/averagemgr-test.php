<?php /* Template Name: AVERAGE MANAGER TEST*/ ?>
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

if(($roll) == 'editor'){

?>
<link rel="stylesheet" href="<?php echo plugins_url(); ?>/javascripts/uijquery.css">
  <script src="<?php echo plugins_url(); ?>/javascripts/uijquery.js"></script>
  <script src="<?php echo plugins_url(); ?>/javascripts/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#start_date" ).datepicker({
dateFormat : 'd/m/yy',
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to_date" ).datepicker({
dateFormat : 'd/m/yy',
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>
<style>
body {
	font-family: "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";
	font-size: 72.5%;
}

</style>



<form id="form_id" method="post" enctype="multipart/form-data">
<div width="800px">From Date : <input type="text" class="custom_date" name="start_date" id="start_date" value=""/>

To Date :<input type="text" class="custom_date" name="to_date" id="to_date" value=""/></div>
<h2>Employees :</h2> 
<?php 
  $user_id = $idu;
  $key = 'mgrid';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
?>

<?php 

$semp = mysql_query("SELECT *FROM wp_attendance WHERE Ecode IN ($user_last) GROUP BY NAME,ECODE LIMIT 20");

while($empsele = mysql_fetch_array($semp)){

$enam = $empsele['Name'];
$ecod = $empsele['ECode'];
//echo $ecod;
echo $enam .": <input type='checkbox' name='emp[]' value='".$ecod."' />&nbsp;&nbsp;&nbsp;&nbsp;";

}
//echo "<br />All : <input type='checkbox' name='emp[]' value='".$ecod."' />";
?>
<br><br><a href="#" onClick="select_all('emp', '1');">Check All</a> | <a href="#" onClick="select_all('emp', 
'0');">Uncheck All</a><br><br>
<!--Challa VN Karthik Kumar <input type="checkbox" name="emp[]" value="1115" />
Brahmam Chowdary <input type="checkbox" name="emp[]" value="1117" />
Ajith Kumar B <input type="checkbox" name="emp[]" value="1095" />
J.Anand Gopal <input type="checkbox" name="emp[]" value="1126" /><br />

<h2>ATTENDANCE</h2>

PRESENT : <input type="radio" name="status" value="present" />
LEAVE : <input type="radio" name="status" value="absent" />--><br />
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
$search_string = implode(',', $emp);


//ECode,Name,SEC_TO_TIME(AVG(TIME_TO_SEC(`WorkDur`))) AS work

$wof = mysql_query("SELECT * FROM wp_attendance WHERE ECode IN ($search_string) AND DATE BETWEEN '$sdat' AND '$tda' AND Status = '$stat' GROUP BY Date");

$count=mysql_num_rows($wof);

//echo $count;

while($eeko = mysql_fetch_array($wof)){

//$stek = array($eeko['Status']);
//$stek = array_count_values(array_map('strtolower', $stek));
//echo $stek;

}


/*echo do_shortcode('[tablemaster sql="select ECode,Name,SEC_TO_TIME(AVG(TIME_TO_SEC(__SC__WorkDur__SC__))) AS work, SEC_TO_TIME(SUM(TIME_TO_SEC(__SC__WorkDur__SC__))) AS totwork, COUNT(ECode) AS cody from wp_attendance WHERE ECode IN ($search_string) AND DATE BETWEEN __SC__$sdat__SC__ AND __SC__$tda__SC__ AND Status <> __SC__$stat__SC__ GROUP BY ECode,Name" columns="ECode,Name,work,totwork,work,Status" class="black-header-gray-alternate-rows" ]'); */

 
$list_q = mysql_query("select ECode,Name,SEC_TO_TIME(AVG(TIME_TO_SEC(`WorkDur`))) AS work, SEC_TO_TIME(SUM(TIME_TO_SEC(`WorkDur`))) AS totwork, COUNT(ECode) AS cody from wp_attendance WHERE ECode IN ($search_string) AND DATE BETWEEN '$sdat' AND '$tda' AND Status <> '$stat' GROUP BY ECode,Name");
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
echo $count;
echo "</td>";

echo "<td>";
echo $list_y['work'];
echo "</td>";
echo "</tr>";

} else {

echo "<tr><td colSpan='7'><h2>No Leave details found.</h2></td></tr>";
}
}

//echo $idu;
 
//echo $rid;

//$Absent = 'Absent';

//echo $key;



echo "</table>";


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
