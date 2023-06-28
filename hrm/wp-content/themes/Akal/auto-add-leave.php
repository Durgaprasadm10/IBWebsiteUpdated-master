<?php /* Template Name: AUTO ADD LEAVE */ ?>
<?php
   global $wpdb;
get_header();

?>
<?php global $current_user;
      get_currentuserinfo();
$name = $current_user->user_firstname;
$username = $current_user->user_login;
$mgrcode = $current_user->mgr_code;
$idu = $current_user->ID;
//$rid = $current_user->emp_code;
//echo $username;

?>
<div class="container">
<div class="row-fluid" style="height:700px;">



<?php 

if ( is_user_logged_in() ) {
$roll = get_user_role();

if(($roll) == 'author'){



?>
<br />
<?php 

$semp = ("SELECT *FROM wp_attendance GROUP BY NAME,ECODE");
$list_addclsl = $wpdb->get_results($semp);
foreach($list_addclsl as $list_addclsl){

$name = $list_addclsl->Name;
$ecode = $list_addclsl->ECode;

//echo $ecode; 
//echo $name;



$dataddl = date('d');
$cl = '0.50';
$sl = '0.50';
//$ecode = '1002';
if(($dataddl) == 19 ){
$sqlmetappen = mysql_query("INSERT wp_add_leave (ecode, name, cl, sl)VALUES('$ecode','$name','$cl','$sl')");

$inseappen = mysql_query("INSERT wp_emp_leave_list (ecode, name, cl, sl)VALUES('$ecode','$name','$cl','$sl')");

echo 'Record added.';//. $user_id . $ecode
}
}
/*$sqlappend = ("SELECT SUM(cl) as ecl FROM wp_add_leave GROUP BY ecode");
$list_del = $wpdb->get_results($sqlappend);
foreach($list_del as $list_d){
echo $list_d->ecl;
}*/
echo do_shortcode("[tablemaster sql='SELECT ecode,name,SUM(cl) as empcl,SUM(sl) as empsl from wp_add_leave GROUP BY ecode' columns='ecode,name,empcl,empsl' class='black-header-gray-alternate-rows']"); 
}
}
?>

<?php //wp_insert_user( $userdata ); ?>

</div></div>
<?php get_footer(); ?>