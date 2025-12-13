<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// KONEKSI DATABASE
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');    
define('DB_NAME', 'whiskey');

// CREATE CONNECTION
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// CHECK CONNECTION
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// CEK LOGIN
function check_session() {    
    if (!isset($_SESSION['user_id'])) {
        $trace = debug_backtrace();
        $callerFile = $trace[0]['file'] ?? '';

        $redirectPath = strpos($callerFile, '/admin/') !== false || strpos($callerFile, '\\admin\\') !== false
            ? '../login.php'
            : 'login.php'; 
            
        $currentDir = basename(dirname($_SERVER['PHP_SELF']));
        $finalRedirect = ($currentDir === 'admin') ? '../login.php' : 'login.php';
        
        header("Location: " . $finalRedirect);
        exit;
    }
}

// CEK ROLE
function check_admin() {
    check_session();
    if (($_SESSION['role'] ?? '') !== 'admin') { 
        header("Location: ../index.php");
        exit;
    }
}
?>