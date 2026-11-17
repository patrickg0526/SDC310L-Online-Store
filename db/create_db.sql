-- =============================================================
-- SDC310L Course Project - Summit Trail Outfitters Online Store
-- create_db.sql : creates the online_store database, the
-- application user, the products and cart tables, and loads
-- the starting product data.
-- Run in phpMyAdmin (SQL tab) or: mysql -u root < create_db.sql
-- =============================================================

DROP DATABASE IF EXISTS online_store;
CREATE DATABASE online_store
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE online_store;

-- -------------------------------------------------------------
-- products: the store catalog (one row per product)
-- -------------------------------------------------------------
CREATE TABLE products (
    product_id          INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    product_name        VARCHAR(100)   NOT NULL,
    product_description TEXT           NOT NULL,
    product_cost        DECIMAL(10,2)  NOT NULL,
    PRIMARY KEY (product_id),
    CONSTRAINT chk_product_cost CHECK (product_cost > 0)
) ENGINE=InnoDB;

-- -------------------------------------------------------------
-- cart: current shopping cart contents (one row per product)
-- -------------------------------------------------------------
CREATE TABLE cart (
    product_id INT UNSIGNED NOT NULL,
    quantity   INT          NOT NULL DEFAULT 0,
    PRIMARY KEY (product_id),
    CONSTRAINT fk_cart_product FOREIGN KEY (product_id)
        REFERENCES products (product_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT chk_cart_quantity CHECK (quantity >= 0)
) ENGINE=InnoDB;

-- -------------------------------------------------------------
-- Starting product data (at least five products required)
-- -------------------------------------------------------------
INSERT INTO products (product_name, product_description, product_cost) VALUES
('Trail Daypack 28L',
 'Lightweight 28-liter daypack with a padded hip belt, hydration sleeve, and rain cover for full-day hikes.',
 64.99),
('Insulated Water Bottle 32 oz',
 'Double-wall stainless steel bottle that keeps water cold for 24 hours. Leak-proof lid with carry loop.',
 24.95),
('Trekking Poles (Pair)',
 'Adjustable aluminum trekking poles with cork grips and quick-lock levers. Folds down to 26 inches.',
 49.50),
('Waterproof Hiking Socks',
 'Merino wool blend socks with a waterproof breathable membrane to keep feet dry on wet trails.',
 18.00),
('LED Headlamp 350 Lumen',
 'Rechargeable headlamp with spot, flood, and red-light modes. Up to 40 hours of battery life on low.',
 29.99),
('Compact First Aid Kit',
 'Water-resistant first aid kit with bandages, blister care, antiseptic wipes, and an emergency blanket.',
 22.75);

-- -------------------------------------------------------------
-- Application database account (least privilege, local only).
-- The web application uses this account instead of root.
-- Development credentials only - change for any real deployment.
-- -------------------------------------------------------------
DROP USER IF EXISTS 'store_user'@'localhost';
CREATE USER 'store_user'@'localhost' IDENTIFIED BY 'SummitTrail#Dev2026';
GRANT SELECT, INSERT, UPDATE, DELETE ON online_store.* TO 'store_user'@'localhost';
FLUSH PRIVILEGES;
