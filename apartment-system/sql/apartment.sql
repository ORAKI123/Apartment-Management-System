-- apartment_system sample schema + data
CREATE DATABASE IF NOT EXISTS apartment_system;
USE apartment_system;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin','staff','tenant') DEFAULT 'tenant',
  status ENUM('active','inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS units (
  id INT AUTO_INCREMENT PRIMARY KEY,
  unit_number VARCHAR(20) NOT NULL,
  status ENUM('vacant','occupied') DEFAULT 'vacant',
  tenant_id INT DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS tenants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(150),
  email VARCHAR(150),
  phone VARCHAR(50),
  address VARCHAR(255),
  age INT,
  occupation VARCHAR(100),
  unit_id INT DEFAULT NULL,
  id_image VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS contracts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tenant_id INT,
  unit_id INT,
  start_date DATE,
  end_date DATE,
  rent DECIMAL(10,2)
);

CREATE TABLE IF NOT EXISTS payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tenant_id INT,
  unit_id INT,
  amount DECIMAL(10,2),
  method VARCHAR(50),
  reference_no VARCHAR(100),
  payment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  status ENUM('Paid','Pending','Overdue') DEFAULT 'Paid'
);

CREATE TABLE IF NOT EXISTS maintenance (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tenant_id INT,
  unit_id INT,
  request_text TEXT,
  status ENUM('Pending','In Progress','Resolved') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS visitors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  visitor_name VARCHAR(150),
  tenant_id INT,
  unit_id INT,
  purpose VARCHAR(255),
  visit_date DATE,
  check_in TIME,
  check_out TIME
);

CREATE TABLE IF NOT EXISTS announcements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  message TEXT,
  is_important TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS activity_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  action VARCHAR(255),
  log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- sample data (units, tenants, contracts, payments, maintenance, visitors, announcements)

INSERT INTO units (unit_number, status) VALUES
('101','occupied'),
('102','vacant'),
('103','occupied');

INSERT INTO tenants (full_name, email, phone, address, age, occupation, unit_id) VALUES
('Juan Dela Cruz','juan@example.com','09171234567','Manila',28,'IT Support',1),
('Maria Santos','maria@example.com','09219876543','Quezon City',35,'Teacher',3);

UPDATE units SET tenant_id = 1 WHERE id = 1;
UPDATE units SET tenant_id = 2 WHERE id = 3;

INSERT INTO contracts (tenant_id, unit_id, start_date, end_date, rent) VALUES
(1,1,'2025-09-01',NULL,5000.00),
(2,3,'2025-07-01',NULL,6000.00);

INSERT INTO payments (tenant_id, unit_id, amount, method, reference_no, payment_date, status) VALUES
(1,1,5000.00,'Cash','RCPT-1001','2025-09-01 10:00:00','Paid'),
(2,3,6000.00,'Bank Transfer','TRX-2002','2025-09-05 14:30:00','Pending');

INSERT INTO maintenance (tenant_id, unit_id, request_text, status) VALUES
(2,3,'Leaking faucet in kitchen','Pending'),
(1,1,'Aircon not cooling','Resolved');

INSERT INTO visitors (visitor_name, tenant_id, unit_id, purpose, visit_date, check_in) VALUES
('Pedro Reyes',1,1,'Delivery','2025-09-08','09:30:00');

INSERT INTO announcements (title, message, is_important) VALUES
('Water interruption on Sept 10','Please conserve water. There will be scheduled maintenance.',1),
('Fire drill scheduled on Sept 20','Please participate in the fire drill at 10AM.',0);

INSERT INTO activity_log (user_id, action) VALUES
(NULL,'System initialized with sample data');
