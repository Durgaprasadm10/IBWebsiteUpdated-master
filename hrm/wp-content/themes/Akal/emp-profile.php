<?php /* Template Name: EMPLOYEE PRO */ ?>
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
<?php //echo get_calendar(); ?>
<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();

if(($roll) == 'author'){

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




<form id="form_id" method="post" enctype="multipart/form-data">
<div width="800px">
Emp Code : <input type="text" class="custom_date" name="empcode" id="empcode" value="" required/>
<!--From Date : <input type="text" class="custom_date" name="start_date" id="start_date" value="" />

To Date :<input type="text" class="custom_date" name="to_date" id="to_date" value=""/>--></div>
<!--<h2>Employees :</h2> -->
<?php 
  $user_id = $idu;
  $key = 'mgrid';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
?>
<br />
<input type="submit" name="submit" value="SEARCH" />
</form>



<br />

<?php

if(isset($_POST['submit'])){
$ecod = $_POST['empcode'];

//echo do_shortcode('[printfriendly]');
$sele = mysql_query("SELECT *FROM wp_profile WHERE ecode = '$ecod'");

while ($empdata = mysql_fetch_array($sele)){

$ecod = $empdata['ecode'];

$firstname = $empdata['firstname'];
$lastname = $empdata['lastname'];
$email = $empdata['email'];
$phone= $empdata['phone'];
$address = $empdata['address'];
$city = $empdata['city'];
$state = $empdata['state'];
$country = $empdata['country']; 
$zip = $empdata['zip'];
$doj = $empdata['doj'];
$bankname = $empdata['bankname'];
$acno = $empdata['acno'];
$epfno = $empdata['epfno'];
$aadhar = $empdata['aadhar'];
$driving = $empdata['driving'];
$passport = $empdata['passport'];
$visa = $empdata['visa'];
$image = $empdata['image'];
$information = $empdata['information'];



echo "<input class='text-input' name='ecode' type='hidden' id='ecode' value='$ecod' />";

}

 ?>
<?php 
$list_ecod = "select * from wp_users WHERE emp_code = '$ecod'";
$list_ecod = $wpdb->get_results($list_ecod);

foreach($list_ecod as $list_ecod)
				{
$empcode = $list_ecod->ID;
$assigncode = $list_ecod->assign_mgr;
//echo $empcode;
}
?>

<?php 
  $user_id = $empcode;
  $key = 'mgrid';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
?>

<?php

$list_img = "select * from wp_posts WHERE ID = '$image'";
$list_img = $wpdb->get_results($list_img);

foreach($list_img as $list_img)
				{
$imgsoursc = $list_img->guid;
}


?>
<?php echo do_shortcode('[printfriendly]'); ?>
        <br />    
<table>
<th>PERSONAL DETAILS</th> 
<tr><td><p class="form-username">
                        <label for="first-name"><h5>First Name :</h5></label>

                       <h3> <?php echo $firstname; ?></h3>
                    </p><!-- .form-username --></td>

<td>
<p class="form-username">
                        <label for="last-name"><h5>Last Name :</h5></label>
                         <h3> <?php echo $lastname; ?></h3>
                    </p><!-- .form-username -->

</td>

<td colSpan='2' rowSpan="2">

<p class="form-password">
                        <label for="pass2">Profile Picture</label><br />
                       <!-- <input class="file" name="image" type="file" id="Image" value="" />-->
<?php
echo "<img src='$imgsoursc' width='170' height='170' />";

?>

                    </p>


</td>
<tr>
<td>
<p class="form-email">
                        <label for="email"><h5>E-mail :</h5></label>
                      <h3><?php echo $email; ?></h3>
                    </p><!-- .form-email -->
</td>
<td>
<p class="form-url">
                        <label for="url"><h5>Address : </h5></label>
             <h3><?php echo $address; ?></h3>
                    </p><!-- .form-url -->
</td>
</tr>
</tr>
<tr><td>
<p class="form-password">
                        <label for="pass1"><h5>City :</h5></label>
                        <h3><?php echo $city; ?></h3>
                    </p><!-- City -->
</td>

<td>
<p class="form-password">
                        <label for="pass2"><h5>State :</h5></label>
                        <h3><?php echo $state; ?></h3>
                    </p><!-- state -->
</td>

<td>
<p class="form-password">
                        <label for="pass2"><h5>Zip :</h5></label>
                        <h3><?php echo $zip; ?></h3>
                    </p>
</td>

<td>
<p class="form-password">
                        <label for="pass2"><h5>Country :</h5></label>
                        <h3><?php echo $country; ?></h3>
                    </p>
</td></tr>

<tr><td>
<p class="form-password">
                        <label for="pass2"><h5>Phone :</h5></label>
                        <h3><?php echo $phone; ?></h3>
                    </p>
</td>

<td>
<p class="form-password">
                        <label for="pass2"><h5>Aadhar No :</h5></label>
                        <h3><?php echo $aadhar; ?></h3>
                    </p>
</td>

<td>
<p class="form-password">
                        <label for="pass2"><h5>Driving License No :</h5></label>
                        <h3><?php echo $driving; ?></h3>
                    </p>
</td>

<td>
<p class="form-password">
                        <label for="pass2"><h5>Date of Birth :</h5></label>
                        <h3><?php echo $dob; ?></h3>
                    </p>
</td></tr>
<tr>
<td>
<p class="form-password">
                        <label for="pass2"><h5>Date of Join :</h5></label>
                        <h3><?php echo $doj; ?></h3>
                    </p>
</td>
<td>
<p class="form-password">
                        <label for="pass2"><h5>Bank Name :</h5></label>
                        <h3><?php echo $bankname; ?></h3>
                    </p>
</td>
<td>
<p class="form-password">
                        <label for="pass2"><h5>Bank Account No :</h5></label>
                        <h3><?php echo $acno; ?></h3>
                    </p>
</td>
<td>
<p class="form-password">
                        <label for="pass2"><h5>EPF No :</h5></label>
                        <h3><?php echo $epfno; ?></h3>
                    </p>
</td>

</tr>

<tr><td>
<p class="form-password">
                        <label for="pass2"><h5>Passport No :</h5></label>
                        <h3><?php echo $passport; ?></h3>
                    </p>
</td>

<td>
<p class="form-password">
                        <label for="pass2"><h5>Visa Details :</h5></label>
                         <h3><?php echo $visa; ?></h3>
                    </p>

</td>

<td>
<p class="form-textarea">
                        <label for="description"><h5>Biographical Information :</h5></label>
                       <br /> <?php echo $information; ?>

                    </p><!-- .form-textarea -->
</td>

<td>
<?php //echo 'Manager : '.$user_last;  ?>
<?php 
$list_emgr = "select * from wp_users WHERE emp_code = '$assigncode'";
$list_emgr = $wpdb->get_results($list_emgr);

foreach($list_emgr as $list_emgr)
				{
$empemgr = $list_emgr->user_nicename;
echo 'Manager : '.$empemgr;
}
?>


</td></tr>
</table>


<?php }



}

else { 
//echo '<h2>Sorry, You dont have permission to view this page.</h2>'; 
}  

?>


<?php } else {

echo do_shortcode('[wp-members page=login]');

} ?>


</div></div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php get_footer(); ?>
