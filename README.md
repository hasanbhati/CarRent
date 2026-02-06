# Car Rental Application

A beginner-friendly web application for managing car rentals with client and admin roles.

## Features

- User Registration with email-based account activation
- Email Activation system to verify new accounts
- Client Dashboard to browse, rent, and manage cars
- Admin Dashboard to add, remove, and manage cars
- Rental History tracking for all users
- Account Management for profile updates and settings

## Getting Started

Follow the **[SETUP_GUIDE.md](SETUP_GUIDE.md)** for complete installation and configuration instructions.

### Quick Start
1. Install XAMPP (or WAMP/Laragon)
2. Start Apache and MySQL services
3. Import sql/init_cars.sql via phpMyAdmin
4. Place project in XAMPP's htdocs directory
5. Access at http://localhost/CarRent/index.html

## Default Admin Account

- **Email:** admin1@carrental.com
- **Password:** adminpass

## Key Files

- index.html - Login & signup page
- client_dashboard.php - Client interface
- dmin_dashboard.php - Admin interface
- php/ - Backend scripts (authentication, database, email, etc.)
- ctivate.php - Email verification endpoint
- src/ - PHPMailer library (required for emails)
- css/ & js/ - Styling and frontend interactions

## Technology Stack

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+
- **Server:** Apache (XAMPP/WAMP/Laragon)
- **Email:** PHPMailer + Brevo SMTP

---

**For detailed setup, troubleshooting, and testing instructions, see [SETUP_GUIDE.md](SETUP_GUIDE.md).**
