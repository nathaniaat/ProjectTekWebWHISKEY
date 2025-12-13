<?php
include 'config.php';

header('Content-Type: application/json');

// GET CATS
$action = $_GET['action'] ?? '';

if ($action === 'getCats') {
    $sql = "SELECT id, name, age, gender, image_url, backstory, bg_color FROM cats ORDER BY id ASC";
    $result = $conn->query($sql);
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['data_gender'] = strtolower($row['gender']); 
            $data[] = $row;
        }
    }
    echo json_encode(['success' => true, 'data' => $data]);
} 
// GET EDUCATION ARTICLES
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

// POST SUBMIT DONATION
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
    
    if (isset($_FILES['proof']) && $_FILES['proof']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['proof'];
        $destination_dir = 'uploads/proofs/';
        
        if (!is_dir($destination_dir)) {
            mkdir($destination_dir, 0777, true);
        }

        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        // FORMAT NAMA FILE BUKTI DONASI
        $new_file_name = 'donation_' . date('Ymd_His') . '.' . $file_extension;
        $destination_path = $destination_dir . $new_file_name;

        if (move_uploaded_file($file['tmp_name'], $destination_path)) {
            $proof_url = $destination_path;
        } else {
            $upload_success = false;
            error_log("Gagal memindahkan file bukti donasi: " . $file['name']);
        }
    }

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

else if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'submitAdoption') {
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

$conn->close();
?>