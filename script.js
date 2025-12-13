$(document).ready(function () {
  // NAVIGASI
  const $allSections = $(
    "#header, #aboutUsPage, #adoptionPage, #donationPage, #educationPage, #homeArticles"
  );

  function hideAllSections() {
    $allSections.hide();
    window.scrollTo({ top: 0, behavior: "smooth" });
  }

  // HOME PAGE, HIDE PAGE LAIN
  function showHomePage() {
    hideAllSections();
    $("#header").fadeIn();
    $("#aboutUsPage").fadeIn();
    $("#adoptionPage").fadeIn();
    $("#donationPage").fadeIn();
    $("#homeArticles").fadeIn();
  }

  // HANYA MENAMPILKAN PAGE SESUAI NAVBAR
  function navigateToSingleSection(targetSelector) {
    hideAllSections();
    $(targetSelector).fadeIn();
  }

  $("#homeNav").on("click", showHomePage);

  $("#aboutNav").on("click", function () {
    navigateToSingleSection("#aboutUsPage");
  });

  $("#adoptNav").on("click", function () {
    navigateToSingleSection("#adoptionPage");
  });

  $("#donateNav").on("click", function () {
    navigateToSingleSection("#donationPage");
  });

  $("#eduNav").on("click", function () {
    navigateToSingleSection("#educationPage");
  });

  $("#btnGoToEducation").on("click", function () {
    navigateToSingleSection("#educationPage");
  });

  showHomePage();
  $("#educationPage").hide(); 

  const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString("id-ID", {
      day: "2-digit",
      month: "2-digit",
      year: "numeric",
    });
  };

  // ADOPTION
  let allCatData = [];
  const $catDetailModal = $("#catDetailModal");
  const $adoptionFormModal = $("#adoptionFormModal");
  const $adoptionForm = $("#adoptionForm");
  const $catNameField = $("<input>")
    .attr({ type: "hidden", id: "catNameField", name: "cat_name" });

  if ($("#catNameField").length === 0) {
    $adoptionForm.prepend($catNameField);
  }

  function generateCatCards(data) {
    const $cardContainer = $("#adoptionPage .grid.gap-8");
    $cardContainer.empty();

    data.forEach((cat) => {
      const imageUrl = cat.image_url;
      const cardHtml = `
                <div class="cat-card ${cat.bg_color} rounded-2xl overflow-hidden shadow-lg p-4 hover:shadow-xl transition" data-gender="${cat.gender}">
                    <img src="${imageUrl}" alt="cat ${cat.name}" class="w-full aspect-[4/3] object-cover rounded-xl mb-3" />
                    <p class="text-[var(--dark-blue)] font-semibold text-xl mb-1 text-left">${cat.name}</p>
                    <div class="flex justify-between items-center text-sm">
                        <p class="text-[var(--dark-blue)] opacity-70">${cat.age} | ${cat.gender}</p>
                        <button class="view-detail-btn btn-green px-4 py-1 rounded-full font-medium"
                             data-name="${cat.name}" 
                             data-age="${cat.age}" 
                             data-gender="${cat.gender}" 
                             data-backstory="${cat.backstory}"
                             data-id="${cat.id}">
                             View
                        </button>
                    </div>
                </div>`;
      $cardContainer.append(cardHtml);
    });

    initializeAdoptionHandlers();
  }

  // DONASI
  function initializeAdoptionHandlers() {
    $(".view-detail-btn").off("click");
    $(".close-modal-btn").off("click");
    $("#openAdoptionFormBtn").off("click");
    $adoptionForm.off("submit");
    $(document).off("click.modal_close");

    $(".view-detail-btn").on("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const catName = $(this).data("name");

      $("#modalCatName").text(catName);
      $("#modalCatAge").text($(this).data("age"));
      $("#modalCatGender").text($(this).data("gender"));
      $("#modalCatBackstory").text($(this).data("backstory"));

      $("#openAdoptionFormBtn").data("cat-name", catName);

      $catDetailModal.removeClass("hidden").addClass("flex");
      $catDetailModal
        .find("> div")
        .removeClass("scale-95")
        .addClass("scale-100");
    });

    // ADOPSI
    $("#openAdoptionFormBtn").on("click", function () {
      closeModal("#catDetailModal"); 

      const catName = $(this).data("cat-name");
    
      $("#catNameField").val(catName);
      $adoptionForm[0].reset();

      // MODAL FORM
      setTimeout(() => {
        $adoptionFormModal.removeClass("hidden").addClass("flex");
        $adoptionFormModal
          .find("> div")
          .removeClass("scale-95")
          .addClass("scale-100");
      }, 100);
    });

    // SUBMIT FORM ADOPSI
    $adoptionForm.on("submit", function (event) {
      event.preventDefault();

      const catName = $("#catNameField").val();
      const formData = {
        action: "submitAdoption",
        cat_name: catName,
        firstName: $("#firstName").val(),
        lastName: $("#lastName").val(),
        email: $("#email").val(),
        phone: $("#phone").val(),
        city: $("#city").val(),
        postalCode: $("#postalCode").val(),
        residenceType: $("#residenceType").val(),
      };

      $.post("api.php", formData, function (response) {
        try {
          if (typeof response === "string") response = JSON.parse(response);
        } catch (e) {
          alert("Error parsing server response.");
          return;
        }

        if (response && response.success) {
          closeModal("#adoptionFormModal");
          $("#adoptionSuccessModal").removeCla
          $adoptionForm[0].reset();
        } else {
          alert(
            "Gagal mengirim permintaan adopsi: " +
              (response.message || "Server error.")
          );
        }
      }).fail(function () {
        alert("Gagal terhubung ke server saat mengirim aplikasi adopsi.");
      });
    });

    $("#adoptionSuccessModal button").on("click", function () {
      closeModal("#adoptionSuccessModal");
    });

    $catDetailModal.on("click", function (e) {
      if (e.target === this) closeModal("#catDetailModal");
    });

    $adoptionFormModal.on("click", function (e) {
      if (e.target === this) closeModal("#adoptionFormModal");
    });

    $("#adoptionSuccessModal").on("click", function (e) {
      if (e.target === this) closeModal("#adoptionSuccessModal");
    });

    $(document).on("click", ".close-modal-btn", function (e) {
      e.preventDefault();
      const $m = $(this).closest("[id$='Modal']");
      if ($m.length) closeModal("#" + $m.attr("id"));
    });

    $(document).on("click.modal_close", function (event) {
      if (
        $catDetailModal.hasClass("flex") &&
        $(event.target).closest("#catDetailModal > div").length === 0
      ) {
        closeModal("#catDetailModal");
      }
      if (
        $adoptionFormModal.hasClass("flex") &&
        $(event.target).closest("#adoptionFormModal > div").length === 0
      ) {
        closeModal("#adoptionFormModal");
      }
    });
  }

  function closeModal(modalSelector) {
    const $modal = $(modalSelector);
    $modal.find("> div").removeClass("scale-100").addClass("scale-95");
    setTimeout(() => {
      $modal.removeClass("flex").addClass("hidden");
    }, 200);
  }

  // LOAD DATA KUCING DARI API
  $.getJSON("api.php?action=getCats", function (response) {
    if (response.success) {
      allCatData = response.data;
      generateCatCards(allCatData);
    } else {
      console.error("Gagal memuat data kucing dari API.");
    }
  }).fail(function () {
    console.error("Gagal terhubung ke api.php (Cats).");
  });

  // FILTER KUCING
  $(".filter-btn").on("click", function () {
    const filterType = $(this).data("filter");
    $(".filter-btn").removeClass("btn-green").addClass("btn-outline-green");
    $(this).removeClass("btn-outline-green").addClass("btn-green");

    let filteredData =
      filterType === "all"
        ? allCatData
        : allCatData.filter((cat) => cat.gender === filterType);
    generateCatCards(filteredData);
  });
  $('.filter-btn[data-filter="all"]')
    .removeClass("btn-outline-green")
    .addClass("btn-green");

  // DONASI
  const scrollBtn = document.getElementById("scrollToContact");
  const contactSection = document.getElementById("contact");
  if (scrollBtn && contactSection) {
    scrollBtn.addEventListener("click", function () {
      contactSection.scrollIntoView({ behavior: "smooth" });
    });
  }

  const $donationModal = $("#donationModal");
  $("#donate_btnDonateHero").on("click", function () {
    $donationModal.removeClass("hidden").addClass("flex");
  });

  $("#closeDonationModal").on("click", function () {
    $donationModal.addClass("hidden").removeClass("flex");
    resetDonationForm();
  });

  const $customAmount = $("#donate_customAmount");
  const $donationOptions = $("#donate_donationOptions");
  const $donationSummary = $("#donate_donationSummary");
  const $paymentMethodSummary = $("#donate_paymentMethodSummary");
  const $paymentButtons = $(
    "#donate_paymentButtonsContainer .donate-payment-btn"
  );
  const $btnCheckout = $("#donate_btnCheckoutFinal");

  let currentAmount = 0;
  let currentMethod = "";

  const formatRupiah = (amount) => {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(amount);
  };

  const updateCheckoutButton = () => {
    const proofInput = document.getElementById("proofUpload");
    const hasProof = proofInput && proofInput.files && proofInput.files.length > 0;
    $btnCheckout.prop("disabled", !(currentAmount > 0 && currentMethod && hasProof));
  };

  const updateAmount = (newAmount) => {
    currentAmount = newAmount;
    if ($donationSummary.length)
      $donationSummary.text(formatRupiah(currentAmount));
    $("#donate_donationOptions .option-btn")
      .removeClass("btn-green border-green")
      .addClass("btn-outline-green");
    updateCheckoutButton();
  };

  function resetDonationForm() {
    currentAmount = 0;
    $donationSummary.text(formatRupiah(0));
    $("#donate_donationOptions .option-btn")
      .removeClass("btn-green border-green")
      .addClass("btn-outline-green");
    $customAmount.val("");
    currentMethod = "";
    $paymentMethodSummary.text("No Rekening: -");
    $paymentButtons.removeClass("btn-green").addClass("btn-outline-green");

    const proofInput = document.getElementById("proofUpload");
    const fileNameDisplay = document.getElementById("uploadedFileName");
    if (proofInput) proofInput.value = "";
    if (fileNameDisplay) fileNameDisplay.textContent = "";

    updateCheckoutButton();
  }

  const proofInput = document.getElementById("proofUpload");
  if (proofInput) {
    proofInput.addEventListener("change", function () {
      const file = this.files[0];
      const fileNameDisplay = document.getElementById("uploadedFileName");
      if (fileNameDisplay)
        fileNameDisplay.textContent = file ? "File dipilih: " + file.name : "";
      updateCheckoutButton();
    });
  }

  $("#closeDonationModal").on("click", function () {
    $("#donationModal").addClass("hidden").removeClass("flex");
    resetDonationForm();
  });

  $("#donationModal").on("click", function (e) {
    if (e.target === this) {
      $(this).addClass("hidden").removeClass("flex");
      resetDonationForm();
    }
  });

  if ($donationOptions.length) {
    $donationOptions.on("click", ".option-btn", function () {
      const amount = parseInt($(this).data("amount"));
      updateAmount(amount);
      if ($customAmount.length) $customAmount.val("");
      $(this)
        .removeClass("btn-outline-green")
        .addClass("btn-green border-green");
    });
  }

  if ($customAmount.length) {
    $customAmount.on("input", function () {
      let raw = $(this)
        .val()
        .replace(/[^0-9]/g, "");
      if (!raw) {
        updateAmount(0);
        $(this).val("");
        return;
      }
      let amount = parseInt(raw);
      updateAmount(amount);
      $(this).val(amount.toLocaleString("id-ID"));
    });
  }

  if ($paymentButtons.length) {
    $paymentButtons.on("click", function () {
      currentMethod = $(this).data("method");
      $paymentMethodSummary.text("No Rekening: " + currentMethod);
      $paymentButtons.removeClass("btn-green").addClass("btn-outline-green");
      $(this).removeClass("btn-outline-green").addClass("btn-green");
      updateCheckoutButton();
    });
  }

  if ($btnCheckout.length) {
    $btnCheckout.on("click", function () {
      if (!(currentAmount > 0 && currentMethod)) return;

      const proofEl = document.getElementById("proofUpload");
      const file =
        proofEl && proofEl.files && proofEl.files[0] ? proofEl.files[0] : null;

      const formData = new FormData();
      formData.append("action", "submitDonation");
      formData.append("amount", currentAmount);
      formData.append("payment_method", currentMethod);
      if (file) formData.append("proof", file);

      $btnCheckout.prop("disabled", true).text("Submitting...");

      $.ajax({
        url: "api.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (resp) {
          try {
            if (typeof resp === "string") resp = JSON.parse(resp);
          } catch (e) {}
          if (resp && resp.success) {
            $("#successModal").removeClass("hidden").addClass("flex");
            $("#donationModal").addClass("hidden").removeClass("flex");
            resetDonationForm();
          } else {
            alert(
              "Gagal mengirim donasi: " +
                (resp && resp.message ? resp.message : "Server error")
            );
          }
        },
        error: function () {
          alert("Gagal terhubung ke server saat mengirim donasi.");
        },
        complete: function () {
          $btnCheckout.prop("disabled", false).text("Submit Donation");
        },
      });
    });
  }

  $("#closeSuccessModal").on("click", function () {
    $("#successModal").addClass("hidden").removeClass("flex");
  });

  if ($donationSummary.length) {
    $donationSummary.text(formatRupiah(0));
  }

  let articlesData = [];

  function renderArticles(data) {
    const homeContainer = $("#home-articles-container");
    if (homeContainer.length) {
      homeContainer.empty();
      const homeData = data.slice(0, 2);

      homeData.forEach((article) => {
        const articleDate = formatDate(article.publish_date);
        const html = `
                        <article class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 h-full flex flex-col">
                            <div class="lg:flex h-full">
                                <img src="${article.image_url}" class="w-full lg:w-1/3 object-cover h-48 lg:h-auto" />
                                <div class="p-6 lg:w-2/3 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-xl headerTxt700 mb-2">${article.title}</h3>
                                    <p class="text-sm text-gray-500 mb-2">${articleDate}</p>
                                    <p class="bodyTxt text-gray-700">${article.teaser_content}</p> 
                                </div>
                                <a href="#" class="text-green font-bold read-more-article mt-2"
                                    data-title="${article.title}" 
                                    data-content="${article.content}" 
                                    data-image="${article.image_url}">Read More</a>
                                </div>
                            </div>
                        </article>`;
        homeContainer.append(html);
      });
    }

    const eduContainer = $("#education-articles-container");
    if (eduContainer.length) {
      eduContainer.empty();
      data.forEach((article, index) => {
        const hiddenClass = index >= 2 ? "hidden" : "";
        let badgeColorClass = "bg-gray-100 text-dark-blue";
        if (article.category === "Health") {
          badgeColorClass = "bg-soft-pink text-dark-blue";
        } else if (article.category === "Tips") {
          badgeColorClass = "bg-soft-blue text-dark-blue";
        }
        const articleDate = formatDate(article.publish_date);

        const html = `
                        <article class="article-item ${hiddenClass} bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                            <div class="lg:flex">
                            <img src="${article.image_url}" class="w-full lg:w-1/3 object-cover aspect-[4/3]" />
                            <div class="p-6 lg:w-2/3">
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <span class="mr-3">${articleDate}</span> • <span class="ml-2">By ${article.author}</span>
                                </div>
                                <h3 class="text-2xl text-left headerTxt700 mb-2">${article.title}</h3>
                                <p class="bodyTxt text-left text-gray-700 mb-4">${article.teaser_content}</p> 
                                <div class="flex items-center justify-between">
                                <div class="flex gap-2">
                                    <span class="px-3 py-1 rounded-full text-sm ${badgeColorClass} category-label font-medium">${article.category}</span>
                                </div>
                                <a href="#" class="btn-outline-green px-4 py-2 rounded-full read-more-article font-medium"
                                    data-title="${article.title}" 
                                    data-content="${article.content}" 
                                    data-image="${article.image_url}">
                                    Read More
                                </a>
                                </div>
                            </div>
                            </div>
                        </article>`;
        eduContainer.append(html);
      });
    }

    if (data.length > 2) {
      $("#loadMoreBtn").show();
    } else {
      $("#loadMoreBtn").hide();
    }
  }

  // --- LOAD DATA EDUKASI DARI API ---
  $.getJSON("api.php?action=getEducation", function (response) {
    if (response.success) {
      articlesData = response.data;
      renderArticles(articlesData);
    } else {
      console.error("Gagal memuat articles dari API.");
    }
  }).fail(function () {
    console.error("Gagal terhubung ke api.php (Education).");
  });

  // MODAL READ MORE
  $(document).on("click", ".read-more-article", function (e) {
    e.preventDefault();
    $("#articleModalTitle").text($(this).data("title"));
    $("#articleModalContent").html($(this).data("content"));
    $("#articleModalImage").attr("src", $(this).data("image"));
    $("#articleModal").removeClass("hidden").addClass("flex");
  });

  $("#articleClose").on("click", function () {
    $("#articleModal").addClass("hidden").removeClass("flex");
  });

  $("#articleModal").on("click", function (e) {
    if (e.target === this) $(this).addClass("hidden").removeClass("flex");
  });

  // SEARCH & FILTER
  function performSearch() {
    const value = $("#articleSearchInput").val().toLowerCase().trim();
    $(".article-item").each(function () {
      const text = $(this).text().toLowerCase();
      $(this).toggle(text.indexOf(value) > -1);
    });
    $("#loadMoreBtn").hide();
  }

  $("#articleSearchInput").on("input", performSearch);
  $("#articleSearchBtn").on("click", performSearch);

  // FILTER CATEGORY
  $(".category-filter").on("click", function (e) {
    e.preventDefault();
    const category = $(this).text().trim();

    $(".category-filter").removeClass(
      "shadow-md font-bold ring-2 ring-offset-2 ring-blue-500 ring-pink-500 ring-green-500"
    );

    if (category === "Show All") {
      $("#articleSearchInput").val("");
      $(".article-item").removeClass("hidden").show();
      renderArticles(articlesData);
    } else {
      $("#articleSearchInput").val("");

      $(this).addClass(
        "shadow-md font-bold ring-2 ring-offset-2 ring-blue-500"
      );

      $(".article-item").each(function () {
        const articleCategory = $(this).find(".category-label").text().trim();
        if (articleCategory === category) {
          $(this).removeClass("hidden").show();
        } else {
          $(this).addClass("hidden").hide();
        }
      });
      $("#loadMoreBtn").hide();
    }
  });

  $("#loadMoreBtn").on("click", function (e) {
    e.preventDefault();
    const $btn = $(this);

    if ($btn.text().trim() === "Load More") {
      const hiddenArticles = $(
        "#education-articles-container .article-item.hidden"
      );
      hiddenArticles.removeClass("hidden").hide().fadeIn("slow");
      $btn.text("View Less");
    } else {
      const articlesToHide = $(
        "#education-articles-container .article-item"
      ).slice(2);
      articlesToHide.fadeOut("fast", function () {
        $(this).addClass("hidden");
      });
      $("html, body").animate(
        { scrollTop: $("#educationPage").offset().top },
        500
      );
      $btn.text("Load More");
    }
  });

  $(document).on("click", function (e) {
    const $menu = $(".nav-links");
    const $icon = $('ion-icon[onclick="onToggleMenu(this)"]');

    if ($menu.hasClass("top-[9%]")) {
      if (
        !$menu.is(e.target) &&
        $menu.has(e.target).length === 0 &&
        !$icon.is(e.target)
      ) {
        $menu.removeClass("top-[9%]");
        $icon.attr("name", "menu");
      }
    }
  });
});

function onToggleMenu(e) {
  const navLinks = document.querySelector(".nav-links");
  navLinks.classList.toggle("top-[9%]");
  e.name = e.name === "menu" ? "close" : "menu";
}