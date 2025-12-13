<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


---


# Laravel E-Commerce API

A RESTful **E-Commerce API** built with **Laravel**, designed to handle core online store functionalities such as products, categories, users, and orders.  
This project serves as a backend API that can be consumed by web or mobile applications.

---

## 📑 Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Installation](#installation)
- [Environment Configuration](#environment-configuration)
- [Database](#database)
- [API Documentation](#api-documentation)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Testing](#testing)
- [Troubleshooting](#troubleshooting)
- [Contributors](#contributors)
- [License](#license)

---

## 📘 Introduction

This Laravel E-Commerce API provides backend functionality for an online store.  
It exposes RESTful endpoints to manage users, products, categories, and orders, making it suitable for frontend frameworks such as Vue, React, Angular, or mobile apps.

---

## ✨ Features

- User authentication
- Product management (CRUD)
- Category management
- Order processing
- RESTful API endpoints
- Database schema included
- Postman collection for API testing

---

## 🛠 Technology Stack

- **PHP** (Laravel Framework)
- **MySQL** (or compatible relational database)
- **Composer** (Dependency Manager)
- **Postman** (API Testing)

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/Aking16/laravel-ecommerce-api.git
cd laravel-ecommerce-api
```

### 2. Install dependencies

```bash
composer install
```

### 3. Copy environment file

```bash
cp .env.example .env
```

### 4. Generate application key

```bash
php artisan key:generate
```

---

## ⚙️ Environment Configuration

Edit the `.env` file and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_ecommerce
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🗄 Database

Run migrations to create database tables:

```bash
php artisan migrate
```

A visual database schema is provided in the project:

```
db-schema.png
```

---

## 📬 API Documentation

A Postman collection is included for testing all available endpoints:

```
postman_collection.json
```

### Import Steps:

1. Open Postman
2. Click **Import**
3. Select `postman_collection.json`
4. Configure your base URL (e.g. `http://127.0.0.1:8000/api`)

---

## ▶️ Usage

Start the Laravel development server:

```bash
php artisan serve
```

API will be available at:

```
http://127.0.0.1:8000/api
```

---

## 📁 Project Structure

```
laravel-ecommerce-api/
├── app/              # Application logic
├── database/         # Migrations & seeders
├── routes/           # API routes
├── public/           # Public assets
├── postman_collection.json
├── db-schema.png
└── README.md
```

---

## 🧪 Testing

If tests are included, you can run them using:

```bash
php artisan test
```

---

## 🛠 Troubleshooting

* Ensure **Composer** is installed and up to date
* Verify database credentials in `.env`
* Run `php artisan config:clear` if environment changes aren’t reflected
* Make sure required PHP extensions are enabled

---

## 👥 Contributors

* **Aking16** – Project Author

Contributions are welcome. Feel free to fork the repository and submit a pull request.

---

## 📄 License

This project is open-source and available under the **MIT License**.

---

## ⭐ Support

If you find this project useful, please consider giving it a ⭐ on GitHub.

```

