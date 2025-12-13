<?php

include 'config.php';
check_session(); 

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WHISKEY</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Montserrat:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  </head>
  <body class=>
    <!---------- NAVBAR SECTION ----------->
    <nav class="top-0 left-0 w-full bg-white z-50 shadow">
      <div class="flex justify-between items-center w-[92%] mx-auto py-3">
        <!-- LOGO -->
        <div>
          <img class="w-32 cursor-pointer" src="img\Whiskey.png" alt="..." />
        </div>

        <!-- MENU BAR -->
        <div
          class="nav-links duration-500 md:static absolute bg-white md:min-h-fit min-h-[60vh] left-0 top-[-100%] md:w-auto w-full flex items-center px-5 z-20"
        >
          <ul
            class="flex md:flex-row flex-col md:items-center md:gap-[4vw] gap-8 font-semibold text-blue-800"
          >
            <li>
              <a role="button" class="hover:text-blue-300" id="homeNav">Home</a>
            </li>
            <li>
              <a role="button" class="hover:text-blue-300" id="aboutNav"
                >About Us</a
              >
            </li>
            <li>
              <a role="button" class="hover:text-blue-300" id="adoptNav"
                >Adoption</a
              >
            </li>
            <li>
              <a role="button" class="hover:text-blue-300" id="donateNav"
                >Donation</a
              >
            </li>
            <li>
              <a role="button" class="hover:text-blue-300" id="eduNav"
                >Education</a
              >
            </li>
            <li>
              <a href="logout.php" class="hover:text-red-500 font-bold"
                >Logout</a
              >
            </li>
          </ul>
        </div>
        <div class="flex items-center gap-6 md:hidden">
          <ion-icon
            onclick="onToggleMenu(this)"
            name="menu"
            class="text-3xl cursor-pointer text-blue-800"
          ></ion-icon>
        </div>
      </div>
    </nav>

    <!-- ---------- HEADER SECTION ---------- -->
    <section id="header">
      <header class="pt-16 lg:pt-0 px-4 lg:px-2 bg-soft-blue">
        <div
          class="flex flex-col lg:flex-row justify-center items-center w-full"
        >
          <div class="w-full lg:w-2/3 lg:mr-16 max-w-lg lg:ml-8">
            <img
              src="img/Whiskey.png"
              alt="Whiskey"
              class="h-16 lg:h-auto w-auto mx-auto lg:mx-0"
            />
            <h2 class="headerTxt400 text-xl lg:text-2xl lg:text-start mb-6">
              The Key To Every Cat’s Whisker
            </h2>
            <p
              class="bodyTxt lg:text-md max-w-sm mx-auto lg:max-w-full text-center lg:text-start mb-3"
            >
              Karena setiap kumis pantas punya tempat untuk bersandar dan
              bermain dengan damai.
            </p>

            <div class="flex justify-center lg:justify-start gap-3 pt-2">
              <a
                href="#donationPage"
                class="inline-block btn-green font-semibold px-6 py-2 rounded-full shadow-md"
              >
                Donate
              </a>
              <a
                href="#adoptionPage"
                class="inline-block btn-outline-green font-semibold px-6 py-2 rounded-full"
              >
                Adopt
              </a>
            </div>
          </div>

          <div
            class="mt-8 lg:mt-0 lg:px-0 flex justify-center lg:justify-end w-full h-full self-end lg:w-1/3"
          >
            <img
              src="img/header_cat.png"
              alt="Whiskey the cat"
              class="block w-full max-w-md mx-auto h-auto lg:w-auto lg:max-w-2xl object-cover"
              class="block mx-auto h-auto lg:h-full lg:w-auto object-cover"
            />
          </div>
        </div>
      </header>
    </section>

    <!--ABOUT US SECTION-->
    <section class="pt-16 px-8 lg:px-2" id="aboutUsPage">
      <h1 class="headerTxt700 text-4xl text-center mt-6 mb-8">About Us</h1>
      <div
        class="flex flex-col lg:flex-row justify-center items-center w-full mb-16"
      >
        <div class="w-full lg:w-1/2 lg:mr-12 max-w-lg lg:ml-8 mb-6 lg:mb-0">
          <img
            src="img/about1.png"
            alt="Whiskey the cat"
            class="block w-full max-w-sm mx-auto h-auto lg:w-auto object-cover"
          />
        </div>
        <div class="w-full lg:w-1/2 lg:mr-16 max-w-lg">
          <h3
            class="subheaderTxt text-center lg:text-end text-2xl mb-4 font-bold"
          >
            Our Story
          </h3>
          <p
            class="bodyTxt lg:mx-0 Lg:text-end text-center text-sm lg:text-end leading-relaxed font-normal text-black"
          >
            Whiskey adalah sebuah inisiatif penyelamatan dan perawatan kucing
            terlantar yang lahir dari kepedulian seorang guru SMP bernama Bu
            Widen. Berawal dari niat sederhana untuk memberi makan kucing
            jalanan di sekitar rumah, Whiskey tumbuh menjadi wadah yang berfokus
            pada penyelamatan, perawatan, serta penyaluran kucing-kucing yang
            membutuhkan rumah baru penuh kasih. Sejak masa pandemi, kegiatan
            kecil ini berkembang pesat. Dengan waktu luang yang lebih banyak, Bu
            Widen mulai merawat kucing yang sakit, terluka, dan ditelantarkan.
            Dari sana, lahir sebuah komitmen berkelanjutan untuk memberikan
            kehidupan yang lebih baik bagi kucing-kucing tanpa tempat
            berlindung. Hingga kini, Whiskey telah merawat ratusan kucing dan
            terus berkembang menjadi jembatan antara para penyayang hewan, calon
            adopter, dan para donatur yang ingin berbuat kebaikan.
          </p>
        </div>
      </div>
      <div
        class="flex flex-col-reverse lg:flex-row justify-center items-center w-full mb-16"
      >
        <div class="w-full lg:w-1/2 lg:mr-12 max-w-lg lg:ml-8 mb-6 lg:mb-0">
          <h3
            class="subheaderTxt text-center lg:text-start text-2xl mb-4 font-bold text-green"
          >
            Visi
          </h3>
          <div
            class="bodyTxt lg:mx-0 Lg:text-end text-center text-sm lg:text-start leading-relaxed font-normal text-black"
          >
            <p>
              Menjadi wadah penyelamatan dan perawatan kucing yang penuh kasih
              dan terpercaya serta menjadi tempat dimana setiap kucing memiliki
              kesempatan untuk hidup sehat, aman, dan dicintai.
            </p>
          </div>
        </div>
        <div class="w-full lg:w-1/2 lg:mr-8 max-w-lg mb-6 lg:mb-0">
          <img
            src="img/about2.png"
            alt="Whiskey the cat"
            class="block w-full max-w-2xl mx-auto h-auto lg:max-w-lg object-cover"
          />
        </div>
      </div>
      <div
        class="flex flex-col lg:flex-row justify-center items-center w-full mb-16"
      >
        <div class="w-full lg:w-1/2 lg:mr-12 max-w-xl lg:ml-8 mb-6 lg:mb-0">
          <img
            src="img/about3.png"
            alt="Whiskey the cat"
            class="block w-full max-w-lg mx-auto h-auto lg:max-w-lg object-cover"
          />
        </div>
        <div class="w-full lg:w-1/2 lg:mr-16 max-w-lg">
          <h3
            class="subheaderTxt text-center lg:text-end text-2xl mb-4 font-bold text-yellow"
          >
            Misi
          </h3>
          <div
            class="bodyTxt lg:mx-0 Lg:text-end text-center text-sm lg:text-end leading-relaxed font-normal text-black"
          >
            <ul class="list-disc list-inside">
              <li>
                Menyelamatkan dan merawat kucing yang terluka dan ditelantarkan
                agar dapat hidup lebih layak.
              </li>
              <li>
                Menyalurkan kucing yang siap diadopsi kepada keluarga baru yang
                penuh kasih.
              </li>
              <li>
                Mengedukasi masyarakat tentang pentingnya kasih sayang, tanggung
                jawab, dan sterilisasi hewan peliharaan.
              </li>
              <li>
                Mengajak masyarakat untuk berdonasi dan berpartisipasi aktif
                dalam hal membantu biaya perawatan dan kebutuhan sehari-hari
                kucing.
              </li>
              <li>
                Mendorong perubahan positif terhadap cara pandang masyarakat
                terhadap hewan jalanan berhak dihargai dan dicintai.
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!--ABOUT US ENDS-->

    <!-- ---------- ADOPTION SECTION ---------- -->
    <section
      id="adoptionPage"
      class="bg-super-soft-blue w-full py-16 px-6 lg:px-12"
    >
      <div class="max-w-6xl mx-auto">
        <div class="flex justify-center items-center mb-10">
          <div class="flex-1 flex justify-end">
            <img src="img/pawLeft.png" alt="paw" class="w-16 opacity-80" />
          </div>

          <div class="flex flex-col items-center text-center mx-6">
            <h2 class="headerTxt700 text-4xl md:text-5xl mb-2">
              Adoption Page
            </h2>
            <h3 class="headerTxt400 text-2xl -mt-1">Provide a Home for Them</h3>
          </div>

          <div class="flex-1 flex justify-start">
            <img src="img/pawRight.png" alt="paw" class="w-16 opacity-80" />
          </div>
        </div>

        <div class="flex justify-center gap-4 mb-10 text-sm md:text-lg">
          <button
            class="filter-btn btn-green px-6 py-2 rounded-full border-2 border-[var(--green)] font-medium transition"
            data-filter="all"
          >
            All Cats
          </button>
          <button
            class="filter-btn btn-outline-green px-6 py-2 rounded-full border-2 border-[var(--green)] font-medium transition"
            data-filter="male"
          >
            Male
          </button>
          <button
            class="filter-btn btn-outline-green px-6 py-2 rounded-full border-2 border-[var(--green)] font-medium transition"
            data-filter="female"
          >
            Female
          </button>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8"></div>
      </div>
    </section>
    <!-- ---------- ADOPTION ENDS ---------- -->

    <!-- ---------- DONATION SECTION ---------- -->

    <section id="donationPage">
      <section
        id="donationPageHero"
        class="pt-16 lg:pt-0 hero-whiskey-style bg-soft-blue lg:min-h-[550px]"
      >
        <div
          class="flex flex-col lg:flex-row justify-center items-center w-full h-full lg:h-[550px]"
        >
          <div
            class="w-full lg:w-1/2 z-10 text-center lg:text-left py-12 lg:py-0 flex justify-center lg:justify-end"
          >
            <div class="max-w-lg lg:mr-16 px-6 lg:px-0 pb-12 lg:pb-0">
              <h1 class="text-6xl mb-2 headerTxt700 title-whiskey">Help Us Save More Cats</h1>
              <h2 class="subheaderTxt font-semibold lg:text-2xl mb-4">
                Setiap Hari Ada Kumis yang Butuh Uluran Tanganmu
              </h2>
              <p class="bodyTxt lg:text-md max-w-sm mx-auto lg:max-w-full mb-8">
                Di Whiskey Shelter, kami menyelamatkan kucing jalanan yang
                kehilangan tempat tinggal, memberi makan, perawatan, dan kasih
                sayang. Dengan donasimu, kamu membantu mereka mendapatkan rumah
                dan harapan baru.
              </p>
              <div class="flex justify-center lg:justify-start gap-4 pt-2">
                <button
                  id="donate_btnDonateHero"
                  class="btn-green font-semibold px-6 py-2 rounded-full shadow-lg"
                >
                  Make a Donation
                </button>
                <button
                  id="scrollToContact"
                  class="btn-outline-green font-semibold px-6 py-2 rounded-full"
                >
                  Contact Us
                </button>

              </div>
            </div>
          </div>

          <div
            class="w-full lg:w-1/2 h-[400px] lg:h-full bg-cover bg-center"
            style="background-image: url('img/poorcat.jpg')"
          ></div>
        </div>
      </section>

      <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6 text-center">
          <h2 class="headerTxt700 text-3xl mb-6 text-dark-blue">
            Dampak Nyata dari Setiap Donasimu 🐾
          </h2>
          <p class="bodyTxt text-lg mb-12 max-w-2xl mx-auto">
            Bersama para donatur, Whiskey Shelter telah membantu ratusan kucing
            jalanan mendapatkan makanan, tempat tinggal, dan kasih sayang yang
            layak.
          </p>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Card 1 -->
            <div
              class="bg-soft-pink p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300"
            >
              <h3 class="headerTxt700 text-5xl mb-2 text-dark-blue">200+</h3>
              <p class="subheaderTxt font-semibold text-xl lg:text-2xl mb-4">
                Kucing Diselamatkan
              </p>
              <p class="bodyTxt lg:text-md max-w-sm mx-auto lg:max-w-full mb-8">
                Kucing terlantar kini mendapatkan rumah baru dan perawatan penuh
                cinta.
              </p>
            </div>
            <!-- Card 2 -->
            <div
              class="bg-soft-blue p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300"
            >
              <h3 class="headerTxt700 text-5xl mb-2 text-dark-blue">3.000+</h3>
              <p class="subheaderTxt font-semibold text-xl lg:text-2xl mb-4">
                Porsi Makanan Tiap Bulan
              </p>
              <p class="bodyTxt lg:text-md max-w-sm mx-auto lg:max-w-full mb-8">
                Setiap rupiah donasimu membantu menyediakan makanan bergizi
                untuk para kucing shelter.
              </p>
            </div>
            <!-- Card 3 -->
            <div
              class="bg-soft-yellow p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300"
            >
              <h3 class="headerTxt700 text-5xl mb-2 text-dark-blue">20+</h3>
              <p class="subheaderTxt font-semibold text-xl lg:text-2xl mb-4">
                Shelter Aktif
              </p>
              <p class="bodyTxt lg:text-md max-w-sm mx-auto lg:max-w-full mb-8">
                Kami bermitra dengan puluhan tempat penampungan di berbagai kota
                untuk membantu lebih banyak kucing.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- DONATION FORM SECTION  -->
      <div id="donationModal"
      class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">

      <div class="bg-white p-8 rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl relative">

        <button id="closeDonationModal"
          class="absolute top-4 right-4 text-black hover:text-red-500 text-3xl">
          ×
        </button>

      <div class="max-w-3xl mx-auto px-4 text-center">
          <h2 class="headerTxt700 text-3xl mb-4">Dukung Misi Kami</h2>
          <p class="bodyTxt text-lg mb-8">
            Pilih jumlah donasi Anda di bawah atau masukkan jumlah kustom.
            Setiap rupiah sangat berharga untuk makanan, perawatan medis, dan
            tempat tinggal.
          </p>

          <!-- Pilihan Nominal Donasi -->
          <div
            class="flex flex-wrap justify-center gap-4 mb-8"
            id="donate_donationOptions"
          >
            <button
              data-amount="100000"
              class="option-btn btn-outline-green border-2 px-6 py-3 rounded-full font-semibold text-lg hover:shadow-lg transition duration-300"
            >
              Rp 100.000
            </button>
            <button
              data-amount="200000"
              class="option-btn btn-outline-green border-2 px-6 py-3 rounded-full font-semibold text-lg hover:shadow-lg transition duration-300"
            >
              Rp 200.000
            </button>
            <button
              data-amount="500000"
              class="option-btn btn-outline-green border-2 px-6 py-3 rounded-full font-semibold text-lg hover:shadow-lg transition duration-300"
            >
              Rp 500.000
            </button>
          </div>

          <!-- Input Jumlah Kustom  -->
          <div class="mb-8">
            <label for="donate_customAmount" class="bodyTxt block text-lg mb-2"
              >Atau masukkan jumlah kustom:</label
            >
            <input
              type="text"
              id="donate_customAmount"
              placeholder="Contoh: 75000"
              min="10000"
              class="w-full max-w-sm p-3 border-2 border-gray-300 rounded-lg text-xl text-center focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 transition duration-150"
            />
          </div>

          <!-- Ringkasan & Metode Pembayaran  -->
          <div
            class="bg-white p-6 rounded-xl shadow-2xl border border-gray-200"
          >
            <h3 class="headerTxt400 text-2xl mb-4">Total Donasi Anda:</h3>
            <p
              class="headerTxt700 text-4xl mb-6 text-green"
              id="donate_donationSummary"
            >
              Rp 0
            </p>

            <h3 class="headerTxt400 text-xl mb-4">Pilih Metode Pembayaran:</h3>
            <div
              class="flex justify-center gap-4 flex-wrap"
              id="donate_paymentButtonsContainer"
            >
              <button
                class="donate-payment-btn btn-outline-green border px-4 py-2 rounded-lg"
                data-method="1234567890 (BCA)"
              >
                BCA
              </button>
              <button
                class="donate-payment-btn btn-outline-green border px-4 py-2 rounded-lg"
                data-method="1234567890 (Mandiri)"
              >
                Mandiri
              </button>
              <button
                class="donate-payment-btn btn-outline-green border px-4 py-2 rounded-lg"
                data-method="081234567890 (OVO/Gopay)"
              >
                OVO/Gopay
              </button>
            </div>
            <p
              id="donate_paymentMethodSummary"
              class="bodyTxt mt-4 text-gray-600"
            >
              No Rekening: -
            </p>

          <!-- Upload Bukti Pembayaran -->
          <div class="mt-8 text-center">
          <label class="headerTxt400 text-xl mb-3 block">
            Upload Bukti Pembayaran
          </label>

          <div class="flex justify-center">
            <div class="file-wrapper">
              <span class="file-button">Choose File</span>
              <input 
                type="file" 
                id="proofUpload" 
                class="file-input-custom"
                accept="image/*,application/pdf"
              />
            </div>
          </div>
            <p id="uploadedFileName" class="mt-3 text-sm text-gray-700"></p>
            <button
              id="donate_btnCheckoutFinal"
              class="btn-green font-bold px-8 py-3 rounded-full mt-8 w-full transition duration-300"
              disabled
            >
              Submit Donation
            </button>
          </div>
        </div>
      </section>
    </section>

    <!-- SUCCESS MODAL -->
    <div id="successModal"
      class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">

      <div class="bg-white p-8 rounded-2xl shadow-2xl text-center max-w-md w-full relative">

        <h2 class="headerTxt700 text-2xl mb-4">Pembayaran Berhasil!</h2>
        <p class="bodyTxt mb-6">
          Terima kasih atas donasi Anda. Bantuan Anda sangat berarti bagi para kucing.
        </p>

        <button id="closeSuccessModal"
          class="btn-green px-6 py-3 rounded-full font-bold">
          Tutup
        </button>

      </div>
    </div>

    <!-- ---------- DONATION SECTION ENDS ---------- -->

    <!-- EDU HOME STARTS -->
    <section id="homeArticles" class="py-16 px-6 bg-white">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-10">
          <h2 class="headerTxt700 text-3xl text-dark-blue">Latest Articles</h2>
          <p class="bodyTxt text-gray-600">Pelajari cara merawat kucing kesayanganmu.</p>
        </div>

        <div id="home-articles-container" class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10"></div>

        <div class="text-center">
          <button id="btnGoToEducation" class="btn-outline-green px-8 py-3 rounded-full font-bold text-lg shadow-md hover:shadow-lg transition">
            View All Articles
          </button>
        </div>
      </div>
    </section>
    <!-- EDU HOME ENDS -->

    <!-- ---------- EDUCATION SECTION STARTS ---------- -->
    <section id="educationPage" class="py-16 bg-soft-pink pt-10 pb-24">
      <div class="max-w-6xl mx-auto px-6">
        
        <div class="flex flex-col items-center text-center mx-6 mb-12">
          <h2 class="headerTxt700 text-4xl md:text-5xl mb-2">
            Education Page
          </h2>
          <h3 class="headerTxt400 text-2xl -mt-1">
            Knowledge & Care for Every Cat
          </h3>
        </div>

        <div class="flex flex-col-reverse lg:grid lg:grid-cols-3 gap-8">
          <div class="lg:col-span-2 space-y-8">
            <div id="education-articles-container" class="space-y-8"></div>
            <div class="text-center mt-4">
              <button id="loadMoreBtn" class="btn-green px-6 py-2 rounded-full font-semibold shadow-md hover:shadow-lg transition">
                Load More
              </button>
            </div>
          </div>

          <aside class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-lg">
              <h4 class="bodyTxt text-xl mb-4 font-semibold">Search Articles</h4>
              <div class="flex gap-2">
                <input
                  type="search"
                  id="articleSearchInput"
                  placeholder="Search..."
                  class="w-full p-3 border-2 border-gray-200 rounded-lg focus:border-green focus:ring-green outline-none transition"
                />
                <button id="articleSearchBtn" class="btn-green px-4 py-2 rounded-lg font-bold">Go</button>
              </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-lg">
              <h4 class="bodyTxt text-xl mb-4 font-semibold">Categories</h4>
              <div class="grid grid-cols-2 gap-3 text-sm"> 
                <a href="#" class="category-filter bg-soft-blue text-dark-blue text-center hover:opacity-80 px-3 py-2 rounded-full transition">Tips</a>
                <a href="#" class="category-filter bg-soft-pink text-dark-blue text-center hover:opacity-80 px-3 py-2 rounded-full transition">Health</a>
                <a href="#" class="category-filter bg-gray-100 text-dark-blue text-center hover:opacity-80 px-3 py-2 rounded-full transition">Behavior</a>
                <a href="#" class="category-filter text-red-500 hover:text-red-700 font-bold text-center transition px-3 py-2 rounded-full">Show All</a>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </section>
    <!-- ---------- EDUCATION SECTION ENDS ---------- -->

    <!-- ---------- FOOTER ---------- -->
    <footer class="pt-6 pb-8 px-6" id="contact">
      <div class="flex justify-center w-full">
        <div class="w-full max-w-md flex flex-col items-center text-center">
          <img src="img/Whiskey.png" alt="whiskeylogo" class="h-10 mb-4" />
          <h2 class="headerTxt400 text-xl lg:text-2xl mb-6">Contact Us</h2>

          <div class="flex flex-col space-y-4">
            <div class="flex items-center justify-center space-x-3">
              <img src="img/PersonICon.png" alt="person" class="w-7 h-7" />
              <p class="bodyTxt text-md">+6282131013107 (Bu Widen)</p>
            </div>

            <div class="flex items-center justify-center space-x-3">
              <img
                src="img/InstagramIcon.png"
                alt="instagram"
                class="w-7 h-7"
              />
              <p class="bodyTxt text-md">@whiskey2310</p>
            </div>

            <div class="flex items-start justify-center space-x-3">
              <img src="img/LocationIcon.png" alt="loc" class="w-7 h-7 mt-1" />
              <p class="bodyTxt text-md leading-snug max-w-xs">
                Jl. Kutisari Indah Selatan IV/23<br />
                Surabaya, East Java 60291, Indonesia
              </p>
            </div>
          </div>
          <div>
            <p class="text-center text-sm text-gray-500 mt-10">
              © 2025 Whiskey. All Rights Reserved.
            </p>
          </div>
        </div>
      </div>
    </footer>
    <!-- ---------- FOOTER ENDS ---------- -->

    <!-- ---------- MODAL START ---------- -->
    <div
      id="catDetailModal"
      class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden items-center justify-center z-[100] transition-opacity duration-300"
    >
      <div
        class="bg-white rounded-2xl p-8 max-w-lg w-full m-4 shadow-2xl transform transition-transform duration-300 scale-95"
      >
        <div class="flex justify-between items-start mb-4">
          <h3
            id="modalCatName"
            class="headerTxt700 text-3xl text-[var(--dark-blue)]"
          ></h3>
          <button
            class="close-modal-btn text-gray-500 hover:text-gray-700 text-3xl leading-none"
            data-modal="catDetailModal"
          >
            &times;
          </button>
        </div>
        <div class="mb-6">
          <p class="text-gray-600 mb-2">
            <span class="font-semibold">Age:</span>
            <span id="modalCatAge"></span> |
            <span class="font-semibold">Gender:</span>
            <span id="modalCatGender"></span>
          </p>
          <p class="text-gray-700 mt-4">
            <span class="font-semibold text-lg block mb-1">Backstory:</span>
            <span id="modalCatBackstory" class="bodyTxt leading-relaxed"></span>
          </p>
        </div>
        <div class="flex justify-end space-x-3">
          <button
            id="openAdoptionFormBtn"
            class="btn-green px-6 py-2 rounded-full font-medium"
          >
            Adopt Me!
          </button>
        </div>
      </div>
    </div>

    <div
      id="adoptionFormModal"
      class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden items-center justify-center z-[100] transition-opacity duration-300"
    >
      <div
        class="bg-white rounded-2xl p-8 max-w-xl w-full m-4 shadow-2xl transform transition-transform duration-300 scale-95"
      >
        <div class="flex justify-between items-start mb-6">
          <h3 class="headerTxt700 text-3xl text-[var(--dark-blue)]">
            Adoption Request Form
          </h3>
          <button
            class="close-modal-btn text-gray-500 hover:text-gray-700 text-3xl leading-none"
            data-modal="adoptionFormModal"
          >
            &times;
          </button>
        </div>
        <form id="adoptionForm" class="bodyTxt">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
              <label
                for="firstName"
                class="block text-sm font-medium text-gray-700"
                >First Name</label
              >
              <input
                type="text"
                id="firstName"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-green focus:ring-green"
              />
            </div>
            <div>
              <label
                for="lastName"
                class="block text-sm font-medium text-gray-700"
                >Last Name</label
              >
              <input
                type="text"
                id="lastName"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-green focus:ring-green"
              />
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700"
                >Email</label
              >
              <input
                type="email"
                id="email"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-green focus:ring-green"
              />
            </div>
            <div>
              <label for="phone" class="block text-sm font-medium text-gray-700"
                >Phone Number</label
              >
              <input
                type="tel"
                id="phone"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-green focus:ring-green"
              />
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
              <label for="city" class="block text-sm font-medium text-gray-700"
                >City</label
              >
              <input
                type="text"
                id="city"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-green focus:ring-green"
              />
            </div>
            <div>
              <label
                for="postalCode"
                class="block text-sm font-medium text-gray-700"
                >Postal Code</label
              >
              <input
                type="text"
                id="postalCode"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-green focus:ring-green"
              />
            </div>
          </div>
          <div class="mb-6">
            <label
              for="residenceType"
              class="block text-sm font-medium text-gray-700"
              >Where do you live?</label
            >
            <select
              id="residenceType"
              required
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-green focus:ring-green"
            >
              <option value="">Select an option</option>
              <option value="apartment">Apartment</option>
              <option value="house">House</option>
            </select>
          </div>
          <div class="flex justify-end">
            <button
              type="submit"
              class="btn-green px-6 py-2 rounded-full font-medium"
            >
              Submit Adoption Request
            </button>
          </div>
        </form>
      </div>
    </div>

    <div id="adoptionSuccessModal"
      class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">

      <div class="bg-white p-8 rounded-2xl shadow-2xl text-center max-w-md w-full relative">

        <h2 class="headerTxt700 text-2xl mb-4">Pengajuan Adopsi Berhasil!</h2>
        <p class="bodyTxt mb-6">
          Terima kasih atas pengajuan adopsi Anda. Kami akan menghubungi Anda segera.
        </p>

        <button id="closeSuccessModal"
          class="btn-green px-6 py-3 rounded-full font-bold">
          Tutup
        </button>

      </div>
    </div>

    <!-- MODAL ARTICLE -->
    <div id="articleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-[200]">
      <div class="bg-white w-11/12 md:w-2/3 lg:w-1/2 p-6 rounded-2xl shadow-xl relative max-h-[90vh] overflow-y-auto flex flex-col items-center">
        <button id="articleClose" class="absolute top-3 right-3 text-2xl hover:text-red-500 transition">&times;</button>
        <img id="articleModalImage" src="" class="w-full max-h-64 object-contain rounded-lg mb-4"/>
        <h2 id="articleModalTitle" class="headerTxt700 text-2xl mb-3 text-center"></h2>
        <p id="articleModalContent" class="bodyTxt text-gray-700 leading-relaxed text-left"></p>
      </div>
    </div>  
    <!--  MODAL ARTICLE ENDS -->
     <script src="script.js"></script>
  </body>
</html>