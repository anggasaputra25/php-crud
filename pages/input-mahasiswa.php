<!-- Judul Halaman -->
<div class="mb-4">
    <h3 class="fw-bold">Input Data Mahasiswa</h3>
    <p class="text-muted">Silakan isi formulir di bawah ini untuk menambahkan data mahasiswa baru.</p>
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

<!-- Form Input -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-people-fill me-2"></i> Form Input Data Mahasiswa
    </div>

    <div class="card-body">
        <form action="proses_mahasiswa.php" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>

            <!-- Action -->
            <input type="hidden" name="action" value="tambah">
            
            <!-- Data -->
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