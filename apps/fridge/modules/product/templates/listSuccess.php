<?php
// auto-generated by sfPropelCrud
// date: 2008/07/23 15:51:32
?>
<div id="product_list">
<h1>Product List</h1>

<?php if ($user) { ?>
<p>Select something to purchase from the fridge.</p>
<?php } else { ?>
<p>You know, if you <?php echo link_to("logged in", "security/index"); ?>, you could buy something from this fridge.</p>
<?php } ?>

<?php use_helper('My'); ?>

<?php if ($purchase) { ?>
<div class="message">
	You have successfully purchased <?php echo number_format(-$purchase->getQuantity()); ?>
	<?php echo link_to($purchase->getProduct()->getTitle() . (-$purchase->getQuantity() == 1 ? "" : "s"), "product/show?id=".$purchase->getProduct()->getId()); ?>
	for <b><?php echo my_format_currency((($purchase->getPrice() + $purchase->getSurcharge()) * -$purchase->getQuantity())); ?></b>.
	<br>
	Your <?php echo link_to("account balance", "user/index"); ?>
	is now <b><?php echo my_format_currency($user->getAccountCredit()); ?></b>.
</div>
<?php } ?>

<?php if ($credit) { ?>
<div class="message">
	You have successfully credited <?php echo number_format($credit->getQuantity()); ?>
	<?php echo link_to($credit->getProduct()->getTitle() . ($credit->getQuantity() == 1 ? "" : "s"), "product/show?id=".$credit->getProduct()->getId()); ?>
	at <b><?php echo my_format_currency($credit->getPrice()); ?></b> each. The new product price
	is now <b><?php echo my_format_currency(apply_surcharge($credit->getProduct()->getPrice())); ?></b>.
	<br>
	Your <?php echo link_to("account balance", "user/index"); ?>
	is now <b><?php echo my_format_currency($user->getAccountCredit()); ?></b>.
</div>
<?php } ?>

<?php if ($stock) { ?>
<div class="message">
	Stock loss action successful.
</div>
<?php } ?>

<div class="product_list">

