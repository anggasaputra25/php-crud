<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Akses tidak valid.";
    header("Location: index.php");
    exit;
}
// nama, email, jurusan, jenis_kelamin, minat
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
    
    header("Location: index.php");
    exit;
} catch (PDOException $e) {
    $_SESSION['error'] = "Data gagal disimpan: " . $e->getMessage();
    header("Location: index.php");
    exit;
}