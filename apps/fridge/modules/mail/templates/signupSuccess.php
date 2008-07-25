Hi <b><?php echo $user->getName(); ?></b>,<br>
<br>
You have been signed up for an account at <?php echo link_to(sfConfig::get("app_title", "your local fridge system"), url_for("@homepage", true)); ?> by the system adminstrators.<br>
<br>
Your temporary password is <b><?php echo $password; ?></b>.<br>
<br>
You should <?php echo link_to("log in immediately", url_for("security/login", true)); ?> and then change your password.<br>
<br>
<?php include_partial("powered_by"); ?>
