<?php
function emp_assign_mngr( $atts ) {
global $wpdb; 

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
<?php //echo get_calendar(); ?>
<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();

if(($roll) == 'author'){

?>
<br />
<table>
<th>EMP ID</th><th>EMP NAME</th><th>ASSIGNED MANAGER</th>
<tr><td>
<?php



$mymn = ("SELECT *FROM wp_users WHERE emp_code = '$ecod'");
$list_r = $wpdb->get_results($mymn);

foreach($list_r as $list_emp){
$mid = $list_emp->ID;
echo '<h3> MANAGER : '.$list_emp->mgr_name.'</h3><br />';
}

  $user_id = $mid;
  $key = 'mgrid';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 //echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
//echo $ecod;
//echo $user_id;
//$semp = mysql_query("SELECT *FROM wp_attendance GROUP BY Name,ECode ORDER BY ECode"); //WHERE ECode IN ($user_last)

$start=0;
$limit=10;

if(isset($_GET['id']))
{
$id=$_GET['id'];
$start=($id-1)*$limit;
}



$semp = mysql_query("SELECT *FROM wp_users ORDER BY emp_code LIMIT $start, $limit"); //GROUP BY Name,ECode ORDER BY ECode
while($empsele = mysql_fetch_array($semp)){

//$enam = $empsele['Name'];
//$ecod = $empsele['ECode'];
$enam = $empsele['user_nicename'];
$ecod = $empsele['emp_code'];
$eid = $empsele['assign_mgr'];
$mgrname = $empsele['mgr_name'];
$mymn = ("SELECT *FROM wp_users WHERE emp_code = '$eid'");
$list_r = $wpdb->get_results($mymn);

foreach($list_r as $list_emp){
$mid = $list_emp->ID;
$mgna = $list_emp->mgr_name;
//echo '<h3> MANAGER : '.$list_emp->mgr_name.'</h3><br />';
}
//echo $ecod;
//echo $ecod.'&nbsp;&nbsp;&nbsp;&nbsp;'. $enam ."<br />";
echo "<tr>";
echo "<td>";
echo $ecod;
echo "</td>";
echo "<td>";
echo $enam;
echo "</td>";
echo "<td>";
echo $mgna;
echo "</td>";
echo "</tr>";
}

echo "<tr><td colspan='9' style='text-align: -webkit-center;'>";//mgrid = '$rid'
//echo "<li><a href='?id=".$rid."'>".$rid."</a></li>";

$rows=mysql_num_rows(mysql_query("SELECT *FROM wp_users"));
$total=ceil($rows/$limit);

if($id>1)
{
echo "<a href='?id=".($id-1)."' class='buttons'>PREVIOUS</a>";
}
if($id!=$total)
{
echo "<a href='?id=".($id+1)."' class='buttons'>NEXT</a>";
}
echo "<ul class='pages'>";
for($i=1;$i<=$total;$i++)
{
if($i==$id) { echo "<li class='currents' style='list-style-type: none;'>".$i."</li>"; }

else { echo "<li style='list-style-type: none;'><a href='?id=".$i."'>".$i."</a></li>"; }
}
echo "</ul>";
echo "</td>";
echo "</tr>";

}
}

?>

</td></tr></table>
</div></div>

<br /><br /><br /><br />

<?php
}
add_shortcode( 'empassignedmngr', 'emp_assign_mngr' );

?>