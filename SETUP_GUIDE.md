# Car Rental Application - Complete Setup Guide

This guide will help you set up the Car Rental application on your local machine. The application requires a web server (Apache), PHP, and MySQL.

## Quick Start (XAMPP Recommended)

### Prerequisites

You need a local web server with PHP and MySQL. The easiest option is **XAMPP**.

### Step 1: Install XAMPP

1. Download XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Install it on your computer (default location: `C:\xampp` on Windows)
3. During installation, ensure **Apache** and **MySQL** are selected

### Step 2: Start Services

1. Open **XAMPP Control Panel**
2. Click **Start** next to **Apache** and **MySQL**
3. Wait for both to show green "Running" status

### Step 3: Set Up Database

1. Open your browser to: **http://localhost/phpmyadmin**
2. Click the **Import** tab
3. Click **Choose File** and select: `sql/init_cars.sql` from your project folder
4. Click **Go** to import
5. The `car_rental` database will be created with all tables and sample data

**Note:** The database includes activation columns (`is_activated`, `activation_token_hash`, `activation_expires_at`) required for the email activation system.

### Step 4: Place Project in XAMPP Directory

Copy your project folder to XAMPP's web directory:
- Windows: `C:\xampp\htdocs\CarRent`
- macOS: `/Applications/XAMPP/htdocs/CarRent`
- Linux: `/opt/xampp/htdocs/CarRent`

### Step 5: Access the Application

Open your browser to: **http://localhost/CarRent/index.html**

---

## Email Activation System (Important!)

The application uses **email-based account activation**. When a user signs up, they receive an activation email with a link. Accounts remain inactive until the user clicks the activation link.

### PHPMailer Setup (Required for Email Activation)

Email sending is handled by PHPMailer using Brevo SMTP. PHPMailer files must be in the `src/` folder at your project root.

#### PHPMailer Installation

PHPMailer files should be located at:
```
CarRent/
  src/
    PHPMailer.php
    SMTP.php
    Exception.php
    OAuth.php
    POP3.php
    DSNConfigurator.php
    OAuthTokenProvider.php
```

**If you don't have these files, follow one of these methods:**

#### Method 1: Download PHPMailer Manually (Recommended)

1. Visit: https://github.com/PHPMailer/PHPMailer/releases
2. Download the latest release (e.g., PHPMailer-6.9.1.zip)
3. Extract the ZIP file
4. Copy the `src/` folder contents to your project's `src/` folder
5. Verify files are at: `CarRent/src/PHPMailer.php`, `CarRent/src/SMTP.php`, etc.

#### Method 2: Using Composer

1. Install Composer: https://getcomposer.org/download/
2. From your project root, run:
   ```bash
   composer require phpmailer/phpmailer
   ```
3. Composer creates a `vendor/` folder with PHPMailer
4. Copy from `vendor/phpmailer/phpmailer/src/` to `CarRent/src/`

#### Configure Brevo Credentials

Edit `php/mailer.php` and update the SMTP credentials (around line 15-20):

```php
$mail->Username = 'your_brevo_email@example.com';
$mail->Password = 'your_brevo_api_key';
```

**Get your Brevo credentials:**
1. Sign up/login at: https://www.brevo.com/
2. Go to SMTP & API section and create/copy your API key
3. Replace in `php/mailer.php`

**Important:** Ensure PHP's `openssl` extension is enabled for TLS connections.

---

## First Login

### Account (Pre-configured)

Email: `admin1@carrental.com`  
Password: `adminpass`

Email: client@carrental.com
Password: abcd1234

These account is pre-activated and ready to use immediately.

### Creating Client Accounts

1. Click **Sign Up** on the login page
2. Enter your email and password
3. Click **Sign Up**
4. Check your email (including spam/promotions folder) for activation link
5. Click the activation link in the email
6. Return to login page and log in with your email and password
7. You now have access to the client dashboard

**Note:** Accounts remain inactive until the email link is clicked. Attempting to log in before activation shows: "Account not activated. Please check your email."

---

## Alternative Setup Methods

### Using WAMP (Windows)

1. Download from: https://www.wampserver.com/
2. Install and start WAMP
3. Place project in: `C:\wamp64\www\CarRent`
4. Import SQL via: http://localhost/phpmyadmin
5. Access at: http://localhost/CarRent/index.html

### Using Laragon (Windows)

1. Download from: https://laragon.org/
2. Install and start Laragon
3. Place project in: `C:\laragon\www\CarRent`
4. Import SQL via: http://localhost/phpmyadmin
5. Access at: http://localhost/CarRent/index.html

### Using Docker (Advanced)

For Docker setup, refer to Docker documentation for creating a PHP 7.4+ container with MySQL 5.7+ and mounting your project directory.

---

## Troubleshooting

### Database Connection Error

**Error:** "Connection failed" or database-related errors

**Solution:**
- Verify MySQL is running in XAMPP Control Panel
- Check `php/db.php` for correct credentials:
  ```php
  $host = 'localhost';
  $user = 'root';
  $password = '';
  $database = 'car_rental';
  ```
- Verify the `car_rental` database exists in phpMyAdmin
- If you set a MySQL password, update `php/db.php` to include it

### Activation Email Not Received

**Error:** Sign up succeeds but no email arrives

