<?php
/*if(isset($_POST['form_submit1234'])){
	
	$adminEmail1 = "sales@ideabytes.com";
	
	$logoText = "ideabytes";
	$ipAddress = (@$_SERVER['REMOTE_ADDR'] != "") ? @$_SERVER['REMOTE_ADDR'] : "";
	
	$contactName = isset($_POST["widget-contact-form-name"]) ? $_POST["widget-contact-form-name"] : "";
	$contactEmail = isset($_POST["widget-contact-form-email"]) ? $_POST["widget-contact-form-email"] : "";
	$companyName = isset($_POST["widget-contact-form-company_name"]) ? $_POST["widget-contact-form-company_name"] : "";
	$countrycode = isset($_POST["widget-contact-form-countrycode"]) ? $_POST["widget-contact-form-countrycode"] : "";
	$designation = isset($_POST["widget-contact-form-designation"]) ? $_POST["widget-contact-form-designation"] : "";
	$phoneNumber = isset($_POST["widget-contact-form-phone_number"]) ? $_POST["widget-contact-form-phone_number"] : "";
	//$contactPhone = isset($_POST["phone"]) ? $_POST["phone"] : "";
//	$contactSubject = isset($_POST["widget-contact-form-subject"]) ? $_POST["widget-contact-form-subject"] : "";
//	$contactMessage = isset($_POST["widget-contact-form-message"]) ? $_POST["widget-contact-form-message"] : "";	

	//$contactSubject = "Entry to Get Free Pen Testing Diagnostics";
	$contactSubject = $contactName." is interested to Get limited free cybersecurity diagnostics";
	
	if($contactEmail != ""){
				//sending mail to admin
				$contactSubjectToAdmin = $contactSubject;
				$contactMessageToAdmin = "<p>Hi Admin, <br> The following data received from " . $logoText . " contact us for the diagnostics page </p>
										 <p>Name: ". $contactName ."<br>
											Email: ". $contactEmail ."<br>
											Company Name : ". $companyName ."<br>
											Designation : ". $designation."<br>
											Country Code: ". $countrycode."<br>
											Phone Number: ". $phoneNumber."<br>";
											//Message: ". $contactMessage ."<br>
											//From ip: ". $ipAddress ."
										$contactMessageToAdmin .="</p>";
				// Always set content-type when sending HTML email
				$contactheaders = "MIME-Version: 1.0" . "\r\n";
				$contactheaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				// More headers
				$contactheaders .= 'From: <'.$contactEmail.'>' . "\r\n";
				//$headers .= 'Cc: myboss@example.com' . "\r\n";

				$r = mail($adminEmail1, $contactSubjectToAdmin, $contactMessageToAdmin, $contactheaders);
				if($r){
					$msg = "Thank you for signing up, our security expert will reach out to you shortly for consent and scope.";
				}else{
					//$msg = "fail";
				}
				
	} else{
		//$msg = "no email id provided";
	}
}*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
     <link rel="icon" href="https://cdn.ideabytes.com/images/favicon.ico" type="image/x-icon">
    <meta name="author" content="Ideabytes" />
    <meta name="description" content="Test Automation, Custom IT solutions, IOT in Health and Elderly Care, Dangerous Goods Compliance Solutions, Media Streaming solutions, Shonar Bangla Bengali TV channels" />
	<meta name="keywords" content="IoT Solutions & App Development" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="home" />
	<meta property="og:description" content="Test Automation, Custom IT solutions, IOT in Health and Elderly Care, Dangerous Goods Compliance Solutions, Media Streaming solutions, Shonar Bangla Bengali TV channels" />
	<meta property="og:url" content="http://ideabytes.com/" />
	
    <!-- Document title -->
    <title>Custom IoT Solutions & App Development | Ideabytes</title>
    <!-- Stylesheets & Fonts -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://cdn.ideabytes.com/css/fonts.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.ideabytes.com/css/plugins.css" rel="stylesheet">
    <link href="https://cdn.ideabytes.com/css/style.css" rel="stylesheet">
    
    <link href="css/responsive.css" rel="stylesheet">

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-172671537-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-172671537-1');
</script>
 </head>

<body>


    <!-- Wrapper -->
    <div id="wrapper">
		
		<div id="topbar">
			<div class="container">
				<div class="row">
					<div class="col-sm-5 hidden-xs">
						
					</div>
					<div class="col-sm-6">
						<div class="social-icons social-icons-colored-hover">
							<ul>
								<li class="social-facebook"><a href="https://www.facebook.com/dgsmsproducts" target="_blank"><i class="fa fa-facebook"></i></a></li>
								
								<li class="social-facebook"><a href="https://www.facebook.com/DGMOBI" target="_blank"><i class="fa fa-facebook"></i></a></li>
								
								<li class="social-linkedin"><a href="https://in.linkedin.com/company/ideabytes-inc" target="_blank"><i class="fa fa-linkedin"></i></a></li>
								
								<li class="social-twitter"><a href="https://twitter.com/DGSMS_r" target="_blank"><i class="fa fa-twitter"></i></a></li>
								
								
							</ul>
						</div>
					</div>
					<div class="col-sm-1">
						<ul class="top-menu">
						<li><a type="button" class="btn btn-md btn-rounded btn-outline"  href="contact-us.php">Contact</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

        <!-- Header -->
        <header id="header" class="header-transparent dark">
            <div id="header-wrap">
                <div class="container">
                    <!--Logo-->
                    <div id="logo">
                        <a href="index.html" class="logo" data-dark-logo="https://cdn.ideabytes.com/images/logo-dark.png">
                            <img src="images/logo.png" alt="Ideabytes Logo">
                        </a>
                    </div>
                    <!--End: Logo-->

                    
                   
                    <!--end: Header Extras-->

                    <!--Navigation Resposnive Trigger-->
                    <div id="mainMenu-trigger">
                        <button class="lines-button x"> <span class="lines"></span> </button>
                    </div>
                    <!--end: Navigation Resposnive Trigger-->

                    <!--Navigation-->
                    <div id="mainMenu" class="light">
                        <div class="container">
                            <nav>
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    
                                    
                                    <li class="dropdown"> <a href="#">Services</a>
                                        <ul class="dropdown-menu">
                                            
                                        <li> <a href="security-testing.html">Penetration Testing</a> </li>
                                             <li> <a href="test-automation.html">Test Automation</a> </li>
                                            <li> <a href="web-mobile-app-dev.html">Application Development</a> </li><strong></strong>
                                        </ul>
                                    </li>
                                       <li class="dropdown"> <a href="#">Solutions</a>
                                        <ul class="dropdown-menu">
                                            
											<li> <a href="https://dgtrak.com/" target="_blank">IoT Solutions</a> </li>
											<li> <a href="https://www.dgsms.ca" target="_blank">DG HAZMAT</a> </li>
                                            <li> <a href="https://www.qezymedia.com" target="_blank">Qezy® Media</a> </li>
                                            
                                        </ul>
                                    </li> 
                                   <li class="dropdown"> <a href="#">Products</a>
                                         <ul class="dropdown-menu">
                                            
                                             <li> <a href="https://dgsms.ca/pages/dgmobi_eng.php" target="_blank">DGMobi™</a> </li>
                                            <li> <a href="https://dgsms.ca/pages/DGsms_eng.php" target="_blank">DGSMS<sup>®</sup></a> </li>
											<li> <a href="https://dgsms.ca/pages/DGCheck_eng.php" target="_blank">DGCheck™</a> </li>
                                             <li> <a href="https://dgsms.ca/pages/DGdox_eng.php" target="_blank">DGDOX™</a> </li>
                                              <li> <a href="https://dgsms.ca/pages/DGRMA_eng.php" target="_blank">DGRMA™</a> </li>
                                            <li> <a href="https://dgsms.ca/pages/DGVFF_eng.php" target="_blank">DGVFF™</a> </li>
                                            <li> <a href="https://dgsms.ca/pages/DGSDS_eng.html" target="_blank">DGSDS™</a> </li>
                                            <li> <a href="https://dgsms.ca/pages/DGSOS_eng.php" target="_blank">DGSOS™</a> </li>
                                            <li> <a href="http://testsuiteexpress.com/index.html" target="_blank">Test Suite Express™</a> </li>
                                            
                                        </ul>
                                    </li>
                                    <li><a href="partnership.html">Partnerships</a></li>
                                    
                                    	    <li class="dropdown"> <a href="#">Company</a>
                                        <ul class="dropdown-menu">
                                            
                                            <li><a href="about-us.html">About Us</a></li>
                                            <li><a href="contact-us.php">Contact Us</a></li>
											<li><a href="team.html">Team</a></li>
                                        </ul>
                                    </li>	
                                     <!--  <li class="dropdown mega-menu-item"> <a href="#">Products</a>
                                        <ul class="dropdown-menu">
                                            <li class="mega-menu-content">
                                                <div class="row">
                                                    <div class="col-md-2-5">
                                                        <ul>
                                                            <li class="mega-menu-title">DG HAZMAT</li>
                                                            <li> <a href="#">DGSMS</a> </li>
                                                            <li> <a href="blog-masonry-4.html">DGMobi</a> </li>
                                                            <li> <a href="blog-masonry-sidebar.html">DGDOX</a> </li>
                                                            <li> <a href="blog-masonry-no-page-title.html">DGVFF</a> </li>
                                                           
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-2-5">
                                                        <ul>
                                                            <li class="mega-menu-title">Qezy®</li>
                                                            <li> <a href="#">Qezy® Play</a> </li>
                                            				<li> <a href="#">Qezy® Media</a> </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-2-5">
                                                        <ul>
                                                            <li class="mega-menu-title">IoT</li>
                                                           <li> <a href="#">ScioTy</a> </li>
                                                        </ul>
                                                    </div>
                                                   
                                                </div>
                                            </li>
                                        </ul>
                                    </li>-->
                                    
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!--end: Navigation-->
                </div>
            </div>
        </header>
        <!-- end: Header -->
        
        <!-- Page title -->
         <section id="page-title" data-parallax-image="images/Chance.jpg">
            <div class="container">
               
                <div class="page-title">
                    <h1>Get Your<br>Limited Free Cybersecurity Diagnostics</h1>
                    <span></span>
                </div>
            </div>
        </section>
        </section>
        <!-- end: Page title -->


       
        <!-- WHAT WE DO -->
        
  <!-- CONTENT -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-6" id="msg" style="display:none;">
                        <h3 class="blue_header">Get In Touch</h3>
                        <p style="color:green;" class="resp"><?php if(isset($msg) && ($msg != "")){ echo $msg;} ?></p>
                    </div>

                    <div class="col-md-6" id="nomsg">
                        <h3 class="blue_header">Sign up</h3>
                        <p style="color:green;"><?php if(isset($msg) && ($msg != "")){ echo $msg;} ?></p>
                        <div class="m-t-30">
<?php if(!isset($_POST['form_submit1234'])) {?>
                          <!--  <form class="widget-contact-form" action="include/contact-form.php" role="form" method="post"> -->
			    <form id="frm"  method="post">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="name">Name</label>
                                        <input type="text" required aria-required="true" id="widget-contact-form-name" name="widget-contact-form-name" class="form-control required name" placeholder="Enter your Name">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="email">Email</label>
                                        <input type="email" required aria-required="true" id="widget-contact-form-email" name="widget-contact-form-email" class="form-control required email" placeholder="Enter your Email">
					<input type="hidden" readonly name="toaddress" class="" required value="reach@ideabytes.com" id="toaddress">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="name">Company Name</label>
                                        <input type="text" required aria-required="true" id="widget-contact-form-company_name" name="widget-contact-form-company_name" class="form-control required company_name" placeholder="Enter your Company Name">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="designation">Designation</label>
                                        <input type="text" required aria-required="true" id="widget-contact-form-designation" name="widget-contact-form-designation" class="form-control required designation" placeholder="Enter your Designation">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="countrycode">Country Code</label>
                                        <input type="text" required aria-required="true" id="widget-contact-form-countrycode" name="widget-contact-form-countrycode" class="form-control required phone_number" placeholder="Enter your Country Code">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="email">Phone Number</label>
                                        <input type="text" required aria-required="true" id="widget-contact-form-phone_number" name="widget-contact-form-phone_number" class="form-control required phone_number" placeholder="Enter your Phone Number">
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="form-group col-sm-12 subject_for_prize">
                                        <label for="subject">Subject_for_prize</label>
                                        <input type="text" name="widget-contact-form-subject" class="form-control required" required placeholder="Subject...">
                                    </div>
                                </div> -->
                                <!-- <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea type="text" name="widget-contact-form-message" rows="5" class="form-control required" required placeholder="Enter your Message"></textarea>
                                </div>-->
                                <div class="form-group">
                                   <div class="g-recaptcha" data-sitekey="6Lfc6LwUAAAAAIarOjTZt1MfDKyYiB4rM_96lVKQ"></div>
                                </div> 

                                <input class="btn btn-default" type="submit" name="form_submit1234" id="form_submit1234" value="Submit">                      
                              <?php //<!-- <button class="btn btn-default" type="submit" id="form_submit123" name="form_submit123"><i class="fa fa-paper-plane"></i>&nbsp;Send message</button> --> ?>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="blue_header">How secure is system from threats?</h3>
                        <ul class="diagnostics_list">
                            <li class="diagnostics_item">
                            <img src="https://cdn.ideabytes.com/images/Firewall_icon.png" alt="" class="diagnostics_icon">
                            <p class="diagnostics_dsc">
                                Firewalls protect against brute force break-ins. Most break-ins are with legal access to your system.
                            </p>
                                
                            </li>
                            <li class="diagnostics_item">
                                <img src="https://cdn.ideabytes.com/images/review_icon.png" alt="" class="diagnostics_icon">
                                <p class="diagnostics_dsc">
                                    Let our Security engineers review your system and advise or help you secure it.
                                </p>
                            
                            </li>
                            <li class="diagnostics_item">
                                <img src="https://cdn.ideabytes.com/images/hand_shake_icon.png" alt="" class="diagnostics_icon">
                                <p class="diagnostics_dsc">
                                    Before we evaluate your system, we will meet with you and explain the process, get your sign-off and deliever a report.  
                                </p>
                         
                            </li>
                            <li class="diagnostics_item">
                                <img src="https://cdn.ideabytes.com/images/free_icon.png" alt="" class="diagnostics_icon">
                                <p class="diagnostics_dsc">
                                    The initial diagnostics report is free.
                                </p>
                            
                            </li>
                            <li class="diagnostics_item">
                                <img src="https://cdn.ideabytes.com/images/calendar_icon.png" alt="" class="diagnostics_icon">
                                <p class="diagnostics_dsc">
                                    Don't put this off - once the system is penetrated, it is too late!
                                </p>
                            
                            </li>
                        </ul>
                       

                        
                    </div>
                </div>
            </div>
        </section>
        <!-- end: CONTENT -->
	
              
        

   <!-- end: MAP -->

		 <!-- Footer -->
        <footer id="footer" class="footer-light">
           
            <div class="copyright-content">
                <div class="container">
                 <div class="row">
                 <div class="col-md-6">
					<div class="copyright-text text-left">&copy; Ideabytes<sup>®</sup> 2021 - Innovation is Business<br>V 4.0.3A
					 </div></div>
                    <div class="col-md-6">
                    <div class="social-icons social-icons-border float-right">
                                    <ul>
                                       <li class="social-facebook"><a href="https://www.facebook.com/dgsmsproducts" target="_blank"><i class="fa fa-facebook"></i></a></li>
								
								<li class="social-facebook"><a href="https://www.facebook.com/DGMOBI" target="_blank"><i class="fa fa-facebook"></i></a></li>
								
								<li class="social-linkedin"><a href="https://in.linkedin.com/company/ideabytes-inc" target="_blank"><i class="fa fa-linkedin"></i></a></li>
								
								<li class="social-twitter"><a href="https://twitter.com/DGSMS_r" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    </ul>
						</div></div>
                </div>
				</div></div>
        </footer>
        <!-- end: Footer -->	

        
    </div>
    <!-- end: Wrapper -->

    <!-- Go to top button -->
    <a id="goToTop"><i class="fa fa-angle-up top-icon"></i><i class="fa fa-angle-up"></i></a>

    <!--Plugins-->
    <script src="https://cdn.ideabytes.com/js/jquery.js"></script>
    <script src="https://cdn.ideabytes.com/js/plugins.js"></script>

    <!--Template functions-->
    <script src="https://cdn.ideabytes.com/js/functions.js"></script>
    

<script src="https://maps.google.com/maps/api/js?key=AIzaSyBKS14AnP3HCIVlUpPKtGp7CbYuMtcXE2o"></script>

<script>
function checkRecaptcha() {
   var res = $('#g-recaptcha-response').val();

    if (res == "" || res == undefined || res.length == 0)
        return false;
    else
        return true;
}

$(function(){
$('#frm').submit(function(e) {
	e.preventDefault();
    if(!checkRecaptcha()) {
      //  $( "#frm-result" ).text("Please validate your reCAPTCHA.");
	alert("Please validate your reCAPTCHA.");
        return false;
    } 

        $("#form_submit1234").attr("disabled","disabled");
        $.ajax({
                'type':'POST',
                'url':'savecontact.php?page=contact-us-for-diagnostics.php',
                'data':$(this).serialize(),
                'success':function(data){
                        //console.log(data)
                        if(data=="success"){
                                $(".resp").html('Thank you for signing up, our security expert will reach out to you shortly for consent and scope.');
                                $("#msg").css('display','block');
                                $("#nomsg").css('display','none');
                        }else{
                                $(".resp").html('');
                                $("#msg").css('display','none');
                                $("#nomsg").css('display','block');
                                $("#form_submit1234").removeAttr("disabled");
                        }
                }
        });

});
});
</script>

   <script> (function(){ window.ldfdr = window.ldfdr || {}; (function(d, s, ss, fs){ fs = d.getElementsByTagName(s)[0]; function ce(src){ var cs = d.createElement(s); cs.src = src; setTimeout(function(){fs.parentNode.insertBefore(cs,fs)}, 1); } ce(ss); })(document, 'script', 'https://sc.lfeeder.com/lftracker_v1_Xbp1oaEk1eq7EdVj.js'); })(); </script> 
  
</body>

</html>
