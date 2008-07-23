<h2>Authentication</h2>

<?php if ($sf_request->hasErrors()): ?>
<div class="error">
  Identification failed: <?php echo implode("; ", $sf_request->getErrors()); ?> - please try again
</div>
<?php endif; ?>

<div class="error">You do not have sufficient rights to access this page. You can try logging in with
different credentials here:</div>

<?php include_partial("login"); ?>
