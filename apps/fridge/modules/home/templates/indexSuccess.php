<h1>Welcome to the fridge</h1>

<?php if ($sf_user->isAuthenticated() && $user = $sf_user->getUserObject(false)) { ?>
	<?php echo link_to("go shopping", "product/list"); ?>
<?php } else { ?>
	<?php include_partial("security/login"); ?>
<?php } ?>