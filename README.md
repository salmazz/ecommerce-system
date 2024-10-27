# **E-Commerce System API Documentation**

## **Table of Contents**
1. [Introduction](#introduction)
2. [Project Structure](#project-structure)
3. [Features](#features)
4. [Setup Instructions](#setup-instructions)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
    - [Configuration](#configuration)
    - [Database Setup](#database-setup)
5. [Routes](#routes)
    - [User and Admin Routes](#user-and-admin-routes)
6. [Middleware](#middleware)
7. [Database Seeders and Factories](#database-seeders-and-factories)
8. [API Endpoints](#api-endpoints)
    - [Authentication](#authentication)
    - [Categories](#categories)
    - [Products](#products)
    - [Orders](#orders)
9. [Postman Collection](#postman-collection)
10. [Testing](#testing)
11. [Caching](#caching)
12. [Contact Information](#contact-information)

---

## **Introduction**
This project is a simplified e-commerce system built using Laravel 8 that provides a RESTful API to manage products, categories, and orders. The system is designed with robust authentication, validation, and error handling mechanisms to ensure the secure and accurate processing of orders.

## **Project Structure**
Below is a brief description of the major components in the project:

```
/app
    /Http
        /Controllers          # API Controllers
        /Requests             # Form request validations
        /Middleware           # Middleware for access control
    /Models                   # Eloquent Models
    /Services                 # Business logic services
    /Repositories             # Data handling repositories
    /Enums                    # Enums for constants (like OrderStatusEnum)
    /Common
        /Helpers              # Helper functions like Response, JsonResponseHelper

/routes
    /api.php                  # API routes configuration

/tests
    /Feature                  # Feature tests for API endpoints
```

## **Features**
- **Authentication** using Laravel Sanctum.
- **User and Admin roles** for access control.
- **Product & Category Management**
- **Order Management** (placing orders, checking product availability, etc.).
- **Search and Pagination** for products.
- **Caching** of frequently accessed data (products) for performance optimization.
- **Error Handling** with clear and structured error messages.
- **Unit and Feature Testing** to ensure code reliability.

## **Setup Instructions**

### **Prerequisites**
Ensure you have the following installed:
- PHP >= 8.0
- Composer
- MySQL (or any other database supported by Laravel)
- Laravel 11+
- Node.js & npm (optional, for frontend assets)
- Postman (for API testing)

### **Installation**
1. Clone the repository:
   ```bash
   git clone https://github.com/salmazz/ecommerce-system.git
   cd ecommerce-system
   ```

2. Install the dependencies using Composer:
   ```bash
   composer install
   ```

3. Install frontend dependencies (optional):
   ```bash
   npm install && npm run dev
   ```

### **Configuration**
1. Copy the `.env.example` file to create your own configuration:
   ```bash
   cp .env.example .env
   ```

2. Generate the application key:
   ```bash
   php artisan key:generate
   ```

3. Set up the environment variables in the `.env` file (database, caching, etc.).

### **Database Setup**
1. Create a database for the project in your MySQL server.
2. Set up the database configuration in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

3. Run the migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```

4. (Optional) Run the factories if needed:
   ```bash
   php artisan db:seed
   ```

## **Routes**

### **User and Admin Routes**
The API is structured to handle different types of users with specific routes:
- **Admin Routes**:
    - Require the `auth:sanctum` and `admin` middleware.
    - Admins can create, update, and delete products.
    - Example Route: `POST /api/products`.

- **User Routes**:
    - Require the `auth:sanctum` middleware.
    - Users can manage their orders and view product listings.
    - Example Route: `POST /api/orders`.

### **Route Middleware**
- **`auth:sanctum`**: Used for authenticating users.
- **`admin`**: Middleware that restricts access to certain routes for admin users only.

### **Seeders and Factories**

#### **User credential**
The database is seeded with both an admin and a regular user for testing purposes:

```php
Admin credential 
            'email' => 'admin@example.com',
            'password' => 'secret'
    
User credential     
            'email' => 'user@example.com',
            'password' => 'secret'
```

### **Factories**
The system utilizes factories to create dummy data for users, products, and categories, which helps in testing and development.

## **API Endpoints**

### **Authentication**
- **POST /api/login**: Login a user.
- **POST /api/register**: Register a new user.
- **POST /api/logout**: Logout the current user.
- **GET /api/user**: Get the current authenticated user.

### **Categories**
- **GET /api/categories**: Retrieve a list of all categories.

### **Products**
- **GET /api/products**: Retrieve a list of products with search and pagination support.
    - **Query Parameters**: `?search=keyword&min_price=value&max_price=value&per_page=value`
- **POST /api/products**: Create a new product (Admin Only).
- **PUT /api/products/{id}**: Update an existing product (Admin Only).
- **DELETE /api/products/{id}**: Delete a product (Admin Only).

### **Orders**
- **GET /api/orders**: Retrieve a list of orders for the authenticated user.
- **GET /api/orders/{id}**: Retrieve details of a specific order (Authenticated User Only).
- **POST /api/orders**: Place a new order.

## **Postman Collection**
A **Postman Collection** is provided to facilitate API testing. You can import this collection in Postman to quickly access all API routes:

1. Download the collection file: [Postman Collection JSON](ecommerce.postman_collection.json)
2. Open **Postman** and go to **File** → **Import**.
3. Choose the downloaded JSON file to import the collection.
4. The collection includes:
    - Authentication routes
    - Category Route
    - Product and category management routes
    - Order management routes

## **Testing**
This project includes both **Unit Tests** and **Feature Tests** to ensure the functionality of each module.

1. To run the tests:
   ```bash
   php artisan test
   ```


## **Caching**
Caching is implemented using Laravel's caching system to improve the performance of data retrieval for the products.

### **Caching Implementation**
- Products are cached when retrieved using search and pagination criteria.
- The cache is invalidated whenever a product is updated or deleted.

### **Commands to Clear Cache**
- To clear the product cache manually:
  ```bash
  php artisan cache:clear
  ```

## **Contact Information**
For any inquiries or issues, feel free to contact:
- **Name**: Salma Mehanny
- **Email**: salmamehanny@gmail.com
- **GitHub**: [salmazz](https://github.com/salmazz)

---

Let me know if you need further adjustments or if there are additional details to include! 😊
