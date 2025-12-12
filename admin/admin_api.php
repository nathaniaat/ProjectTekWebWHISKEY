<?php
// admin/admin_api.php
header('Content-Type: application/json');

include '../config.php'; 
// call check_admin() only if it exists (auth helper may be optional in this setup)
if (function_exists('check_admin')) {
    check_admin();
}

$response = ['success' => false, 'message' => 'Invalid action or missing required fields.'];

// Allowed tables (whitelist) to avoid SQL injection via table names
$ALLOWED_TABLES = ['cats', 'education_content', 'adoption_applications', 'donations'];

// Fungsi helper untuk mengambil semua data dari tabel tertentu (ORDER BY id ASC)
function getTableData($conn, $tableName, $orderBy = 'id ASC') {
    global $ALLOWED_TABLES;
    $data = [];
    if (!in_array($tableName, $ALLOWED_TABLES)) return $data;

    // Only allow a few safe ORDER BY values (prevent injection via orderBy)
    $allowedOrders = ['id ASC', 'id DESC', 'application_date DESC', 'donation_date DESC'];
    if (!in_array($orderBy, $allowedOrders)) $orderBy = 'id ASC';

    $safeTable = $conn->real_escape_string($tableName);
    $sql = "SELECT * FROM `{$safeTable}` ORDER BY {$orderBy}";
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// --- FUNGSI HELPER UPLOAD FILE (TETAP SAMA) ---
function handleFileUpload($fileKey, $targetDir) {
    // Normalize target dir and ensure trailing slash
    $targetDir = rtrim($targetDir, '/') . '/';
    $fullPath = realpath(__DIR__ . '/..') . '/' . ltrim($targetDir, '/');

    if (!is_dir($fullPath)) {
        mkdir($fullPath, 0777, true);
    }

    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES[$fileKey];
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $new_file_name = uniqid('img_') . ($file_extension ? '.' . $file_extension : '');
        $destination_path = $fullPath . $new_file_name;

        if (move_uploaded_file($file['tmp_name'], $destination_path)) {
            // Return web-relative path like 'img/cats/xxxx.jpg'
            $webPath = ltrim($targetDir . $new_file_name, '/');
            return $webPath;
        }
    }
    return null;
}
// --- END FUNGSI HELPER UPLOAD ---


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // --- LOGIKA GET (READ) ---
    $action = $_GET['action'] ?? '';

    try {
        switch ($action) {
            case 'getCats':
                $response = ['success' => true, 'data' => getTableData($conn, 'cats')];
                break;
            case 'getEducation':
                $response = ['success' => true, 'data' => getTableData($conn, 'education_content')];
                break;
            case 'getAdoptions':
                $response = ['success' => true, 'data' => getTableData($conn, 'adoption_applications', 'application_date DESC')];
                break;
            case 'getDonations':
                $response = ['success' => true, 'data' => getTableData($conn, 'donations', 'donation_date DESC')];
                break;

            case 'getCatDetails':
            case 'getEducationDetails':
                $id = (int)($_GET['id'] ?? 0);
                $table = ($action === 'getCatDetails') ? 'cats' : 'education_content';

                if ($id > 0) {
                    $sql = "SELECT * FROM $table WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result && $result->num_rows === 1) {
                        $response = ['success' => true, 'data' => $result->fetch_assoc()];
                    }
                    $stmt->close();
                }
                break;
        }
    } catch (Exception $e) {
        $response = ['success' => false, 'message' => 'Server exception: ' . $e->getMessage()];
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Deteksi Sumber Data dan Action
    $is_file_upload = !empty($_POST['action']);
    $action = $_POST['action'] ?? '';
    $data = $_POST;

    if (!$is_file_upload) {
        // Jika bukan file upload, coba parse JSON (untuk operasi DELETE)
        $data_json = json_decode(file_get_contents('php://input'), true) ?? [];
        $action = $data_json['action'] ?? $action;
        $data = $data_json;
    }

    try {
        switch ($action) {

            // --- LOGIKA ADD/UPDATE YANG MELIBATKAN FILE UPLOAD ---
            case 'addCat':
            case 'updateCat':
            case 'addEducation':
            case 'updateEducation':

                $is_cat = in_array($action, ['addCat', 'updateCat']);
                $table = $is_cat ? 'cats' : 'education_content';
                $upload_key = 'image_file';
                $target_dir = $is_cat ? '../img/cats/' : '../img/articles/'; 
                $id = (int)($data['id'] ?? 0);
                $current_image_url = $data['current_image_url'] ?? ''; 

                // 1. Kelola File Upload
                $new_image_path = handleFileUpload($upload_key, $target_dir);
                $final_image_path = $new_image_path ?: $current_image_url;

                // 2. Validasi Kritis
                if (empty($final_image_path) && ($action === 'addCat' || $action === 'addEducation')) {
                    $response = ['success' => false, 'message' => 'Gambar wajib diupload/dipertahankan.']; 
                    break;
                }
                if (($action !== 'addCat' && $action !== 'addEducation') && $id <= 0) {
                    $response = ['success' => false, 'message' => 'ID item tidak valid.']; 
                    break;
                }

                // 3. Persiapkan Data & SQL
                if ($is_cat) {
                    // normalize keys
                    $name = $data['name'] ?? ($data['Name'] ?? '');
                    $age = $data['age'] ?? '';
                    $gender = strtolower($data['gender'] ?? '');
                    $backstory = $data['backstory'] ?? '';
                    $bgColor = $data['bgColor'] ?? ($data['bg_color'] ?? '');

                    if ($action === 'addCat') {
                        $sql = "INSERT INTO cats (name, age, gender, image_url, backstory, bg_color) VALUES (?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ssssss", $name, $age, $gender, $final_image_path, $backstory, $bgColor);
                    } else { // updateCat
                        $sql = "UPDATE cats SET name=?, age=?, gender=?, image_url=?, backstory=?, bg_color=? WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ssssssi", $name, $age, $gender, $final_image_path, $backstory, $bgColor, $id);
                    }
                } else { 
                    // Data Edukasi
                    $title = $data['title'] ?? ($data['Title'] ?? '');
                    $author = $data['author'] ?? '';
                    $date = $data['date'] ?? ($data['publish_date'] ?? ''); 
                    $teaserContent = $data['teaserContent'] ?? ($data['teaser_content'] ?? '');
                    $fullContent = $data['fullContent'] ?? $data['content'] ?? $data['fullcontent'] ?? '';
                    $category = $data['category'] ?? ''; 

                    if ($action === 'addEducation') {
                        $sql = "INSERT INTO education_content (title, author, publish_date, teaser_content, content, image_url, category) VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sssssss", $title, $author, $date, $teaserContent, $fullContent, $final_image_path, $category);
                    } else { // updateEducation
                        $sql = "UPDATE education_content SET title=?, author=?, publish_date=?, teaser_content=?, content=?, image_url=?, category=? WHERE id=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sssssssi", $title, $author, $date, $teaserContent, $fullContent, $final_image_path, $category, $id);
                    }
                }

                // 4. Eksekusi
                if (isset($stmt) && $stmt && $stmt->execute()) {
                    $message = ($action === 'addCat' || $action === 'addEducation') ? 'Data berhasil ditambahkan.' : 'Data berhasil diperbarui.';
                    $response = ['success' => true, 'message' => $message];
                } else {
                    $err = isset($stmt) && $stmt ? $stmt->error : $conn->error;
                    $response = ['success' => false, 'message' => 'Gagal eksekusi database: ' . $err];
                }
                if (isset($stmt) && $stmt) $stmt->close();
                break;

            // --- LOGIKA DELETE (JSON Parsing) ---
            case 'deleteCat':
            case 'deleteEducation':
                $id = (int)($data['id'] ?? 0);
                $table = ($action === 'deleteCat') ? 'cats' : 'education_content';

                if ($id <= 0) { 
                    $response = ['success' => false, 'message' => 'ID tidak valid.']; 
                } else {
                    if (!in_array($table, $ALLOWED_TABLES)) { $response = ['success'=>false,'message'=>'Table not allowed']; break; }
                    $stmt = $conn->prepare("DELETE FROM {$table} WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    if ($stmt->execute()) {
                        $response = ['success' => true, 'message' => 'Item berhasil dihapus.'];
                    } else {
                        $response = ['success' => false, 'message' => 'Gagal menghapus: ' . $stmt->error];
                    }
                    $stmt->close();
                }
                break;
        }
    } catch (Exception $e) {
        $response = ['success' => false, 'message' => 'Server exception: ' . $e->getMessage()];
    }
}

echo json_encode($response);
$conn->close();
?>