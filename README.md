# Summit Trail Outfitters - SDC310L Online Store

PHP / MySQL course project for SDC310L Server-Side Scripting with PHP Lab.
A simplified online store with a product catalog and a shopping cart.

## Week 2 - Database and Application Framework
- `db/create_db.sql` - creates the `online_store` database, the `products` and `cart` tables,
  six starting products, and a least-privilege application user.
- `index.php` - home page / entry point
- `catalog.php` - catalog page shell (product table, cart controls)
- `cart.php` - shopping cart page shell (cart table, totals, Continue Shopping / Check Out)
- `includes/` - shared `header.php` and `footer.php`
- `css/styles.css` - shared store styling

## Setup (XAMPP 7.4)
1. Start Apache and MySQL in the XAMPP Control Panel.
2. In phpMyAdmin, open the **SQL** tab, paste the contents of `db/create_db.sql`, and click **Go**
   (or run `mysql -u root < db/create_db.sql`).
3. Place this folder at `C:\xampp\htdocs\SDC310L-Online-Store`.
4. Browse to http://localhost/SDC310L-Online-Store/
