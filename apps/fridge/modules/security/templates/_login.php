
<?php echo form_tag('security/login') ?>
<table>
<tr>
	<th><label for="email">e-mail address:</label></th>
	<td><?php echo input_tag('email', $sf_params->get('email')) ?></td>
</tr>
<tr>
	<th><label for="password">password:</label></th>
	<td><?php echo input_password_tag('password') ?></td>
</tr>
<tr>
	<td></td>
	<td><?php echo submit_tag('submit', 'class=default') ?></td>
</tr>
</table>
</form>

