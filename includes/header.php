<?php
// Shared page header. Set $page_title and $active_page before including.
$page_title  = $page_title  ?? 'Summit Trail Outfitters';
$active_page = $active_page ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> | Summit Trail Outfitters</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="logo" href="index.php">&#9650; Summit Trail <span>Outfitters</span></a>
        <nav class="main-nav">
            <a href="index.php"   class="<?php echo $active_page === 'home'    ? 'active' : ''; ?>">Home</a>
            <a href="catalog.php" class="<?php echo $active_page === 'catalog' ? 'active' : ''; ?>">Catalog</a>
            <a href="cart.php"    class="<?php echo $active_page === 'cart'    ? 'active' : ''; ?>">&#128722; Cart</a>
        </nav>
    </div>
</header>
<main class="container">
