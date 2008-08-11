<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>

<link rel="shortcut icon" href="<?php echo image_path("favicon.ico"); ?>" />

</head>

<body>

<div id="navigation">
	<ul>
		<li class="title"><?php echo sfConfig::get("app_title", "Fridgex Fridge System"); ?></li>
		<li><?php echo link_to("home", "@homepage", array("class" => "home")); ?></li>
		<?php if ($sf_user->isAuthenticated() && $sf_user->getUserObject(false)) { ?>
		<li><?php echo link_to("your account", "user/index", array("class" => "account")); ?></li>

		<?php if ($sf_user->getUserObject(false)->canViewActivity()) { ?>
		<li class="manager"><?php echo link_to("recent activity", "purchase/index", array("class" => "activity")); ?></li>
		<?php } ?>
		<?php if ($sf_user->getUserObject(false)->canAddUser()) { ?>
		<li class="admin"><?php echo link_to("manage users", "user_admin/index", array("class" => "users")); ?></li>
		<?php } ?>
		<?php if ($sf_user->getUserObject(false)->canVerifyCredit()) { ?>
		<li class="admin"><?php echo link_to("manage purchases", "purchase/credit", array("class" => "purchases")); ?></li>
		<?php } ?>

		<?php } else { ?>
		<li><?php echo link_to("signup", "security/signup", array("class" => "signup")); ?></li>
		<li><?php echo link_to("login", "security/index", array("class" => "login")); ?></li>
		<?php } ?>

		<?php if (sfConfig::get("app_help")) { ?>
		<li><?php echo link_to("help", sfConfig::get("app_help"), array("class" => "help")); ?></li>
		<?php } ?>

		<?php if ($sf_user->getUserObject(false)) { ?>
		<li class="login">You are logged in as <?php echo link_to($sf_user->getUserObject()->getNickname(), "user/index", array("class" => "username")); ?> <?php echo link_to("logout", "security/logout", array("class" => "logout")); ?></li>
		<?php } else { ?>
		<li class="login">You are anonymous</li>
		<?php } ?>
	</ul>
</div>

<?php echo $sf_data->getRaw('sf_content') ?>

<div id="powered_by">
	<?php echo link_to(sfConfig::get("app_title", "This fridge system"), "@homepage"); ?> powered by <?php echo link_to("Fridgex", "http://code.google.com/p/fridgex"); ?>
</div>

</body>
</html>
