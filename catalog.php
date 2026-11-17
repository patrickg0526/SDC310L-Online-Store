<?php
// Catalog page - Week 2 static shell.
// Week 3: rows will be generated from the products table joined to the cart table,
// and the add / remove / quantity buttons will update the cart table.
$page_title  = 'Catalog';
$active_page = 'catalog';
include 'includes/header.php';

// Placeholder data (matches the rows loaded by db/create_db.sql).
$products = [
    [1, 'Trail Daypack 28L', 'Lightweight 28-liter daypack with a padded hip belt, hydration sleeve, and rain cover for full-day hikes.', 64.99],
    [2, 'Insulated Water Bottle 32 oz', 'Double-wall stainless steel bottle that keeps water cold for 24 hours. Leak-proof lid with carry loop.', 24.95],
    [3, 'Trekking Poles (Pair)', 'Adjustable aluminum trekking poles with cork grips and quick-lock levers. Folds down to 26 inches.', 49.50],
    [4, 'Waterproof Hiking Socks', 'Merino wool blend socks with a waterproof breathable membrane to keep feet dry on wet trails.', 18.00],
    [5, 'LED Headlamp 350 Lumen', 'Rechargeable headlamp with spot, flood, and red-light modes. Up to 40 hours of battery life on low.', 29.99],
    [6, 'Compact First Aid Kit', 'Water-resistant first aid kit with bandages, blister care, antiseptic wipes, and an emergency blanket.', 22.75],
];
?>
<div class="page-heading">
    <h1>Product Catalog</h1>
    <a class="btn btn-secondary" href="cart.php">View Cart &rarr;</a>
</div>

<div class="notice">
    <strong>Under construction:</strong> Product data and cart buttons will be connected to the database in Week 3.
</div>

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
    <?php foreach ($products as $p) : ?>
        <tr>
            <td><?php echo $p[0]; ?></td>
            <td class="name"><?php echo htmlspecialchars($p[1]); ?></td>
            <td class="desc"><?php echo htmlspecialchars($p[2]); ?></td>
            <td class="num">$<?php echo number_format($p[3], 2); ?></td>
            <td class="num">0</td>
            <td class="actions">
                <button class="btn btn-small" disabled title="Coming in Week 3">&minus;</button>
                <button class="btn btn-small" disabled title="Coming in Week 3">+</button>
                <button class="btn btn-small btn-primary" disabled title="Coming in Week 3">Add to Cart</button>
                <button class="btn btn-small btn-danger" disabled title="Coming in Week 3">Remove</button>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>
