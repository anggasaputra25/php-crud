<!-- Judul Halaman -->
<div class="mb-4">
    <h3 class="fw-bold">Data Mahasiswa</h3>
    <p class="text-muted">Berikut adalah daftar data mahasiswa</p>
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
                    <th>Aksi</th>
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
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="edit-mahasiswa.php?id=<?= $mhs['id'] ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="proses_mahasiswa.php"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        <input type="hidden" name="action" value="hapus">
                                        <input type="hidden" name="id" value="<?= $mhs['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
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