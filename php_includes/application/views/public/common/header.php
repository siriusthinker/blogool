<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<meta charset="utf-8" />
	<title><?php echo SITE_NAME; ?></title>
	<meta content="<?php echo SITE_NAME; ?>" name="description" />
	<meta content="<?php echo SITE_NAME; ?>" name="author" />
	<meta name="google-signin-scope" content="profile email">
	<meta name="google-signin-client_id" content="994709089479-1pfs928b5fo3qgeg9u54sblad27i7306.apps.googleusercontent.com">
	<link href="http://fast.fonts.net/cssapi/f1dc833e-9664-4b09-ac60-fcd4773857e8.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('css/fontawesome.min.css')?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('css/jqueryui.min.css')?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('css/bootstrap.min.css')?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('css/style.css')?>" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="account-header">
		<div class="site-brand">
			<div>
				<a href="<?php echo base_url(); ?>">
					<img src="<?php echo base_url('images/logo2.png')?>" class="site-logo" title="Blogool" />
				</a>
			</div>
		</div>
		<div class="site-navigation">
			<ul class="account-menu">
				<?php if (is_object($user) !== true) { ?>
					<li><div class="g-signin2" data-onsuccess="onSignIn" data-height="30"></div></li>
				<?php } else {  ?>
					<li class="account-details">
						<a href="#">
							<?php echo $user->first_name . ' ' . $user->last_name; ?> <span class="caret"></span>
						</a>
						<ul class="dropdown-content">
							<li>
								<a href="<?php echo base_url('login/logout'); ?>">
									<i class="fa fa-sign-out" aria-hidden="true"></i>Logout
								</a>
							</li>
						</ul>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>

	<div class="account-sidebar">
		<ul class="modules-list">
			<li>
				<a href="#" class="parent_menu homepage-list">
					<div class="pull-left">
						<i class="fa fa-feed" aria-hidden="true"></i> Recent Posts
					</div>
					<div class="clear">&nbsp;</div>
				</a>
			</li>
			<?php if (is_object($user) === true) { ?>
			<li>
				<a href="#" class="parent_menu dashboard-list">
					<div class="pull-left">
						<i class="fa fa-dashboard" aria-hidden="true"></i> Dashboard
					</div>
					<div class="clear">&nbsp;</div>
				</a>
			</li>
			<li>
				<a href="#" class="parent_menu markdown-list">
					<div class="pull-left">
						<i class="fa fa-edit" aria-hidden="true"></i> Markdown Editor
					</div>
					<div class="clear">&nbsp;</div>
				</a>
			</li>
			<?php } ?>
		</ul>
	</div>

	<div class="account-content-container">
		<div class="account-content">