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

            <!-- Judul Halaman -->
            <div class="mb-4">
                <h3 class="fw-bold">Dashboard EduApp</h3>
                <p class="text-muted">Selamat datang di halaman pengelolaan data mahasiswa</p>
            </div>

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

            <!-- Statistik -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">Total Mahasiswa</h6>
                            <h3 class="fw-bold">120</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">Total Jurusan</h6>
                            <h3 class="fw-bold">5</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">Data Aktif</h6>
                            <h3 class="fw-bold">98</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Input -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-people-fill me-2"></i> Form Input Data Mahasiswa
                </div>

                <div class="card-body">
                    <form action="proses_mahasiswa.php" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                            <div class="invalid-feedback">
                                Nama lengkap wajib diisi.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
                            <div class="invalid-feedback">
                                Email wajib diisi dengan format yang benar.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select name="jurusan" id="jurusan" class="form-select" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="Informatika">Informatika</option>
                                <option value="Sistem Informasi">Sistem Informasi</option>
                                <option value="Manajemen">Manajemen</option>
                                <option value="Bisnis Digital">Bisnis Digital</option>
                            </select>
                            <div class="invalid-feedback">
                                Jurusan wajib dipilih.
                            </div>
                        </div>

                        <!-- Radio Button -->
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="laki-laki" required checked>
                                <label class="form-check-label" for="laki">
                                    Laki-Laki
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="perempuan" required>
                                <label class="form-check-label" for="perempuan">
                                    Perempuan
                                </label>
                                <div class="invalid-feedback">
                                    Jenis kelamin wajib dipilih.
                                </div>
                            </div>
                        </div>

                        <!-- Checkbox -->
                        <div class="mb-3">
                            <label class="form-label">Minat Mahasiswa</label>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="minat[]" value="Web Programming" id="web">
                                <label class="form-check-label" for="web">
                                    Web Programming
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="minat[]" value="Mobile Programming" id="mobile">
                                <label class="form-check-label" for="mobile">
                                    Mobile Programming
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="minat[]" value="Data Science" id="data">
                                <label class="form-check-label" for="data">
                                    Data Science
                                </label>
                            </div>
                        </div>

                        <!-- Upload File -->
                        <div class="mb-3">
                            <label for="foto" class="form-label">Upload Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
                            <div class="invalid-feedback">
                                Foto wajib diupload.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Simpan Data
                        </button>

                        <button type="reset" class="btn btn-secondary">
                            Reset
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <i class="bi bi-file-fill me-2"></i> Data Mahasiswa
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Jurusan</th>
                                <th>Jenis Kelamin</th>
                                <th>Minat</th>
                                <th>Foto</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data_mahasiswa)) : ?>
                                <?php $no = 1; ?>
                                <?php foreach ($data_mahasiswa as $mhs) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($mhs['nama']); ?></td>
                                        <td><?= htmlspecialchars($mhs['email']); ?></td>
                                        <td><?= htmlspecialchars($mhs['jurusan']); ?></td>
                                        <td><?= htmlspecialchars($mhs['jenis_kelamin']); ?></td>
                                        <td><?= htmlspecialchars($mhs['minat']); ?></td>
                                        <td>
                                            <img src="uploads/<?= htmlspecialchars($mhs['foto']); ?>"
                                                width="60"
                                                class="rounded">
                                        </td>
                                        <td>
                                            <?php if ($mhs['status'] == 'Aktif') : ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else : ?>
                                                <span class="badge bg-warning text-dark">
                                                    <?= htmlspecialchars($mhs['status']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        Belum ada data mahasiswa.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
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