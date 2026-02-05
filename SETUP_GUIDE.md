# Local Setup Guide - Car Rental Application

## Prerequisites

You need a local web server with PHP and MySQL. The easiest option is **XAMPP**.

### Option 1: Using XAMPP (Recommended)

#### Step 1: Install XAMPP
1. Download XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Install it (default location: `C:\xampp` on Windows)
3. During installation, make sure to install **Apache** and **MySQL** components

#### Step 2: Start XAMPP Services
1. Open **XAMPP Control Panel**
2. Click **Start** next to **Apache**
3. Click **Start** next to **MySQL**
4. Both should show green "Running" status

#### Step 3: Set Up the Database
1. Open your browser and go to: **http://localhost/phpmyadmin**
2. Click on the **Import** tab at the top
3. Click **Choose File** button
4. Navigate to your project folder: `D:\Installed Softwares\htdocs\carrental\sql\init_cars.sql`
5. Select the `init_cars.sql` file
6. Click **Go** at the bottom
7. You should see a success message and the `car_rental` database will be created with sample data

#### Step 4: Verify Project Location
Your project is already in: `D:\Installed Softwares\htdocs\carrental`

**Note:** If your XAMPP `htdocs` folder is in a different location (like `C:\xampp\htdocs`), you have two options:
- **Option A:** Copy your project folder to `C:\xampp\htdocs\carrental`
- **Option B:** Configure XAMPP to use your current location (more advanced)

#### Step 5: Access the Application
1. Open your web browser
2. Go to: **http://localhost/carrental/index.html**
   - If you copied to `C:\xampp\htdocs`, use: **http://localhost/carrental/index.html**
   - If your htdocs is at `D:\Installed Softwares\htdocs`, you may need to configure Apache's DocumentRoot

#### Step 6: Test the Application

**Client Login:**
- Username: `client1`
- Password: `clientpass`
- User Type: Select "Client"

**Admin Login:**
- Username: `admin1`
- Password: `adminpass`
- User Type: Select "Admin"

---

### Option 2: Using WAMP (Windows Alternative)

1. Download and install WAMP from [https://www.wampserver.com/](https://www.wampserver.com/)
2. Start WAMP services
3. Access phpMyAdmin at: http://localhost/phpmyadmin
4. Import the `sql/init_cars.sql` file
5. Place your project in `C:\wamp64\www\carrental`
6. Access at: http://localhost/carrental/index.html

---

### Option 3: Using Laragon (Windows Alternative)

1. Download and install Laragon from [https://laragon.org/](https://laragon.org/)
2. Start Laragon
3. Access phpMyAdmin at: http://localhost/phpmyadmin
4. Import the `sql/init_cars.sql` file
5. Place your project in `C:\laragon\www\carrental`
6. Access at: http://localhost/carrental/index.html

---

## Troubleshooting

### Issue: "Connection failed" error
**Solution:** 
- Make sure MySQL is running in XAMPP Control Panel
- Check that the database `car_rental` exists (go to phpMyAdmin and verify)
- Verify database credentials in `php/db.php` match your MySQL setup

### Issue: Page not found (404)
**Solution:**
- Verify Apache is running
- Check the URL path matches your folder name
- Ensure files are in the correct `htdocs` directory

### Issue: Images not displaying
**Solution:**
- Check that the `images/` folder exists and contains the car images
- Verify file permissions allow reading

### Issue: Can't upload images when adding cars
**Solution:**
- Check that the `images/` folder has write permissions
- On Windows, right-click the folder → Properties → Security → Edit → Allow "Write" for your user

### Issue: Database credentials don't match
**Solution:**
- If your MySQL has a password, edit `php/db.php`:
  ```php
  $password = 'your_mysql_password';
  ```
- If your MySQL uses a different username, update:
  ```php
  $user = 'your_mysql_username';
  ```

---

## Quick Test Checklist

After setup, test these features:

**As Client:**
- [ ] Login successfully
- [ ] View available cars
- [ ] Click on a car row to see details
- [ ] Rent a car
- [ ] View rented cars section
- [ ] Release a car
- [ ] View rental history

**As Admin:**
- [ ] Login successfully
- [ ] View available cars
- [ ] View rented cars (with renter names)
- [ ] Click "Add a car" button
- [ ] Fill and submit the add car form
- [ ] Remove a car from available list

---

## Default Database Configuration

The application uses these default settings (in `php/db.php`):
- Host: `localhost`
- Username: `root`
- Password: `` (empty)
- Database: `car_rental`

If your MySQL setup is different, update `php/db.php` accordingly.

---

## Next Steps

Once everything is running:
1. Test all features as both client and admin
2. Try adding new cars with images
3. Test the rental workflow
4. Check the rental history functionality

Enjoy testing your Car Rental application! 🚗
