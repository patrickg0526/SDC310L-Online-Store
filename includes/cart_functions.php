<?php
// CRUD functions for the products and cart tables.
// Every query that uses a value from the user is a prepared statement.

const TAX_RATE      = 0.05;  // 5% tax on items ordered
const SHIPPING_RATE = 0.10;  // 10% shipping & handling on the pre-tax total

// READ: every product with its current quantity in the cart (0 if not in the cart).
function get_products(PDO $db)
{
    $sql = 'SELECT p.product_id, p.product_name, p.product_description, p.product_cost,
                   COALESCE(c.quantity, 0) AS quantity
            FROM products p
            LEFT JOIN cart c ON c.product_id = p.product_id
            ORDER BY p.product_id';
    return $db->query($sql)->fetchAll();
}

// READ: true if the product ID exists in the catalog.
function product_exists(PDO $db, int $product_id)
{
    $stmt = $db->prepare('SELECT COUNT(*) FROM products WHERE product_id = ?');
    $stmt->execute([$product_id]);
    return (int)$stmt->fetchColumn() === 1;
}

// READ: one product's name (used for status messages).
function get_product_name(PDO $db, int $product_id)
{
    $stmt = $db->prepare('SELECT product_name FROM products WHERE product_id = ?');
    $stmt->execute([$product_id]);
    return (string)$stmt->fetchColumn();
}

// CREATE / UPDATE: add one of the product to the cart.
// Inserts a new cart row if the product is not in the cart yet, otherwise adds 1 to the quantity.
function add_to_cart(PDO $db, int $product_id)
{
    $stmt = $db->prepare('INSERT INTO cart (product_id, quantity) VALUES (?, 1)
                          ON DUPLICATE KEY UPDATE quantity = quantity + 1');
    $stmt->execute([$product_id]);
}

// UPDATE: increase the quantity by 1 (same as adding one more to the cart).
function increase_quantity(PDO $db, int $product_id)
{
    add_to_cart($db, $product_id);
}

// UPDATE: decrease the quantity by 1. The quantity can never go below 0;
// when it reaches 0 the product's row is removed from the cart.
function decrease_quantity(PDO $db, int $product_id)
{
    $stmt = $db->prepare('UPDATE cart SET quantity = quantity - 1
                          WHERE product_id = ? AND quantity > 0');
    $stmt->execute([$product_id]);

    $stmt = $db->prepare('DELETE FROM cart WHERE product_id = ? AND quantity <= 0');
    $stmt->execute([$product_id]);
}

// DELETE: remove the product from the cart completely (quantity back to 0).
function remove_from_cart(PDO $db, int $product_id)
{
    $stmt = $db->prepare('DELETE FROM cart WHERE product_id = ?');
    $stmt->execute([$product_id]);
}

// READ: products in the cart with a quantity of at least 1, plus each product total.
function get_cart_items(PDO $db)
{
    $sql = 'SELECT p.product_id, p.product_name, c.quantity, p.product_cost,
                   (c.quantity * p.product_cost) AS product_total
            FROM cart c
            JOIN products p ON p.product_id = c.product_id
            WHERE c.quantity >= 1
            ORDER BY p.product_id';
    return $db->query($sql)->fetchAll();
}

// Calculate the order totals from the cart items.
function calculate_totals(array $items)
{
    $subtotal = 0.0;
    foreach ($items as $item) {
        $subtotal += $item['quantity'] * $item['product_cost'];
    }
    $subtotal = round($subtotal, 2);
    $tax      = round($subtotal * TAX_RATE, 2);
    $shipping = round($subtotal * SHIPPING_RATE, 2);

    return [
        'subtotal' => $subtotal,
        'tax'      => $tax,
        'shipping' => $shipping,
        'total'    => round($subtotal + $tax + $shipping, 2),
    ];
}

// DELETE: check out - clear every product from the cart.
function clear_cart(PDO $db)
{
    $db->exec('DELETE FROM cart');
}

// Format a number as US currency, e.g. 1234.5 -> $1,234.50
function format_money($amount)
{
    return '$' . number_format((float)$amount, 2);
}

// Store a one-time status message to show on the next page load.
function set_flash($message)
{
    $_SESSION['flash'] = $message;
}

// Get (and clear) the one-time status message.
function get_flash()
{
    $message = $_SESSION['flash'] ?? '';
    unset($_SESSION['flash']);
    return $message;
}
