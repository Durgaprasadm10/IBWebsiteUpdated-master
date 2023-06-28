<?php

$DB_Server = "ideabytesdb.c6hujshgwzfd.us-east-1.rds.amazonaws.com";   
$DB_Username = "ideabytes_wp";   
$DB_Password = "&(wp_ideabytes)&";                
$DB_DBName = "ideabytes_hrm";         
$DB_TBLName = "wp_attendance";  
$filename = "teamaverage". date('Y-m i-s');         


 $emp = $_GET['ecode'];
$sdat = $_GET['sdat'];
$tda = $_GET['toda'];
$stat = 'WeeklyOff';
$holiday = 'Holiday';
$absent = 'Absent';
//$emps = implode(',', $emp);


$start = strtotime($_GET['sdat']);
$end = strtotime($_GET['toda']);

$days_between = ceil(abs($end - $start) / 86400);

$between = $days_between + '1 ';



/*$sql = "select ECode,Name, COUNT(ECode) AS TotalWorkingDays, SEC_TO_TIME(SUM(TIME_TO_SEC(`WorkDur`))) AS NoofWorkingHours,  SEC_TO_TIME(AVG(TIME_TO_SEC(`WorkDur`))) AS Average from wp_attendance WHERE ECode IN ($emp) AND Date BETWEEN '$sdat' AND '$tda' AND Status = 'Present' GROUP BY ECode,Name";*/
$Connect = @mysql_connect($DB_Server, $DB_Username, $DB_Password);
//select database   
$Db = @mysql_select_db($DB_DBName, $Connect);   
//execute query 
//$result = @mysql_query($sql,$Connect);    
$file_ending = "xls";
//header info for browser
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

?>

<?php
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

//echo $countla;

while($eekola = mysql_fetch_array($wofla)){

$stela = $eekola['idno'];
//$stek = array_count_values(array_map('strtolower', $stek));
//echo $stela .'<br />';

}


$wofcount = mysql_query("SELECT * FROM wp_attendance WHERE idno BETWEEN '$steon' AND '$stela' AND Status = '$stat' GROUP BY Date ");

$countall = mysql_num_rows($wofcount);

//echo $countall;

while($eekola = mysql_fetch_array($wofcount)){

//$stela = $eekola['idno'];
//$stek = array_count_values(array_map('strtolower', $stek));
//echo $stela .'<br />';

}
$wofhds = mysql_query("SELECT * FROM wp_attendance WHERE idno BETWEEN '$steon' AND '$stela' AND Status = '$holiday' GROUP BY Date ");

$countholid = mysql_num_rows($wofhds);

//echo $countall;

while($eekola = mysql_fetch_array($wofhds)){

//$stela = $eekola['idno'];
//$stek = array_count_values(array_map('strtolower', $stek));
//echo $stela .'<br />';

}

$wofabse = mysql_query("SELECT * FROM wp_attendance WHERE idno BETWEEN '$steon' AND '$stela' AND Status = '$absent' GROUP BY Date ");

$coua = mysql_num_rows($wofabse);

//echo $countall;

while($eekola = mysql_fetch_array($wofabse)){

//$stela = $eekola['idno'];
//$stek = array_count_values(array_map('strtolower', $stek));
//echo $stela .'<br />';

}

?>



<?php


 $qry="select ECode,Name, COUNT(ECode) AS TotalWorkingDays, SEC_TO_TIME(SUM(TIME_TO_SEC(`WorkDur`))) AS NoofWorkingHours,  SEC_TO_TIME(AVG(TIME_TO_SEC(`WorkDur`))) AS Average from wp_attendance WHERE ECode IN ($emp) AND Date BETWEEN '$sdat' AND '$tda' AND Status = 'Present' GROUP BY ECode,Name";
 $result=mysql_query($qry);


 $records = array();

 while($row = mysql_fetch_assoc($result)){ 
    $records[] = $row;
  }

?>
<div class="row" style="height:300px;overflow:scroll;">
                        <table id="employees" class="table table-striped">
                <thead>         
                    <tr class="warning">
                        <th>Date</th>
                        <th>Ecode</th>
                        <th>Name</th>
<th>Total No Of<br />Days</th>
                        <th>Total Working<br />Days</th>
<th>No of<br />Working<br />Hours</th>
 

<th>Week Off</th>
<th>Holidays</th>
<th>Leave</th>
<th>Average</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($records as $rec):?>
                    <tr>
                        <td><?php echo $sdat. '--to--' .$tda; ?></td>
                        <td><?php echo $rec['ECode']; ?></td>
                        <td><?php echo $rec['Name']; ?></td>
<td><?php echo $between; ?></td>
                        <td><?php echo $rec['TotalWorkingDays']; ?></td>
<td><?php echo $rec['NoofWorkingHours']; ?></td>
<td><?php echo $countall; ?></td>
<td><?php echo $countholid; ?></td>
<?php 
$leco = $countall + $countholid + $rec['TotalWorkingDays'];
$leav = $between - $leco;
?>

<td><?php echo $leav; ?></td>
<td><?php echo $rec['Average']; ?></td> 
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                    </table>
</div>
