-- RCN Mission Hospital SQL schema and sample data

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('SuperAdmin','Admin','Editor') NOT NULL DEFAULT 'Editor',
  status ENUM('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Email queue for queued sending (newsletter, contact, etc.)
CREATE TABLE IF NOT EXISTS email_queue (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  type VARCHAR(32) NOT NULL,
  recipient VARCHAR(255) NOT NULL,
  subject VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  meta TEXT NULL,
  status ENUM('pending','sent','failed') NOT NULL DEFAULT 'pending',
  attempts INT UNSIGNED NOT NULL DEFAULT 0,
  last_attempt_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  sent_at DATETIME NULL,
  error TEXT NULL,
  PRIMARY KEY (id),
  INDEX idx_email_queue_status (status),
  INDEX idx_email_queue_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS blog_posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(200) NOT NULL UNIQUE,
  excerpt TEXT NOT NULL,
  content TEXT NOT NULL,
  image VARCHAR(255) DEFAULT NULL,
  author VARCHAR(100) NOT NULL,
  created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS outreach_reports (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  description TEXT NOT NULL,
  file_link VARCHAR(255) DEFAULT NULL,
  image VARCHAR(255) DEFAULT NULL,
  date DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS sponsors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  message TEXT NOT NULL,
  image VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS trips (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  location VARCHAR(200) NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  description TEXT NOT NULL,
  image VARCHAR(255) DEFAULT NULL,
  cost DECIMAL(10,2) DEFAULT NULL,
  register_deadline DATE DEFAULT NULL,
  spots_available INT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS gallery (
  id INT AUTO_INCREMENT PRIMARY KEY,
  image VARCHAR(255) NOT NULL,
  caption VARCHAR(255) DEFAULT NULL,
  uploaded_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Legacy simple key/value settings (retained for compatibility)
CREATE TABLE IF NOT EXISTS site_settings (
  `key` VARCHAR(100) PRIMARY KEY,
  `value` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- New structured settings table for admin-managed configuration
CREATE TABLE IF NOT EXISTS settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL UNIQUE,
  value TEXT NOT NULL,
  is_secret TINYINT(1) NOT NULL DEFAULT 0,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updated_by INT NULL,
  INDEX (name),
  INDEX (updated_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS audit_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  action VARCHAR(100) NOT NULL,
  timestamp DATETIME NOT NULL,
  INDEX (action),
  INDEX (timestamp)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample users (update passwords in production)
INSERT INTO users (name, email, password_hash, role, status) VALUES
('Super Admin', 'admin@example.com', '$2y$10$Yp6iB9GfC0w1ZC1Yq8bJYuKQpFzFj9C0C8mWJp0xHn3lD9Wv4Yx6e', 'SuperAdmin', 'active'),
('Content Editor', 'editor@example.com', '$2y$10$Yp6iB9GfC0w1ZC1Yq8bJYuKQpFzFj9C0C8mWJp0xHn3lD9Wv4Yx6e', 'Editor', 'active');
-- The above hashes correspond to password: Password123!

-- Sample blog posts
INSERT INTO blog_posts (title, slug, excerpt, content, image, author, created_at) VALUES
('Our Mission in Action', 'our-mission-in-action', 'Highlights from recent outreach efforts.', 'We saw lives impacted through medical care and prayer.', NULL, 'Super Admin', NOW()),
('Upcoming Trip to Rural Community', 'upcoming-trip-rural-community', 'Join us for the next mission trip.', 'Sign up to serve alongside fellow believers.', NULL, 'Super Admin', NOW());

-- Sample trips
INSERT INTO trips (title, location, start_date, end_date, description) VALUES
('Community Health Outreach', 'Kogi State', '2025-12-01', '2025-12-07', 'Providing medical care and sharing the Gospel.'),
('Mobile Clinic Week', 'Kaduna State', '2026-01-10', '2026-01-15', 'Mobile clinics serving remote areas.');

-- Sample sponsors
INSERT INTO sponsors (name, message, image) VALUES
('Mission Partner A', 'Thank you for your generous support!', NULL),
('Mission Partner B', 'Your gifts make a difference.', NULL);

-- Sample outreach reports
INSERT INTO outreach_reports (title, description, file_link, date) VALUES
('Q3 Outreach Summary', 'Patients treated and Bibles distributed.', NULL, '2025-09-30');

-- Resources for download (admin-managed)
CREATE TABLE IF NOT EXISTS resources (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  description TEXT NOT NULL,
  file_link VARCHAR(255) DEFAULT NULL,
  file VARCHAR(255) DEFAULT NULL,
  date DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Future programs (admin-managed)
CREATE TABLE IF NOT EXISTS future_programs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  description TEXT NOT NULL,
  start_date DATE DEFAULT NULL,
  end_date DATE DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Donations tracking (from PayPal IPN or other gateways)
CREATE TABLE IF NOT EXISTS donations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  gateway VARCHAR(50) NOT NULL, -- e.g., 'paypal', 'paystack'
  type ENUM('one_time','recurring') NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  currency VARCHAR(10) NOT NULL,
  email VARCHAR(150) DEFAULT NULL,
  status VARCHAR(50) NOT NULL, -- e.g., 'Completed','Pending','Failed'
  transaction_id VARCHAR(100) DEFAULT NULL,
  external_id VARCHAR(100) DEFAULT NULL, -- e.g., PayPal subscr_id reference
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  raw_payload TEXT NULL,
  INDEX (gateway),
  INDEX (type),
  INDEX (status),
  INDEX (created_at),
  INDEX (transaction_id),
  INDEX (external_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Subscriptions tracking (PayPal subscr_* events, or other gateways)
CREATE TABLE IF NOT EXISTS subscriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  gateway VARCHAR(50) NOT NULL,
  external_id VARCHAR(100) NOT NULL, -- unique subscription reference from gateway
  plan_code VARCHAR(100) DEFAULT NULL,
  amount DECIMAL(10,2) DEFAULT NULL,
  currency VARCHAR(10) DEFAULT NULL,
  email VARCHAR(150) DEFAULT NULL,
  status VARCHAR(50) NOT NULL, -- e.g., 'active','cancelled','suspended'
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  raw_payload TEXT NULL,
  UNIQUE KEY (external_id),
  INDEX (gateway),
  INDEX (status),
  INDEX (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- Newsletter subscribers (public email signups)
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL,
  source VARCHAR(100) DEFAULT NULL,
  ip_address VARCHAR(45) DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  confirmed_at DATETIME DEFAULT NULL,
  unsubscribed_at DATETIME DEFAULT NULL,
  unsubscribe_token VARCHAR(64) DEFAULT NULL,
  UNIQUE KEY uniq_newsletter_email (email),
  UNIQUE KEY uniq_unsubscribe_token (unsubscribe_token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Newsletter confirmations (double opt-in tokens)
CREATE TABLE IF NOT EXISTS newsletter_confirmations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL,
  token VARCHAR(64) NOT NULL,
  expires_at DATETIME NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_newsletter_token (token),
  INDEX idx_newsletter_email (email),
  INDEX idx_expires_at (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Testimonials (admin-managed)
CREATE TABLE IF NOT EXISTS testimonials (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  role VARCHAR(120) DEFAULT NULL,
  message TEXT NOT NULL,
  photo VARCHAR(255) DEFAULT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample testimonials
INSERT INTO testimonials (name, role, message, is_active, sort_order) VALUES
('Dr. Jane Doe', 'Volunteer Physician', 'Serving with RCN Mission Hospital was life-changing. We provided care and shared hope with every patient.', 1, 1),
('John Smith', 'Logistics Volunteer', 'I witnessed compassion in action and saw communities transformed through medical outreach and prayer.', 1, 2);