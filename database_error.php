<?php
// Friendly error page shown when the database cannot be reached or a query fails.
// The raw database error is never shown to the user.
$page_title    = 'Database Error';
$active_page   = '';
$error_message = $error_message ?? 'Something went wrong while talking to the store database.';
include 'includes/header.php';
?>
<div class="page-heading">
    <h1>Sorry, something went wrong</h1>
</div>
<div class="notice notice-error">
    <?php echo htmlspecialchars($error_message); ?>
</div>
<p><a class="btn btn-secondary" href="catalog.php">&larr; Back to the Catalog</a></p>
<?php include 'includes/footer.php'; ?>
