<?php
// auto-generated by sfPropelCrud
// date: 2008/07/24 15:35:45
?>
<h1>Manage users</h1>

<?php use_helper("My"); ?>
<?php set_title("Manage users"); ?>

<table>
<thead>
<tr>
  <th>Email</th>
  <th>Name</th>
  <th>Nickname</th>
  <th>Last login</th>
  <th>Ignore</th>
  <th>Stock losses</th>
  <th>Account credit</th>
  <th>Purchases</th>
  <th>Credits</th>
  <th>Debit</th>
  <th>Credit</th>
  <th>Verified</th>
</tr>
</thead>
<tbody>
<?php foreach ($users as $user): ?>
<tr>
      <td><?php echo link_to($user->getEmail(), 'user_admin/show?id='.$user->getId()) ?></td>
      <td><?php echo $user->getName() ?></td>
      <td><span class="username"><?php echo $user->getNickname() ?></span></td>
      <td><?php echo my_format_date($user->getLastLogin()) ?></td>
      <td><?php echo $user->isIgnored() ? yes_icon() : no_icon(); ?></td>
      <td><?php echo $user->isStockLoss() ? yes_icon() : no_icon(); ?></td>
      <td class="currency"><?php echo my_format_currency($user->getAccountCredit()) ?></td>
      <td class="number">
      	<?php if ($user->getPurchaseCount()) { ?>
      		<?php echo number_format($user->getPurchaseCount()); ?> (<?php echo number_format($user->getPurchaseItems()); ?> items)
      	<?php } else { ?>
      		-
      	<?php } ?>
      </td>
      <td class="number">
      	<?php if ($user->getCreditCount()) { ?>
      		<?php echo number_format($user->getCreditCount()); ?> (<?php echo number_format($user->getPurchaseItems()); ?> items)
      	<?php } else { ?>
      		-
      	<?php } ?>
      </td>
      <td class="currency"><?php echo my_format_currency($user->getPurchaseValue()); ?></td>
      <td class="currency"><?php echo my_format_currency($user->getCreditValue()); ?></td>
      <td class="number">
      	<?php if ($user->getCreditCount()) { ?>
	      	<?php echo number_format($user->getCreditPercent()); ?> %
      	<?php } else { ?>
      		-
      	<?php } ?>
      </td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>

<?php echo link_to ('Create new user', 'user_admin/create') ?>
 | <?php echo link_to('User permissions', 'user_admin/permissions') ?>
