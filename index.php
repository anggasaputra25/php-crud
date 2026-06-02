<?php
session_start();
require_once 'koneksi.php';

$stmt = $pdo->query("SELECT * FROM mahasiswa ORDER BY id DESC");
$data_mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduApp - Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f4f6f9;
        }
        .main-wrapper {
            flex: 1;
            display: flex;
        }
        .sidebar {
            width: 250px;
            min-height: calc(100vh - 56px);
        }
        .sidebar .nav-link {
            color: #fff;
            margin-bottom: 8px;
            border-radius: 6px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link:active {
            background-color: #0d6efd;
            color: #fff;
        }
        .active {
            background-color: #0d6efd;
            color: #fff;
        }
        .content {
            flex: 1;
            padding: 25px;
        }
        footer {
            margin-top: auto;
        }
        @media (max-width: 768px) {
            .main-wrapper {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                min-height: auto;
            }
        }
    </style>
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a href="#" class="navbar-brand fw-bold">✨EduApp</a>

            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Data</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Keluar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Wrapper sidebar + content -->
    <div class="main-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar bg-dark text-white p-3">
            <h5 class="text-center mb-4">
                <i class="bi bi-list-task"></i> Menu Utama
            </h5>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="index.php?page=dashboard" class="nav-link <?= ($_GET['page'] ?? 'dashboard') == 'dashboard' ? 'active' : ''; ?>">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="index.php?page=data-mahasiswa" class="nav-link <?= ($_GET['page'] ?? '') == 'data-mahasiswa' ? 'active' : ''; ?>">
                        <i class="bi bi-people-fill me-2"></i> Data Mahasiswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="index.php?page=input-mahasiswa" class="nav-link <?= ($_GET['page'] ?? '') == 'input-mahasiswa' ? 'active' : ''; ?>">
                        <i class="bi bi-book-fill me-2"></i> Input Mahasiswa
                    </a>
                </li>
                
            </ul>
        </aside>

        <!-- Content Area -->
        <main class="content">
            <?php
                $page = $_GET['page'] ?? 'dashboard';
                $allowed_pages = ['dashboard', 'data-mahasiswa', 'input-mahasiswa'];

                if (in_array($page, $allowed_pages)) {
                    include "pages/{$page}.php";
                } else {
                    echo "<div class='alert alert-danger'>Halaman tidak ditemukan.</div>";
                }
            ?>
        </main>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        &copy; 2026 EduApp. Semua Hak Dilindungi.
    </footer>

    <!-- Bootstrap Form Validation -->
    <script>
        (() => {
            'use strict';

            const forms = document.querySelectorAll('.needs-validation');

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>