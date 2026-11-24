<?php
// Catalog page: lists every product from the database with its quantity in the cart,
// and handles the Add to Cart, +, -, and Remove buttons.
session_start();
require 'database.php';
require 'includes/cart_functions.php';

$allowed_actions = ['add', 'increase', 'decrease', 'remove'];

// Handle a cart change (always sent with POST), then redirect back to this page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action     = $_POST['action'] ?? '';
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

    try {
        if (!in_array($action, $allowed_actions, true)) {
            set_flash('That action is not allowed.');
        } elseif ($product_id === false || $product_id === null || !product_exists($db, $product_id)) {
            set_flash('That product could not be found.');
        } else {
            $name = get_product_name($db, $product_id);
            switch ($action) {
                case 'add':
                    add_to_cart($db, $product_id);
                    set_flash("Added 1 $name to your cart.");
                    break;
                case 'increase':
                    increase_quantity($db, $product_id);
                    set_flash("Increased the quantity of $name.");
                    break;
                case 'decrease':
                    decrease_quantity($db, $product_id);
                    set_flash("Decreased the quantity of $name.");
                    break;
                case 'remove':
                    remove_from_cart($db, $product_id);
                    set_flash("Removed $name from your cart.");
                    break;
            }
        }
    } catch (PDOException $e) {
        $error_message = 'Your cart could not be updated. Please try again.';
        include 'database_error.php';
        exit();
    }

    header('Location: catalog.php');
    exit();
}

// Load the catalog.
try {
    $products = get_products($db);
} catch (PDOException $e) {
    $error_message = 'The product catalog could not be loaded.';
    include 'database_error.php';
    exit();
}

$flash       = get_flash();
$page_title  = 'Catalog';
$active_page = 'catalog';
include 'includes/header.php';
?>
<div class="page-heading">
    <h1>Product Catalog</h1>
    <a class="btn btn-secondary" href="cart.php">View Cart &rarr;</a>
</div>

<?php if ($flash !== '') : ?>
    <div class="notice notice-success"><?php echo htmlspecialchars($flash); ?></div>
<?php endif; ?>

<table class="data-table">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Description</th>
            <th class="num">Product Cost</th>
            <th class="num">Quantity in Cart</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product) : ?>
        <?php $id = (int)$product['product_id']; $qty = (int)$product['quantity']; ?>
        <tr>
            <td><?php echo $id; ?></td>
            <td class="name"><?php echo htmlspecialchars($product['product_name']); ?></td>
            <td class="desc"><?php echo htmlspecialchars($product['product_description']); ?></td>
            <td class="num"><?php echo format_money($product['product_cost']); ?></td>
            <td class="num qty"><?php echo $qty; ?></td>
            <td class="actions">
                <form method="post" action="catalog.php" class="inline-form">
                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                    <button class="btn btn-small" name="action" value="decrease" title="Decrease quantity"
                        <?php echo $qty === 0 ? 'disabled' : ''; ?>>&minus;</button>
                    <button class="btn btn-small" name="action" value="increase" title="Increase quantity">+</button>
                    <button class="btn btn-small btn-primary" name="action" value="add">Add to Cart</button>
                    <button class="btn btn-small btn-danger" name="action" value="remove"
                        <?php echo $qty === 0 ? 'disabled' : ''; ?>>Remove</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>
