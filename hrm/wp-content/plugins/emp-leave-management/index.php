<?php 

/*
    Plugin Name: EMP LEAVE MANAGEMENT
    Plugin URI: http://ideabytes.com/
    Description: LEAVE MANAGEMENT Developed by IB. Apply leave[applyleaves] Leave Reports [complete_leave_details]
    Author: IB
    Version: 1.7.18
    Author URI: http://www.ideabytes.com
    Contributors: IB
        Requires at least: 3.5
    Tested up to: 4.4.2
    Text Domain: emp-leave-management
    
    
 */
ob_start();
?>

<?php
function available_leaves( $atts ) {
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
<?php //echo get_calendar(); ?>
<?php //if ( is_user_logged_in() ) { 

//$roll = get_user_role();

//if(($roll) == 'subscriber' || $roll == 'author' || $roll == 'editor' || $roll == ''){

?>
<table style="background-color: #ffffff !important;border: none;"><tr><td style="background-color: #ffffff !important;border: none;">
<?php
/*echo do_shortcode("[tablemaster sql='SELECT ecode,name,SUM(cl) as cl,SUM(sl) as sl, SUM(el) as el, SUM(compoff) as compoff from wp_emp_leave_list WHERE ecode = $rid GROUP BY ecode' columns='ecode,name,cl,sl,el,compoff' class='black-header-gray-alternate-rows']");*/

$showleave = ("SELECT ecode, name, SUM(cl) as cl, SUM(sl) as sl, SUM(el) as el, SUM(compoff) as compoff FROM wp_emp_leave_list WHERE ecode = '$rid' GROUP BY ecode"); 
echo "<table>
<tr><td style='background-color: #242a30;color:#FFFFFF;' colspan='4'><strong>TOTAL LEAVES</strong></td></tr>
<th>CLs</th><th>SLs</th><th>ELs</th><th>Comp-Offs</th>"; //<th>Ecode</th><th>Name</th>
$showleavelist = $wpdb->get_results($showleave);

foreach($showleavelist as $showleavelist){

$showecode = $showleavelist->ecode;
$showname = $showleavelist->name;
$showcl = $showleavelist->cl;
$showsl = $showleavelist->sl;
$showel = $showleavelist->el;
$showcomp = $showleavelist->compoff;
echo "<tr>";
//echo "<td>".$showecode."</td>";
//echo "<td>".$showname."</td>";
echo "<td>".$showcl."</td>";
echo "<td>".$showsl."</td>";
echo "<td>".$showel."</td>";
echo "<td>".$showcomp."</td></tr>";
}
echo "</table>";
 ?>
<br />

<?php
/*echo do_shortcode("[tablemaster sql='SELECT ecode,ename,SUM(noofdays) as nod, type from wp_leave WHERE ecode = $rid AND status = 'Approved' GROUP BY type' columns='ecode,ename,nod,type' class='black-header-gray-alternate-rows']");*/

$usedleave = ("SELECT ecode,ename,SUM(noofdays) as nod, type FROM wp_leave WHERE ecode = '$rid' AND status = 'Approved' GROUP BY ecode, type"); 
echo "<table>
<tr><td style='background-color: #242a30;color:#FFFFFF;' colspan='4'><strong>USED LEAVES</strong></td></tr>
<th>Type</th><th>No of Days used</th><th>Actions</th>";//<th>Ecode</th><th>Name</th>
$usedleavelist = $wpdb->get_results($usedleave);

foreach($usedleavelist as $usedleavelist){

$usedecode = $usedleavelist->ecode;
$usedname = $usedleavelist->ename;
$usednod = $usedleavelist->nod;
$usedtype = "<a href='/hrm/leave-type/?types=$usedleavelist->type' target='popup' onclick='window.open(/hrm/leave-type/?types=$usedleavelist->type,name,width=600,height=400)'>".$usedleavelist->type."</a>";

echo "<tr>";
//echo "<td>".$usedecode."</td>";
//echo "<td>".$usedname."</td>";
//echo "<td>".$usedtype."</td>"; 

echo "<td>"; ?>

<?php $deur = 'http://ideabytes.com/hrm/emp-leave-type/?types='.$usedleavelist->type.'&&ecode='.$usedecode; ?>
<a href="<?php echo $deur;  ?>" onclick="javascript:void window.open('<?php echo $deur; ?>','27','width=900,height=500,toolbar=0,menubar=1,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;"><?php echo $usedleavelist->type; ?></a>

<?php
echo "</td>";

echo "<td>".$usednod."</td>"; 
echo "<td>";
?>
<?php $deur = 'http://ideabytes.com/hrm/emp-leave-type/?types='.$usedleavelist->type.'&&ecode='.$usedecode; ?>
<a href="<?php echo $deur;  ?>" onclick="javascript:void window.open('<?php echo $deur; ?>','27','width=900,height=500,toolbar=0,menubar=1,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;"><?php //echo $usedleavelist->type; ?><!--<img src="http://ideabytes.com/hrm/wp-content/themes/Akal/images/view.jpeg" />-->View</a>

<?php
echo "</td>";
echo "</tr>";
}
echo "</table>";


 ?>

<?php 

/*echo do_shortcode("[tablemaster sql='SELECT ecode,name,SUM(cl) as cl,SUM(sl) as sl, el, compoff from wp_emp_leave_list WHERE ecode = $rid GROUP BY ecode' columns='ecode,name,cl,sl,el,compoff' class='black-header-gray-alternate-rows']"); */


$addleave = ("SELECT emp.ecode, emp.name, SUM(cl) as cl, SUM(sl) as sl, SUM(el) as el, SUM(compoff) as compoff, wpl.ecode, wpl.status, COUNT(type) as type FROM wp_emp_leave_list emp

LEFT JOIN wp_leave wpl ON emp.ecode = wpl.ecode


WHERE emp.ecode = '$rid' AND wpl.status = 'Approved' GROUP BY emp.ecode, type"); 
$addleavelist = $wpdb->get_results($addleave);
echo "<table>
<tr><td style='background-color: #242a30;color:#FFFFFF;' colspan='4'><strong>AVAILABLE LEAVES</strong></td></tr>
<th>CLs</th><th>SLs</th><th>ELs</th><th>Comp-Offs</th>";//<th>Ecode</th><th>Name</th>

foreach($addleavelist as $addleavelist){

$addecode = $addleavelist->ecode;
$addname = $addleavelist->name;
$addcl = $addleavelist->cl;
$addsl = $addleavelist->sl;

$addel = $addleavelist->el;
$addcomp = $addleavelist->compoff;
}

$typescl = ("SELECT COUNT(type) as types, type, SUM(noofdays) as noofdays FROM wp_leave WHERE  ecode = '$rid' AND type = 'CL' AND status = 'Approved' GROUP BY ecode, type"); 
$typesclist = $wpdb->get_results($typescl);

foreach($typesclist as $typesclist){

$addtypes = $typesclist->noofdays;
$ltype = $typesclist->type;

//echo $addtypes;

}

$typeslev = ("SELECT COUNT(type) as typevels, type, SUM(noofdays) as noofdays FROM wp_leave WHERE  ecode = '$rid' AND type = 'SL' AND status = 'Approved' GROUP BY ecode, type"); 
$typevels = $wpdb->get_results($typeslev);

foreach($typevels as $typevels){

$velstypes = $typevels->noofdays;
$ltype = $typesclist->type;

//echo $addtypes;

}

$typelearn = ("SELECT COUNT(type) as typelearn, type, SUM(noofdays) as noofdays FROM wp_leave WHERE  ecode = '$rid' AND type = 'EL' AND status = 'Approved' GROUP BY ecode, type"); 
$learntype = $wpdb->get_results($typelearn);

foreach($learntype as $learntype){

$addlearn = $learntype->noofdays;
$ltype = $typesclist->type;

//echo $addtypes;

}

$typecompoff = ("SELECT COUNT(type) as typescomp, type, SUM(noofdays) as noofdays FROM wp_leave WHERE  ecode = '$rid' AND type = 'Comp-Off' AND status = 'Approved' GROUP BY ecode, type"); 
$typecomplist = $wpdb->get_results($typecompoff);

foreach($typecomplist as $typecomplist){

$addcomptypes = $typecomplist->noofdays;
$ltype = $typecomplist->type;

//echo $addtypes;

}

$comptype =  $showcomp - $addcomptypes;
$slc = $showcl - $addtypes;
$leavs = $showsl - $velstypes;
$earn = $showel - $addlearn;

echo "<tr>";
//echo "<td>".$addecode."</td>";
//echo "<td>".$addname."</td>";
echo "<td>".$slc."</td>";
echo "<td>".$leavs."</td>";
echo "<td>".$earn."</td>";
echo "<td>".$comptype."</td></tr>";



//echo '<h2>'.$addcl - $typecl.'</h2>';
echo "</table>";
/*if(($ecode) == '$rid' && $from == '$sdat' ){

echo 'You already submitted leave request for the given dates.';

} else { echo 'Your leave request submitted successfully.'; }*/

?>

</td></tr></table>

<?php 

//}
// }
}
add_shortcode( 'available_leave', 'available_leaves' );

?>
<?php 
include('apply-leave.php'); 
include('emp-complete-leave-details.php'); 
include('recent-leave.php');
?>