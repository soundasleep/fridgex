<?php
// auto-generated by sfPropelCrud
// date: 2008/07/23 15:51:32
?>

&nbsp;<?php echo link_to('< back to product list', 'product/list') ?>

<table>
<tbody>
<tr>
<th>Id: </th>
<td><?php echo $product->getId() ?></td>
</tr>
<tr>
<th>Title: </th>
<td><?php echo $product->getTitle() ?></td>
</tr>
<tr>
<th>Price: </th>
<td><?php echo $product->getPrice() ?></td>
</tr>
<tr>
<th>Inventory: </th>
<td><?php echo $product->getInventory() ?></td>
</tr>
<tr>
<th>Image: </th>
<td><?php echo image_tag($product->getImageUrl()) ?></td>
</tr>
<tr>
<th>Sort order: </th>
<td><?php echo $product->getSortOrder() ?></td>
</tr>
</tbody>
</table>

<?php if ($user) { ?>

<?php if ($product->getInventory() > 0) { ?>

<hr />
Purchase some of these:
<?php echo form_tag("product/purchase"); ?>
<?php echo input_hidden_tag("id", $product->getId()); ?>
Quantity: <?php echo input_tag("quantity", 1); ?>
<?php echo submit_tag("Purchase"); ?>
</form>

<?php } else { ?>

<hr />
<span class="disabled">Purchase some of these</span>

<?php } ?>

<?php if ($user->canCredit($product)) { ?>
<hr />
Credit some of these:
<?php echo form_tag("product/credit"); ?>
<?php echo input_hidden_tag("id", $product->getId()); ?>
Quantity: <?php echo input_tag("quantity", 1); ?><br>
Price paid each: <?php echo input_tag("price", 1); ?>
<?php echo submit_tag("Credit"); ?>
<?php } ?>

<?php } else { ?>

<hr />
<span class="disabled">Purchase some of these</span>

<?php } ?>
