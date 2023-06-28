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



 $qry="select * from wp_attendance WHERE ECode IN ($emp) AND Date BETWEEN '$sdat' AND '$tda' ORDER BY ECode, Date";
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
<th>A. Intime</th>
                        <th>A. Outtime</th>
<th>Work Dur</th>
<th>Status</th>

                    </tr>
                </thead>
                <tbody>
                <?php foreach($records as $rec):?>
                    <tr>
                        <td><?php echo $rec['Date']; ?></td>
                        <td><?php echo $rec['ECode']; ?></td>
                        <td><?php echo $rec['Name']; ?></td>
<td><?php echo $rec['AInTime']; ?></td>
                        <td><?php echo $rec['AOutTime']; ?></td>
<td><?php echo $rec['WorkDur']; ?></td>
<td><?php echo $rec['Status']; ?></td>

                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                    </table>
</div>
