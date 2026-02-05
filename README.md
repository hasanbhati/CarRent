# Car Rental Project

## Project Structure
- `index.html` – Login page
- `client_dashboard.php` – Client dashboard
- `admin_dashboard.php` – Admin dashboard
- `css/` – Stylesheets
- `js/` – JavaScript files
- `images/` – Car images
- `php/` – PHP backend scripts
- `sql/` – SQL scripts for database setup

## XAMPP Setup Instructions

Follow these steps to set up and run the Car Rental project locally using XAMPP:

### 1. Install XAMPP
- Download XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
- Install it on your computer (Windows, Mac, or Linux)

### 2. Start Apache and MySQL
- Open the XAMPP Control Panel
- Click **Start** next to **Apache** and **MySQL**

### 3. Set Up the Database
- Open your browser and go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
- Click the **Import** tab at the top
- Click **Choose File** and select the `sql/init_cars.sql` file from your project folder
- Click **Go** to import. This will create the `car_rental` database and fill it with sample car data

### 4. Place Project Files in XAMPP’s Web Directory
- Find your XAMPP installation directory (e.g., `C:/xampp` on Windows or `/Applications/XAMPP` on Mac)
- Open the `htdocs` folder inside XAMPP
- Copy your entire project folder (e.g., `CarRental`) into the `htdocs` folder
- Make sure the folder structure is preserved

### 5. Access the Website
- In your browser, go to: [http://localhost/CarRental/index.html](http://localhost/CarRental/index.html)
- You should see the login page

### 6. Login and Test
- **Client login:**
  - Username: `client1`
  - Password: `clientpass`
- **Admin login:**
  - Username: `admin1`
  - Password: `adminpass`
- Try renting, releasing, adding, and removing cars to see all features in action

---

## How to Use
- **Clients** can rent, release, and view cars
- **Admins** can add, remove, and view cars, and see who rented each car

---

If you have any issues, make sure file permissions allow uploads to the `images/` folder and that your XAMPP services are running. If you need help, open an issue or contact the project maintainer. 