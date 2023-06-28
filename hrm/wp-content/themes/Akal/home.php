<?php /* Template Name: HOME PAGE */ ?>
<?php
   global $wpdb;
get_header();
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=1,initial-scale=1,user-scalable=1" />
	<title>Ideabytes Login</title>

	<link href="http://fonts.googleapis.com/css?family=Lato:100italic,100,300italic,300,400italic,400,700italic,700,900italic,900" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="http://ideabytes.com/hrm/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="http://ideabytes.com/hrm/css/styles.css" />
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	
	<section class="container login-form">
		<section>
			<!--<form method="post" action="" role="login"></form>-->

				<img src="http://ideabytes.com/hrm/images/ideabytes-logo.png" alt="" width="232" height="79" class="img-responsive" />
			
				<div class="form-group">
<?php echo do_shortcode("[wp-members page='login']"); ?>
					<!--<input type="email" name="email" required class="form-control" placeholder="Email address" />-->
				</div>
				
				<div class="input-group">
					<!--<input type="password" name="password" required class="form-control" placeholder="Password" />-->
					<span class="input-group-btn">
						<!--<button class="btn btn-default" type="button" id="tooltip" data-toggle="tooltip" data-placement="top" title="Forgot password ?">?</button>-->
					</span>
				</div>
				
				<!--<button type="submit" name="go" class="btn btn-primary btn-block">Login Now</button>-->
				
				<!--Not yet a member ? <a href="#">Register now</a>`-->
			
		</section>
	</section>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	
	<script>
	<!--
	$( document ).ready(function() {
	    $('#tooltip').tooltip();
	});
	-->
	</script>

</body>
</html>