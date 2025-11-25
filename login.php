<?php
include 'config.php';

// Jika sudah login, redirect sesuai role
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/admin.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan username dan password yang di-hash
    // Karena kita menggunakan PASSWORD() di INSERT, kita bisa menggunakan fungsi yang sama untuk verifikasi di MySQL.
    $sql = "SELECT id, username, role, password_hash FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password (menggunakan fungsi PASSWORD() untuk kompatibilitas skema)
        // Note: Idealnya, verifikasi ini dilakukan di PHP dengan password_verify() jika Anda menggunakan bcrypt.
        $sql_check_pass = "SELECT id FROM users WHERE username = ? AND password_hash = PASSWORD(?)";
        $stmt_check = $conn->prepare($sql_check_pass);
        $stmt_check->bind_param("ss", $username, $password);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows === 1) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            if ($user['role'] === 'admin') {
                header("Location: admin/admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $error = "Username atau Password salah.";
        }
    } else {
        $error = "Username atau Password salah.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Whiskey Shelter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css" />
</head>
<body class="flex items-center justify-center min-h-screen bg-soft-blue">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-xl shadow-2xl">
        <h2 class="text-3xl font-bold text-center headerTxt700 text-blue-800">Welcome to</h2>
        <img src="img/Whiskey.png" alt="Whiskey Shelter Logo">
        
        <?php if ($error): ?>
            <p class="p-3 text-sm text-red-700 bg-red-100 border border-red-400 rounded"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" required class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:border-green focus:ring-green" value="<?php echo $_POST['username'] ?? ''; ?>">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:border-green focus:ring-green">
            </div>
            <button type="submit" class="w-full btn-green font-semibold px-6 py-3 rounded-full shadow-lg transition duration-150">
                Log In
            </button>
        </form>
    </div>
</body>
</html>