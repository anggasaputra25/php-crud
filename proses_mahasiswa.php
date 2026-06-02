<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Akses tidak valid.";
    header("Location: index.php");
    exit;
}

$action = $_POST['action'] ?? 'tambah';

// Hapus data mahasiswa
if ($action === 'hapus') {
    $id = intval($_POST['id'] ?? 0);

    if ($id <= 0) {
        $_SESSION['error'] = "ID tidak valid.";
        header("Location: index.php");
        exit;
    }

    try {
        // Ambil nama foto sebelum dihapus
        $stmt = $pdo->prepare("SELECT foto FROM mahasiswa WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $mahasiswa = $stmt->fetch();

        if (!$mahasiswa) {
            $_SESSION['error'] = "Data tidak ditemukan.";
            header("Location: index.php");
            exit;
        }

        // Hapus file foto dari server
        $lokasi_foto = 'uploads/' . $mahasiswa['foto'];
        if (file_exists($lokasi_foto)) {
            unlink($lokasi_foto);
        }

        // Hapus dari database
        $stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $_SESSION['success'] = "Data mahasiswa berhasil dihapus.";
        header("Location: index.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal menghapus data: " . $e->getMessage();
        header("Location: index.php");
        exit;
    }
}

// Tambah data mahasiswa
if ($action === 'tambah') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $jurusan = trim($_POST['jurusan'] ?? '');
    $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
    $minat = $_POST['minat'] ?? [];

    if ($nama === '' || $email === '' || $jurusan === '' || $jenis_kelamin === '') {
        $_SESSION['error'] = "Semua data wajib diisi.";
        header("Location: index.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email tidak valid.";
        header("Location: index.php");
        exit;
    }

    if (!isset($_FILES['foto']) || $_FILES['foto']['error'] != 0) {
        $_SESSION['error'] = "Foto wajib diupload.";
        header("Location: index.php");
        exit;
    }

    $folder_upload = 'uploads/';

    if (!is_dir($folder_upload)) {
        mkdir($folder_upload, 0777, true);
    }

    $nama_file = $_FILES['foto']['name'];
    $tmp_file = $_FILES['foto']['tmp_name'];
    $ukuran_file = $_FILES['foto']['size'];

    $extensi_diizinkan = ['jpg', 'jpeg', 'png'];
    $extensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    if (!in_array($extensi_file, $extensi_diizinkan)) {
        $_SESSION['error'] = "Format foto harus JPG, JPEG, PNG.";
        header("Location: index.php");
        exit;
    }

    if ($ukuran_file > 2 * 1024 * 1024) {
        $_SESSION['error'] = "Ukuran foto maksimal 2MB.";
        header("Location: index.php");
        exit;
    }

    $nama_file_baru = time() . '_' . uniqid() . '.' . $extensi_file;
    $lokasi_upload = $folder_upload . $nama_file_baru;

    if (!move_uploaded_file($tmp_file, $lokasi_upload)) {
        $_SESSION['error'] = "Foto gagal diupload.";
        header("Location: index.php");
        exit;
    }

    $minat_text = !empty($minat) ? implode(', ', $minat) : '-';

    try {
        $sql = "INSERT INTO mahasiswa
                (nama, email, jurusan, jenis_kelamin, minat, foto, status)
                VALUES
                (:nama, :email, :jurusan, :jenis_kelamin, :minat, :foto, :status)";
                
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':nama' => $nama,
            ':email' => $email,
            ':jurusan' => $jurusan,
            ':jenis_kelamin' => $jenis_kelamin,
            ':minat' => $minat_text,
            ':foto' => $nama_file_baru,
            ':status' => 'Aktif'
        ]);
        
        $_SESSION['success'] = "Data mahasiswa berhasil disimpan ke database.";
        
        header("Location: index.php?page=input-mahasiswa");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Data gagal disimpan: " . $e->getMessage();
        header("Location: index.php");
        exit;
    }
}

// Edit data mahasiswa
if ($action === 'edit') {
    $id      = intval($_POST['id'] ?? 0);
    $nama    = trim($_POST['nama'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $jurusan = trim($_POST['jurusan'] ?? '');
    $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
    $minat   = $_POST['minat'] ?? [];
    $minat_text = !empty($minat) ? implode(', ', $minat) : '-';

    // Cek apakah ada foto baru diupload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $folder_upload = 'uploads/';

        if (!is_dir($folder_upload)) {
            mkdir($folder_upload, 0777, true);
        }

        $nama_file = $_FILES['foto']['name'];
        $tmp_file = $_FILES['foto']['tmp_name'];
        $ukuran_file = $_FILES['foto']['size'];

        $extensi_diizinkan = ['jpg', 'jpeg', 'png'];
        $extensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        if (!in_array($extensi_file, $extensi_diizinkan)) {
            $_SESSION['error'] = "Format foto harus JPG, JPEG, PNG.";
            header("Location: index.php");
            exit;
        }

        if ($ukuran_file > 2 * 1024 * 1024) {
            $_SESSION['error'] = "Ukuran foto maksimal 2MB.";
            header("Location: index.php");
            exit;
        }
        
        $nama_file_baru = time() . '_' . uniqid() . '.' . $extensi_file;
        move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $nama_file_baru);

        // Hapus foto lama
        $stmt = $pdo->prepare("SELECT foto FROM mahasiswa WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $lama = $stmt->fetchColumn();
        if ($lama && file_exists('uploads/' . $lama)) unlink('uploads/' . $lama);

    } else {
        // Pakai foto lama
        $stmt = $pdo->prepare("SELECT foto FROM mahasiswa WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $nama_file_baru = $stmt->fetchColumn();
    }

    try {
        $stmt = $pdo->prepare("UPDATE mahasiswa 
                                SET nama=:nama, email=:email, jurusan=:jurusan,
                                    jenis_kelamin=:jenis_kelamin, minat=:minat, foto=:foto
                                WHERE id=:id");
        $stmt->execute([
            ':nama'          => $nama,
            ':email'         => $email,
            ':jurusan'       => $jurusan,
            ':jenis_kelamin' => $jenis_kelamin,
            ':minat'         => $minat_text,
            ':foto'          => $nama_file_baru,
            ':id'            => $id,
        ]);

        $_SESSION['success'] = "Data berhasil diupdate.";
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal update: " . $e->getMessage();
        header("Location: index.php");
        exit;
    }
}