**Solution:**
1. Check spam/promotions folder in your email
2. Mark as "Not Spam" to improve delivery
3. Verify Brevo credentials in `php/mailer.php` are correct
4. Verify `php/mailer.php` can find PHPMailer files (should be at `CarRent/src/`)
5. Check Apache error log: `xampp/apache/logs/error.log` for PHP errors
6. Ensure OpenSSL extension is enabled in PHP
7. Enable debug logging by adding to top of `php/mailer.php`:
   ```php
   error_log("Email debug: attempting to send to " . $to);
   ```

### Login Shows "Account Not Activated" Error

**Error:** "Account not activated. Please check your email."

**Solution:**
- You haven't clicked the activation link in the email yet
- Find the email, check spam folder, and click the activation link
- After clicking, try logging in again with your email and password

### Cannot Rent Cars

**Error:** "Action failed" message or can't rent cars

**Solution:**
- Verify your account is activated (check activation email and click link)
- Verify you're logged in to the correct account
- Check that you have a valid client account (not admin)

### Cannot Add Cars as Admin

**Error:** "Action failed" message when trying to add/rent cars

**Solution:**
- Verify you're logged in as admin (`admin1@carrental.com`)
- Check that the `images/` folder is writable:
  - Windows: Right-click folder → Properties → Security → Edit → Allow "Write"
  - Linux/Mac: Run `chmod 755 images/`
- Check Apache error log for specific error messages

### Page Shows "Not Found" (404)

**Error:** Site displays 404 error

**Solution:**
- Verify Apache is running (XAMPP Control Panel shows green)
- Check URL path matches your folder name: `http://localhost/CarRent/`
- Verify project is in correct htdocs location
- Restart Apache

### Images Not Displaying

**Error:** Car images show as broken image icons

**Solution:**
- Verify `images/` folder exists in project root
- Check image files have correct names (lowercase .jpg/.png)
- Check image folder permissions are readable
- Verify relative paths in code point to `images/` folder

### CSS or JavaScript Not Loading

**Error:** Page displays but looks broken or isn't interactive

**Solution:**
- Open browser Developer Tools (F12) → Console tab
- Check for 404 errors for CSS/JS files
- Verify `css/` and `js/` folders exist with files
- Restart browser (Ctrl+Shift+R to hard refresh)

### Cannot Create Account with Valid Email

**Error:** Signup fails with error message

**Solution:**
- Check that your email format is correct (name@domain.com)
- Verify password meets requirements (if any)
- Check database `users` table isn't full or corrupted
- Check Apache error log for database errors

---

## Database Configuration

The application uses these default settings (in `php/db.php`):
- Host: `localhost`
- Username: `root`
- Password: `` (empty)
- Database: `car_rental`

If your MySQL setup is different, update `php/db.php` accordingly.

---

## Quick Test Checklist

After successful setup:

### Signup & Activation Flow
- [ ] Click Sign Up, enter email and password
- [ ] Get success message: "Account created. Check your email..."
- [ ] Find email in inbox or spam folder
- [ ] Click activation link in email
- [ ] See success message: "Account activated! You can now log in."
- [ ] Log in with your email and password

### Client Dashboard
- [ ] Login as client (recently activated account)
- [ ] See "Available Cars" with list
- [ ] Click car row to expand details
- [ ] Click "Rent" button on a car
- [ ] See the car move to "Your Rentals" section
- [ ] Click "Release" to return the car
- [ ] Check "Rental History" shows past rentals

### Admin Dashboard
- [ ] Login as admin: `admin1@carrental.com` / `adminpass`
- [ ] See "Available Cars" list
- [ ] See "Rented Cars" with renter names
- [ ] Click "Add a Car" button
- [ ] Fill form: name, daily rate, upload image
- [ ] Submit form
- [ ] New car appears in Available Cars list
- [ ] Click remove button (X) to delete a car

### Account & Settings
- [ ] Click "Account" → "Edit Profile"
- [ ] Update your name or password
- [ ] See "Delete Account" option (requires re-login)

---

## SQL Commands Reference

All database tables are created automatically when you import `sql/init_cars.sql`. However, if you need to manually add activation columns to an existing users table, run this in phpMyAdmin:

```sql
ALTER TABLE users
  ADD COLUMN is_activated TINYINT(1) NOT NULL DEFAULT 0,
  ADD COLUMN activation_token_hash VARCHAR(255) DEFAULT NULL,
  ADD COLUMN activation_expires_at DATETIME DEFAULT NULL;

UPDATE users SET is_activated = 1 WHERE email = 'admin1@carrental.com';
```

---

## More Information

- [README.md](README.md) - Project overview
- [ACCOUNT_MANAGEMENT_CHANGES.md](ACCOUNT_MANAGEMENT_CHANGES.md) - Account features
- [ACCOUNT_SYSTEM_CHANGES.md](ACCOUNT_SYSTEM_CHANGES.md) - System changes log

---

## Support

If you encounter issues:

1. **Check the Troubleshooting section** above
2. **Review Apache error logs:** `xampp/apache/logs/error.log`
3. **Enable PHP errors:** Add to `php/db.php` for debugging:
   ```php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```
4. **Check browser console:** Open DevTools (F12) → Console tab

---

Setup complete! Enjoy using the Car Rental application.
