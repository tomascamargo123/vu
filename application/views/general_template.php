<!doctype html>
<html lang="es">
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
		<!-- Ionicons -->
		<link rel="stylesheet" href="plugins/ionicons/css/ionicons.min.css" />
		<!-- daterange picker -->
		<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
		<!-- DATA TABLES -->
		<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css" />
		<link rel="stylesheet" href="plugins/datatables/extensions/Responsive/css/responsive.bootstrap.min.css" />
		<link rel="stylesheet" href="plugins/datatables/extensions/ColReorder/css/colReorder.bootstrap.min.css" />
		<!-- Select2 -->
		<link rel="stylesheet" href="plugins/select2/select2.min.css" />
		<!-- Theme style -->
		<link rel="stylesheet" href="css/AdminLTE.min.css" />
		<link rel="stylesheet" href="css/skins/skin-lavalle.min.css" />
		<?php
		if (!empty($css))
		{
			if (is_array($css))
			{
				foreach ($css as $C)
				{
					//var_dump($C);die();
					if (substr($C, 0, 4) !== 'http')
					{
						echo '<link rel="stylesheet" href="' . auto_version($C) . '">';
					}
					else
					{
						echo '<link rel="stylesheet" href="' . $C . '">';
					}
				}
			}
			else
			{
				if (substr($css, 0, 4) !== 'http')
				{
					echo '<link rel="stylesheet" href="' . auto_version($css) . '">';
				}
				else
				{
					echo '<link rel="stylesheet" href="' . $css . '">';
				}
			}
		}
		?>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- jQuery 2.1.4 -->
		<script src="js/jquery/jquery-2.1.4.min.js" type="text/javascript"></script>
	</head>
	<body class="hold-transition skin-lavalle sidebar-mini <?php echo ($menu_collapse === '1') ? 'sidebar-collapse' : ''; ?>">
		<div class="wrapper">
			<?php echo $header; ?>
			<?php echo $sidebar; ?>
			<?php echo $content; ?>
			<?php echo $footer; ?>
		</div>
		<!-- Bootstrap 3.3.5 -->
		<script src="js/bootstrap/bootstrap.min.js" type="text/javascript"></script>
		<!-- MOMENT -->
		<script src="plugins/daterangepicker/moment.min.js"></script>
		<!-- DATA TABLES SCRIPT -->
		<script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
		<script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
		<script src="plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
		<script src="plugins/datatables/extensions/Responsive/js/responsive.bootstrap.min.js" type="text/javascript"></script>
		<script src="plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js" type="text/javascript"></script>
		<script src="plugins/datatables/datetime-moment.js"></script>
		<!-- SELECT2 SCRIPT -->
		<script src="plugins/select2/select2.min.js" type="text/javascript"></script>
		<!-- BOOTSTRAP VALIDATOR -->
		<script src="plugins/bootstrap-validator/validator.min.js" type="text/javascript"></script>
		<!-- date-range-picker -->
		<script src="plugins/daterangepicker/daterangepicker.js"></script>
		<!-- AdminLTE App -->
		<script src="js/adminlte/app.min.js" type="text/javascript"></script>
		<!-- Main JS -->
		<script src="js/main.js" type="text/javascript"></script>
		<?php
		if (!empty($js))
		{
			if (is_array($js))
			{
				foreach ($js as $J)
				{
					if (substr($J, 0, 4) !== 'http')
					{
						echo '<script src="' . auto_version($J) . '" type="text/javascript"></script>';
					}
					else
					{
						echo '<script src="' . $J . '" type="text/javascript"></script>';
					}
				}
			}
			else
			{
				if (substr($js, 0, 4) !== 'http')
				{
					echo '<script src="' . auto_version($js) . '" type="text/javascript"></script>';
				}
				else
				{
					echo '<script src="' . $js . '" type="text/javascript"></script>';
				}
			}
		}
		?>
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
		<script>
			var hash = '<?php echo $this->security->get_csrf_hash(); ?>';
		</script>
	</body>
</html>