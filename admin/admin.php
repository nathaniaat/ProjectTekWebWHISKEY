<?php
// admin/admin_dashboard.php
include '../config.php'; 
check_admin();

// Fungsi helper untuk mengambil data dari database (digunakan untuk memuat data awal)
function getTableData($conn, $tableName) {
    $data = [];
    $sql = "SELECT * FROM $tableName ORDER BY id ASC";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Ambil data untuk tampilan PHP
$cats = getTableData($conn, 'cats');
$education = getTableData($conn, 'education_content');

// Ambil data untuk tinjauan cepat (quick counts)
$counts_data = [
    'cats' => 'Kucing Tersedia',
    'adoption_applications' => 'Aplikasi Adopsi',
    'donations' => 'Donasi Masuk',
    'education_content' => 'Artikel Edukasi'
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Whiskey Shelter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../style.css"> 
</head>
<body class="bg-gray-100 p-4 sm:p-8">
    <header class="headeradmin mb-8 flex justify-between items-center">
        <h1 class="text-4xl font-bold text-indigo-700">Admin WHISKEY</h1>
        <a href="../logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 font-semibold text-base">Logout</a>
    </header>
    
    <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-indigo-200">
        <h2 class="text-2xl font-bold mb-4 text-indigo-700 border-b pb-2">Kelola Kucing 🐾</h2>
        
        <button id="showAddCatFormBtn" class="btn-green px-4 py-2 rounded-lg font-semibold mb-4">
            + Tambah Kucing Baru
        </button>

        <div id="addCatFormContainer" class="bg-indigo-50 p-4 rounded-lg mb-4 hidden">
            <h3 class="font-bold mb-3">Form Tambah Kucing</h3>
            <form id="addCatForm" class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="md:col-span-1">
                    <label for="catName" class="block text-xs font-medium text-gray-700 mb-1">Nama Kucing</label>
                    <input type="text" id="catName" placeholder="Nama Kucing" class="w-full p-2 border rounded" required>
                </div>

                <div class="md:col-span-1">
                    <label for="catAge" class="block text-xs font-medium text-gray-700 mb-1">Usia</label>
                    <input type="text" id="catAge" placeholder="Usia (ex: 1 year)" class="w-full p-2 border rounded" required>
                </div>

                <div class="md:col-span-1">
                    <label for="catGender" class="block text-xs font-medium text-gray-700 mb-1">Gender</label>
                    <select id="catGender" class="w-full p-2 border rounded" required>
                        <option value="">Pilih Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="md:col-span-3">
    <label class="block text-xs font-medium text-gray-700 mb-2">Upload Gambar Kucing</label>

    <div class="flex items-center space-x-3">
        <label for="catImage" class="relative inline-block cursor-pointer flex-shrink-0">
            <span class="btn-outline-green font-semibold px-4 py-1 rounded-lg shadow-sm hover:shadow-md transition duration-150">
                Pilih Gambar
            </span>
            <input 
                type="file" 
                id="catImage" 
                name="image_file" 
                accept="image/*" 
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                required
            />
        </label>
        
        <span id="catFileName" class="text-sm text-gray-600 truncate max-w-[200px]">
            (Belum ada file dipilih)
        </span>
    </div>
</div>

                <div class="md:col-span-2">
                    <label for="catBackstory" class="block text-xs font-medium text-gray-700 mb-1">Backstory</label>
                    <textarea id="catBackstory" placeholder="Backstory" class="w-full p-2 border rounded h-20" required></textarea>
                </div>

                <div class="md:col-span-1">
                    <label for="catBgColor" class="block text-xs font-medium text-gray-700 mb-1">Warna Background</label>
                    <select id="catBgColor" class="w-full p-2 border rounded h-12" required>
                        <option value="bg-soft-pink">Pink Card (bg-soft-pink)</option>
                        <option value="bg-soft-yellow">Yellow Card (bg-soft-yellow)</option>
                    </select>
                </div>

                <div class="md:col-span-3 text-right">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 font-semibold">Simpan Kucing</button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-left text-sm border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border-b">ID</th>
                        <th class="p-3 border-b">Nama</th>
                        <th class="p-3 border-b">Usia</th>
                        <th class="p-3 border-b">Gender</th>
                        <th class="p-3 border-b">Backstory (Ringkas)</th>
                        <th class="p-3 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody id="masterCatList">
                    <?php 
                    if (!empty($cats)) {
                        foreach($cats as $row) {
                            echo "<tr class='border-b hover:bg-indigo-50'>";
                            echo "<td class='p-3'>{$row['id']}</td>";
                            echo "<td class='p-3 font-semibold'>{$row['name']}</td>";
                            echo "<td class='p-3'>{$row['age']}</td>";
                            echo "<td class='p-3'>{$row['gender']}</td>";
                            echo "<td class='p-3 text-xs truncate max-w-xs'>".substr($row['backstory'], 0, 50)."...</td>";
                            echo "<td class='p-3 space-x-2 whitespace-nowrap'>";
                            echo "<button data-id='{$row['id']}' class='edit-cat-btn text-blue-600 hover:text-blue-800 text-sm'>Edit</button>";
                            echo "<button data-id='{$row['id']}' class='delete-cat-btn text-red-600 hover:text-red-800 text-sm'>Hapus</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='p-4 text-center text-gray-500'>Tidak ada data di tabel Kucing.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-green-200">
        <h2 class="text-2xl font-bold mb-4 text-green-700 border-b pb-2">Kelola Edukasi 📚</h2>

        <button id="showAddEducationFormBtn" class="btn-green px-4 py-2 rounded-lg font-semibold mb-4">
            + Tambah Artikel Baru
        </button>

        <div id="addEducationFormContainer" class="bg-green-50 p-4 rounded-lg mb-4 hidden">
            <h3 class="font-bold mb-3">Form Tambah Artikel</h3>
            <form id="addEducationForm" class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="md:col-span-3">
                    <label for="eduTitle" class="block text-xs font-medium text-gray-700 mb-1">Judul Artikel</label>
                    <input type="text" id="eduTitle" placeholder="Judul Artikel" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label for="eduAuthor" class="block text-xs font-medium text-gray-700 mb-1">Penulis</label>
                    <input type="text" id="eduAuthor" placeholder="Penulis" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label for="eduDate" class="block text-xs font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" id="eduDate" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label for="eduCategory" class="block text-xs font-medium text-gray-700 mb-1">Kategori</label>
                    <select id="eduCategory" class="w-full p-2 border rounded" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Tips">Tips</option>
                        <option value="Health">Health</option>
                        <option value="Behavior">Behavior</option>
                    </select>
                </div>

                <div class="md:col-span-3">
    <label class="block text-xs font-medium text-gray-700 mb-2">Upload Gambar Artikel</label>

    <div class="flex items-center space-x-3">
        <label for="eduImage" class="relative inline-block cursor-pointer flex-shrink-0">
            <span class="btn-outline-green font-semibold px-4 py-1 rounded-lg shadow-sm hover:shadow-md transition duration-150">
                Pilih Gambar
            </span>
            <input 
                type="file" 
                id="eduImage" 
                name="image_file" 
                accept="image/*" 
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                required
            />
        </label>
        
        <span id="eduFileName" class="text-sm text-gray-600 truncate max-w-[200px]">
            (Belum ada file dipilih)
        </span>
    </div>
</div>

                <div class="md:col-span-3">
                    <label for="eduTeaserContent" class="block text-xs font-medium text-gray-700 mb-1">Ringkasan (Teaser)</label>
                    <textarea id="eduTeaserContent" placeholder="Isi Ringkasan Konten" class="w-full p-2 border rounded h-24" required></textarea>
                </div>

                <div class="md:col-span-3">
                    <label for="eduContent" class="block text-xs font-medium text-gray-700 mb-1">Konten Penuh</label>
                    <textarea id="eduContent" placeholder="Isi Konten (lengkap)" class="w-full p-2 border rounded h-36" required></textarea>
                </div>

                <div class="md:col-span-3 text-right">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-semibold">Simpan Artikel</button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-left text-sm border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border-b">ID</th>
                        <th class="p-3 border-b">Judul</th>
                        <th class="p-3 border-b">Penulis</th>
                        <th class="p-3 border-b">Tanggal</th>
                        <th class="p-3 border-b">Kategori</th>
                        <th class="p-3 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody id="masterEducationList">
                    <?php 
                    if (!empty($education)) {
                        foreach($education as $row) {
                            echo "<tr class='border-b hover:bg-green-50'>";
                            echo "<td class='p-3'>{$row['id']}</td>";
                            echo "<td class='p-3 font-semibold'>{$row['title']}</td>";
                            echo "<td class='p-3'>{$row['author']}</td>";
                            echo "<td class='p-3'>{$row['publish_date']}</td>";
                            echo "<td class='p-3'><span class='px-2 py-1 text-xs rounded-full bg-gray-200'>{$row['category']}</span></td>";
                            echo "<td class='p-3 space-x-2 whitespace-nowrap'>";
                            echo "<button data-id='{$row['id']}' class='edit-edu-btn text-blue-600 hover:text-blue-800 text-sm'>Edit</button>";
                            echo "<button data-id='{$row['id']}' class='delete-edu-btn text-red-600 hover:text-red-800 text-sm'>Hapus</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='p-4 text-center text-gray-500'>Tidak ada data di tabel Edukasi.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-yellow-200">
        <h2 class="text-2xl font-bold mb-4 text-yellow-700 border-b pb-2">Aplikasi Adopsi Masuk 📋</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-left text-sm border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border-b">ID</th>
                        <th class="p-3 border-b">Kucing</th>
                        <th class="p-3 border-b">Nama Pengaju</th>
                        <th class="p-3 border-b">Kontak & Email</th>
                        <th class="p-3 border-b">Lokasi</th>
                        <th class="p-3 border-b">Tinggal</th>
                        <th class="p-3 border-b">Tanggal</th>
                    </tr>
                </thead>
                <tbody id="adoptionReviewList">
                    <tr><td colspan="9" class="p-4 text-center text-gray-500">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-lg border border-red-200">
        <h2 class="text-2xl font-bold mb-4 text-red-700 border-b pb-2">Data Donasi Masuk 💰</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-left text-sm border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border-b">ID</th>
                        <th class="p-3 border-b">Jumlah</th>
                        <th class="p-3 border-b">Metode Bayar</th>
                        <th class="p-3 border-b">Tanggal</th>
                        <th class="p-3 border-b">Bukti</th>
                    </tr>
                </thead>
                <tbody id="donationListBody">
                    <tr><td colspan="5" class="p-4 text-center text-gray-500">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="admin.js"></script>
</body>
</html>