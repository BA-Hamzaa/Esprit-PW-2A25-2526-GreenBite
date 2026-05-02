-- Add password reset columns to users table
ALTER TABLE users 
ADD COLUMN password_reset_token VARCHAR(255) NULL,
ADD COLUMN reset_token_expiry DATETIME NULL;
