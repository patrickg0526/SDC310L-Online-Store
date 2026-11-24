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

## Week 3 - Adding Database Support
- `database.php` - PDO connection using the least-privilege `store_user` account, with a friendly
  error page (`database_error.php`) if the connection or a query fails
- `includes/cart_functions.php` - CRUD functions: get products, add to cart, increase/decrease
  quantity (never below 0), remove from cart, get cart items, calculate totals, clear cart
- `catalog.php` - catalog loaded from the database with working Add to Cart, +, -, and Remove buttons
- `cart.php` - cart items (quantity of at least 1), product totals, 5% tax, 10% shipping & handling,
  order total, Continue Shopping, and Check Out (clears the cart and returns to the catalog)

## Setup (XAMPP 7.4)
1. Start Apache and MySQL in the XAMPP Control Panel.
2. In phpMyAdmin, open the **SQL** tab, paste the contents of `db/create_db.sql`, and click **Go**
   (or run `mysql -u root < db/create_db.sql`).
3. Place this folder at `C:\xampp\htdocs\SDC310L-Online-Store`.
4. Browse to http://localhost/SDC310L-Online-Store/
