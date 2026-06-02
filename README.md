# ✨ EduApp - Student Data Management System

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.0-blue.svg?style=flat-square&logo=php)](https://www.php.net/)
[![Bootstrap Version](https://img.shields.io/badge/Bootstrap-5.3.8-purple.svg?style=flat-square&logo=bootstrap)](https://getbootstrap.com/)
[![Database](https://img.shields.io/badge/Database-MySQL%20%2F%20MariaDB-orange.svg?style=flat-square&logo=mysql)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

**EduApp** is a simple, web-based application designed specifically to manage student data efficiently and securely. Built using **Native PHP** with a **PDO (PHP Data Objects)** connection to ensure secure database queries, it is wrapped in a modern, responsive user interface using **Bootstrap 5.3.8**.

---

## 🚀 Key Features

- **Student Data CRUD (Create, Read, Update, Delete)**: Complete student data management integrated with photo upload capabilities.
- **Client & Server-Side Form Validation**:
  - Email format validation using PHP's `FILTER_VALIDATE_EMAIL`.
  - Allowed file formats for student photos: `JPG`, `JPEG`, and `PNG`.
  - Max photo upload file size limit of `2MB`.
  - Clean HTML5 form validation using Bootstrap 5 classes (`needs-validation`).
- **Interactive Dashboard**:
  - Responsive navigation sidebar that collapses into a hamburger menu on mobile devices.
  - At-a-glance statistics (*Total Students*, *Total Departments*, *Active Data*).
  - Dynamic alert system with dismissal triggers for success and error messages.
- **Secure File Upload System**: Employs an encrypted, randomized file renaming convention using `timestamp` and `uniqid` to prevent filename collisions on the server.
- **Secure PDO Database Management**: Protects against *SQL Injection* vulnerabilities using *Prepared Statements*.

---

## 🛠️ Tech Stack & Dependencies

- **Backend**: PHP 8.x (Native PHP)
- **Database**: MySQL / MariaDB (via PDO)
- **Frontend & UI**:
  - [Bootstrap 5.3.8 CSS & JS Bundle](https://getbootstrap.com/) (via CDN)
  - [Bootstrap Icons 1.13.1](https://icons.getbootstrap.com/) (via CDN)
- **Local Server Recommendation**: [Laragon](https://laragon.org/) / [XAMPP](https://www.apachefriends.org/)

---

## 📁 Project Directory Structure

```bash
pweb-bootstrap/
├── uploads/               # Directory where uploaded student photos are stored
├── edit-mahasiswa.php     # Edit/update student data form page
├── index.php              # Main dashboard and student data creation form page
├── koneksi.php            # PDO database connection configuration file
├── proses_mahasiswa.php   # Core business logic processing CRUD operations
└── README.md              # Project documentation (this file)
```

---

## ⚙️ Installation & Setup Steps

Follow these instructions to run **EduApp** in your local development environment:

### 1. Clone/Place the Project
Move all project files into your local server's root directory:
- **Laragon**: `C:\laragon\www\pweb-bootstrap`
- **XAMPP**: `C:\xampp\htdocs\pweb-bootstrap`

### 2. Setup the Database
1. Open your database client (such as phpMyAdmin, DBeaver, or MySQL CLI).
2. Execute the following SQL query to create the `db_eduapp` database and the `mahasiswa` (student) table:

```sql
-- Create Database
CREATE DATABASE IF NOT EXISTS db_eduapp;
USE db_eduapp;

-- Create Student Table
CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    jurusan VARCHAR(50) NOT NULL,
    jenis_kelamin VARCHAR(20) NOT NULL,
    minat VARCHAR(255) DEFAULT '-',
    foto VARCHAR(255) NOT NULL,
    status VARCHAR(20) DEFAULT 'Aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 3. Configure Database Connection
Adjust the database connection parameters in `koneksi.php` to match your local server environment:

```php
// koneksi.php
$host = 'localhost';
$dbname = 'db_eduapp';
$username = 'root'; // Adjust to your MySQL username
$password = 'root'; // Adjust to your MySQL password (leave blank for default XAMPP setups)
```

### 4. Running the Application
1. Start the **Apache** and **MySQL** services in your Laragon / XAMPP control panel.
2. Open your browser and navigate to:
   `http://localhost/pweb-bootstrap` or `http://pweb-bootstrap.test` (if utilizing Laragon's automatic virtual hosts).

---

## 🛡️ Validation & Security Workflow

The application implements several security and validation rules out of the box:

> [!IMPORTANT]
> **File Upload Restrictions:**
> - Permitted image formats: `.jpg`, `.jpeg`, and `.png`.
> - Maximum file size limit: `2 Megabytes (2MB)`.
> - Automatic Cleanup: Old image files are automatically deleted from the server directory (`uploads/`) when a student record is removed or when their photo is updated.

> [!TIP]
> **Prepared Statements (PDO):**
> All queries executing `INSERT`, `UPDATE`, and `DELETE` actions inside `proses_mahasiswa.php` utilize bound parameters with **PDO Prepared Statements** to secure database calls and protect against *SQL Injection*.

---

## 🎨 Modern UI & UX Design

The interface is created with usability and modern aesthetics in mind:
* **Glassmorphism & Shadow Cards**: Smooth cards with subtle drop shadows give the user interface a sleek, premium, and clean appearance.
* **Responsive Sidebar Layout**: A fluid layout adjusting dynamically from large desktop monitors down to mobile and tablet screen boundaries.
* **Interactive Action Alerts**: Incorporates dynamic confirmation dialogues before deletion requests are processed to prevent accidental data loss.

---

## 📄 License

This project is licensed under the **MIT License**. You are free to use, distribute, and modify it for both private and academic learning purposes.

---
*Created with ❤️ for a clean, responsive, and secure academic data management experience.*
