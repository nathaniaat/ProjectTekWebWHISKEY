// admin/admin.js
const ADMIN_API_URL = "admin_api.php";

$(document).ready(function () {
  // Helper function for AJAX POST requests (JSON - digunakan untuk DELETE)
  function sendAdminRequest(action, data) {
    $.ajax({
      url: ADMIN_API_URL,
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify({ action: action, ...data }),
      success: function (response) {
        alert(response.message);
        if (response.success) {
          location.reload();
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error(
          "AJAX Error:",
          textStatus,
          errorThrown,
          jqXHR.responseText
        );
        alert("Koneksi gagal atau server error saat memproses data.");
      },
    });
  }

  // Helper function for AJAX POST requests (FormData - digunakan untuk ADD/UPDATE dengan file)
  function sendAdminUploadRequest(action, formData) {
    formData.append("action", action);

    $.ajax({
      url: ADMIN_API_URL,
      type: "POST",
      data: formData,
      processData: false, // Wajib untuk FormData
      contentType: false, // Wajib untuk FormData
      success: function (response) {
        if (typeof response === "string") {
          try {
            response = JSON.parse(response);
          } catch (e) {}
        }
        alert(response.message);
        if (response.success) {
          location.reload();
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error(
          "Upload AJAX Error:",
          textStatus,
          errorThrown,
          jqXHR.responseText
        );
        alert("Upload gagal atau server error. Cek konsol.");
      },
    });
  }

  // Helper function for Rupiah formatting
  function formatRupiah(amount) {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(amount);
  }

  // Helper function untuk mengumpulkan data dasar form dan file
  function getFormDataAndFile(formId, fileInputId) {
    const formData = new FormData();
    const fileInput = document.getElementById(fileInputId);
    const file = fileInput.files[0];
    const mode = $(formId).find('button[type="submit"]').data("mode") || "add";

    // Tambahkan semua input teks ke FormData
    $(
      formId +
        ' input[type="text"], ' +
        formId +
        ' input[type="date"], ' +
        formId +
        " select, " +
        formId +
        " textarea"
    ).each(function () {
      // Menggunakan nama ID elemen sebagai key, setelah menghapus prefix 'cat' atau 'edu'
      // Convert to lowerCamelCase so server receives consistent keys (e.g. 'Title' -> 'title', 'BgColor' -> 'bgColor')
      const rawId = $(this).attr("id") || "";
      let key = rawId.replace(/^(cat|edu)/i, "");
      if (key.length > 0) {
        key = key.charAt(0).toLowerCase() + key.slice(1);
      }
      // Special-case mapping to match server-side expected keys
      const rid = rawId.toLowerCase();
      if (rid === "educontent") key = "fullContent";
      formData.append(key, $(this).val());
    });

    // Tambahkan ID jika mode edit
    const id = $(formId).find('button[type="submit"]').data("id");
    if (mode === "edit" && id) {
      formData.append("id", id);
    }

    // Penanganan File
    if (file) {
      formData.append("image_file", file);
    } else if (mode === "edit") {
      // Jika mode edit, kirim URL lama yang sudah di-set di data atribut form
      const currentUrl = $(formId).data("current-image-url") || "";
      formData.append("current_image_url", currentUrl);
    }

    return { mode: mode, formData: formData, id: id };
  }

  // Helper untuk menampilkan nama file yang dipilih (Digunakan untuk Kucing dan Edukasi)
  const updateFileNameDisplay = (inputElementId, displayElementId) => {
    const fileInput = document.getElementById(inputElementId);
    const fileNameDisplay = document.getElementById(displayElementId);

    if (fileInput && fileNameDisplay) {
      fileInput.addEventListener("change", function () {
        if (this.files.length > 0) {
          fileNameDisplay.textContent = this.files[0].name;
        } else {
          fileNameDisplay.textContent = "(Belum ada file dipilih)";
        }
      });
    }
  };

  // ===================================
  // I. LOGIKA FORM TAMBAH (ADD/UPDATE) - Menggunakan FormData
  // ===================================

  // 1. Tambah/Update Kucing
  $("#addCatForm").on("submit", function (e) {
    e.preventDefault();
    const { mode, formData } = getFormDataAndFile("#addCatForm", "catImage");
    const action = mode === "edit" ? "updateCat" : "addCat";
    sendAdminUploadRequest(action, formData);
  });

  // 2. Tambah/Update Edukasi
  $("#addEducationForm").on("submit", function (e) {
    e.preventDefault();
    const { mode, formData } = getFormDataAndFile(
      "#addEducationForm",
      "eduImage"
    );
    const action = mode === "edit" ? "updateEducation" : "addEducation";
    sendAdminUploadRequest(action, formData);
  });

  // ===================================
  // II. LOGIKA EDIT (READ ONE untuk Edit Form)
  // ===================================

  function loadEditForm(id, type) {
    const action = type === "cat" ? "getCatDetails" : "getEducationDetails";
    const formContainerId =
      type === "cat" ? "#addCatFormContainer" : "#addEducationFormContainer";
    const formId = type === "cat" ? "#addCatForm" : "#addEducationForm";

    // Reset the form before loading
    $(formId)[0].reset();
    $(formId).removeData("current-image-url"); // Clear data attr

    $.getJSON(
      ADMIN_API_URL + `?action=${action}&id=${id}`,
      function (response) {
        if (response.success && response.data) {
          const data = response.data;
          const imageUrl = data.image_url || "";

          // Set URL lama di data atribut form untuk digunakan saat UPDATE tanpa file upload baru
          $(formId).data("current-image-url", imageUrl);

          // Ganti judul form
          $(formContainerId)
            .find("h3")
            .text(`Edit ${type === "cat" ? "Kucing" : "Artikel"} ID: ${id}`);

          // Reset nama file display
          const fileNameDisplayId =
            type === "cat" ? "catFileName" : "eduFileName";
          $("#" + fileNameDisplayId).text(
            `URL Lama: ${imageUrl.substring(imageUrl.lastIndexOf("/") + 1)}`
          );

          // Isi formulir
          if (type === "cat") {
            $("#catName").val(data.name);
            $("#catAge").val(data.age);
            $("#catGender").val(data.gender);
            $("#catBackstory").val(data.backstory);
            $("#catBgColor").val(data.bg_color);
            // ... (Set tombol edit) ...
          } else {
            // Education
            $("#eduTitle").val(data.title || "");
            $("#eduAuthor").val(data.author || "");
            $("#eduDate").val(data.publish_date || "");
            $("#eduContent").val(data.content || "");
            $("#eduCategory").val(data.category || "");
            $("#eduTeaserContent").val(data.teaser_content || "");
            // ... (Set tombol edit) ...
          }

          // Set tombol ke mode edit
          $(formId)
            .find('button[type="submit"]')
            .text("Simpan Perubahan (ID " + id + ")")
            .removeClass("bg-indigo-600 bg-green-600")
            .addClass("bg-orange-600")
            .data("mode", "edit")
            .data("id", id);

          // Tampilkan formulir
          $(formContainerId).slideDown(200);
        } else {
          alert("Gagal memuat detail: " + response.message);
        }
      }
    ).fail(function () {
      alert("Gagal terhubung ke API untuk memuat detail.");
    });
  }

  // Delegasi event untuk tombol Edit Kucing
  $("#masterCatList").on("click", ".edit-cat-btn", function () {
    const catId = $(this).data("id");
    loadEditForm(catId, "cat");
  });

  // Delegasi event untuk tombol Edit Edukasi
  $("#masterEducationList").on("click", ".edit-edu-btn", function () {
    const eduId = $(this).data("id");
    loadEditForm(eduId, "education");
  });

  // ===================================
  // III. LOGIKA HAPUS (DELETE) & IV. MEMUAT DATA (READ)
  // ===================================

  // Delegasi event untuk Hapus Kucing
  $("body").on("click", "#masterCatList .delete-cat-btn", function () {
    const catId = $(this).data("id");
    if (
      confirm(
        `Yakin ingin menghapus Kucing ID: ${catId}? Aplikasi adopsi yang menyebut nama kucing ini mungkin perlu ditinjau secara manual.`
      )
    ) {
      sendAdminRequest("deleteCat", { id: catId });
    }
  });

  // Delegasi event untuk Hapus Edukasi
  $("body").on("click", "#masterEducationList .delete-edu-btn", function () {
    const eduId = $(this).data("id");
    if (confirm(`Yakin ingin menghapus Artikel Edukasi ID: ${eduId}?`)) {
      sendAdminRequest("deleteEducation", { id: eduId });
    }
  });

  // Memuat Aplikasi Adopsi
  function loadAdoptions() {
    $.getJSON(ADMIN_API_URL + "?action=getAdoptions", function (response) {
      const $container = $("#adoptionReviewList");
      $container.empty();

      if (response.success && response.data.length > 0) {
        response.data.forEach((app) => {
          const row = `
                        <tr class="border-b hover:bg-yellow-50">
                            <td class="p-3">${app.id}</td>
                            <td class="p-3 font-semibold">${app.cat_name}</td> 
                            <td class="p-3">${app.first_name} ${app.last_name}</td>
                            <td class="p-3 text-sm">${app.email}<br>${app.phone_number}</td>
                            <td class="p-3">${app.city} (${app.postal_code})</td>
                            <td class="p-3">${app.residence_type}</td>
                            <td class="p-3 text-xs">${app.application_date}</td>
                            </td>
                        </tr>
                    `;
          $container.append(row);
        });
      } else {
        $container.html(
          '<tr><td colspan="9" class="p-4 text-center text-gray-500">Belum ada aplikasi adopsi yang masuk.</td></tr>'
        );
      }
    }).fail(function () {
      $("#adoptionReviewList").html(
        '<tr><td colspan="9" class="p-4 text-center text-red-500">Gagal memuat data Adopsi.</td></tr>'
      );
    });
  }

  function loadDonations() {
    $.getJSON(ADMIN_API_URL + "?action=getDonations", function (response) {
      const $container = $("#donationListBody");
      $container.empty();

      if (response.success && response.data.length > 0) {
        response.data.forEach((donation) => {
          const row = `
                        <tr class="border-b hover:bg-red-50">
                            <td class="p-3">${donation.id}</td>
                            <td class="p-3 font-semibold text-red-700">${formatRupiah(
                              donation.amount
                            )}</td>
                            <td class="p-3">${donation.payment_method}</td>
                            <td class="p-3">${donation.donation_date}</td>
                                <td class="p-3 whitespace-nowrap">
                                <button data-id='${donation.id}' data-proof='${
            donation.proof_image_url || ""
          }' class='donation-detail-btn text-blue-600 hover:text-blue-800 text-sm'>Detail</button>
                            </td>
                        </tr>
                    `;
          $container.append(row);
        });
      } else {
        $container.html(
          '<tr><td colspan="5" class="p-4 text-center text-gray-500">Belum ada data donasi yang masuk.</td></tr>'
        );
      }
    }).fail(function () {
      $("#donationListBody").html(
        '<tr><td colspan="5" class="p-4 text-center text-red-500">Gagal memuat data Donasi.</td></tr>'
      );
    });
  }

  // --- PANGGIL FUNGSI LOAD SAAT DOKUMEN SIAP ---
  // Delegated handler: buka gambar bukti transfer di tab baru
  $("body").on("click", "#donationListBody .donation-detail-btn", function (e) {
    e.preventDefault();
    const proof = $(this).data("proof") || "";
    if (!proof) {
      alert("Tidak ada bukti transfer terlampir untuk donasi ini.");
      return;
    }

    let url = proof;
    // Jika bukan URL absolut, buat path relatif dari folder admin ke root
    if (!/^https?:\/\//i.test(proof)) {
      if (proof.charAt(0) === "/") {
        url = window.location.origin + proof; // absolute path from root
      } else {
        url = "../" + proof; // likely stored as 'img/..' so go up from /admin/
      }
    }

    window.open(url, "_blank");
  });
  loadAdoptions();
  loadDonations();

  // Sinkronisasi display file input
  updateFileNameDisplay("eduImage", "eduFileName");
  updateFileNameDisplay("catImage", "catFileName");

  // Logika untuk menampilkan/menyembunyikan form (Toggle button click handlers)
  $("#showAddCatFormBtn").on("click", function () {
    $("#addCatForm")[0].reset();
    $("#addCatForm").removeData("current-image-url"); // Clear old URL data
    $("#catFileName").text("(Belum ada file dipilih)"); // Reset display
    $("#addCatFormContainer").find("h3").text("Form Tambah Kucing");
    $("#addCatForm")
      .find('button[type="submit"]')
      .text("Simpan Kucing")
      .removeClass("bg-orange-600 bg-green-600")
      .addClass("bg-indigo-600")
      .data("mode", "add")
      .data("id", "");

    $("#addCatFormContainer").slideToggle(200);
  });

  $("#showAddEducationFormBtn").on("click", function () {
    $("#addEducationForm")[0].reset();
    $("#addEducationForm").removeData("current-image-url"); // Clear old URL data
    $("#eduFileName").text("(Belum ada file dipilih)"); // Reset display
    $("#addEducationFormContainer").find("h3").text("Form Tambah Artikel");
    $("#addEducationForm")
      .find('button[type="submit"]')
      .text("Simpan Artikel")
      .removeClass("bg-orange-600 bg-indigo-600")
      .addClass("bg-green-600")
      .data("mode", "add")
      .data("id", "");

    $("#addEducationFormContainer").slideToggle(200);
  });
});
