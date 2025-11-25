<?php
// PENTING: Selalu mulai session di awal file PHP yang membutuhkan session,
// sebelum ada output HTML atau PHP warning/error.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Pengaturan Koneksi Database
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Ganti dengan username DB Anda
define('DB_PASSWORD', '');     // Ganti dengan password DB Anda
define('DB_NAME', 'whiskey');  // Nama Database

// Membuat Koneksi
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Cek Koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi Keamanan Sederhana untuk Cek Login (Memperbaiki Konflik Jalur Redirect)
function check_session() {
    // Session sudah dimulai di bagian atas file ini
    
    if (!isset($_SESSION['user_id'])) {
        
        // 1. Dapatkan direktori file yang memanggil check_session()
        // Fungsi debug_backtrace() akan memberikan informasi siapa yang memanggil
        $trace = debug_backtrace();
        $callerFile = $trace[0]['file'] ?? '';
        
        // 2. Tentukan Path Redirect: Jika dipanggil dari sub-folder admin/
        // Periksa apakah file pemanggil ada di sub-folder 'admin/'
        $redirectPath = strpos($callerFile, '/admin/') !== false || strpos($callerFile, '\\admin\\') !== false
            ? '../login.php' // Jika dari admin/admin.php, naik satu level
            : 'login.php';   // Jika dari index.php, path langsung

        // Namun, cara yang lebih aman adalah selalu redirect ke root (./login.php)
        // Kita hanya perlu memastikan PHP tahu bahwa kita keluar dari admin/
        
        // Cek path yang memanggil:
        $currentDir = basename(dirname($_SERVER['PHP_SELF']));
        $finalRedirect = ($currentDir === 'admin') ? '../login.php' : 'login.php';
        
        header("Location: " . $finalRedirect);
        exit;
    }
}

// Fungsi Keamanan untuk Cek Role Admin
function check_admin() {
    check_session();
    // Jika role bukan admin, tendang kembali ke index
    // Perbaikan: Redirect ke root index, memastikan path keluar dari admin
    if (($_SESSION['role'] ?? '') !== 'admin') { 
        header("Location: ../index.php"); // Path ini sudah benar (keluar dari admin/ ke index.php)
        exit;
    }
}
?>