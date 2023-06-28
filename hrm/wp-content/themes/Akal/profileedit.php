<?php /* Template Name: PROFILE EDIT */ ?>
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
$rid = $current_user->emp_code;
//echo $username;

?>
<div class="container">
<div class="row-fluid" style="height:100%;">

<?php if ( !is_user_logged_in() ) : ?>
                    <p class="warning">
                        <?php _e('You must be logged in to edit your profile.', 'profile'); ?>
                    </p><!-- .warning -->
            <?php else : ?>
                <?php //if ( count($error) > 0 ) echo '<p class="error">' . implode("<br />,", $error) . '</p>'; ?>
                <form method="post" id="adduser" action="<?php //the_permalink(); ?>" enctype="multipart/form-data">
<?php

$sele = mysql_query("SELECT *FROM wp_profile WHERE ecode = '$rid'");

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
$aadhar = $empdata['aadhar'];
$dob = $empdata['dob'];
$doj = $empdata['doj'];
$bankname = $empdata['bankname'];
$acno = $empdata['acno'];
$epfno = $empdata['epfno'];
$driving = $empdata['driving'];
$passport = $empdata['passport'];
$visa = $empdata['visa'];
$image = $empdata['image'];
$information = $empdata['information'];



echo "<input class='text-input' name='ecode' type='hidden' id='ecode' value='$ecod' />";
}

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
//minDate : 0,
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
<br />

<table>
<th colspan="9">EDIT PROFILE</th>
<tr><td>
                    <p class="form-username">
                        <label for="first-name"><?php _e('First Name', 'profile'); ?></label>

                        <input class="text-input" name="firstname" type="text" id="firstname" value="<?php echo $firstname; ?>" />
                    </p><!-- .form-username --></td><td>
                    <p class="form-username">
                        <label for="last-name"><?php _e('Last Name', 'profile'); ?></label>
                        <input class="text-input" name="lastname" type="text" id="lastname" value="<?php echo $lastname; ?>" />
                    </p><!-- .form-username --></td><td>
                    <p class="form-email">
                        <label for="email"><?php _e('E-mail *', 'profile'); ?></label>
                        <input class="text-input" name="email" type="text" id="email" value="<?php echo $email; ?>" />
                    </p><!-- .form-email --></td><td>
                    <p class="form-url">
                        <label for="url"><?php _e('Address', 'profile'); ?></label>
             <input class="text-input" name="address" type="text" id="address" value="<?php echo $address; ?>" />
                    </p><!-- .form-url --></td></tr>
                 <tr><td>   <p class="form-password">
                        <label for="pass1"><?php _e('City *', 'profile'); ?> </label>
                        <input class="text-input" name="city" type="text" id="city" value="<?php echo $city; ?>" />
                    </p><!-- .form-password --></td><td>
                    <p class="form-password">
                        <label for="pass2"><?php _e('State *', 'profile'); ?></label>
                        <input class="textbox" name="state" type="text" id="state" value="<?php echo $state; ?>" />
                    </p><!-- .form-password --></td><td>
<p class="form-password">
                        <label for="pass2"><?php _e('Zip *', 'profile'); ?></label>
                        <input class="textbox" name="zip" type="text" id="zip" value="<?php echo $zip; ?>" />
                    </p></td><td>
<p class="form-password">
                        <label for="pass2"><?php _e('Country *', 'profile'); ?></label>
                        <input class="textbox" name="country" type="text" id="country" value="<?php echo $country; ?>" />
                    </p></td></tr>
<tr><td>
<p class="form-password">
                        <label for="pass2"><?php _e('Phone *', 'profile'); ?></label>
                        <input class="textbox" name="phone" type="text" id="phone" value="<?php echo $phone; ?>" />
                    </p></td><td>
<p class="form-password">
                        <label for="pass2"><?php _e('Date OF Birth *', 'profile'); ?></label>
                        <input class="textbox" name="dob" type="text" id="start_date" value="<?php echo $dob; ?>" />
                    </p></td><td>
<p class="form-password">
                        <label for="pass2"><?php _e('Date Of Join *', 'profile'); ?></label>
                        <input class="textbox" name="doj" type="text" id="to_date" value="<?php echo $doj; ?>" />
                    </p></td><td>
<p class="form-password">
                        <label for="pass2"><?php _e('Bank Name*', 'profile'); ?></label>
                        <input class="textbox" name="bankname" type="text" id="bankname" value="<?php echo $bankname; ?>" />
                    </p></td></tr>
