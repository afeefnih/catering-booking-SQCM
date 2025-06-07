-- Database Update Script
-- This script increases the size of columns that might be too small
-- and adds a new table for payment information

USE catering_booking;

-- Increase contact_person field size from 50 to 100 characters
ALTER TABLE orders MODIFY COLUMN contact_person VARCHAR(100) NOT NULL;

-- Optional: Also increase other potentially small fields
ALTER TABLE orders MODIFY COLUMN company_name VARCHAR(100) NOT NULL;
ALTER TABLE orders MODIFY COLUMN email VARCHAR(100) NOT NULL;
ALTER TABLE orders MODIFY COLUMN location VARCHAR(100) NOT NULL;

-- Show the updated structure
DESCRIBE orders;

-- Create payment table
CREATE TABLE payment (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id MEDIUMINT UNSIGNED NOT NULL, -- Changed from INT to MEDIUMINT UNSIGNED
    amount DECIMAL(10, 2) NOT NULL,
    payment_status VARCHAR(50) NOT NULL DEFAULT 'pending',
    transaction_id VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

-- Show the structure of the new payment table
DESCRIBE payment;
