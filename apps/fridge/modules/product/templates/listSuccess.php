<?php
// auto-generated by sfPropelCrud
// date: 2008/07/23 15:51:32
?>
<h1>product list</h1>

<?php use_helper('Number'); ?>

<?php if ($purchase) { ?>
<div class="message">
	You have successfully purchased <?php echo number_format(-$purchase->getQuantity()); ?>
	<?php echo link_to($purchase->getProduct()->getTitle() . (-$purchase->getQuantity() == 1 ? "" : "s"), "product/show?id=".$purchase->getProduct()->getId()); ?>
	for <b><?php echo format_currency($purchase->getPrice() * -$purchase->getQuantity()); ?></b>.
	<br>
	Your <?php echo link_to("account balance", "user/index"); ?>
	is now <b><?php echo format_currency($user->getAccountCredit()); ?></b>.
</div>
<?php } ?>

<?php if ($credit) { ?>
<div class="message">
	You have successfully credited <?php echo number_format($credit->getQuantity()); ?>
	<?php echo link_to($credit->getProduct()->getTitle() . ($credit->getQuantity() == 1 ? "" : "s"), "product/show?id=".$credit->getProduct()->getId()); ?>
	at <b><?php echo format_currency($credit->getPrice()); ?></b> each. The new product price
	is now <b><?php echo format_currency($credit->getProduct()->getPrice()); ?></b>.
	<br>
	Your <?php echo link_to("account balance", "user/index"); ?>
	is now <b><?php echo format_currency($user->getAccountCredit()); ?></b>.
</div>
<?php } ?>

<?php if ($list) { ?>
<?php echo link_to("as gallery", "product/list?list=0"); ?>

<div id="product_list">
<table>
<thead>
<tr>
  <th>Title</th>
  <th>Price</th>
  <th>Inventory</th>
  <th>Image url</th>
</tr>
</thead>
<tbody>
<?php foreach ($products as $product): ?>
<tr>
      <td><?php echo link_to($product->getTitle(), 'product/show?id='.$product->getId()) ?></td>
      <td><?php echo format_currency($product->getPrice()) ?></td>
      <td><?php echo $product->getInventory() ?></td>
      <td><?php echo $product->getImageUrl() ?></td>
      <td>

      	<?php echo form_tag("product/purchase"); ?>
	  	      	<?php echo input_hidden_tag("id", $product->getId()); ?>
	  	      	<?php echo input_hidden_tag("quantity", 1); ?>
	  	      	<?php echo submit_tag("purchase one (" . format_currency($product->getPrice()) . ")", array("disabled" => ($product->getInventory() <= 0))); ?>
      	</form>

		<?php if ($user && $user->canEditProduct($product)) { ?>
		<?php echo link_to("edit", "product_admin/edit?id=".$product->getId()); ?>
		<?php } ?>

    </td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<?php } else { ?>
<?php echo link_to( "as list", "product/list?list=1"); ?>

<div id="product_gallery">
<table>
<?php $i = 0; ?>
<?php foreach ($products as $product): ?>
<?php $i++; ?>

<?php if ($i % $gallery_size == 0) echo "<tr>"; ?>

<td>
	<?php echo link_to(image_tag($product->getImageUrl(), array("width" => "100")), "product/show?id=".$product->getId()); ?><br>

	<?php echo link_to($product->getTitle(), 'product/show?id='.$product->getId()) ?> - <b><?php echo format_currency($product->getPrice()) ?></b><br>

		<?php echo form_tag("product/purchase"); ?>
	      	<?php echo input_hidden_tag("id", $product->getId()); ?>
	      	<?php echo input_hidden_tag("quantity", 1); ?>
	      	<?php echo submit_tag("purchase one (" . format_currency($product->getPrice()) . ")", array("disabled" => ($product->getInventory() <= 0))); ?>
      	</form>

		<?php if ($user && $user->canEditProduct($product)) { ?>
		<?php echo link_to("edit", "product_admin/edit?id=".$product->getId()); ?>
		<?php } ?>

</td>

<?php if ($i % $gallery_size == $gallery_size - 1) echo "</tr>"; ?>

<?php endforeach; ?>

<?php if ($i % $gallery_size != $gallery_size - 1) echo "</tr>"; ?>
</table>
</div>

<?php } ?>

<?php if ($user && $user->canAddProduct()) { ?>
<?php echo link_to("add new product", "product_admin/create"); ?>
<?php } ?>