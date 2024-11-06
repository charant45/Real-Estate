# Real Estate Project

## Table of Contents

1. [Project Overview](#project-overview)
2. [Features](#features)
3. [File Structure](#file-structure)
4. [Setup and Installation](#setup-and-installation)
5. [Database Configuration](#database-configuration)
6. [Usage](#usage)
7. [Contributing](#contributing)
8. [License](#license)

## Project Overview

This project is a web-based real estate listing application built with PHP, MySQL, and Tailwind CSS. It allows users to view property listings, see detailed information about each property, and simulate a purchase process with a discount option.

## Features

- Display a grid of property listings
- View detailed information for each property
- Simulated purchase process with a discount
- Responsive design using Tailwind CSS
- Database-driven content
- User authentication (to be implemented)

## File Structure 
<pre>
real-estate-project/ 
│
├── index.php              # Main entry point of the application
├── database.php           # Database connection and query functions
├── auth.php               # Authentication functions (to be implemented)
├── header.php             # Common header for all pages
├── footer.php             # Common footer for all pages
├── README.md              # This file
│
├── login.php              # User login page
├── register.php           # User registration page
├── profile.php            # User profile page
└── add_listing.php        # Page for adding new property listings   
</pre>

## Setup and Installation
<pre>
1. Clone the repository or download the project files to your local machine.
2. Ensure you have PHP (7.4+) and MySQL installed on your system.
3. Set up a web server (e.g., Apache) to serve the PHP files.
4. Create a new MySQL database for the project (see [Database Configuration](#database-configuration)).
5. Update the database connection details in database.php.
6. Place the project files in your web server's document root or set up a virtual host.
</pre>  

## Database Configuration
<pre>
1. Create a new MySQL database named real_estate.
2. Import the following SQL schema to create the necessary tables:

CREATE TABLE listings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    location VARCHAR(255) NOT NULL,
    bedrooms INT NOT NULL,
    bathrooms INT NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add more tables as needed (e.g., users, payments)

3.Update the database connection details in database.php:
$db_host = 'localhost';
$db_name = 'real_estate';
$db_user = 'your_username';
$db_pass = 'your_password';
</pre>
##Usage

1.Navigate to the project URL in your web browser.<br/>
2.Browse the list of property listings on the main page.<br/>
3.Click "View Details" to see more information about a specific property.<br/>
4.Click "Buy with Discount" to simulate a purchase process with a 10% discount.<br/>

##Contributing

1.Fork the repository<br/>
2.Create your feature branch (git checkout -b feature/AmazingFeature)<br/>
3.Commit your changes (git commit -m 'Add some AmazingFeature')<br/>
4.Push to the branch (git push origin feature/AmazingFeature)<br/>
5.Open a Pull Request

##License

This project is licensed under the MIT License - see the LICENSE.md file for details.


### Instructions to Use

1. Create a new file named `README.md` in the root directory of your project.<br/>
2. Copy and paste the content provided above into this file.<br/>
3. Modify any details, such as database credentials or additional features, to match your project's specifics.<br/>
4. If you haven’t already, consider adding a `LICENSE.md` file to your project with the appropriate license text.

This README will effectively communicate the purpose and structure of your project to other developers or users. 

## Screenshots

Here are some screenshots of the application in action:

### Login Page
![Login Page](https://res.cloudinary.com/dhja9jrwn/image/upload/v1730899029/php-project/Screenshot_200_lcjp98.png)

### Register Page
![Register Page](https://res.cloudinary.com/dhja9jrwn/image/upload/v1730899285/php-project/Screenshot_201_p3hdxo.png)

### Home Page
![Home Page](https://res.cloudinary.com/dhja9jrwn/image/upload/v1730899029/php-project/Screenshot_202_phnoy5.png)

![Home Page](https://res.cloudinary.com/dhja9jrwn/image/upload/v1730899031/php-project/Screenshot_207_m4mbmf.png)

### Listing Page
![Listing](https://res.cloudinary.com/dhja9jrwn/image/upload/v1730899029/php-project/Screenshot_208_iv7qdl.png)

### Profile Page
![Profile Page](https://res.cloudinary.com/dhja9jrwn/image/upload/v1730899029/php-project/Screenshot_206_zxwhxx.png)
