<h2>Authentication</h2>

<?php if ($sf_request->hasErrors()):
$error_text = array();
foreach ($sf_request->getErrors() as $e) {
	if (is_array($e)) {
		$error_text[] = implode("; ", $e);
	} else {
		$error_text[] = $e;
	}
}
?>
<div class="error">
  Identification failed: <?php echo implode("; ", $error_text); ?> - please try again
</div>
<?php endif; ?>

<?php include_partial("login"); ?>
