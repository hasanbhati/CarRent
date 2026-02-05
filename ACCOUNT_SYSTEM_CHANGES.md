# User Account Management System - Changes Made

## Overview
The application now has a complete user account management system where users can create accounts using their email address and password.

## What Changed

### 1. Database Changes
- **New Table: `users`**
  - Stores user email, password, and account type (client/admin)
  - Default admin account: `admin1@carrental.com` / `adminpass`

- **Updated Table: `cars`**
  - `rented_by` field changed from VARCHAR(50) to VARCHAR(100) to support email addresses

### 2. Login Page (index.html)
- Changed from "Username" to "Email" field
- Removed "Login as" dropdown (user type is determined from database)
- Added "Sign Up" button that shows a registration form
- Added toggle between login and signup forms
- Added error/success message display

### 3. New Files Created
- **php/signup.php** - Handles new user registration
  - Checks if email already exists
  - Creates new user account in database
  - Redirects with success/error messages

### 4. Updated Files

#### php/login.php
- Now checks email and password against database
- Removed hardcoded user credentials
- Determines user type from database
- Uses email in session

#### client_dashboard.php
- Uses `$_SESSION['email']` instead of `$_SESSION['username']`
- All queries updated to use email

#### admin_dashboard.php
- Uses `$_SESSION['email']` instead of `$_SESSION['username']`

#### php/car_actions.php
- All actions now use email from session
- Rental history stores email addresses

#### php/add_car.php & php/add_car_form.php
- Updated to check for email in session

## How to Use

### For New Users:
1. Go to the login page
2. Click "Don't have an account? Sign Up"
3. Enter your email address
4. Enter a password
5. Select account type (Client or Admin)
6. Click "Create Account"
7. You'll be redirected to login page with success message
8. Login with your new email and password

### For Existing Users:
1. Go to the login page
2. Enter your email address
3. Enter your password
4. Click "Login"

### Default Admin Account:
- Email: `admin1@carrental.com`
- Password: `adminpass`

## Database Setup

**Important:** You need to update your database!

1. Go to phpMyAdmin (http://localhost/phpmyadmin)
2. Select the `car_rental` database
3. Run this SQL to create the users table:

```sql
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    usertype ENUM('client', 'admin') DEFAULT 'client',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Update cars table to support longer emails
ALTER TABLE cars MODIFY rented_by VARCHAR(100);

-- Insert default admin user
INSERT INTO users (email, password, usertype) VALUES
('admin1@carrental.com', 'adminpass', 'admin');
```

**OR** you can re-import the updated `sql/init_cars.sql` file which includes all these changes.

## Notes
- Passwords are stored in plain text (beginner level - can be improved later)
- Email addresses must be unique
- User type determines which dashboard they see after login
- All rental history now tracks email addresses instead of usernames
