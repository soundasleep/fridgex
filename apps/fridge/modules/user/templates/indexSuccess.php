<h1>Hi, <?php echo $user->getNickname(); ?>!</h1>

<?php use_helper('Number'); ?>

<h2>Recent Activity</h2>

<table>
<thead>
<tr>
  <th>ID</th>
  <th>Date</th>
  <th>Activity</th>
  <th>Price</th>
  <th>Quantity</th>
  <th>Credit</th>
  <th>Debit</th>
</tr>
</thead>
<tbody>
<?php foreach ($purchases as $purchase) { ?>
<tr>
	<td><?php echo $purchase->getId(); ?></td>
<?php if ($purchase->getQuantity() < 0) { ?>
	<td><?php echo $purchase->getCreatedAt(); ?></td>
	<td>Purchase: <?php echo link_to($purchase->getProduct()->getTitle(), "product/show?id=".$purchase->getProduct()->getId()); ?></td>
	<td><?php echo format_currency($purchase->getPrice()); ?></td>
	<td><?php echo format_number(-$purchase->getQuantity()); ?></td>
	<td></td>
	<td><?php echo format_currency($purchase->getPrice() * $purchase->getQuantity()); ?></td>
<?php } else { ?>
	<td><?php echo $purchase->getCreatedAt(); ?></td>
	<td>Credit: <?php echo link_to($purchase->getProduct()->getTitle(), "product/show?id=".$purchase->getProduct()->getId()); ?>
		<?php if (!$purchase->getVerifiedBy()) { ?>
		(Unverified)
		<?php } ?>
		</td>
	<td><?php echo format_currency($purchase->getPrice()); ?></td>
	<td><?php echo format_number($purchase->getQuantity()); ?></td>
	<td><?php echo format_currency($purchase->getPrice() * $purchase->getQuantity()); ?></td>
	<td></td>
<?php } ?>
</tr>
<?php } ?>
<tr>
	<th colspan="5">Account Balance</th>
	<th><?php if ($user->getAccountCredit() > 0) echo format_currency($user->getAccountCredit()); ?></th>
	<th><?php if ($user->getAccountCredit() <= 0) echo format_currency($user->getAccountCredit()); ?></th>
</tr>
</tbody>
</table>

