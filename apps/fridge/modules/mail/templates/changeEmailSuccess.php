Hi <b><?php echo $user->getName(); ?></b>,<br>
<br>
You have changed your e-mail address to <b><?php echo mail_to($user->getEmail()); ?></b>.<br>
<br>
<?php include_partial("powered_by"); ?>