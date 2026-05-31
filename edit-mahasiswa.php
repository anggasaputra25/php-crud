<?php
session_start();
require_once 'koneksi.php';

// Ambil ID dari URL
$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['error'] = "ID tidak valid.";
    header("Location: index.php");
    exit;
}

// Ambil data mahasiswa berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE id = :id");
$stmt->execute([':id' => $id]);
$mahasiswa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mahasiswa) {
    $_SESSION['error'] = "Data mahasiswa tidak ditemukan.";
    header("Location: index.php");
    exit;
}

// Pecah minat menjadi array untuk pengecekan checkbox
$minat_list = array_map('trim', explode(',', $mahasiswa['minat']));
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
                    <a href="#" class="nav-link active">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="bi bi-people-fill me-2"></i> Data Mahasiswa
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="bi bi-book-fill me-2"></i> Data Jurusan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="bi bi-gear-fill me-2"></i> Pengaturan
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Content Area -->
        <main class="content">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Mahasiswa</li>
                </ol>
            </nav>

            <!-- Alert Notifikasi -->
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['success']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Form Input -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-people-fill me-2"></i> Form Update Data Mahasiswa
                </div>

                <div class="card-body">
                    <form action="proses_mahasiswa.php" method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?= $mahasiswa['id'] ?>">

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="<?= htmlspecialchars($mahasiswa['nama']) ?>" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="<?= htmlspecialchars($mahasiswa['email']) ?>" required>
                        </div>

                        <!-- Jurusan -->
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select name="jurusan" id="jurusan" class="form-select" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <?php foreach (['Informatika', 'Sistem Informasi', 'Manajemen', 'Bisnis Digital'] as $j): ?>
                                    <option value="<?= $j ?>" <?= $mahasiswa['jurusan'] === $j ? 'selected' : '' ?>>
                                        <?= $j ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                    value="laki-laki" <?= $mahasiswa['jenis_kelamin'] === 'laki-laki' ? 'checked' : '' ?>>
                                <label class="form-check-label">Laki-Laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                    value="perempuan" <?= $mahasiswa['jenis_kelamin'] === 'perempuan' ? 'checked' : '' ?>>
                                <label class="form-check-label">Perempuan</label>
                            </div>
                        </div>

                        <!-- Minat (Checkbox) -->
                        <div class="mb-3">
                            <label class="form-label">Minat Mahasiswa</label>
                            <?php foreach (['Web Programming', 'Mobile Programming', 'Data Science'] as $m): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="minat[]"
                                        value="<?= $m ?>" <?= in_array($m, $minat_list) ? 'checked' : '' ?>>
                                    <label class="form-check-label"><?= $m ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Foto -->
                        <div class="mb-3">
                            <label class="form-label">Foto Saat Ini</label><br>
                            <img src="uploads/<?= htmlspecialchars($mahasiswa['foto']) ?>"
                                height="80" class="mb-2 rounded">
                            <label for="foto" class="form-label d-block">Ganti Foto (opsional)</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Data</button>
                        <a href="index.php" class="btn btn-secondary">Batal</a>

                    </form>
                </div>
            </div>
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