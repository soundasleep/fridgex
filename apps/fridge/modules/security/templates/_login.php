
<?php echo form_tag('security/login') ?>
<table>
<tr>
	<th><label for="email">e-mail/nickname:</label></th>
	<td><?php echo input_tag('email', $sf_params->get('email')) ?></td>
</tr>
<tr>
	<th><label for="password">password:</label></th>
	<td><?php echo input_password_tag('password') ?></td>
</tr>
<tr>
	<td></td>
	<td><label><?php echo checkbox_tag("autologin"); ?> remember me</label></td>
</tr>
<tr>
	<td></td>
	<td><?php echo submit_tag('submit', 'class=default') ?></td>
</tr>
<tr>
	<td></td>
	<td><?php echo link_to("forgot password?", "security/forgot"); ?></td>
</tr>
</table>
</form>

