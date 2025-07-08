-- Add OAuth fields to users table
ALTER TABLE users 
ADD COLUMN oauth_provider VARCHAR(50) NULL AFTER password,
ADD COLUMN oauth_id VARCHAR(255) NULL AFTER oauth_provider;

-- Add index for OAuth lookups
CREATE INDEX idx_oauth_provider_id ON users(oauth_provider, oauth_id);
CREATE INDEX idx_email_oauth ON users(email, oauth_provider);

-- Update existing users to have NULL oauth_provider (regular registration)
UPDATE users SET oauth_provider = NULL WHERE oauth_provider IS NULL; 