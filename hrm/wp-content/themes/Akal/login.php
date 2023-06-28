<?php /* Template Name: LOGIN */ ?>
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
<table><tr><td>
<?php 

if ( is_user_logged_in() ) { ?>
<?php 
  $user_id = $idu;
  $key = 'addr1';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
?>
<!--<div style="display: flex;"><div style="display: flex;"><h2><a href="http://hrm.ideabytes.com/my-attendance/">Attendance</a></h2></div>
<div style="display: flex;padding-left:20%;"><h2><a href="http://hrm.ideabytes.com/leave-management/">Leave Management</a></h2></div>
<div style="display: flex;padding-left:20%;"><h2><a href="http://efforts.ideabyte.net/" target="_blank">Timesheets/Project Management</a></h2></div></div>
<h2><a href="http://hrm.ideabytes.com/#" target="_blank">ACCOUNT</a><br /></h2>
<h2><a href="http://hrm.ideabytes.com/#" target="_blank">I-Drive</a><br /></h2>
<h2><a href="http://hrm.ideabytes.com/#" target="_blank">CRM</a><br /></h2>
<h2><a href="http://hrm.ideabytes.com/#" target="_blank">POLICIES</a><br /></h2>-->
<br /><br /><br />


<!--<!DOCTYPE html>
<html>-->
    
<head>
       <!-- <title>Ideabytes</title>-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <link rel="stylesheet" type="text/css" href="http://ideabytes.com/hrm/css/metro.css" />
        <link rel="stylesheet" type="text/css" href="http://ideabytes.com/hrm/css/metro_mobile.css" media="screen and (max-height: 500px), screen and (orientation:portrait)" />
        <link rel="stylesheet" type="text/css" href="http://ideabytes.com/hrm/css/demo.css" />
        <script type="text/javascript" src="http://ideabytes.com/hrm/javascript/jquery.js"></script>
        <script type="text/javascript" src="http://ideabytes.com/hrm/javascript/metro.js"></script>
     
        <!-- Computed in PHP based on your settings -->
        <style>
            #widget_scroll_container {
                width: 2160px;
            }
            div.widget_container {
                width: 1200px;
            }
            div.widget_container.half {
                width: 400px;
            }
            @media screen and (max-height: 680px) {
                #widget_scroll_container {
                    width: 1660px;
                }
                div.widget_container {
                    width: 900px;
                }
                div.widget_container.half {
                    width: 300px;
                }
            }
        </style>
    </head>
   <br /><br /><br /><br />
        <div id="widget_scroll_container">
            <div class="widget_container full" data-num="0">
                <div class="widget widget4x2 widget_orange animation unloaded">
                    <a href="http://hrm.ideabyte.net/my-attendance/"><div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/attendance.png');">
                            <span>Attendance</span>
                        </div>
                    </div></a>
                </div>
                  <div class="widget widget2x2 widget_darkred animation unloaded">
                   <!-- <div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_editable.png');">
                            <span>Typography</span>
                        </div>
                    </div>-->
                </div>
                <div class="widget widget4x2 widget_red widget_link animation unloaded" style="background-color:#3E3F3A;">
                    <a href="http://efforts.ideabyte.net/" target="_blank"><div class="widget_content">
                        <div class="main" style="background-color:#3E3F3A;background-image:url('http://ideabytes.com/hrm/images/task.png');">
                            <span>Time Sheets / Project Management </span>
                        </div>
                    </div></a>
                </div>
              
                <div class="widget widget2x2 widget_green animation unloaded">
                    <!--<div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_metro_gallery.png');">
                            <span>Metro Gallery</span>
                        </div>
                    </div>-->
                </div>
                <!-- <div class="widget widget2x2 widget_darkblue animation unloaded" data-url="contact.php" data-theme="darkblue" data-name="Contact">
                    <div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_contact.png');">
                            <span>Contact</span>
                        </div>
                    </div>
                </div>
                <div class="widget widget2x2 widget_red animation unloaded" data-url="royal_preloader.php" data-theme="red" data-name="royal_preloader">
                    <div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_royal_preloader.png');">
                            <span>Royal Preloader</span>
                        </div>
                    </div>
                </div>-->
                
                   <div class="widget widget2x2 widget_blue animation unloaded">
                      <!--<div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_sliding_menu.png');">
                            <span>Sliding Menu</span>
                        </div>
                    </div>-->
                </div>
                 <div class="widget widget4x2 widget_darkgreen animation unloaded" >
                    <a href="http://hrm.ideabyte.net/leave-management/"><div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/leave.png');">
                            <span>Leave Management</span>
                        </div>
                    </div></a>
                </div>
                <div class="widget widget2x2 widget_darkblue animation unloaded" >
                      <!--<div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_timeline.png');">
                            <span>timeline</span>
                        </div>
                    </div>-->
                </div>
                <div class="widget widget4x2 widget_darkblue animation unloaded" >
                     <!-- <div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_tab.png');">
                            <span>Royal Tab</span>
                        </div>
                    </div>-->
                </div>
                  <div class="widget widget2x2 widget_blue animation unloaded">
                     <!-- <div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_gallery.png');">
                            <span>3D Cube Gallery</span>
                        </div>
                    </div>-->
                </div>
                <div class="widget widget2x2 widget_red animation unloaded">
                    <!--<div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_chart.png');">
                            <span>grid slider</span>
                        </div>
                    </div>-->
                </div>
               
                
             
              
                
                 <!--<div class="widget widget2x2 widget_purple widget_link animation unloaded" data-url="" data-theme="purple" data-name="About" data-link="http://www.lee-le.com/#!about">
                    <div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_aboutme.png');">
                            <span>About Me</span>
                        </div>
                    </div>
                </div>
                <div class="widget widget1x1 widget_ widget_link animation unloaded" style="background-color:#3B5B99;" data-url="" data-theme="" data-name="Facebook" data-link="http://facebook.com/MelonHTML5">
                    <div class="widget_content">
                        <div class="main" style="background-color:#3B5B99;background-image:url('http://ideabytes.com/hrm/images/social/facebook.png');">
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="widget widget1x1 widget_ widget_link animation unloaded" style="background-color:#00ACED;" data-url="" data-theme="" data-name="Twitter" data-link="http://twitter.com/MelonHTML5">
                    <div class="widget_content">
                        <div class="main" style="background-color:#00ACED;background-image:url('http://ideabytes.com/hrm/images/social/twitter_w.png');">
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="widget widget1x1 widget_ widget_link animation unloaded" style="background-color:#232323;" data-url="" data-theme="" data-name="CodeCanyon" data-link="http://codecanyon.net/user/MelonHTML5">
                    <div class="widget_content">
                        <div class="main" style="background-color:#232323;background-image:url('http://ideabytes.com/hrm/images/social/codecanyon2.png');">
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="widget widget1x1 widget_yellow animation unloaded" data-url="" data-theme="yellow" data-name="Share">
                    <div class="widget_content">
                        <div class="main">
                            <span><iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.melonhtml5.com&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=true&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21&amp;appId=161905873924694" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
                              <div><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.melonhtml5.com" data-hashtags="MelonHTML5"></a></div></span>
                        </div>
                    </div>
                </div>
            </div>
             <!--<div class="widget_container half" data-num="1">
                <div class="widget widget2x2 widget_darkred animation unloaded" data-url="emu_slider.php" data-theme="darkred" data-name="emu_slider.html">
                    <div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_slider.png');">
                            <span>Emu Slider</span>
                        </div>
                    </div>
                </div>
                <div class="widget widget2x2 widget_darkblue animation unloaded" data-url="timeline_wp.php" data-theme="darkblue" data-name="timeline_wp">
                    <div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_timeline.png');">
                            <span>timeline wp</span>
                        </div>
                    </div>
                </div>
                <div class="widget widget2x2 widget_red animation unloaded" data-url="royal_preloader_wp.php" data-theme="red" data-name="royal_preloader_wp">
                    <div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_royal_preloader.png');">
                            <span>royal preloader wp</span>
                        </div>
                    </div>
                </div>
                <div class="widget widget2x2 widget_orange widget_link animation unloaded" data-url="" data-theme="orange" data-name="github" data-link="https://github.com/MelonHTML5">
                    <div class="widget_content">
                        <div class="main" style="background-image:url('http://ideabytes.com/hrm/images/widget_github.png');">
                            <span>GitHub</span>
                        </div>
                    </div>
                </div>
                <div class="widget widget2x2 widget_grey animation unloaded" data-url="blank.php" data-theme="grey" data-name="tile_00035">
                    <div class="widget_content">
                        <div class="main">
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="widget widget2x2 widget_grey animation unloaded" data-url="blank.php" data-theme="grey" data-name="tile_00036">
                    <div class="widget_content">
                        <div class="main">
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>-->
             <!--<div class="widget_container half" data-num="2">
                <div class="widget widget2x2 widget_grey animation unloaded" data-url="blank.php" data-theme="grey" data-name="tile_00023">
                    <div class="widget_content">
                        <div class="main">
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="widget widget2x2 widget_grey animation unloaded" data-url="blank.php" data-theme="grey" data-name="tile_00023">
                    <div class="widget_content">
                        <div class="main">
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="widget widget2x2 widget_grey animation unloaded" data-url="blank.php" data-theme="grey" data-name="tile_00024">
                    <div class="widget_content">
                        <div class="main">
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="widget widget2x2 widget_grey animation unloaded" data-url="blank.php" data-theme="grey" data-name="tile_00025">
                    <div class="widget_content">
                        <div class="main">
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="widget widget2x2 widget_grey animation unloaded" data-url="blank.php" data-theme="grey" data-name="tile_00026">
                    <div class="widget_content">
                        <div class="main">
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="widget widget2x2 widget_grey animation unloaded" data-url="blank.php" data-theme="grey" data-name="tile_00027">
                    <div class="widget_content">
                        <div class="main">
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
       
        
   <!-- </body>

