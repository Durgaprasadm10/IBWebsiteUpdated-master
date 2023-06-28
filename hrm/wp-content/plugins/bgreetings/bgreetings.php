<?php 

/*
    Plugin Name: Birthday Greetings
    Plugin URI: http://ideabytes.com/
    Description: Birthday Greetings Developed by IB.
    Author: IB
    Version: 1.7.18
    Author URI: http://www.ideabytes.com
    Contributors: IB
        Requires at least: 3.5
    Tested up to: 4.4.2
    Text Domain: birthday-greetings
    
    
 */
ob_start();

function bday_today( $atts ) {
global $wpdb;

$tda = date('d');
$tmon = date('m');
$tful = date('Y-m-d');



$list_bday = ("SELECT MONTH(dob) as tmonth, DAY(dob) as tday, firstname, lastname, image FROM wp_profile WHERE MONTH(dob) = '$tmon' AND DAY(dob) = '$tda'");// WHERE dob = '$tday' 
$list_bday = $wpdb->get_results($list_bday);



echo "<h3><u>TODAY’S BIRTHDAY’S</u></h3>";
foreach($list_bday as $list_bday){

//echo "Ideabytes wishing you all Many more returns of this day.<br />";

$image = $list_bday->image. "<br />";

	

$list_img = "select * from wp_posts WHERE ID = '$image'";
$list_img = $wpdb->get_results($list_img);

foreach($list_img as $list_img)
				{
$imgsoursc = $list_img->guid;
}
echo "<div align='center' style='border:1px #cccccc solid;'>";
echo "<br /><img src='$imgsoursc' width='90' height='90' /><br />";
echo '<strong>'.$list_bday->firstname.'</strong><br /><br />';
echo "</div>";
} 
}
add_shortcode( 'bdtoday', 'bday_today' );



function bday_thisweek( $atts ) {
global $wpdb;

$tda = date('d');
$tmon = date('m');
$tful = date('Y-m-d');

$sun = 'Sunday';
$mon = 'Monday';
$tue = 'Tuesday';
$wed = 'Wednesday';
$thu = 'Thursnday';
$fri = 'Friday';
$sat = 'Satday';

$wday = date('l');

$date = date('Y-m-d',time()-(1*86400));
//echo $date;

//echo date('Y-m-l');

$monday = strtotime("last monday");
$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
 
$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
 
$this_week_sd = date("Y-m-d",$monday);
$this_week_ed = date("Y-m-d",$sunday);

$this_week_sday = date("d",$monday);
$this_week_edya = date("d",$sunday);
 
//echo "Current week range from $this_week_sd to $this_week_ed ";

//echo $this_week_sday;
//echo $this_week_edya;


$list_bweek = ("SELECT MONTH(dob) as tmonth, DAY(dob) as tday, firstname, lastname, image FROM wp_profile WHERE MONTH(dob) = '$tmon' AND DAY(dob) BETWEEN '$this_week_sday' AND '$this_week_edya'");// WHERE dob = '$tday' 
$list_bweek = $wpdb->get_results($list_bweek);
echo "<br /><h3><u>BIRTHDAY’S IN THIS WEEK</u></h3>";
echo "<div align='center' style='height:200px; overflow: scroll;border:1px #cccccc solid;'>";
foreach($list_bweek as $list_bweek){


$image = $list_bweek->image. "<br />";

	

$list_imgweek = "select * from wp_posts WHERE ID = '$image'";
$list_imgweek = $wpdb->get_results($list_imgweek);

foreach($list_imgweek as $list_imgweek)
				{
$imgsoursc = $list_imgweek->guid;
}
$monthNum  = $list_bweek->tmonth;
$monthName = date('F', mktime(0, 0, 0, $monthNum, 10));

echo "<img src='$imgsoursc' width='72' height='72' /><br />";
echo '<strong>'.$list_bweek->firstname.'</strong>&nbsp;&nbsp;<br />';
echo '<strong>'.$list_bweek->tday.'</strong>&nbsp;-&nbsp;';
echo '<strong>'.$monthName.'</strong>&nbsp;&nbsp;<br />';
}echo "</div>";
}
add_shortcode( 'bdthisweek', 'bday_thisweek' );






function bday_thismonth( $atts ) {
global $wpdb;

$tda = date('d');
$tmon = date('m');
$tful = date('Y-m-d');
$list_bmonth = ("SELECT MONTH(dob) as tmonth, DAY(dob) as tday, firstname, lastname, image, dob FROM wp_profile WHERE MONTH(dob) = '$tmon'");// WHERE dob = '$tday' 
$list_bmonth = $wpdb->get_results($list_bmonth);
echo "<div align='center' style='height:200px; overflow: scroll;border:1px #cccccc solid;'>";
foreach($list_bmonth as $list_bmonth){


$image = $list_bmonth->image. "<br />";

	

$list_imgmonth = "select * from wp_posts WHERE ID = '$image'";
$list_imgmonth = $wpdb->get_results($list_imgmonth);

foreach($list_imgmonth as $list_imgmonth)
				{
$imgsoursc = $list_imgmonth->guid;
}
$monthNum  = $list_bmonth->tmonth;
$monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
echo "<img src='$imgsoursc' width='72' height='72' /><br />";
echo '<strong>'.$list_bmonth->firstname.'</strong>&nbsp;&nbsp;<br />';
echo '<strong>'.$list_bmonth->tday.'</strong>&nbsp;-&nbsp;';
echo '<strong>'.$monthName.'</strong>&nbsp;&nbsp;<br />';
}echo "</div>";
}
add_shortcode( 'bdthismonth', 'bday_thismonth' );

?>