<tr>
<td>
<p class="form-password">
                        <label for="pass2"><?php _e('Bank Account No *', 'profile'); ?></label>
                        <input class="textbox" name="acno" type="text" id="acno" value="<?php echo $acno; ?>" />
                    </p>
</td>
<td>
<p class="form-password">
                        <label for="pass2"><?php _e('EPF No *', 'profile'); ?></label>
                        <input class="textbox" name="epfno" type="text" id="epfno" value="<?php echo $epfno; ?>" />
                    </p>
</td>

<td>
<p class="form-password">
                        <label for="pass2"><?php _e('Aadhar No *', 'profile'); ?></label>
                        <input class="textbox" name="aadhar" type="text" id="aadhar" value="<?php echo $aadhar; ?>" />
                    </p>

</td><td>
<p class="form-password">
                        <label for="pass2"><?php _e('Driving License No*', 'profile'); ?></label>
                        <input class="textbox" name="driving" type="text" id="driving" value="<?php echo $driving; ?>" />
                    </p>
                   </td></tr>





<tr><td><p class="form-password">
                        <label for="pass2"><?php _e('Passport No *', 'profile'); ?></label>
                        <input class="textbox" name="passport" type="text" id="passport" value="<?php echo $passport; ?>" />
                    </p></td><td>
<p class="form-password">
                        <label for="pass2"><?php _e('Visa Details *', 'profile'); ?></label>
                        <input class="textbox" name="visa" type="text" id="visa" value="<?php echo $visa; ?>" />
                    </p></td><td>
<p class="form-password">
                        <label for="pass2"><?php _e('Image *', 'profile'); ?></label>
                        <input class="file" name="image" type="file" id="image" value="" required />
                    </p>
</td><td>
                    <p class="form-textarea">
                        <label for="description"><?php _e('Biographical Information', 'profile') ?></label>
                        <textarea name="information" id="information" rows="3" cols="50"><?php echo $information; ?></textarea>

                    </p><!-- .form-textarea --></td></tr>
<tr><td>
                    <?php 
                        //action hook for plugin and extra fields
                        do_action('edit_user_profile',$current_user); 
                    ?>
                    <p class="form-submit">
                        <?php echo $referer; ?>
                        <input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update', 'profile'); ?>" />
                        <?php wp_nonce_field( 'update-user' ) ?>
                        <input name="action" type="hidden" id="action" value="update-user" />
                    </p><!-- .form-submit -->
                </form><!-- #adduser -->
            <?php endif; ?>
        </div><!-- .entry-content -->
    </div><!-- .hentry .post -->

</td></tr></table>
<?php
ob_start();

if(isset($_POST['updateuser'])){

$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
$email = trim($_POST['email']);
$phone= trim($_POST['phone']);
$address = trim($_POST['address']);
$city = trim($_POST['city']);
$state = trim($_POST['state']);
$country = trim($_POST['country']); 
$zip = trim($_POST['zip']);
$dob = trim($_POST['dob']);
$doj = trim($_POST['doj']);
$bankname = trim($_POST['bankname']);
$acno = trim($_POST['acno']);
$epfno = trim($_POST['epfno']);
$aadhar = trim($_POST['aadhar']);
$driving = trim($_POST['driving']);
$passport = trim($_POST['passport']);
$visa = trim($_POST['visa']);
//$image = trim($_POST['image']);
$information = trim($_POST['information']);



require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php');

$attachment_id = media_handle_upload('image', $post->ID);

$unicename = "$firstname $lastname";

$updatempl = mysql_query("UPDATE `wp_profile` SET `firstname`= '$firstname',`lastname`= '$lastname',`address`= '$address',`city`= '$city',`state`='$state',`country`='$country',`zip`='$zip',`aadhar`='$aadhar', `dob`='$dob', `doj`='$doj', `bankname`='$bankname', `acno`='$acno', `epfno`='$epfno',`driving`='$driving', `passport`='$passport', `visa`='$visa', `image`='$attachment_id', `information`='$information',`email`='$email',`phone`='$phone' WHERE `ecode`= '$rid'");



$sqlmetappen = mysql_query("UPDATE wp_users SET user_nicename = '$unicename', user_email = '$email' WHERE emp_code = '$rid'");

echo '<h2>Profile updated successfully.</h2>';

echo '<script type="text/javascript">'; 
echo 'alert("Successfully Approved.");'; 
echo 'window.location.href = "http://hrm.ideabyte.net/profile-view/"';
echo '</script>';


}
?>
</div></div>
<?php get_footer(); ?>