</html>
-->










<?php

//$list_q = mysql_query("select * from wp_attendance WHERE Ecode = '$rid' AND Status = 'Absent' GROUP BY Date,ECode,Name");
//$list_r = $wpdb->get_results($list_q);

//echo "<h2>Leave Details</h2>";
//echo  $rid;
//echo "<table><th>Date</th><th>Ecode</th><th>Name</th><th>Intime</th><th>Outtime</th><th>Duration</th><th>Status</th>";


//while($list_y = mysql_fetch_array($list_q)){

//$stat = $list_y['Absent'];

//if(($stat) != 'Absent'){

/*$cour = $list_y->ID;


echo "<tr>";
echo "<td>";
echo $list_y['Date'];
echo "</td>";

echo "<td>";
echo $rid;
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
echo 'Leave';
echo "</td>";
echo "</tr>";*/

//} else {

//echo "<tr><td colSpan='7'><h2>No Leave details found.</h2></td></tr>";
//}
//}

//echo $idu;
 
//echo $rid;

//$Absent = 'Absent';

//echo $key;



echo "</table>";

/*echo do_shortcode("[tablemaster sql='SELECT * from wp_attendance where ECode __EQ__ $user_last GROUP BY Date,ECode,Name LIMIT 1' columns='Date,ECode,Name,AInTime,AOutTime,WorkDur,Status' class='black-header-gray-alternate-rows' ]"); */

?>


<?php } else {

echo do_shortcode('[wp-members page=login]');







} ?>

</td></tr></table>
</div></div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php //get_footer(); ?>
