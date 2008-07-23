<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>

<link rel="shortcut icon" href="/favicon.ico" />

</head>

<body>

<div id="navigation">
	<ul>
		<li class="title">TINA Fridge System</li>
		<li><?php echo link_to("home", "@homepage"); ?></li>
		<?php if ($sf_user->isAuthenticated()) { ?>
		<li><?php echo link_to("your account", "user/home"); ?></li>
		<li><?php echo link_to("logout", "security/logout"); ?></li>
		<?php } else { ?>
		<li><?php echo link_to("signup", "security/signup"); ?></li>
		<li><?php echo link_to("login", "security/index"); ?></li>
		<?php } ?>
	</ul>
</div>

<?php echo $sf_data->getRaw('sf_content') ?>

</body>
</html>