<?php if ($list) { ?>
<div class="display_switch">
<?php echo link_to("Display as gallery", "product/list?list=0"); ?>
</div>

<table>
<thead>
<tr>
  <th>Title</th>
  <th>Price</th>
  <th>Inventory</th>
  <th>Purchase</th>
</tr>
</thead>
<tbody>
<?php foreach ($products as $product): ?>
<tr>
      <td><?php echo link_to($product->getTitle(), 'product/show?id='.$product->getId()) ?></td>
      <td class="currency"><?php echo my_format_currency(apply_surcharge($product->getPrice())) ?></td>
      <td class="number"><?php echo format_number($product->getInventory()) ?></td>
      <td>

		<?php if ($user) { ?>
      	<?php echo form_tag("product/purchase"); ?>
	  	      	<?php echo input_hidden_tag("id", $product->getId()); ?>
	  	      	<?php echo input_hidden_tag("quantity", 1); ?>
				<?php echo submit_tag("purchase one (" . my_format_currency(apply_surcharge($product->getPrice())) . ")", array("disabled" => ($product->getInventory() <= 0))); ?>

		<?php if ($user && $user->canEditProduct($product)) { ?>
		<?php echo link_to("edit", "product_admin/edit?id=".$product->getId()); ?>
		<?php } ?>

      	</form>
		<?php } ?>

    </td>
  </tr>
<?php endforeach; ?>
<?php if (!$products) { ?>
<tr>
   <td class="no_activity" colspan="4">There are no products to purchase!</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

<?php } else { ?>
<div class="display_switch">
<?php echo link_to("Display as list", "product/list?list=1"); ?>
</div>

<div id="product_gallery">
<?php $i = 0; ?>
<?php foreach ($products as $product): ?>

<div class="product">
	<div class="image_tag">
		<?php echo link_to(image_tag($product->getImageUrl(), array("width" => "100")), "product/show?id=".$product->getId()); ?><br>
	</div>

	<?php echo link_to($product->getTitle(), 'product/show?id='.$product->getId()) ?> - <b><?php echo my_format_currency(apply_surcharge($product->getPrice())) ?></b><br>

      	<?php if ($user) { ?>
		<?php echo form_tag("product/purchase"); ?>
	      	<?php echo input_hidden_tag("id", $product->getId()); ?>
	      	<?php echo input_hidden_tag("quantity", 1); ?>
      		<?php echo submit_tag("purchase one (" . my_format_currency(apply_surcharge($product->getPrice())) . ")", array("disabled" => ($product->getInventory() <= 0))); ?>

		<?php if ($user && $user->canEditProduct($product)) { ?>
		<?php echo link_to("edit", "product_admin/edit?id=".$product->getId()); ?>
		<?php } ?>

      	</form>
      	<?php } ?>
</div>

<?php $i++; ?>
<?php endforeach; ?>
<?php if (!$products) { ?>
   <div class="no_activity">There are no products to purchase!</td>
<?php } ?>

<div class="bottom_wrap"></div>
</div>

<?php } ?>

<div id="product_tools">
<?php if ($user && $user->canAddProduct()) { ?>
<?php echo link_to("Add new product", "product_admin/create"); ?>
<?php } ?>
</div>

</div>

<div id="statistics">
<h2>Fridge statistics</h2>

<table class="statistics">
<tr>
	<th></th>
	<th>Purchases</th>
	<th>Value</th>
	<?php if ($user && $user->canViewSurcharge()) { ?>
		<th>Surcharges</th>
	<?php } ?>
	<?php if ($user && $user->canSeeStockLosses()) { ?>
		<th>Stock losses</th>
	<?php } ?>
</tr>
<tr>
	<th>Today</th>
	<td class="number"><?php echo format_number(-$stat["today"]["sum_quantity_debit"]); ?></td>
	<td class="currency"><?php echo my_format_currency(-$stat["today"]["sum_total_debit"] - $stat["today"]["sum_surcharge_debit"]); ?></td>
	<?php if ($user && $user->canViewSurcharge()) { ?>
		<td class="currency"><?php echo my_format_currency(-$stat["today"]["sum_surcharge_debit"]); ?></td>
	<?php } ?>
	<?php if ($user && $user->canSeeStockLosses()) { ?>
		<td class="currency"><?php echo my_format_currency(-$stock_losses["today"]["sum_total_debit"]); ?></td>
	<?php } ?>
</tr>
<tr>
	<th>Last week</th>
	<td class="number"><?php echo format_number(-$stat["week"]["sum_quantity_debit"]); ?></td>
	<td class="currency"><?php echo my_format_currency(-$stat["week"]["sum_total_debit"] - $stat["week"]["sum_surcharge_debit"]); ?></td>
	<?php if ($user && $user->canViewSurcharge()) { ?>
		<td class="currency"><?php echo my_format_currency(-$stat["week"]["sum_surcharge_debit"]); ?></td>
	<?php } ?>
	<?php if ($user && $user->canSeeStockLosses()) { ?>
		<td class="currency"><?php echo my_format_currency(-$stock_losses["week"]["sum_total_debit"]); ?></td>
	<?php } ?>
</tr>
<tr>
	<th>Last month</th>
	<td class="number"><?php echo format_number(-$stat["month"]["sum_quantity_debit"]); ?></td>
	<td class="currency"><?php echo my_format_currency(-$stat["month"]["sum_total_debit"] - $stat["month"]["sum_surcharge_debit"]); ?></td>
	<?php if ($user && $user->canViewSurcharge()) { ?>
		<td class="currency"><?php echo my_format_currency(-$stat["month"]["sum_surcharge_debit"]); ?></td>
	<?php } ?>
	<?php if ($user && $user->canSeeStockLosses()) { ?>
		<td class="currency"><?php echo my_format_currency(-$stock_losses["month"]["sum_total_debit"]); ?></td>
	<?php } ?>
</tr>
<tr>
	<th>This year</th>
	<td class="number"><?php echo format_number(-$stat["year"]["sum_quantity_debit"]); ?></td>
	<td class="currency"><?php echo my_format_currency(-$stat["year"]["sum_total_debit"] - $stat["year"]["sum_surcharge_debit"]); ?></td>
	<?php if ($user && $user->canViewSurcharge()) { ?>
		<td class="currency"><?php echo my_format_currency(-$stat["year"]["sum_surcharge_debit"]); ?></td>
	<?php } ?>
	<?php if ($user && $user->canSeeStockLosses()) { ?>
		<td class="currency"><?php echo my_format_currency(-$stock_losses["year"]["sum_total_debit"]); ?></td>
	<?php } ?>
</tr>
</table>
</div>

</div>