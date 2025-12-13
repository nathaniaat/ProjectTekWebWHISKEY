<?php
include '../config.php';
check_admin();

// AMBIL DATA DARI DB
function getTableData($conn, $tableName)
{
    $data = [];
    $sql = "SELECT * FROM $tableName ORDER BY id ASC";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// AMBIL DATA UNTUK TAMPILAN PHP
$cats = getTableData($conn, 'cats');
$education = getTableData($conn, 'education_content');

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
    <title>Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../style.css">
</head>

<body class="p-4 sm:p-8 bg-soft-blue">
    <header class="headeradmin mb-8 flex flex-row justify-between items-center">
        <img class="w-64" src="../img/Whiskey.png" alt="..." />
        <a href="../logout.php"
            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 font-semibold text-base">Logout</a>
    </header>

    <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-indigo-200">
        <h2 class="text-2xl font-bold mb-4 text-[#334eac] border-b pb-2">Cat Gallery</h2>

        <button id="showAddCatFormBtn" class="btn-green px-4 py-2 rounded-lg font-semibold mb-4">
            + Add New Cat
        </button>

        <div id="addCatFormContainer" class="bg-indigo-50 p-4 rounded-lg mb-4 hidden">
            <h3 class="font-bold mb-3">Add New Cat Form</h3>
            <form id="addCatForm" class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="md:col-span-1">
                    <label for="catName" class="block text-xs font-medium text-gray-700 mb-1">Cat Name</label>
                    <input type="text" id="catName" placeholder="Cat Name" class="w-full p-2 border rounded" required>
                </div>

                <div class="md:col-span-1">
                    <label for="catAge" class="block text-xs font-medium text-gray-700 mb-1">Age</label>
                    <input type="text" id="catAge" placeholder="Age (ex: 1 year)" class="w-full p-2 border rounded"
                        required>
                </div>

                <div class="md:col-span-1">
                    <label for="catGender" class="block text-xs font-medium text-gray-700 mb-1">Gender</label>
                    <select id="catGender" class="w-full p-2 border rounded" required>
                        <option value="">Select Gender</option>
                        <option value="male">male</option>
                        <option value="female">female</option>
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-medium text-gray-700 mb-2">Upload Cat Image</label>

                    <div class="flex items-center space-x-3">
                        <input type="file" id="catImage" name="image_file" accept="image/*" class="hidden" required />

                        <label for="catImage" class="cursor-pointer">
                        <img
                            id="catImagePreview"
                            src="../img/placeholder.png"
                            class="w-40 h-28 object-cover rounded-lg border hover:opacity-80 transition"
                        />
                        </label>

                        <span id="catFileName" class="text-sm text-gray-600 truncate max-w-[200px]">
                        (No file chosen)
                        </span>

                        <span id="catFileName" class="text-sm text-gray-600 truncate max-w-[200px]">
                            (No file chosen)
                        </span>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label for="catBackstory" class="block text-xs font-medium text-gray-700 mb-1">Backstory</label>
                    <textarea id="catBackstory" placeholder="Backstory" class="w-full p-2 border rounded h-20"
                        required></textarea>
                </div>

                <div class="md:col-span-1">
                    <label for="catBgColor" class="block text-xs font-medium text-gray-700 mb-1">Background
                        Color</label>
                    <select id="catBgColor" class="w-full p-2 border rounded h-12" required>
                        <option value="bg-soft-pink">Pink Card</option>
                        <option value="bg-soft-yellow">Yellow Card</option>
                    </select>
                </div>

                <div class="md:col-span-3 text-right">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 font-semibold">Save
                        Cat</button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-left text-sm border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border-b">ID</th>
                        <th class="p-3 border-b">Name</th>
                        <th class="p-3 border-b">Age</th>
                        <th class="p-3 border-b">Gender</th>
                        <th class="p-3 border-b">Backstory</th>
                        <th class="p-3 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody id="masterCatList">
                    <?php
                    if (!empty($cats)) {
                        foreach ($cats as $row) {
                            echo "<tr class='border-b hover:bg-indigo-50'>";
                            echo "<td class='p-3'>{$row['id']}</td>";
                            echo "<td class='p-3 font-semibold'>{$row['name']}</td>";
                            echo "<td class='p-3'>{$row['age']}</td>";
                            echo "<td class='p-3'>{$row['gender']}</td>";
                            echo "<td class='p-3 text-xs truncate max-w-xs'>" . substr($row['backstory'], 0, 50) . "...</td>";
                            echo "<td class='p-3 space-x-2 whitespace-nowrap'>";
                            echo "<button data-id='{$row['id']}' class='edit-cat-btn text-blue-600 hover:text-blue-800 text-sm'>Edit</button>";
                            echo "<button data-id='{$row['id']}' class='delete-cat-btn text-red-600 hover:text-red-800 text-sm'>Delete</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='p-4 text-center text-gray-500'>No data in the Cats table.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-green-200">
        <h2 class="text-2xl font-bold mb-4 text-green-700 border-b pb-2">Education Contents</h2>

        <button id="showAddEducationFormBtn" class="btn-green px-4 py-2 rounded-lg font-semibold mb-4">
            + Add New Article
        </button>

        <div id="addEducationFormContainer" class="bg-green-50 p-4 rounded-lg mb-4 hidden">
            <h3 class="font-bold mb-3">Add Article Form</h3>
            <form id="addEducationForm" class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="md:col-span-3">
                    <label for="eduTitle" class="block text-xs font-medium text-gray-700 mb-1">Article Title</label>
                    <input type="text" id="eduTitle" placeholder="Article Title" class="w-full p-2 border rounded"
                        required>
                </div>

                <div>
                    <label for="eduAuthor" class="block text-xs font-medium text-gray-700 mb-1">Author</label>
                    <input type="text" id="eduAuthor" placeholder="Author" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label for="eduDate" class="block text-xs font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" id="eduDate" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label for="eduCategory" class="block text-xs font-medium text-gray-700 mb-1">Category</label>
                    <select id="eduCategory" class="w-full p-2 border rounded" required>
                        <option value="">Select Category</option>
                        <option value="Tips">Tips</option>
                        <option value="Health">Health</option>
                        <option value="Behavior">Behavior</option>
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-medium text-gray-700 mb-2">
                        Upload Article Image
                    </label>

                    <div class="flex items-center space-x-3">
                        <input type="file" id="eduImage" name="image_file" accept="image/*" class="hidden" />
                        <label for="eduImage" class="cursor-pointer">
                            <img
                                id="eduImagePreview"
                                src="../img/placeholder.png"
                                class="w-40 h-28 object-cover rounded-lg border hover:opacity-80 transition"
                            />
                        </label>
                        <span id="eduFileName" class="text-sm text-gray-600 truncate max-w-[200px]">
                        (No file chosen)
                        </span>
                    </div>
                </div>
                <div class="md:col-span-3">
                    <label for="eduTeaserContent" class="block text-xs font-medium text-gray-700 mb-1">Summary</label>
                    <textarea id="eduTeaserContent" placeholder="Enter Content Summary" class="w-full p-2 border rounded h-24" required></textarea>
                </div>
                <div class="md:col-span-3">
                    <label for="eduContent" class="block text-xs font-medium text-gray-700 mb-1">Full Content</label>
                    <textarea id="eduContent" placeholder="Enter Full Content" class="w-full p-2 border rounded h-36" required></textarea>
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
                        <th class="p-3 border-b">Title</th>
                        <th class="p-3 border-b">Author</th>
                        <th class="p-3 border-b">Date</th>
                        <th class="p-3 border-b">Category</th>
                        <th class="p-3 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody id="masterEducationList">
                    <?php
                    if (!empty($education)) {
                        foreach ($education as $row) {
                            echo "<tr class='border-b hover:bg-green-50'>";
                            echo "<td class='p-3'>{$row['id']}</td>";
                            echo "<td class='p-3 font-semibold'>{$row['title']}</td>";
                            echo "<td class='p-3'>{$row['author']}</td>";
                            echo "<td class='p-3'>{$row['publish_date']}</td>";
                            echo "<td class='p-3'><span class='px-2 py-1 text-xs rounded-full bg-gray-200'>{$row['category']}</span></td>";
                            echo "<td class='p-3 space-x-2 whitespace-nowrap'>";
                            echo "<button data-id='{$row['id']}' class='edit-edu-btn text-blue-600 hover:text-blue-800 text-sm'>Edit</button>";
                            echo "<button data-id='{$row['id']}' class='delete-edu-btn text-red-600 hover:text-red-800 text-sm'>Delete</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='p-4 text-center text-gray-500'>No data in the Education table.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-yellow-200">
        <h2 class="text-2xl font-bold mb-4 text-yellow-700 border-b pb-2">Adoption Applications</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-left text-sm border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border-b">ID</th>
                        <th class="p-3 border-b">Cat Name</th>
                        <th class="p-3 border-b">Applicant Name</th>
                        <th class="p-3 border-b">Contact & Email</th>
                        <th class="p-3 border-b">Location</th>
                        <th class="p-3 border-b">Residence</th>
                        <th class="p-3 border-b">Date</th>
                    </tr>
                </thead>
                <tbody id="adoptionReviewList">
                    <tr>
                        <td colspan="9" class="p-4 text-center text-gray-500">Loading data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-lg border border-red-200">
        <h2 class="text-2xl font-bold mb-4 text-red-700 border-b pb-2">Donation Data</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-left text-sm border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border-b">ID</th>
                        <th class="p-3 border-b">Amount</th>
                        <th class="p-3 border-b">Payment Method</th>
                        <th class="p-3 border-b">Date</th>
                        <th class="p-3 border-b">Proof</th>
                    </tr>
                </thead>
                <tbody id="donationListBody">
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">Loading data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="admin.js"></script>
</body>

</html>