Hi <?php echo $user->getName(); ?>,

You have been signed up for an account at Fridex.

You should <?php echo link_to("log in immediately", url_for("security/login", true)); ?> immediately
(use <?php echo link_to("forgot password", url_for("security/forgot", true)); ?> to reset your password).

- Fridgex
