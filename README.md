# BRS-FYPproject

A web-based Barbershop Reservation System (BRS) designed to streamline appointment bookings, manage barbers and services, and provide dashboards for both customers and administrators.

## ABOUT US 
### Group Members:
1. ADAM HARITH BIN JUMAIN (2023602132)
2. AMIR HAFIZ BIN AHMAD ZAIDI (2023681786)
3. IRSYADUDDIN BIN YUSUF (2023693182)
4. MUHAMMAD ALIF NAJIMI BIN AZMAN (2023830238)

# Website build by:
Adam Harith bin Jumain

## Features

- **Customer Booking:** Book appointments online, view available services, and manage your bookings.
- **Admin Dashboard:** Manage barbers, services, appointments, and users.
- **Customer Dashboard:** View and manage your bookings, profile, and notifications.
- **Contact Form:** Customers can reach out for inquiries or support.
- **Authentication:** Secure login and signup for customers and admins.

## Project Structure

```
website/
  ├── admin/                  # Admin dashboard and management pages
  ├── customer_dashboard/     # Customer dashboard and related pages
  ├── config/                 # Database configuration
  ├── images/                 # Image assets
  ├── includes/               # Shared includes (e.g., header)
  ├── index.php               # Landing page
  ├── login.php               # Login page
  ├── signup.php              # Signup page
  ├── booking.php             # Booking form
  ├── process_booking.php     # Booking processing logic
  ├── contact.php             # Contact form
  ├── process_contact.php     # Contact form processing
  ├── services.php            # List of services
  ├── barbers.php             # List of barbers
  ├── styles.css              # Main stylesheet
  └── README.md               # Project documentation
```

## Project Files Location

All required files for this project are available in the following Google Drive folder:

**Group G/Barber Reservation System/**

- `Final Report` – Project documentation
- `website/` – Source code (unzip and place in XAMPP htdocs)
- `.sql` files – Database exports for setup (`service.sql`, `barber.sql`, `booking.sql`, `customer.sql`, `admin.sql`)

Please download the entire folder and follow the setup instructions below.

## Setup Instructions

Follow these steps after downloading and unzipping the project folder from Google Drive:

### 1. Move the Project Folder
- Copy the unzipped `website` folder into your XAMPP `htdocs` directory (usually `C:/xampp/htdocs/`).

### 2. Start XAMPP Services
- Open the XAMPP Control Panel.
- Start **Apache** and **MySQL** modules.

### 3. Import the Database
1. Open your browser and go to [phpMyAdmin](http://localhost/phpmyadmin).
2. Click **New** to create a new database (e.g., `barbershop`).
3. With the new database selected, click the **Import** tab.
4. Click **Choose File** and select the `database.sql` file included in the project folder.
5. Click **Go** to import the database structure and data.

### 4. Configure Database Connection
- Open `config/db.php` in a text editor.
- Update the database name, username, and password to match your local XAMPP setup:

```php
// config/db.php
$host = 'localhost';
$db   = 'barbershop'; // Use the name you created in phpMyAdmin
$user = 'root';       // Default XAMPP username
$pass = '';           // Default XAMPP password is empty
```

### 5. Access the Application
- In your browser, go to [http://localhost/website/](http://localhost/website/) to use the Barbershop Reservation System.

---

## Database Setup

This project uses multiple databases. Each database has its own `.sql` file included in the project folder.

### Databases

| Database Name | SQL File      | Description                |
|---------------|--------------|----------------------------|
| service       | service.sql  | Services information       |
| barber        | barber.sql   | Barbers information        |
| booking       | booking.sql  | Booking records            |
| customer      | customer.sql | Customer information       |
| admin         | admin.sql    | Admin user information     |

### Importing the Databases

For each database:

1. Open [phpMyAdmin](http://localhost/phpmyadmin).
2. Click **New** and create a database with the name shown above (e.g., `service`).
3. With the new database selected, click the **Import** tab.
4. Click **Choose File** and select the corresponding `.sql` file (e.g., `service.sql`).
5. Click **Go** to import.
6. Repeat for each database (`barber`, `booking`, `customer`, `admin`).

### Configure Database Connections

- Open `config/db.php` (or the relevant config file).
- Update the database name, username, and password for each connection as needed. If your project uses multiple connections, ensure each one points to the correct database.

```php
// Example for connecting to the 'service' database
$host = 'localhost';
$db   = 'service'; // Change to 'barber', 'booking', 'customer', or 'admin' as needed
$user = 'root';
$pass = '';
```

---


