const ADMIN_API_URL = "admin_api.php";

$(document).ready(function () {
  // DELETE
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

  // ADD/UPDATE
  function sendAdminUploadRequest(action, formData) {
    formData.append("action", action);

    $.ajax({
      url: ADMIN_API_URL,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
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

  // FORMAT RUPIAH
  function formatRupiah(amount) {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(amount);
  }

  function getFormDataAndFile(formId, fileInputId) {
    const formData = new FormData();
    const fileInput = document.getElementById(fileInputId);
    const file = fileInput.files[0];
    const mode = $(formId).find('button[type="submit"]').data("mode") || "add";

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
      const rawId = $(this).attr("id") || "";
      let key = rawId.replace(/^(cat|edu)/i, "");
      if (key.length > 0) {
        key = key.charAt(0).toLowerCase() + key.slice(1);
      }
      const rid = rawId.toLowerCase();
      if (rid === "educontent") key = "fullContent";
      formData.append(key, $(this).val());
    });

    const id = $(formId).find('button[type="submit"]').data("id");
    if (mode === "edit" && id) {
      formData.append("id", id);
    }

    if (file) {
      formData.append("image_file", file);
    } else if (mode === "edit") {
      const currentUrl = $(formId).data("current-image-url") || "";
      formData.append("current_image_url", currentUrl);
    }

    return { mode: mode, formData: formData, id: id };
  }

  function enableImagePreview(inputId, previewId, fileNameId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const fileName = document.getElementById(fileNameId);

    if (!input || !preview) return;

    input.addEventListener("change", function () {
      if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);

        if (fileName) fileName.textContent = this.files[0].name;
      }
    });
  }

  // TAMBAH/UPDATE KUCING
  $("#addCatForm").on("submit", function (e) {
    e.preventDefault();
    const { mode, formData } = getFormDataAndFile("#addCatForm", "catImage");
    const action = mode === "edit" ? "updateCat" : "addCat";
    sendAdminUploadRequest(action, formData);
  });

  // TAMBAH/UPDATE ARTIKEL
  $("#addEducationForm").on("submit", function (e) {
    e.preventDefault();
    const { mode, formData } = getFormDataAndFile(
      "#addEducationForm",
      "eduImage"
    );
    const action = mode === "edit" ? "updateEducation" : "addEducation";
    sendAdminUploadRequest(action, formData);
  });

  // EDIT
  function loadEditForm(id, type) {
    const action = type === "cat" ? "getCatDetails" : "getEducationDetails";
    const formContainerId =
      type === "cat" ? "#addCatFormContainer" : "#addEducationFormContainer";
    const formId = type === "cat" ? "#addCatForm" : "#addEducationForm";

    $(formId)[0].reset();
    $(formId).removeData("current-image-url");

    $.getJSON(
      ADMIN_API_URL + `?action=${action}&id=${id}`,
      function (response) {
        if (response.success && response.data) {
          const data = response.data;
          const imageUrl = data.image_url || "";

          $(formId).data("current-image-url", imageUrl);

          if (type === "cat" && imageUrl) {
            $("#catImagePreview").attr(
              "src",
              imageUrl.startsWith("http") ? imageUrl : "../" + imageUrl
            );
          }

          if (type === "education" && imageUrl) {
            $("#eduImagePreview").attr(
              "src",
              imageUrl.startsWith("http") ? imageUrl : "../" + imageUrl
            );
          }

          $(formContainerId)
            .find("h3")
            .text(`Edit ${type === "cat" ? "Kucing" : "Artikel"} ID: ${id}`);

          const fileNameDisplayId =
            type === "cat" ? "catFileName" : "eduFileName";

          const fileName = imageUrl
            ? imageUrl.substring(imageUrl.lastIndexOf("/") + 1)
            : "(Tidak ada)";

          const href = imageUrl.startsWith("http")
            ? imageUrl
            : "../" + imageUrl;

          $("#" + fileNameDisplayId).html(
            imageUrl
              ? `URL Lama: <span class="ml-1"> <a href="${href}" target="_blank" class="text-blue-600 underline hover:text-blue-800 pointer-events-auto"> ${fileName} </a> </span>`
              : "Tidak ada gambar sebelumnya"
          );

          if (type === "cat") {
            // CATS
            $("#catName").val(data.name);
            $("#catAge").val(data.age);
            $("#catGender").val(data.gender);
            $("#catBackstory").val(data.backstory);
            $("#catBgColor").val(data.bg_color);
            $("#catImage").prop("required", false);
          } else {
            // EDUCATION ARTICLES
            $("#eduTitle").val(data.title || "");
            $("#eduAuthor").val(data.author || "");
            $("#eduDate").val(data.publish_date || "");
            $("#eduContent").val(
              (data.content || "").replace(/<br\s*\/?>/gi, "\n")
            );
            $("#eduCategory").val(data.category || "");
            $("#eduTeaserContent").val(data.teaser_content || "");
            $("#eduImage").prop("required", false);
          }

          $(formId)
            .find('button[type="submit"]')
            .text("Simpan Perubahan (ID " + id + ")")
            .removeClass("bg-indigo-600 bg-green-600")
            .addClass("bg-orange-600")
            .data("mode", "edit")
            .data("id", id);

          $(formContainerId).slideDown(200);
        } else {
          alert("Gagal memuat detail: " + response.message);
        }
      }
    ).fail(function () {
      alert("Gagal terhubung ke API untuk memuat detail.");
    });
  }

  $("#masterCatList").on("click", ".edit-cat-btn", function () {
    const catId = $(this).data("id");
    loadEditForm(catId, "cat");
  });

  $("#masterEducationList").on("click", ".edit-edu-btn", function () {
    const eduId = $(this).data("id");
    loadEditForm(eduId, "education");
  });

  // HAPUS KUCING
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

  // HAPUS EDUKASI ARTIKEL
  $("body").on("click", "#masterEducationList .delete-edu-btn", function () {
    const eduId = $(this).data("id");
    if (confirm(`Yakin ingin menghapus Artikel Edukasi ID: ${eduId}?`)) {
      sendAdminRequest("deleteEducation", { id: eduId });
    }
  });

  // LOAD ADOPSI
  function loadAdoptions() {
    $.getJSON(ADMIN_API_URL + "?action=getAdoptions", function (response) {
      const $container = $("#adoptionReviewList");
      $container.empty();

      if (response.success && response.data.length > 0) {
        response.data.forEach((app) => {
          const row = 
            `<tr class="border-b hover:bg-yellow-50">
              <td class="p-3">${app.id}</td>
              <td class="p-3 font-semibold">${app.cat_name}</td> 
              <td class="p-3">${app.first_name} ${app.last_name}</td>
              <td class="p-3 text-sm">${app.email}<br>${app.phone_number}</td>
              <td class="p-3">${app.city} (${app.postal_code})</td>
              <td class="p-3">${app.residence_type}</td>
              <td class="p-3 text-xs">${app.application_date}</td>
              </td>
            </tr>`;
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
          let proofUrl = donation.proof_image_url || "";
          if (proofUrl && !proofUrl.startsWith("http")) {
            proofUrl = "../" + proofUrl;
          }

          const row = `
            <tr class="border-b hover:bg-red-50">
              <td class="p-3">${donation.id}</td>
              <td class="p-3 font-semibold text-red-700">
                ${formatRupiah(donation.amount)}
              </td>
              <td class="p-3">${donation.payment_method}</td>
              <td class="p-3">${donation.donation_date}</td>
              <td class="p-3 whitespace-nowrap">
                ${
                  proofUrl
                    ? `<a href="${proofUrl}" target="_blank"
                        class="text-blue-600 hover:text-blue-800 text-sm underline">
                        Lihat Bukti
                      </a>`
                    : `<span class="text-gray-400 text-sm">Tidak ada</span>`
                }
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

  // SINKRONISASI DATA & TAMPILAN

  $("#showAddCatFormBtn").on("click", function () {
    $("#addCatForm")[0].reset();
    $("#addCatForm").removeData("current-image-url");
    $("#catImagePreview").attr("src", "../img/placeholder.png");
    $("#catFileName").text("(Belum ada file dipilih)");
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
    $("#addEducationForm").removeData("current-image-url");
    $("#eduImagePreview").attr("src", "../img/placeholder.png");
    $("#eduFileName").text("(Belum ada file dipilih)");
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

  enableImagePreview("catImage", "catImagePreview", "catFileName");
  enableImagePreview("eduImage", "eduImagePreview", "eduFileName");

  loadAdoptions();
  loadDonations();
});