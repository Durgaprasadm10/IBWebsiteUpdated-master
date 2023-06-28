<?php
if(isset($_POST['form_submit1234'])){

        require_once 'include/class-phpmailer.php';
        require_once 'include/class-smtp.php';
        $mail = new PHPMailer();

	$adminEmail1 = "kishore.putrevu@ideabytes.com";
	
	$logoText = "ideabytes";
	$ipAddress = (@$_SERVER['REMOTE_ADDR'] != "") ? @$_SERVER['REMOTE_ADDR'] : "";
	
	$firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
	$lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
	$contactEmail = isset($_POST["widget-contact-form-email"]) ? $_POST["widget-contact-form-email"] : "";
	$contactMobile = isset($_POST["widget-contact-form-mobile"]) ? $_POST["widget-contact-form-mobile"] : "";
	$city = isset($_POST["widget-contact-form-city"]) ? $_POST["widget-contact-form-city"] : "";
	$positionfor = isset($_POST["widget-contact-form-position"]) ? $_POST["widget-contact-form-position"] : "";
	$industry_type = isset($_POST["industry_type"]) ? $_POST["industry_type"] : "";
	$function_type = isset($_POST["function_type"]) ? $_POST["function_type"] : "";
	$qualification = isset($_POST["qualification"]) ? $_POST["qualification"] : "";
	$years = isset($_POST["years"]) ? $_POST["years"] : "";
	$months = isset($_POST["months"]) ? $_POST["months"] : "";
	$ctc = isset($_POST["ctc"]) ? $_POST["ctc"] : "";


	$message = "<p>Hi,</p>";
	$message .= "<p>You have recieved a resume from ".$firstname." ".$lastname."</p>";
	$message .= "<p>Below are the details</p>";
	$message .= "<p>Email: ".$contactEmail."</p>";
	$message .= "<p>Mobile: ".$contactMobile."</p>";
	$message .= "<p>city: ".$city."</p>";
	$message .= "<p>Position Applied: ".$positionfor."</p>";
	$message .= "<p>Industry Type: ".$industry_type."</p>";
	$message .= "<p>Function Type: ".$function_type."</p>";
	$message .= "<p>Qualification: ".$qualification."</p>";
	$message .= "<p>Experience: ".$years." Years, ".$months." Months</p>";
	$message .= "<p>Current CTC: ".$ctc."</p>";

	$subject= "Resume from ".$firstname." ".$lastname." for ".$positionfor;

	
//echo $message;

		/*if($_FILES['resume']['error']>0) {
			$msg = "Your file consists of errors. Please try to upload a new file";		
		}*/

		$temp = explode(".", $_FILES["resume"]["name"]);
		$extension = end($temp);
		//$newname= $_FILES["resume"]["name"].".".$extension;
		$name = $temp[0];
		$newname = $temp[0]."".date('Ymdhis').".".$extension;
		rename($_FILES["resume"]["tmp_name"],$newname);



	    $tmp_name    = $_FILES['resume']['tmp_name']; // get the temporary file name of the file on the server 
	    $name        = $_FILES['resume']['name'];  // get the name of the file 
	    $size        = $_FILES['resume']['size'];  // get size of the file for size validation 
	    $type        = $_FILES['resume']['type'];  // get type of the file 
	    $error       = $_FILES['resume']['error']; // get the error (if any) 


        $mail->IsSMTP(); // send via SMTP
        $mail->Host = "smtp.office365.com"; // SMTP servers
        $mail->Port = 587; // SMTP servers
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->SMTPDebug = 0;
       // $mail->Username = "kishore.putrevu@ideabytes.com"; // SMTP username
       // $mail->Password = "Kishore@idea"; // SMTP password
        $mail->Username = "hr@ideabytes.com"; // SMTP username
        $mail->Password = "Ibytes@20!9"; // SMTP password
        $mail->SMTPSecure = 'tls';
//        $mail->From = "kishore.putrevu@ideabytes.com";
//        $mail->FromName = "Ideabytes HR";
//        $mail->AddAddress('kishore.putrevu@ideabytes.com');
        $mail->From = "hr@ideabytes.com";
        $mail->FromName = "Ideabytes HR";
        $mail->AddAddress('hr@ideabytes.com');
//hr@ideabytes.com
        $mail->IsHTML(true); // send as HTML
        $mail->Subject = $subject;
        $mail->Body = $message;
	$mail->AddAttachment($newname);
        $mail->AltBody = "This is the plain text version of the email content";       


        if (!$mail->send()) {            
            return false;

        } else {

$subject1 = "Thanks for applying!";

$message1 = "<p>Dear ".$firstname." ".$lastname."</p>";
$message1 .= "<p>We have received your application. We appreciate your interest in Ideabytes and the position of ".$positionfor." for which you applied. We are reviewing applications currently and expect to schedule interviews in the next couple of weeks. If you are selected for an interview, you can expect a phone call from our Human Resources staff shortly.</p>";
$message1 .= "<p>Thank you, again, for your interest in our company. We do appreciate the time that you invested in this application.</p>";
$message1 .= "<p>Best Regards,</p>";
$message1 .= "<p>Ideabytes Hiring Team.</p>";

	$mail1 = new PHPMailer();

        $mail1->IsSMTP(); // send via SMTP
        $mail1->Host = "smtp.office365.com"; // SMTP servers
        $mail1->Port = 587; // SMTP servers
        $mail1->SMTPAuth = true; // turn on SMTP authentication
        $mail1->SMTPDebug = 0;
       // $mail->Username = "kishore.putrevu@ideabytes.com"; // SMTP username
       // $mail->Password = "Kishore@idea"; // SMTP password
        $mail1->Username = "hr@ideabytes.com"; // SMTP username
        $mail1->Password = "Ibytes@20!9"; // SMTP password
        $mail1->SMTPSecure = 'tls';
//        $mail->From = "kishore.putrevu@ideabytes.com";
//        $mail->FromName = "Ideabytes HR";
//        $mail->AddAddress('kishore.putrevu@ideabytes.com');
        $mail1->From = "hr@ideabytes.com";
        $mail1->FromName = "Ideabytes HR";
        $mail1->AddAddress($contactEmail);
        $mail1->IsHTML(true); // send as HTML
        $mail1->Subject = $subject1;
        $mail1->Body = $message1;
	//$mail->AddAttachment($newname);
        $mail1->AltBody = "This is the plain text version of the email content";       

	$mail1->send();
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
    <title>Ideabytes | Careers</title>
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
                                    <li class="dropdown"> <a href="#">Careers</a>
                                   <ul class="dropdown-menu">
                                            
                                            <li><a href="upload_resume.php">Submit CV</a></li>
                                         <li><a href="current_positions.html">Current Positions</a></li>
											
                                        </ul></li>
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
         <section id="page-title" data-parallax-image="images/parallax/careers.jpg">
            <div class="container">
               
                <div class="page-title">
                    <h1>Careers</h1>
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
                    <div class="col-md-12">
                       <p> At Ideabytes, we strive to create a high-performance culture, built on the foundation of our core values. Because of this, we have been able to meet and exceed our clients’ expectations and built a value proposition like no other. The challenging opportunities we offer to our employees brings about the pervasive entrepreneurial mindset that eventually helps them to grow in their career.</p>

<?php if(isset($_POST['form_submit1234'])) {?>
                        <h3 class="text-uppercase">Thank you for Applying.</h3>
<?php } else {?>						
			<h3 class="text-uppercase">Fill & Submit your details</h3>
<?php }?>
                        <p style="color:green;"><?php if(isset($msg) && ($msg != "")){ echo $msg;} ?></p>

                        <div class="m-t-30">
<?php if(!isset($_POST['form_submit1234'])) {?>
                          <!--  <form class="widget-contact-form" action="include/contact-form.php" role="form" method="post"> -->
						    <form action=""  method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="firstname">First Name</label>
                                        <input required pattern="[A-Za-z]+" title="Only Alphabets" type="text" aria-required="true" name="firstname" class="form-control required firstname" placeholder="Enter your First Name">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="Lastname">Last Name</label>
                                        <input required type="text" pattern="[A-Za-z]+" title="Only Alphabets" aria-required="true" name="lastname" class="form-control required lastname" placeholder="Enter your Last Name">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="email">Email</label>
                                        <input required type="email" aria-required="true" name="widget-contact-form-email" class="form-control required email" placeholder="Enter your Email">
                                    </div>
                                      <div class="form-group col-sm-6">
                                        <label for="phone">Phone No</label>
                                        <input required type="text" pattern="[6789][0-9]{9}" aria-required="true" name="widget-contact-form-mobile" class="form-control required phone" placeholder="Enter your Mobile No" title="Please enter valid phone number">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="city">City</label>
                                        <input required type="text" aria-required="true" name="widget-contact-form-city" class="form-control required city" placeholder="Enter your City ">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="position">Position applied for</label>
                                        <input required type="text" aria-required="true" name="widget-contact-form-position" class="form-control required position" placeholder="Position applied for">
                                    </div>
                                    <div class="form-group col-sm-6">
									<label>Industry</label>
									<select required class="form-control" name="industry_type" id="industry_type">
									<option value="" disabled>Select</option>
									<option value="Accounting/Finance">Accounting/Finance</option>
									<option value="Advertising / PR / MR / Events">Advertising / PR / MR / Events</option>
									<option value="Agriculture / Diary">Agriculture / Diary</option>
									<option value="Airlines">Airlines</option>
									<option value="Animation">Animation </option>
									<option value="Architecture / Interior Design">Architecture / Interior Design </option>
									<option value="Auto / Auto Ancillary">Auto / Auto Ancillary </option>
									<option value="Aviation / Aerospace Firm">Aviation / Aerospace Firm </option>
									<option value="Banking / Financial Services / Broking / Asset Management">Banking / Financial Services / Broking / Asset Management </option>
									<option value="BPO / ITES">BPO / ITES </option>
									<option value="Brewery / Distillery">Brewery / Distillery </option>
									<option value="Broadcasting">Broadcasting </option>
									<option value="Cement">Cement </option>
									<option value="Ceramics / Sanitary Ware">Ceramics / Sanitary Ware </option>
									<option value="Chemicals / Petro Chemical">Chemicals / Petro Chemical </option>
									<option value="Construction">Construction </option>
									<option value="Consumer Durables">Consumer Durables </option>
									<option value="Courier / Transportation / Freight">Courier / Transportation / Freight </option>
									<option value="Defence / Government">Defence / Government </option>
									<option value="Education / Teaching / Training">Education / Teaching / Training </option>
									<option value="Electricals / Switchgears">Electricals / Switchgears </option>
									<option value="Engineering / Heavy Engg. / EPC">Engineering / Heavy Engg. / EPC </option>
									<option value="Export / Import">Export / Import </option>
									<option value="Facility Management">Facility Management </option>
									<option value="Fertilizers / Pesticides">Fertilizers / Pesticides </option>
									<option value="FMCG / Foods / Beverage">FMCG / Foods / Beverage </option>
									<option value="Food Processing">Food Processing </option>
									<option value="Gems & Jewelry">Gems & Jewelry </option>
									<option value="Glass">Glass </option>
									<option value="Heat Ventilation Air Conditioning">Heat Ventilation Air Conditioning </option>
									<option value="Hotels / Restaurants / Hospitality">Hotels / Restaurants / Hospitality </option>
									<option value="Industrial Products / Heavy Machinery">Industrial Products / Heavy Machinery </option>
									<option value="Infrastructure">Infrastructure </option>
									<option value="Insurance">Insurance </option>
									<option value="Internet / Ecommerce">Internet / Ecommerce </option>
									<option value="IT-Hardware & Networking">IT-Hardware & Networking </option>
									<option value="IT-Software / Software Services">IT-Software / Software Services </option>
									<option value="KPO / Research / Analytics">KPO / Research / Analytics </option>
									<option value="Leather">Leather </option>
									<option value="Legal">Legal </option>
									<option value="Media / Dotcom / Entertainment">Media / Dotcom / Entertainment </option>
									<option value="Medical / Healthcare / Hospital">Medical / Healthcare / Hospital </option>
									<option value="Medical Devices / Equipment’s">Medical Devices / Equipment’s </option>
									<option value="Metals">Metals </option>
									<option value="Mining">Mining </option>
									<option value="NGO / Social Services">NGO / Social Services </option>
									<option value="Office Equipment / Automation">Office Equipment / Automation </option>
									<option value="Oil and Gas">Oil and Gas </option>
									<option value="Paper">Paper </option>
									<option value="Pharma / Biotech / Clinical Research">Pharma / Biotech / Clinical Research </option>
									<option value="Plastics">Plastics </option>
									<option value="Power / Energy / Non conventional Energy">Power / Energy / Non conventional Energy </option>
									<option value="Printing / Packaging">Printing / Packaging </option>
									<option value="Private Equity / Venture Capitalists / Incubators">Private Equity / Venture Capitalists / Incubators </option>
									<option value="Publishing">Publishing </option>
									<option value="Real Estate / Property">Real Estate / Property </option>
									<option value="Recruitment / HR services">Recruitment / HR services </option>
									<option value="Retail">Retail</option>
									<option value="Rubber">Rubber </option>
									<option value="Security / Law Enforcement">Security / Law Enforcement </option>
									<option value="Semiconductors / Electronics">Semiconductors / Electronics </option>
									<option value="Shipping / Marine">Shipping / Marine </option></option>
									<option value="Steel">Steel </option>
									<option value="Strategy / Management Consulting Firms">Strategy / Management Consulting Firms </option>
									<option value="Sugar">Sugar </option>
									<option value="Telecom / ISP">Telecom / ISP </option>
									<option value="Textiles / Garments / Accessories">Textiles / Garments / Accessories </option>
									<option value="Travel & Tourism">Travel & Tourism </option>
									<option value="Tyres">Tyres </option>
									<option value="Water Treatment / Waste Management">Water Treatment / Waste Management</option>
									<option value="Wellness / Fitness / Sports">Wellness / Fitness / Sports </option>

									</select>
									</div>
									
									<div class="form-group col-sm-6">
									<label>Function</label>
									<select required class="form-control" name="function_type" id="function_type">
									<option disabled>Select</option>
									<option>Accounting / Tax / Company Secretary /Audit Agent </option>
									<option>Airline / Reservations / Ticketing / Travel </option>
									<option>Analytics & Business Intelligence </option>
									<option>Anchoring / TV / Films / Production </option>
									<option>Architects / Interior Design / Naval Arch. </option>
									<option>Art Director / Graphic / Web Designer </option>
									<option>Banking / Insurance </option>
									<option>Beauty / Fitness / Spa Services </option>
									<option>Content / Journalism </option>
									<option>Corporate Planning / Consulting </option>
									<option>CSR & Sustainability </option>
									<option>Engineering Design / R&D </option>
									<option>Export / Import / Merchandising </option>
									<option>Fashion / Garments / Merchandising </option>
									<option>Guards / Security Services </option>
									<option>Hotels / Restaurants </option>
									<option>HR / Administration / IR </option>
									<option>IT - Hardware / Telecom / Technical Staff / Support </option>
									<option>IT Software - Application Programming / Maintenance </option>
									<option>IT Software - Client Server </option>
									<option>IT Software - DBA / Data warehousing </option>
									<option>IT Software - Ecommerce / Internet Technologies </option>
									<option>IT Software - Embedded /EDA /VLSI /ASIC / Chip Des. </option>
									<option>IT Software - ERP / CRM</option>
									<option>IT Software - Mainframe </option>
									<option>IT Software - Middleware </option>
									<option>IT Software - Mobile </option>
									<option>IT Software - Network Administration / Security </option>
									<option>IT Software - QA & Testing </option>
									<option>IT Software - System Programming </option>
									<option>IT Software - Systems / EDP / MIS </option>
									<option>IT Software - Telecom Software </option>
									<option>ITES / BPO / KPO / Customer Service / Operations </option>
									<option>Legal </option>
									<option>Marketing / Advertising / MR / PR </option>
									<option>Packaging </option>
									<option>Pharma / Biotech / Healthcare / Medical / R&amp;D </option>
									<option>Production / Maintenance / Quality </option>
									<option>Purchase / Logistics / Supply Chain </option>
									<option>Sales / BD </option>
									<option>Secretary / Front Office / Data Entry </option>
									<option>Self Employed / Consultants </option>
									<option>Shipping </option>
									<option>Site Engineering / Project Management </option>
									<option>Teaching / Education </option> 
									<option>Ticketing / Travel / Airlines </option>
									<option>Top Management </option>
									<option>TV / Films / Production </option>
									<option>Web / Graphic Design / Visualiser</option>
									</select>
									</div>
									
									<div class="form-group col-sm-6">
                                        <label for="education">Highest Educational Qualification</label>
                                        <input required type="text" aria-required="true" name="qualification" class="form-control required qualification" placeholder="Highest Educational Qualification">
                                    </div>
                                    
                              
                                    <div class="form-group col-sm-3">
									<label>Overall experience</label>
									<select required class="form-control" name="years" id="years_type">
									<option disabled>Years</option>
									<option>0</option>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
									<option>6</option>
									<option>7</option>
									<option>8</option>
									<option>9</option>
									<option>10</option>
									<option>11</option>
									<option>12</option>
									<option>13</option>
									<option>14</option>
									<option>15</option>
									<option>16</option>
									<option>17</option>
									<option>18</option>
									<option>19</option>
									<option>20</option>
									<option>21</option>
									<option>22</option>
									<option>23</option>
									<option>24</option>
									<option>25</option>
									<option>26</option>
									<option>27</option>
									<option>28</option>
									<option>29</option>
									<option>30</option>
									<option>31</option>
									<option>32</option>
									<option>33</option>
									<option>34</option>
									<option>35</option>
									<option>36</option>
									<option>37</option>
									<option>38</option>
									<option>39</option>
									<option>40</option>
									<option>41</option>
									<option>42</option>
									<option>43</option>
									<option>44</option>
									<option>45</option>
									<option>46</option>
									<option>47</option>
									<option>48</option>
									<option>49</option>
									<option>50</option>
																
									</select>
									</div>
									
									
									<div class="form-group col-sm-3">
									<label>&nbsp;</label>
									<select required class="form-control" name="months" id="months_type">
									<option disabled>Months</option>
									<option>0</option>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
									<option>6</option>
									<option>7</option>
									<option>8</option>
									<option>9</option>
									<option>10</option>
									<option>11</option>
									<option>12</option>
									
									</select>
									</div>

							
									 <div class="form-group col-sm-6">
                                        <label for="ctc">Present CTC</label>
                                        <input class="form-control" required type="text" name="ctc" id="example-number-input" autocomplete="off" placeholder="Current Salary">
                                        
                                    </div>
                                    <!--<div class="form-group col-sm-4">
                                        <label for="ctc"> &nbsp;</label>
                                        <input class="form-control" type="number" id="example-number-input" autocomplete="off" placeholder="Thousands">
                                        
									  </div> -->

                                    <div class="form-group col-sm-4">
                                        <label for="exampleFormControlFile1">Attach CV</label>
					<input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,.pdf" class="form-control-file" required id="exampleFormControlFile1" name="resume">
                                    </div>
                                    
								</div>
                                 
								</div>

                                <input class="btn btn-default" type="submit" name="form_submit1234" id="" value="Submit">                      
                              <!-- <button class="btn btn-default" type="submit" id="form_submit1234" name="form_submit123"><i class="fa fa-paper-plane"></i>&nbsp;Send message</button> -->
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                    
                </div>
          
        </section>
        <!-- end: CONTENT -->
	


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
    



   
  
</body>

</html>
