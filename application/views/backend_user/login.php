<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Mosaddek">
	<meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
	<link rel="shortcut icon" href="<?php echo base_url() ?>assets/img/favicon.html">

	<title>FlatLab - Flat & Responsive Bootstrap Admin Template</title>

	<!-- Bootstrap core CSS -->
	<link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>css/bootstrap-reset.css" rel="stylesheet">
	<!--external css-->
	<link href="<?php echo base_url() ?>font-awesome/css/font-awesome.css" rel="stylesheet" />
	<!-- Custom styles for this template -->
	<link href="<?php echo base_url() ?>css/style.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>css/style-responsive.css" rel="stylesheet" />

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
	<!--[if lt IE 9]>
	<script src="<?php echo base_url() ?>js/html5shiv.js"></script>
	<script src="<?php echo base_url() ?>js/respond.min.js"></script>
	<![endif]-->
</head>

<body class="login-body">

<div class="container">

	<form class="form-signin" method="POST" action="">
		<h2 class="form-signin-heading">همین حالا وارد شوید</h2>
		<div class="login-wrap">
			<input type="text"  id="username" name="username" class="form-control" placeholder="نام کاربری" autofocus>
			<input type="password" id="password" name="password"  class="form-control" placeholder="کلمه عبور">
			<label class="checkbox">
				<input type="checkbox" value="remember-me"> مرا به خاطر بسپار
				<span class="pull-right"> <a href="#"> کلمه عبور را فراموش کرده اید؟</a></span>
			</label>
			<button class="btn btn-lg btn-login btn-block" type="submit">ورود</button>
			<p>یا توسط یکی از حسابهای شبکه اجتماعی خود وارد شوید</p>
			<div class="login-social-link">
				<a href="index.html" class="facebook">
					<i class="icon-facebook"></i>
					Facebook
				</a>
				<a href="index.html" class="twitter">
					<i class="icon-twitter"></i>
					Twitter
				</a>
			</div>

		</div>

	</form>

</div>


</body>
</html>
