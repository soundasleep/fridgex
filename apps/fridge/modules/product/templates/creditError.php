<?php
// auto-generated by sfPropelCrud
// date: 2008/07/23 15:51:32
?>

&nbsp;<?php echo link_to('< back to '.$product->getTitle(), 'product/show?id='.$product->getId()) ?>

<?php if ($sf_request->hasErrors()): ?>
<div class="error">
  <?php echo implode("; ", $sf_request->getErrors()); ?> - please try again
</div>
<?php endif; ?>
