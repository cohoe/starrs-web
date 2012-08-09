<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?=$title;?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<style type="text/css">
			body {
				padding-top: 60px;
				padding-bottom: 40px;
			}
			.sidebar-nav {
				padding: 9px 0;
			}
		</style>
		<link href="/css/bootstrap.css" rel="stylesheet">
		<link href="/css/docs.css" rel="stylesheet">
		<link href="/css/impulse.css" rel="stylesheet">
		
		<link rel="shortcut icon" href="/ico/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
	</head>

	<body>
		<?=$navbar;?>
		<div class="container-fluid">
			<?=$breadcrumb;?>
			<div class="row-fluid">
				<?=$sidebar;?>
				<?=$content;?>
			</div>
			<hr>
			<div class="footer">
				<p>STARRS &copy; 2012 <a href="http://www.grantcohoe.com">Grant Cohoe</a> - <a href="https://github.com/cohoe/impulse/wiki#wiki-Project_Team">Credits</a></p>
			</div>
		</div>

		<script src="/js/jquery-1.7.2.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/jquery.tablesorter.min.js"></script>
		<?=$scripts;?>
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<script src="/js/iefix.js"></script>
		<![endif]-->

	</body>
</html>
