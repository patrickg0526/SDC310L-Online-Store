<?php
// Shopping cart page: shows products with a quantity of at least 1, the order totals,
// and handles Check Out (clears the cart and returns to the catalog).
session_start();
require 'database.php';
require 'includes/cart_functions.php';

// Check Out (sent with POST): clear the cart, then return to the catalog page.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'checkout') {
    try {
        $had_items = count(get_cart_items($db)) > 0;
        clear_cart($db);
    } catch (PDOException $e) {
        $error_message = 'We could not complete your checkout. Please try again.';
        include 'database_error.php';
        exit();
    }
    set_flash($had_items ? 'Thank you for your order! Your cart has been cleared.' : 'Your cart was already empty.');
    header('Location: catalog.php');
    exit();
}

try {
    $items  = get_cart_items($db);
    $totals = calculate_totals($items);
} catch (PDOException $e) {
    $error_message = 'Your shopping cart could not be loaded.';
    include 'database_error.php';
    exit();
}

$flash       = get_flash();
$page_title  = 'Shopping Cart';
$active_page = 'cart';
include 'includes/header.php';
?>
<div class="page-heading">
    <h1>Shopping Cart</h1>
</div>

<?php if ($flash !== '') : ?>
    <div class="notice notice-success"><?php echo htmlspecialchars($flash); ?></div>
<?php endif; ?>

<table class="data-table">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th class="num">Quantity</th>
            <th class="num">Product Cost</th>
            <th class="num">Product Total</th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($items) === 0) : ?>
        <tr>
            <td colspan="5" class="empty">Your cart is empty. <a href="catalog.php">Browse the catalog</a> to add products.</td>
        </tr>
    <?php else : ?>
        <?php foreach ($items as $item) : ?>
            <tr>
                <td><?php echo (int)$item['product_id']; ?></td>
                <td class="name"><?php echo htmlspecialchars($item['product_name']); ?></td>
                <td class="num"><?php echo (int)$item['quantity']; ?></td>
                <td class="num"><?php echo format_money($item['product_cost']); ?></td>
                <td class="num"><?php echo format_money($item['product_total']); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<div class="cart-bottom">
    <table class="totals">
        <tr><th>Total of Items Ordered</th><td><?php echo format_money($totals['subtotal']); ?></td></tr>
        <tr><th>Tax (5%)</th><td><?php echo format_money($totals['tax']); ?></td></tr>
        <tr><th>Shipping &amp; Handling (10%)</th><td><?php echo format_money($totals['shipping']); ?></td></tr>
        <tr class="grand"><th>Order Total</th><td><?php echo format_money($totals['total']); ?></td></tr>
    </table>
    <div class="cart-buttons">
        <a class="btn btn-secondary" href="catalog.php">&larr; Continue Shopping</a>
        <form method="post" action="cart.php" class="inline-form">
            <button class="btn btn-primary" name="action" value="checkout"
                <?php echo count($items) === 0 ? 'disabled' : ''; ?>>Check Out</button>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
