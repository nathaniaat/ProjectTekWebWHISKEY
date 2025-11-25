<?php
include 'config.php';

header('Content-Type: application/json');

// Logika API untuk GET data publik
$action = $_GET['action'] ?? '';

if ($action === 'getCats') {
    $sql = "SELECT id, name, age, gender, image_url, backstory, bg_color FROM cats ORDER BY id ASC";
    $result = $conn->query($sql);
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Ubah format gender untuk front-end filter
            $row['data_gender'] = strtolower($row['gender']); 
            $data[] = $row;
        }
    }
    echo json_encode(['success' => true, 'data' => $data]);
} 
// Tambahkan GET Education Content (ambil dari admin_dashboard.php lama)
else if ($action === 'getEducation') {
    $sql = "SELECT id, title, author, publish_date, category, image_url, teaser_content, content FROM education_content ORDER BY publish_date DESC";
    $result = $conn->query($sql);
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode(['success' => true, 'data' => $data]);
}
// Tambahkan Logika POST Submit Donation (Sederhana)
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'submitDonation') {
    
    $amount = filter_var($_POST['amount'] ?? 0, FILTER_VALIDATE_INT);
    $method = $conn->real_escape_string($_POST['payment_method'] ?? 'Unknown');
    
    if ($amount < 10000) {
        echo json_encode(['success' => false, 'message' => 'Jumlah donasi minimal Rp 10.000.']);
        $conn->close();
        exit;
    }

    $proof_url = null;
    $upload_success = true;
    
    // --- LOGIKA UPLOAD FILE DIMULAI ---
    if (isset($_FILES['proof']) && $_FILES['proof']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['proof'];
        $destination_dir = 'uploads/proofs/'; // PASTIKAN FOLDER INI ADA DAN WRITABLE!
        
        // Buat folder jika belum ada
        if (!is_dir($destination_dir)) {
            mkdir($destination_dir, 0777, true);
        }

        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        // Buat nama file unik (misalnya: donation_20251125_timestamp.jpg)
        $new_file_name = 'donation_' . date('Ymd_His') . '.' . $file_extension;
        $destination_path = $destination_dir . $new_file_name;

        // Pindahkan file dari lokasi sementara ke lokasi permanen
        if (move_uploaded_file($file['tmp_name'], $destination_path)) {
            $proof_url = $destination_path; // Simpan path relatif ke database
        } else {
            // Gagal memindahkan file (mungkin karena izin folder)
            $upload_success = false;
            error_log("Gagal memindahkan file bukti donasi: " . $file['name']);
            // Kita tetap melanjutkan INSERT ke DB, tetapi proof_url akan tetap null.
            // Anda bisa mengubah ini menjadi kegagalan total jika bukti wajib.
        }
    }
    // --- LOGIKA UPLOAD FILE SELESAI ---

    // Gunakan Prepared Statement yang sudah ada
    $stmt = $conn->prepare("INSERT INTO donations (amount, payment_method, proof_image_url) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $amount, $method, $proof_url);
    
    if ($stmt->execute()) {
        $message = $upload_success ? 'Donasi berhasil dicatat.' : 'Donasi dicatat, tetapi upload bukti gagal (coba hubungi admin).';
        echo json_encode(['success' => true, 'message' => $message]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mencatat donasi ke database: ' . $stmt->error]);
    }
    $stmt->close();
}
// Tambahkan Logika POST Submit Adoption (Sederhana)
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'submitAdoption') {
    // Ambil data dari formulir di script.js
    $catName = $conn->real_escape_string($_POST['cat_name'] ?? 'Kucing Pilihan');
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $city = $conn->real_escape_string($_POST['city']);
    $postalCode = $conn->real_escape_string($_POST['postalCode']);
    $residenceType = $conn->real_escape_string($_POST['residenceType']);

    $stmt = $conn->prepare("INSERT INTO adoption_applications (cat_name, first_name, last_name, email, phone_number, city, postal_code, residence_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $catName, $firstName, $lastName, $email, $phone, $city, $postalCode, $residenceType);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Permintaan adopsi berhasil dikirim.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan aplikasi adopsi.']);
    }
    $stmt->close();
}
// ... (Tambahkan endpoint publik lainnya) ...

$conn->close();
?>