<?php
// auto-generated by sfPropelCrud
// date: 2008/07/24 15:35:45
?>
<?php use_helper('Object') ?>

<?php echo form_tag('user_admin/update') ?>

<?php echo object_input_hidden_tag($user, 'getId') ?>

<table>
<tbody>
<tr>
  <th>Email:</th>
  <td><?php echo object_input_tag($user, 'getEmail', array (
  'size' => 80,
)) ?></td>
</tr>
<tr>
  <th>Name:</th>
  <td><?php echo object_input_tag($user, 'getName', array (
  'size' => 80,
)) ?></td>
</tr>
<tr>
  <th>Nickname:</th>
  <td><?php echo object_input_tag($user, 'getNickname', array (
  'size' => 80,
)) ?></td>
</tr>
<tr>
  <th>Password hash:</th>
  <td><?php echo object_input_tag($user, 'getPasswordHash', array (
  'size' => 80,
)) ?></td>
</tr>
<tr>
  <th>Last login:</th>
  <td><?php echo object_input_date_tag($user, 'getLastLogin', array (
  'rich' => true,
  'withtime' => true,
)) ?></td>
</tr>
<?php if ($current_user->canSetCredit($user)) { ?>
<tr>
  <th>Account credit:</th>
  <td><?php echo object_input_tag($user, 'getAccountCredit', array (
  'size' => 7,
)) ?></td>
</tr>
<?php } ?>
</tbody>
</table>
<hr />
<?php echo submit_tag('save') ?>
<?php if ($user->getId()): ?>
  <?php if ($current_user->canDeleteUser($user)) { ?>
  	&nbsp;<?php echo link_to('delete', 'user_admin/delete?id='.$user->getId(), 'post=true&confirm=Are you sure?') ?>
  <?php } ?>
  &nbsp;<?php echo link_to('cancel', 'user_admin/show?id='.$user->getId()) ?>
<?php else: ?>
  &nbsp;<?php echo link_to('cancel', 'user_admin/list') ?>
<?php endif; ?>
</form>
