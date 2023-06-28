<?php
if(isset($_POST['form_submit1234'])){
	
	$adminEmail1 = "contact@ideabytes.com";
	
	$logoText = "ideabytes";
	$ipAddress = (@$_SERVER['REMOTE_ADDR'] != "") ? @$_SERVER['REMOTE_ADDR'] : "";
	
	$contactName = isset($_POST["widget-contact-form-name"]) ? $_POST["widget-contact-form-name"] : "";
	$contactEmail = isset($_POST["widget-contact-form-email"]) ? $_POST["widget-contact-form-email"] : "";
	//$contactPhone = isset($_POST["phone"]) ? $_POST["phone"] : "";
	$contactSubject = isset($_POST["widget-contact-form-subject"]) ? $_POST["widget-contact-form-subject"] : "";
	$contactMessage = isset($_POST["widget-contact-form-message"]) ? $_POST["widget-contact-form-message"] : "";	
	
	if($contactEmail != ""){
				//sending mail to admin
				$contactSubjectToAdmin = $contactSubject;
				$contactMessageToAdmin = "<p>Hi Admin, <br> The following data received from " . $logoText . " contact us page </p>
										 <p>Name: ". $contactName ."<br>
											Email: ". $contactEmail ."<br>
											Message: ". $contactMessage ."<br>
											From ip: ". $ipAddress ."
										 </p>";
				// Always set content-type when sending HTML email
				$contactheaders = "MIME-Version: 1.0" . "\r\n";
				$contactheaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				// More headers
				$contactheaders .= 'From: <'.$contactEmail.'>' . "\r\n";
				//$headers .= 'Cc: myboss@example.com' . "\r\n";

				$r = mail($adminEmail1, $contactSubjectToAdmin, $contactMessageToAdmin, $contactheaders);
				if($r){
					$msg = "Thankyou for reaching us, our team will contact you soon.";
				}else{
					//$msg = "fail";
				}
				
	} else{
		//$msg = "no email id provided";
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
     <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <meta name="author" content="Ideabytes" />
    <meta name="description" content="Test Automation, Custom IT solutions, IOT in Health and Elderly Care, Dangerous Goods Compliance Solutions, Media Streaming solutions, Shonar Bangla Bengali TV channels" />
	<meta name="keywords" content="Selenium,IOT,Banking,Compliance testing,CDN,Health Care,Video Streaming,QTP,test automation,Robotium,Mobile app testing,ADR,DOT,TDG,Packaging,Consulting,Scanner,Placard,QrCode,IATA,Segregation,ERP,SAP,EDI,Declaration,HAZMAT,Intermodal,IMDG,safety management system,49 CFR,cross dock,SaaS,Android,Browser,Training,Train the trainer,Ideabytes,DGSMS,1 888-409-8057,+91-40-6555-5959,1-613-800-7368" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="home" />
	<meta property="og:description" content="Test Automation, Custom IT solutions, IOT in Health and Elderly Care, Dangerous Goods Compliance Solutions, Media Streaming solutions, Shonar Bangla Bengali TV channels" />
	<meta property="og:url" content="http://ideabytes.com/" />
	
    <!-- Document title -->
    <title>Ideabytes | Contact Us</title>
    <!-- Stylesheets & Fonts -->
    <link href="css/fonts.css" rel="stylesheet" type="text/css" />
    <link href="css/plugins.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet"> </head>

<body>


    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Header -->
        <header id="header" class="header-transparent dark">
            <div id="header-wrap">
                <div class="container">
                    <!--Logo-->
                    <div id="logo">
                        <a href="index.html" class="logo" data-dark-logo="images/logo-dark.png">
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
                                            
                                            
                                             <li> <a href="test-automation.html">Test Automation</a> </li>
                                            <li> <a href="web-mobile-app-dev.html">Application Development</a> </li><strong></strong>
                                        </ul>
                                    </li>
                                       <li class="dropdown"> <a href="#">Solutions</a>
                                        <ul class="dropdown-menu">
                                            
											<li> <a href="http://www.ideabytesiot.com" target="_blank">IoT Solutions</a> </li>                                            
											<li> <a href="http://www.dgsms.ca" target="_blank">DG HAZMAT</a> </li>
                                            <li> <a href="http://www.qezymedia.com" target="_blank">Qezy® Media</a> </li>
                                            
                                        </ul>
                                    </li> 
                                   <li class="dropdown"> <a href="#">Products</a>
                                        <ul class="dropdown-menu">
                                            
                                            
											<li> <a href="https://dgcheck.com/#/pages/dashboard" target="_blank">DGCheck™</a> </li>
                                            <li> <a href="http://testdgdox.dgsmsus.com/?lang=en" target="_blank">DGDOX™</a> </li>
                                            <li> <a href="https://dgsms.ca/dgsms.php" target="_blank">DGSMS™</a> </li>
                                            <li> <a href="http://dgmobi.com/?lang=en" target="_blank">DGMobi™</a> </li>
                                            <li> <a href="http://testdgvff.dgsmsus.com/?lang=en" target="_blank">DGVFF™</a> </li>
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
         <section id="page-title" data-parallax-image="images/parallax/contact.jpg">
            <div class="container">
               
                <div class="page-title">
                    <h1>Contact Us</h1>
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
                    <div class="col-md-6">
                        <h3 class="text-uppercase">Get In Touch</h3>
                        <p style="color:green;"><?php if(isset($msg) && ($msg != "")){ echo $msg;} ?></p>
                        <div class="m-t-30">
                          <!--  <form class="widget-contact-form" action="include/contact-form.php" role="form" method="post"> -->
						    <form action="contact-us.php"  method="post">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="name">Name</label>
                                        <input type="text" aria-required="true" name="widget-contact-form-name" class="form-control required name" placeholder="Enter your Name">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="email">Email</label>
                                        <input type="email" aria-required="true" name="widget-contact-form-email" class="form-control required email" placeholder="Enter your Email">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label for="subject">Your Subject</label>
                                        <input type="text" name="widget-contact-form-subject" class="form-control required" placeholder="Subject...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea type="text" name="widget-contact-form-message" rows="5" class="form-control required" placeholder="Enter your Message"></textarea>
                                </div>

                                <input class="btn btn-default" type="submit" name="form_submit1234" id="form_submit1234" value="Send message">                      
                              <!-- <button class="btn btn-default" type="submit" id="form_submit123" name="form_submit123"><i class="fa fa-paper-plane"></i>&nbsp;Send message</button> -->
                            </form>
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-uppercase">Address</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                  <strong><img src="images/canada-flag.jpg" width="21" height="14" alt="Canada-flag"/> Canada</strong><br>
                                    Ideabytes Inc.,<br>
									3781 Strandherd Dr,<br>
									#34026, Nepean, ON K2J5B1<br>
									<a href="mailto:contact-canada@ideabytes.com">contact-canada@ideabytes.com</a><br>
                                   <abbr title="Phone">TollFree:</abbr> +1 888-409-8057
                              </address>
                            </div>
                            <div class="col-md-6">
                                <address>
                                  <strong><img src="images/India-flag.jpg" width="21" height="14" alt="india-flag"/> India</strong><br>
                                    Ideabytes Software India Pvt Ltd<br>
									#35, Jayabheri Pine Valley, Gachibowli,<br>
									Hyderabad-500032, India.<br>
									<a href="mailto:contact@ideabytes.com">contact@ideabytes.com</a><br>
                                  <abbr title="Phone">P:</abbr> +91 888 583 5959<br>
                                   <abbr title="Phone">TollFree:</abbr> 1800 300 22622
                              </address>
                            </div>
                        </div>
                          <div class="row">
                               <div class="col-md-6">
                                <address>
                                  <strong><img src="images/USA-flag.jpg" width="21" height="14" alt="USA-flag"/> USA</strong><br>
                                    Ideabytes Inc.,<br>
									2897 Lowell CT<br>
									San Jose, CA 95121-1475, USA<br>
									<a href="mailto:contact@ideabytes.com">contact@ideabytes.com</a><br>
                                  <abbr title="Phone">TollFree:</abbr> +1 888-409-8057
                              </address>
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </section>
        <!-- end: CONTENT -->
	
              
        
<section class="no-padding">
            <!-- Google map sensor -->
            <div class="map" data-map-address="Ideabtyes Software India Pvt Ltd, #35, Jayabheri Pine Valley, Gachibowli, Hyderabad, Telangana 500032" data-map-zoom="15" data-map-icon="images/markers/marker1.png" data-map-type="ROADMAP"></div>
        </section>
   <!-- end: MAP -->

		 <!-- Footer -->
        <footer id="footer" class="footer-light">
           
            <div class="copyright-content">
                <div class="container">
                 <div class="row">
                 <div class="col-md-6">
					<div class="copyright-text text-left">&copy; Ideabytes<sup>®</sup> 2017 - Innovation is Business<br>V 4.0.2A
					 </div></div>
                    <div class="col-md-6">
                    <div class="social-icons social-icons-border float-right">
                                    <ul>
                                       <li class="social-linkedin"><a href="https://www.linkedin.com/company/ideabytes-inc" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                        <li class="social-facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
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
    <script src="js/jquery.js"></script>
    <script src="js/plugins.js"></script>

    <!--Template functions-->
    <script src="js/functions.js"></script>
    

<script src="http://maps.google.com/maps/api/js?key=AIzaSyBKS14AnP3HCIVlUpPKtGp7CbYuMtcXE2o"></script>


   
  
</body>

</html>
