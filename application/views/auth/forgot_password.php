<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo base_url(); ?>" />
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo empty($title) ? TITLE : $title; ?></title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="description" content="">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<!-- Bootstrap 3.3.5 -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Font Awesome Icons -->
		<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css" />
		<!-- Theme style -->
		<link rel="stylesheet" href="css/AdminLTE.min.css" />
		<!-- App style -->
		<link rel="stylesheet" href="css/skins/skin-lavalle.min.css" />

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="skin-lavalle login-page">
		<div class="login-box">
			<div class="login-logo">
				<img src="img/generales/logo_login.png" alt="Municipalidad de Lavalle" />
			</div>
			<div class="login-box-body">
				<p class="login-box-msg"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></p>
				<?php if (!empty($error)) : ?>
					<p class="login-box-msg error">
						<?php echo $error; ?>
					</p>
				<?php endif; ?>
				<?php if (!empty($message)) : ?>
					<p class="login-box-msg message">
						<?php echo $message; ?>
					</p>
				<?php endif; ?>
				<?php echo form_open("auth/forgot_password"); ?>
				<div class="form-group has-feedback">
					<?php echo form_input($identity); ?>
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-8"></div>
					<div class="col-xs-4">
						<?php echo form_submit('submit', lang('forgot_password_submit_btn'), 'class="btn btn-primary btn-block btn-flat"'); ?>
					</div>
				</div>
				<?php echo form_close(); ?>
				<br />
				<a href="auth/login">Volver</a>
			</div>
		</div>

		<!-- jQuery 2.1.4 -->
		<script src="js/jquery/jquery-2.1.4.min.js" type="text/javascript"></script>
		<!-- Bootstrap 3.3.5 -->
		<script src="js/bootstrap/bootstrap.min.js" type="text/javascript"></script>
		<!-- Google Analytics -->
        <script>
//			(function(i, s, o, g, r, a, m) {
//				i['GoogleAnalyticsObject'] = r;
//				i[r] = i[r] || function() {
//					(i[r].q = i[r].q || []).push(arguments)
//				}, i[r].l = 1 * new Date();
//				a = s.createElement(o),
//						m = s.getElementsByTagName(o)[0];
//				a.async = 1;
//				a.src = g;
//				m.parentNode.insertBefore(a, m)
//			})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
//
//			ga('create', 'UA-75411332-1', 'auto');
//			ga('send', 'pageview');
        </script>
	</body>
</html>
