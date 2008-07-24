<h2>Forgot Password</h2>

<?php if ($sf_request->hasErrors()): ?>
<div class="error">
  <?php echo implode("; ", $sf_request->getErrors()); ?> - please try again
</div>
<?php endif; ?>

If you have forgotten your password, enter in your e-mail address and you will be sent a new password:

<?php echo form_tag('security/password') ?>
<table>
<tr>
	<th><label for="email">e-mail address:</label></th>
	<td><?php echo input_tag('email', $sf_params->get('email')) ?></td>
</tr>
<tr>
	<td></td>
	<td><?php echo submit_tag('submit', 'class=default') ?></td>
</tr>
</table>
</form>
