<?php
// Home page / application entry point.
// In Week 4 this file becomes the MVC controller.
$page_title  = 'Home';
$active_page = 'home';
include 'includes/header.php';
?>
<section class="hero">
    <h1>Gear up for your next trail.</h1>
    <p>Packs, poles, lights, and essentials for day hikes and weekend adventures.</p>
    <a class="btn btn-primary" href="catalog.php">Shop the Catalog</a>
</section>
<?php include 'includes/footer.php'; ?>
