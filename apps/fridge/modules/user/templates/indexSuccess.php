<h1>Hi, <?php echo $user->getNickname(); ?>!</h1>

<?php use_helper('My'); ?>

<h2>Account Details</h2>

<table>
<tr>
  <th>Name</th>
  <td><?php echo $user->getName(); ?></td>
</tr>
<tr>
  <th>Email</th>
  <td><?php echo mail_to($user->getEmail()); ?></td>
</tr>
<tr>
  <th>Nickname</th>
  <td><span class="username"><?php echo $user->getNickname(); ?></span></td>
</tr>
<tr>
  <th>Account Credit</th>
  <td><?php echo my_format_currency($user->getAccountCredit()); ?></td>
</tr>
<tr>
  <td></td>
  <td><?php echo link_to("Edit account details", "user/edit"); ?></td>
</tr>
</table>

<h2>Recent Activity</h2>

<table>
<thead>
<tr>
  <th>ID</th>
  <th>Date</th>
  <th>Activity</th>
  <th>Price</th>
  <th>Quantity</th>
<?php if ($user->canViewSurcharge()) { ?>
  <th>Surcharge</th>
<?php } ?>
  <th>Credit</th>
  <th>Debit</th>
</tr>
</thead>
<tbody>
<?php foreach ($purchases as $purchase) { ?>
<tr class="<?php if ($purchase->isCancelled()) echo "cancelled"; ?>">
	<td><?php echo $purchase->getId(); ?></td>
<?php if ($purchase->getIsDirectCredit()) { ?>
	<?php if ($purchase->getPrice() > 0) { ?>
		<td><?php echo my_format_date($purchase->getCreatedAt()); ?></td>
		<td>
			Direct credit by <span class="username"><?php echo $purchase->getCreditedByUser() ? link_to($purchase->getCreditedByUser()->getNickname(), "user_admin/show?id=". $purchase->getCreditedByUser()->getId()) : "null"; ?></span>
			<?php if (!$purchase->getVerifiedBy()) { ?>
				(<?php echo link_to("Unverified", "purchase/credit"); ?>)
			<?php } ?>
		</td>
		<td class="currency"><?php echo my_format_currency($purchase->getPrice()); ?></td>
		<td class="number"></td>
		<?php if ($user->canViewSurcharge()) { ?>
			<td class="currency"></td>
		<?php } ?>
		<td class="currency"><?php echo my_format_currency($purchase->getPrice()); ?></td>
		<td class="currency"></td>
	<?php } else { ?>
		<td><?php echo my_format_date($purchase->getCreatedAt()); ?></td>
		<td>
			Direct debit by <span class="username"><?php echo $purchase->getCreditedByUser() ? link_to($purchase->getCreditedByUser()->getNickname(), "user_admin/show?id=". $purchase->getCreditedByUser()->getId()) : "null"; ?></span>
			<?php if (!$purchase->getVerifiedBy()) { ?>
				(<?php echo link_to("Unverified", "purchase/credit"); ?>)
			<?php } ?>
		</td>
		<td class="currency"><?php echo my_format_currency($purchase->getPrice()); ?></td>
		<td class="number"></td>
		<?php if ($user->canViewSurcharge()) { ?>
			<td class="currency"></td>
		<?php } ?>
		<td class="currency"></td>
		<td class="currency"><?php echo my_format_currency($purchase->getPrice()); ?></td>
	<?php } ?>
<?php } elseif ($purchase->getQuantity() < 0) { ?>
	<td><?php echo my_format_date($purchase->getCreatedAt()); ?></td>
	<td>Purchase: <?php echo link_to($purchase->getProduct()->getTitle(), "product/show?id=".$purchase->getProduct()->getId()); ?></td>
	<td class="currency"><?php echo my_format_currency($purchase->getPrice()); ?></td>
	<td class="number"><?php echo format_number(-$purchase->getQuantity()); ?></td>
<?php if ($user->canViewSurcharge()) { ?>
	<td class="currency"><?php echo my_format_currency($purchase->getSurcharge()); ?></td>
<?php } ?>
	<td class="currency"></td>
	<td class="currency"><?php echo my_format_currency(($purchase->getPrice() + $purchase->getSurcharge()) * $purchase->getQuantity()); ?></td>
<?php } else { ?>
	<td><?php echo my_format_date($purchase->getCreatedAt()); ?></td>
	<td>Credit: <?php echo link_to($purchase->getProduct()->getTitle(), "product/show?id=".$purchase->getProduct()->getId()); ?>
		<?php if (!$purchase->getVerifiedBy()) { ?>
		(Unverified)
		<?php } ?>
		</td>
	<td class="currency"><?php echo my_format_currency($purchase->getPrice()); ?></td>
	<td class="number"><?php echo format_number($purchase->getQuantity()); ?></td>
<?php if ($user->canViewSurcharge()) { ?>
	<td class="currency"><?php echo my_format_currency($purchase->getSurcharge()); ?></td>
<?php } ?>
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

