<?php 

/*
    Plugin Name: TOTAL EMP AVERAGE
    Plugin URI: ideabytes.com/
    Description: TOTAL EMP AVERAGE Developed by IB. Team wise average [teamempaverage]
    Author: IB
    Version: 1.7.18
    Author URI: www.ideabytes.com
    Contributors: IB
        Requires at least: 3.5
    Tested up to: 4.4.2
    Text Domain: total-emp-average
    
    
 */
ob_start();
?>

<?php
function t_emp_average( $atts ) {
global $wpdb; 

?>
<?php global $current_user;
      get_currentuserinfo();
$name = $current_user->user_firstname;
$username = $current_user->user_login;
$usermail = $current_user->user_email;
$ename = $current_user->user_nicename;
$mgrcode = $current_user->mgr_code;
$empname = $current_user->display_name;
$idu = $current_user->ID;
$rid = $current_user->emp_code;
//echo $username;
?>
<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();


if(($roll) == 'author'){
ob_start();
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
<br />
<table>
<th>ALL EMP AVERAGE</th>
<tr><td>
<form id="form_id" method="post" enctype="multipart/form-data">
<div width="800px">
<table><tr><td>From Date : <input type="text" class="custom_date" name="start_date" id="start_date" value="" required/>
</td><td>
To Date :<input type="text" class="custom_date" name="to_date" id="to_date" value="" required/></td><td></td></tr></table></div>
<h2>Employees :</h2> 
<?php 
  $user_id = $idu;
  $key = 'mgrid';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
?>

<?php 

$semp = mysql_query("SELECT *FROM wp_attendance GROUP BY NAME,ECODE");

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
<br />
<input type="submit" name="submit" value="Search" />
</form>

</td></tr></table>

<br />

<?php

if(isset($_POST['submit'])){

//$emp = $_POST['emp'];
$sdat = $_POST['start_date'];
$tda = $_POST['to_date'];
$stat = 'WeeklyOff';
//$emp =  implode('',$_POST['emp']); 
$holiday = 'Holiday';
$emp=$_POST["emp"];
$search_string = implode(',', $emp);

echo do_shortcode('[printfriendly]');

$start = strtotime($_POST['start_date']);
$end = strtotime($_POST['to_date']);

$days_between = ceil(abs($end - $start) / 86400);

$between = $days_between + '1 ';

//ECode,Name,SEC_TO_TIME(AVG(TIME_TO_SEC(`WorkDur`))) AS work

$wof = mysql_query("SELECT * FROM wp_attendance WHERE ECode IN ($search_string) AND DATE BETWEEN '$sdat' AND '$tda' AND Status = '$stat' GROUP BY Date");

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
$wofhds = mysql_query("SELECT * FROM wp_attendance WHERE idno BETWEEN '$steon' AND '$stela' AND Status = '$holiday' GROUP BY Date ");

$countholid = mysql_num_rows($wofhds);

//echo $countholid;

while($eekola = mysql_fetch_array($wofhds)){

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

 
$list_q = mysql_query("select ECode,Name,SEC_TO_TIME(AVG(TIME_TO_SEC(`WorkDur`))) AS work, SEC_TO_TIME(SUM(TIME_TO_SEC(`WorkDur`))) AS totwork, COUNT(ECode) AS cody from wp_attendance WHERE ECode IN ($search_string) AND Date BETWEEN '$sdat' AND '$tda' AND Status = 'Present' GROUP BY ECode,Name");
//$list_r = $wpdb->get_results($list_q);
//ob_start();
?>
<!--<input type="hidden" name="empav[]" value="<?php echo $search_string; ?>" />-->
<?php //$deur = 'http://ideabytes.com/hrm/emp-average-export/?ecode='.$search_string.'sdat='.$sdat.'toda='.$tda; 
$deur = 'http://ideabytes.com/hrm/wp-content/themes/Akal/empexporttoexcelaverage.php?ecode='.$search_string.'&&sdat='.$sdat.'&&toda='.$tda;

?>
<br /><a href="<?php echo $deur;  ?>">Export to Excel</a>


<?php
//echo "<a href='#'>Export to Excel</a>";
//echo "<h2>Details</h2>";
//echo  $search_string;
echo "<table>
<tr><td style='background-color: #242a30;color:#FFFFFF;' colspan='10'><strong>EMPLOYEE ATTENDANCE</strong></td></tr>
<th>Date</th><th>Ecode</th><th>Name</th><th>Total<br /> No Of<br /> Days</th><th>Total<br /> Working<br /> Days</th><th>No of <br />Working <br />Hours</th><th>Week Off</th><th>Holidays</th><th>Leave</th><th>Average</th>";


while($list_y = mysql_fetch_array($list_q)){

$stat = $list_y['Absent'];

if(($stat) != 'Absent'){

$cour = $list_y->ID;


echo "<tr>";
echo "<td>";
echo $sdat. '----<br />TO----' .$tda ;
echo "</td>";

echo "<td>";
echo $list_y['ECode'];
echo "</td>";

echo "<td>";
echo $list_y['Name'];
echo "</td>";

echo "<td>";
echo $between;
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
echo $countholid;
echo "</td>";

$leco = $countall + $countholid + $list_y['cody'];
$leav = $between - $leco;

echo "<td>";
echo $leav;
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



//header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
//header("Content-Disposition: attachment; filename=codelution-export.xls");

/*echo do_shortcode("[tablemaster sql='SELECT * from wp_attendance where Ecode IN ($search_string) AND DATE BETWEEN '$sdat' AND '$tda' AND Status = '$stat'  GROUP BY Date,ECode,Name LIMIT 1' columns='Date,ECode,Name,AInTime,AOutTime,WorkDur,Status' class='black-header-gray-alternate-rows' ]"); */
}

else { 
//echo '<h2>Sorry, You dont have permission to view this page.</h2>'; 
}  
}
?>


<?php } else {

echo do_shortcode('[wp-members page=login]');

} 

}

?>


</div></div></td></tr></table>
<?php
add_shortcode( 'totalemp_average', 't_emp_average' );
include('auth-emp-average-by-team.php');
?>