<?php
// Shopping cart page - Week 2 static shell.
// Week 3: rows will come from the cart table (quantity >= 1) and the totals
// will be calculated: tax = 5% of items, shipping & handling = 10% of pre-tax total.
$page_title  = 'Shopping Cart';
$active_page = 'cart';
include 'includes/header.php';
?>
<div class="page-heading">
    <h1>Shopping Cart</h1>
</div>

<div class="notice">
    <strong>Under construction:</strong> Cart items and order totals will be loaded from the database in Week 3.
</div>

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
        <tr>
            <td colspan="5" class="empty">Your cart is empty.</td>
        </tr>
    </tbody>
</table>

<div class="cart-bottom">
    <table class="totals">
        <tr><th>Total of Items Ordered</th><td>$0.00</td></tr>
        <tr><th>Tax (5%)</th><td>$0.00</td></tr>
        <tr><th>Shipping &amp; Handling (10%)</th><td>$0.00</td></tr>
        <tr class="grand"><th>Order Total</th><td>$0.00</td></tr>
    </table>
    <div class="cart-buttons">
        <a class="btn btn-secondary" href="catalog.php">&larr; Continue Shopping</a>
        <button class="btn btn-primary" disabled title="Coming in Week 3">Check Out</button>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
