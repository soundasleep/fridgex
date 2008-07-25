Hi <b><?php echo $user->getName(); ?></b>,<br>
<br>
Your password has been reset to <b><?php echo $password; ?></b>. You should <?php echo link_to("log in immediately", url_for("security/login", true)); ?> and change your password.<br>
<br>
<?php include_partial("powered_by"); ?>
