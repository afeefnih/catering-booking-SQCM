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

-- Note: Payment table is now created in cateringdata.sql for Docker compatibility
