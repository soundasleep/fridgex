Hi <?php echo $user->getName(); ?>,

Your password has been reset to <b><?php echo $password; ?></b>. You should <?php echo link_to("log in immediately", "security/login", true); ?> and change your password.

- Fridgex
