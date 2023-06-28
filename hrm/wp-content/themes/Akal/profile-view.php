<?php /* Template Name: PROFILE VIEW */ ?>
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
$assignmgr = $current_user->assign_mgr;
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
                <form method="post" id="adduser" action="<?php the_permalink(); ?>">
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
$dob = $empdata['dob'];
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

$list_img = "select * from wp_posts WHERE ID = '$image'";
$list_img = $wpdb->get_results($list_img);

foreach($list_img as $list_img)
				{
$imgsoursc = $list_img->guid;
}


?>
<br />
<table>
        <th colspan="9">PERSONAL DETAILS</h>     


<tr><td><p class="form-username">
                        <label for="first-name"><?php _e('First Name :', 'profile'); ?></label>

                       <br /><h5> <?php echo $firstname; ?></h5>
                    </p><!-- .form-username --></td>

<td>
<p class="form-username">
                        <label for="last-name"><?php _e('Last Name :', 'profile'); ?></label>
                         <br /><h5> <?php echo $lastname; ?></h5>
                    </p><!-- .form-username -->

</td>

<td colSpan="2" rowSpan="2" >
<div align="center">
<p class="form-password">
                        <label for="pass2"><?php _e('Profile Picture', 'profile'); ?></label><br />
                       <!-- <input class="file" name="image" type="file" id="Image" value="" />-->
<?php
echo "<img src='$imgsoursc' width='170' height='170' />";

?>

                    </p></div>
</td>

</tr>
<tr>
<td>
<p class="form-email">
                        <label for="email"><?php _e('E-mail :', 'profile'); ?></label>
                      <br /><h5><?php echo $email; ?></h5>
                    </p><!-- .form-email -->
</td>

<td>
<p class="form-url">
                        <label for="url"><?php _e('Address : ', 'profile'); ?></label>
             <br /><h5><?php echo $address; ?></h5>
                    </p><!-- .form-url -->
</td>
</tr>
<tr><td>
<p class="form-password">
                        <label for="pass1"><?php _e('City :', 'profile'); ?> </label>
                        <br /><h5><?php echo $city; ?></h5>
                    </p><!-- City -->
</td>

<td>
<p class="form-password">
                        <label for="pass2"><?php _e('State :', 'profile'); ?></label>
                        <br /><h5><?php echo $state; ?></h5>
                    </p><!-- state -->
</td>

<td>
<p class="form-password">
                        <label for="pass2"><?php _e('Zip :', 'profile'); ?></label>
                        <br /><h5><?php echo $zip; ?></h5>
                    </p>
</td>

<td>
<p class="form-password">
                        <label for="pass2"><?php _e('Country', 'profile'); ?></label>
                        <br /><h5><?php echo $country; ?></h5>
                    </p>
</td></tr>

<tr><td>
<p class="form-password">
                        <label for="pass2"><?php _e('Phone :', 'profile'); ?></label>
                        <br /><h5><?php echo $phone; ?></h5>
                    </p>
</td>

<td>
<p class="form-password">
                        <label for="pass2"><?php _e('Aadhar No :', 'profile'); ?></label>
                        <br /><h5><?php echo $aadhar; ?></h5>
                    </p>
</td>

<td>
<p class="form-password">
                        <label for="pass2"><?php _e('Driving License No :', 'profile'); ?></label>
                        <br /><h5><?php echo $driving; ?></h5>
                    </p>
</td>

<td>
<p class="form-password">
                        <label for="pass2"><?php _e('Passport No :', 'profile'); ?></label>
                        <br /><h5><?php echo $passport; ?></h5>
                    </p>
</td></tr>


<tr><td>
<p class="form-password">
                        <label for="pass2"><?php _e('Visa Details :', 'profile'); ?></label>
                         <br /><h5><?php echo $visa; ?></h5>
                    </p>
</td>

<td>
<p class="form-password">
                        <label for="pass2"><?php _e('Date of Birth :', 'profile'); ?></label>
                         <br /><h5><?php echo $dob; ?></h5>
                    </p>

</td>

<td>
<p class="form-password">
                        <label for="pass2"><?php _e('Date of Join :', 'profile'); ?></label>
                         <br /><h5><?php echo $doj; ?></h5>
                    </p>
</td>

<td>
<p class="form-password">
                        <label for="pass2"><?php _e('Bank Name :', 'profile'); ?></label>
                         <br /><h5><?php echo $bankname; ?></h5>
                    </p>
</td></tr>
<tr>

<td>
<p class="form-password">
                        <label for="pass2"><?php _e('Bank Account No :', 'profile'); ?></label>
                         <br /><h5><?php echo $acno; ?></h5>
                    </p>

</td>
<td>
<p class="form-password">
                        <label for="pass2"><?php _e('EPF No :', 'profile'); ?></label>
                         <br /><h5><?php echo $epfno; ?></h5>
                    </p>

</td>
<td>
<p class="form-textarea">
                        <label for="description"><?php _e('Biographical Information :', 'profile') ?></label>
                       <br /> <?php echo $information; ?>

                    </p><!-- .form-textarea -->
</td>
<td>
<?php 
$sqel = mysql_query("SELECT *FROM wp_users WHERE emp_code = '$assignmgr'");

//$countla = mysql_num_rows($sqel);

//echo $countla;

while($eekola = mysql_fetch_array($sqel)){

$stela = $eekola['user_nicename'];
echo 'Manager : '.$stela .'<br />';

}
?>
<br /><a href="http://hrm.ideabyte.net/profile-edit-2/">EDIT PROFILE</a>
</td>
</tr>
</table>
              

                    <?php 
                        //action hook for plugin and extra fields
                        do_action('edit_user_profile',$current_user); 
                    ?>
                    <!--<p class="form-submit">
                        <?php echo $referer; ?>
                        <input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update', 'profile'); ?>" />-->
                        <?php wp_nonce_field( 'update-user' ) ?>
                        <input name="action" type="hidden" id="action" value="update-user" />
                    </p><!-- .form-submit -->
                </form><!-- #adduser -->
            <?php endif; ?>
        </div><!-- .entry-content -->
    </div><!-- .hentry .post -->
</div></div>
<?php get_footer(); ?>
