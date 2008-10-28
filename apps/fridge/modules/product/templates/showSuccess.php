<?php
// auto-generated by sfPropelCrud
// date: 2008/07/23 15:51:32
?>
<div id="product_show">

<h1><?php echo $product->getTitle(); ?></h1>

&nbsp;<?php echo link_to('< Back to product list', 'product/list') ?>

<div class="info">
	<table>
	<tbody>
	<tr>
	<th>Price: </th>
	<td><?php echo my_format_currency(apply_surcharge($product->getPrice())) ?>
	<?php if ($user && $user->canViewSurcharge() && get_surcharge_for($product->getPrice())) { ?>, includes a surcharge of <?php echo my_format_currency(get_surcharge_for($product->getPrice())); ?><?php } ?></td>
	</tr>
	<tr>
	<th>Inventory: </th>
	<td><?php echo format_number($product->getInventory()) ?></td>
	</tr>
	<tr>
	<th>Image: </th>
	<td><?php echo image_tag($product->getImageUrl()) ?></td>
	</tr>
	</tbody>
	</table>
</div>

<div class="purchase">

<?php if ($user) { ?>

<?php if ($product->getInventory() > 0) { ?>

<?php echo form_tag("product/purchase"); ?>
<?php echo input_hidden_tag("id", $product->getId()); ?>
	<table>
	<thead>
	<tr>
		<th colspan="2">Purchase</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<th>Quantity: </th>
		<td><?php echo input_tag("quantity", 1); ?></td>
	</tr>
	<tr>
		<td></td>
		<td>
			<?php echo submit_tag("Purchase"); ?>
			<?php if ($user->canChargeStockLosses()) { ?>
				<?php echo submit_tag("Purchase as a stock loss", array("name" => "stock_loss")); ?>
			<?php } ?>
		</td>
	</tr>
	</tbody>
	</table>
</form>

<?php } else { ?>

<div class="disabled">None available for purchase</span>

<?php } ?>

<?php if ($user->canCredit($product)) { ?>

<?php echo form_tag("product/credit"); ?>
<?php echo input_hidden_tag("id", $product->getId()); ?>
	<table>
	<thead>
	<tr>
		<th colspan="2">Credit</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<th>Quantity: </th>
		<td><?php echo input_tag("quantity", 1); ?></td>
	</tr>
	<tr>
		<th>Price paid each: </th>
		<td>$ <?php echo input_tag("price", 1, array("size" => 10)); ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo submit_tag("Credit"); ?></td>
	</tr>
	</tbody>
	</table>
</form>

<?php } ?>

<?php } else { ?>

<?php if ($user) { ?>
<div class="disabled">You cannot afford to purchase this.</div>
<?php } else { ?>
<div class="disabled">You need to be <?php echo link_to("logged in", "security/index"); ?> to buy this.</div>
<?php } ?>

<?php } ?>

<?php if ($user && $user->canEditProduct($product)) { ?>
<?php echo link_to("Edit product", "product_admin/edit?id=".$product->getId()); ?>
<?php } ?>

<?php if ($activity) { ?>

<?php /* TODO: put this into a separate file */ ?>
<h2>Recent activity</h2>

<?php use_helper("My"); ?>

<table>
<thead>
<tr>
  <th>Id</th>
  <th>Date</th>
  <th>User</th>
  <th>Product</th>
  <th>Quantity</th>
  <th>Credit</th>
  <th>Debit</th>
<?php if ($user->canVerifyCredit()) { ?>
  <th>Notes</th>
<?php } ?>
<?php if ($user->canCancelPurchases()) { ?>
  <th></th>
<?php } ?>
</tr>
</thead>
<tbody>
<?php $i = 0;
$last_day = 0;
foreach ($activity as $purchase):
	$this_d = date("Y-m-d", strtotime($purchase->getCreatedAt()));
	if ($this_d != $last_day) {
		$i++;
		$last_day = $this_d;
	}
	?>
<tr class="<?php echo "day".($i%2); ?><?php if ($purchase->isCancelled()) echo " cancelled"; ?>">
    <td class="number"><?php echo $purchase->getId() ?></td>
      <td><?php echo my_format_date($purchase->getCreatedAt()) ?></td>
      <td><?php echo $purchase->getUser() ? link_to($purchase->getUser()->getNickname(), "user_admin/show?id=".$purchase->getUser()->getId(), array("class" => "username")) : "null" ?></td>
<?php if ($purchase->getIsDirectCredit()) { ?>
	<td>
		Direct credit by <span class="username"><?php echo $purchase->getCreditedByUser() ? link_to($purchase->getCreditedByUser()->getNickname(), "user_admin/show?id=". $purchase->getCreditedByUser()->getId()) : "null"; ?></span>
		<?php if (!$purchase->getVerifiedBy()) { ?>
			(<?php echo link_to("Unverified", "purchase/credit"); ?>)
		<?php } ?>
	</td>
	<td class="number"></td>
	<td class="currency"></td>
	<td class="currency"><?php echo my_format_currency($purchase->getPrice()); ?></td>
<?php } else { ?>
      <td><?php echo $purchase->getProduct() ? link_to($purchase->getProduct()->getTitle(), "product/show?id=".$purchase->getProduct()->getId()) : "null" ?></td>
      <td class="number"><?php echo format_number($purchase->getQuantity()) ?></td>
<?php if ($purchase->getQuantity() < 0) { ?>
      <td class="currency"></td>
      <td class="currency"><?php echo my_format_currency(($purchase->getPrice() + $purchase->getSurcharge()) * $purchase->getQuantity()) ?></td>
<?php } else { ?>
      <td class="currency"><?php echo my_format_currency(($purchase->getPrice() + $purchase->getSurcharge()) * $purchase->getQuantity()) ?></td>
      <td class="currency"></td>
<?php } ?>
<?php } ?>
<?php if ($user->canVerifyCredit()) { ?>
      <td class="notes"><?php echo $purchase->getNotes(); ?>
		<?php if ($purchase->getQuantity() > 0 && !$purchase->isVerified()) { ?>
			<?php echo link_to("unverified", "purchase/credit"); ?>
		<?php } ?>
	  </td>
<?php } ?>
<?php if ($user->canCancelPurchases()) { ?>
      <td class="notes">
      	<?php if (!$purchase->isCancelled()) { ?>
			<?php echo link_to("cancel", "purchase/cancel?id=".$purchase->getId(), array('onclick' => "return confirm('Are you sure you want to cancel this purchase?');")); ?>
		<?php } else { ?>
			Cancelled by <span class="username"><?php echo $purchase->getCancelledBy() ? $purchase->getCancelledBy()->getNickname() : "null"; ?></span>
		<?php } ?>
	  </td>
<?php } ?>
  </tr>
<?php endforeach; ?>
<?php if (!$activity) { ?>
<tr>
	<td colspan="8" class="no_activity">No recent activity to show!</td>
</tr>
<?php } ?>
</tbody>
</table>

<?php } /* end activity */ ?>

</div>