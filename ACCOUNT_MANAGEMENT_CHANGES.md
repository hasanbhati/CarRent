# Account Management System - Changes Made

## Overview
Users can now edit their account details and delete their account through a dedicated account management page.

## What Changed

### 1. Database Changes
- **Updated Table: `users`**
  - Added `name` (VARCHAR(50)) - First name
  - Added `surname` (VARCHAR(50)) - Last name
  - Added `contact` (VARCHAR(20)) - Phone number
  - Added `address` (TEXT) - Physical address
  - Email and password already existed

### 2. New Files Created

#### account_details.php
- Main account management page
- Shows current user information
- Allows editing of: name, surname, contact, address, password
- Email is displayed but cannot be changed
- Includes delete account section

#### php/update_account.php
- Handles account information updates
- Updates only fields that have values
- Password is optional (only updates if new password is provided)
- Redirects with success/error messages

#### php/delete_account.php
- Handles account deletion
- Releases any cars the user has rented
- Deletes user account from database
- Destroys session and redirects to login

### 3. Updated Files

#### client_dashboard.php
- Added "My Account" button next to logout button

#### admin_dashboard.php
- Added "My Account" button next to logout button

#### css/style.css
- Added styles for account management:
  - `.account-btn` - Button to access account page
  - `.account-form` - Form styling
  - `.save-btn` - Save button styling
  - `.delete-account-section` - Delete account section
  - `.delete-account-btn` - Delete button styling

#### index.html
- Added message display for deleted accounts

## How to Use

### Editing Account Details:
1. Login to your account
2. Click "My Account" button on the dashboard
3. Fill in or update your information:
   - First Name
   - Last Name
   - Contact Number
   - Physical Address
   - Password (optional - leave blank to keep current password)
4. Click "Save Changes"
5. You'll see a success message

### Deleting Account:
1. Go to "My Account" page
2. Scroll down to "Delete Account" section
3. Click "Delete My Account" button
4. Confirm the deletion
5. Your account will be deleted and any rented cars will be released
6. You'll be redirected to the login page

## Database Setup

**Important:** You need to update your database!

Run this SQL in phpMyAdmin to add the new fields:

```sql
ALTER TABLE users 
ADD COLUMN name VARCHAR(50) DEFAULT NULL,
ADD COLUMN surname VARCHAR(50) DEFAULT NULL,
ADD COLUMN contact VARCHAR(20) DEFAULT NULL,
ADD COLUMN address TEXT DEFAULT NULL;
```

**OR** re-import the updated `sql/init_cars.sql` file which includes all changes.

## Features

### What Users Can Edit:
- ✅ First Name
- ✅ Last Name
- ✅ Contact Number
- ✅ Physical Address
- ✅ Password (optional)
- ❌ Email (cannot be changed)

### Account Deletion:
- Releases all rented cars
- Deletes user account
- Keeps rental history (for records)
- Requires confirmation before deletion

## Notes
- All fields are optional except email
- Password change is optional - leave blank to keep current password
- Email address cannot be changed (as requested)
- Account deletion is permanent and cannot be undone
- When a user deletes their account, any cars they rented are automatically released
