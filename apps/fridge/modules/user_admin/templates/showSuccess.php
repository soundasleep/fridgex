<?php
// auto-generated by sfPropelCrud
// date: 2008/07/24 15:35:45
?>

<?php echo link_to('List of users', 'user_admin/list') ?>
<h1 class="username"><?php echo $user->getNickname(); ?></h1>

<?php use_helper("My"); ?>

<table>
<tbody>
<tr>
<th>Id: </th>
<td><?php echo $user->getId() ?></td>
</tr>
<tr>
<th>Email: </th>
<td><?php echo mail_to($user->getEmail()) ?></td>
</tr>
<tr>
<th>Name: </th>
<td><?php echo $user->getName() ?></td>
</tr>
<tr>
<th>Nickname: </th>
<td><span class="username"><?php echo $user->getNickname() ?></span></td>
</tr>
<tr>
<th>Created at: </th>
<td><?php echo my_format_date($user->getCreatedAt()) ?></td>
</tr>
<tr>
<th>Updated at: </th>
<td><?php echo my_format_date($user->getUpdatedAt()) ?></td>
</tr>
<tr>
<th>Last login: </th>
<td><?php echo my_format_date($user->getLastLogin()) ?></td>
</tr>
<tr>
<th>Account credit: </th>
<td><?php echo my_format_currency($user->getAccountCredit()) ?></td>
</tr>
<tr>
<th>Permissions: </th>
<td>
	<?php if (!$user->getUserPermissions()) { ?>
		<i>none</i><?php } else { ?>
		<ul>
		<?php foreach ($user->getUserPermissions() as $p) { ?>
			<li><b><?php echo $p->getPermission(); ?></b> : <?php echo sfConfig::get("app_permission_".$p->getPermission(), "undefined"); ?></li>
		<?php } ?>
		</ul>
	<?php } ?>
	</td>
</tr>
</tbody>
</table>
<?php echo link_to('Edit user', 'user_admin/edit?id='.$user->getId()) ?>
<hr />

<h2>Recent Activity</h2>

<table>
<thead>
<tr>
  <th>ID</th>
  <th>Date</th>
  <th>Activity</th>
  <th>Price</th>
  <th>Quantity</th>
  <th>Surcharge</th>
  <th>Credit</th>
  <th>Debit</th>
</tr>
</thead>
<tbody>
<?php foreach ($purchases as $purchase) { ?>
<tr class="<?php if ($purchase->isCancelled()) echo "cancelled"; ?>">
	<td><?php echo $purchase->getId(); ?></td>
	<td><?php echo my_format_date($purchase->getCreatedAt()); ?></td>
<?php if ($purchase->getQuantity() < 0) { ?>
	<td>
		Purchase: <?php echo $purchase->getProduct() ? link_to($purchase->getProduct()->getTitle(), "product/show?id=".$purchase->getProduct()->getId()) : "null"; ?>
		<?php if ($purchase->isCancelled() && $purchase->getCancelledBy()) { ?>
			(cancelled by <?php echo link_to($purchase->getCancelledBy()->getNickname(), "user_admin/show?id=".$purchase->getCancelledBy()->getId(), array("class" => "username")); ?>)
		<?php } ?>
	</td>
	<td class="currency"><?php echo my_format_currency($purchase->getPrice()); ?></td>
	<td class="number"><?php echo format_number(-$purchase->getQuantity()); ?></td>
	<td class="currency"><?php echo my_format_currency($purchase->getSurcharge()); ?></td>
	<td class="currency"></td>
	<td class="currency"><?php echo my_format_currency(($purchase->getPrice() + $purchase->getSurcharge()) * $purchase->getQuantity()); ?></td>
<?php } else { ?>
	<td>
		Credit: <?php echo $purchase->getProduct() ? link_to($purchase->getProduct()->getTitle(), "product/show?id=".$purchase->getProduct()->getId()) : "null"; ?>
		<?php if (!$purchase->getVerifiedBy()) { ?>
			(<?php echo link_to("Unverified", "purchase/list"); ?>)
		<?php } ?>
		<?php if ($purchase->isCancelled() && $purchase->getCancelledBy()) { ?>
			(cancelled by <?php echo link_to($purchase->getCancelledBy()->getNickname(), "user_admin/show?id=".$purchase->getCancelledBy()->getId(), array("class" => "username")); ?>)
		<?php } ?>
	</td>
	<td class="currency"><?php echo my_format_currency($purchase->getPrice()); ?></td>
	<td class="number"><?php echo format_number($purchase->getQuantity()); ?></td>
	<td class="currency"></td>
	<td class="currency"><?php echo my_format_currency(($purchase->getPrice() + $purchase->getSurcharge()) * $purchase->getQuantity()); ?></td>
	<td class="currency"></td>
<?php } ?>
</tr>
<?php } ?>

<?php if (!$purchases) { ?>
<tr>
	<td colspan="7" class="no_activity">(No recent activity in the last 14 days.)</td>
</tr>
<?php } ?>

<tr>
	<th colspan="5">Account Balance</th>
<?php if ($user->canViewSurcharge()) { ?>
	<th></th>
<?php } ?>
	<th class="currency"><?php if ($user->getAccountCredit() > 0) echo my_format_currency($user->getAccountCredit()); ?></th>
	<th class="currency"><?php if ($user->getAccountCredit() <= 0) echo my_format_currency($user->getAccountCredit()); ?></th>
</tr>
</tbody>
</table>

