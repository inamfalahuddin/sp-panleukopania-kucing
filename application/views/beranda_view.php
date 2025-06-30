<section id="hero" class="hero section light-background">

    <img src="<?= base_url('assets/templates/Medilab'); ?>/assets/img/hero-bg.jpg" alt="Latar belakang kucing" data-aos="fade-in">

    <div class="container position-relative">

        <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
            <h2>SISTEM PAKAR DIAGNOSA PANLEUKOPENIA KUCING</h2>
            <p>Solusi Cerdas untuk Mendiagnosis Penyakit Panleukopenia pada Kucing Kesayangan Anda</p>
        </div>
        <div class="content row gy-4">
            <div class="col-lg-4 d-flex align-items-stretch">
                <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
                    <h3>Kenapa Menggunakan Sistem Ini?</h3>
                    <p>
                        Sistem pakar ini dirancang untuk memberikan diagnosis awal penyakit Panleukopenia pada kucing berdasarkan gejala yang ada. Dengan menggunakan metode Naive Bayes, sistem ini mampu memberikan probabilitas kemungkinan penyakit secara cepat dan akurat, membantu Anda mengambil langkah penanganan lebih awal.
                    </p>
                    <div class="text-center">
                        <a href="#about" class="more-btn"><span>Mulai Diagnosa</span> <i class="bi bi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 d-flex align-items-stretch">
                <div class="d-flex flex-column justify-content-center">
                    <div class="row gy-4">

                        <div class="col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                                <i class="bi bi-clipboard-data"></i>
                                <h4>Diagnosis Akurat</h4>
                                <p>Hasil diagnosis dihitung berdasarkan metode klasifikasi Naive Bayes yang telah teruji dalam analisis probabilitas.</p>
                            </div>
                        </div>
                        <div class="col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                                <i class="bi bi-gem"></i>
                                <h4>Basis Pengetahuan Pakar</h4>
                                <p>Gejala dan kaidah diagnosis dalam sistem ini disusun berdasarkan pengetahuan dari dokter hewan berpengalaman.</p>
                            </div>
                        </div>
                        <div class="col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
                                <i class="bi bi-inboxes"></i>
                                <h4>Hasil Cepat & Informatif</h4>
                                <p>Dapatkan hasil diagnosis beserta tingkat kepercayaan (probabilitas) secara instan setelah memasukkan gejala.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<section id="departments" class="departments section">

    <div class="container section-title" data-aos="fade-up">
        <h2>Informasi Penyakit & Metode</h2>
        <p>Pahami lebih dalam mengenai Panleukopenia, gejala, pencegahan, serta metode yang digunakan dalam sistem ini.</p>
    </div>
    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
            <div class="col-lg-3">
                <ul class="nav nav-tabs flex-column">
                    <li class="nav-item">
                        <a class="nav-link active show" data-bs-toggle="tab" href="#departments-tab-1">Tentang Panleukopenia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-2">Gejala Umum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-3">Penyebab & Penularan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-4">Pencegahan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-5">Metode Naive Bayes</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-9 mt-4 mt-lg-0">
                <div class="tab-content">
                    <div class="tab-pane active show" id="departments-tab-1">
                        <div class="row">
                            <div class="col-lg-8 details order-2 order-lg-1">
                                <h3>Tentang Panleukopenia</h3>
                                <p class="fst-italic">Feline Panleukopenia adalah penyakit virus yang sangat menular dan seringkali fatal pada kucing.</p>
                                <p>Penyakit ini disebabkan oleh Feline Parvovirus (FPV) dan menyerang sel-sel yang membelah dengan cepat di dalam tubuh, seperti yang ada di sumsum tulang, usus, dan pada janin yang sedang berkembang. Penyakit ini juga dikenal sebagai distemper kucing.</p>
                            </div>
                            <div class="col-lg-4 text-center order-1 order-lg-2">
                                <img src="<?= base_url('assets/templates/Medilab'); ?>/assets/img/departments-1.jpg" alt="Kucing Sakit" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="departments-tab-2">
                        <div class="row">
                            <div class="col-lg-8 details order-2 order-lg-1">
                                <h3>Gejala Umum Panleukopenia</h3>
                                <p class="fst-italic">Gejala dapat muncul secara tiba-tiba dan parah. Beberapa gejala yang paling umum meliputi:</p>
                                <p>Lesu dan depresi, demam tinggi, kehilangan nafsu makan, muntah-muntah (seringkali berwarna kuning), diare (bisa disertai darah), dehidrasi, dan rasa sakit pada bagian perut. Kucing mungkin akan sering duduk di dekat mangkuk airnya tetapi tidak minum.</p>
                            </div>
                            <div class="col-lg-4 text-center order-1 order-lg-2">
                                <img src="<?= base_url('assets/templates/Medilab'); ?>/assets/img/departments-2.jpg" alt="Gejala Penyakit Kucing" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="departments-tab-3">
                        <div class="row">
                            <div class="col-lg-8 details order-2 order-lg-1">
                                <h3>Penyebab & Cara Penularan</h3>
                                <p class="fst-italic">Virus FPV sangat kuat dan dapat bertahan di lingkungan selama satu tahun atau lebih.</p>
                                <p>Penularan terjadi melalui kontak dengan feses, urin, atau cairan tubuh lain dari kucing yang terinfeksi. Virus juga dapat menempel pada benda-benda seperti mangkuk makanan, kandang, pakaian, dan tangan manusia, yang kemudian dapat menulari kucing lain.</p>
                            </div>
                            <div class="col-lg-4 text-center order-1 order-lg-2">
                                <img src="<?= base_url('assets/templates/Medilab'); ?>/assets/img/departments-3.jpg" alt="Penularan Virus" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="departments-tab-4">
                        <div class="row">
                            <div class="col-lg-8 details order-2 order-lg-1">
                                <h3>Pencegahan Terbaik</h3>
                                <p class="fst-italic">Vaksinasi adalah cara paling efektif untuk melindungi kucing dari Panleukopenia.</p>
                                <p>Anak kucing harus mendapatkan seri vaksinasi awal, dan kucing dewasa memerlukan booster secara teratur sesuai anjuran dokter hewan. Menjaga kebersihan lingkungan, kandang, dan peralatan makan juga sangat penting untuk mencegah penyebaran virus.</p>
                            </div>
                            <div class="col-lg-4 text-center order-1 order-lg-2">
                                <img src="<?= base_url('assets/templates/Medilab'); ?>/assets/img/departments-4.jpg" alt="Vaksinasi Kucing" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="departments-tab-5">
                        <div class="row">
                            <div class="col-lg-8 details order-2 order-lg-1">
                                <h3>Metode Naive Bayes Classifier</h3>
                                <p class="fst-italic">Sistem ini menggunakan algoritma klasifikasi berdasarkan Teorema Bayes.</p>
                                <p>Naive Bayes bekerja dengan menghitung probabilitas (kemungkinan) seekor kucing menderita Panleukopenia berdasarkan kombinasi gejala yang dimasukkan. Meskipun asumsinya "naif" (menganggap setiap gejala independen), metode ini sangat cepat, efisien, dan terbukti efektif untuk masalah klasifikasi seperti diagnosis medis.</p>
                            </div>
                            <div class="col-lg-4 text-center order-1 order-lg-2">
                                <img src="<?= base_url('assets/templates/Medilab'); ?>/assets/img/departments-5.jpg" alt="Algoritma Komputer" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>
<section id="doctors" class="doctors section">

    <div class="container section-title" data-aos="fade-up">
        <h2>Tim Pengembang & Pakar</h2>
        <p>Sistem ini dikembangkan oleh tim yang berdedikasi dengan bimbingan dari pakar di bidangnya.</p>
    </div>
    <div class="container">

        <div class="row gy-4">

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="team-member d-flex align-items-start">
                    <div class="pic"><img src="<?= base_url('assets/templates/Medilab'); ?>/assets/img/doctors/doctors-1.jpg" class="img-fluid" alt=""></div>
                    <div class="member-info">
                        <h4>(Nama Pengembang 1)</h4>
                        <span>Project Manager</span>
                        <p>Bertanggung jawab atas perencanaan, eksekusi, dan keberhasilan proyek sistem pakar ini.</p>
                        <div class="social">
                            <a href=""><i class="bi bi-twitter-x"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""> <i class="bi bi-linkedin"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="team-member d-flex align-items-start">
                    <div class="pic"><img src="<?= base_url('assets/templates/Medilab'); ?>/assets/img/doctors/doctors-2.jpg" class="img-fluid" alt=""></div>
                    <div class="member-info">
                        <h4>(Nama Pengembang 2)</h4>
                        <span>System Analyst & AI Specialist</span>
                        <p>Merancang alur sistem dan mengimplementasikan algoritma Naive Bayes untuk mesin diagnosis.</p>
                        <div class="social">
                            <a href=""><i class="bi bi-twitter-x"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""> <i class="bi bi-linkedin"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                <div class="team-member d-flex align-items-start">
                    <div class="pic"><img src="<?= base_url('assets/templates/Medilab'); ?>/assets/img/doctors/doctors-3.jpg" class="img-fluid" alt=""></div>
                    <div class="member-info">
                        <h4>drh. (Nama Dokter Hewan)</h4>
                        <span>Pakar & Konsultan Veteriner</span>
                        <p>Menyediakan basis pengetahuan (gejala, aturan, bobot) yang menjadi dasar logika sistem pakar.</p>
                        <div class="social">
                            <a href=""><i class="bi bi-twitter-x"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""> <i class="bi bi-linkedin"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                <div class="team-member d-flex align-items-start">
                    <div class="pic"><img src="<?= base_url('assets/templates/Medilab'); ?>/assets/img/doctors/doctors-4.jpg" class="img-fluid" alt=""></div>
                    <div class="member-info">
                        <h4>(Nama Pengembang 3)</h4>
                        <span>UI/UX Designer</span>
                        <p>Mendesain antarmuka pengguna yang intuitif dan mudah digunakan oleh para pemilik kucing.</p>
                        <div class="social">
                            <a href=""><i class="bi bi-twitter-x"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""> <i class="bi bi-linkedin"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>
<section id="faq" class="faq section light-background">

    <div class="container section-title" data-aos="fade-up">
        <h2>Pertanyaan yang Sering Diajukan (FAQ)</h2>
        <p>Temukan jawaban atas pertanyaan umum mengenai sistem pakar dan penyakit Panleukopenia.</p>
    </div>
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

                <div class="faq-container">

                    <div class="faq-item faq-active">
                        <h3>Apakah sistem ini bisa menggantikan peran dokter hewan?</h3>
                        <div class="faq-content">
                            <p>Tentu saja tidak. Sistem ini dirancang sebagai alat bantu diagnosis awal. Hasil dari sistem ini tidak menggantikan konsultasi, diagnosis, dan penanganan profesional oleh dokter hewan. Jika kucing Anda sakit, segera bawa ke dokter hewan.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>
                    <div class="faq-item">
                        <h3>Seberapa akurat hasil dari sistem ini?</h3>
                        <div class="faq-content">
                            <p>Akurasi sistem bergantung pada kelengkapan dan keakuratan data gejala yang Anda masukkan, serta kualitas basis pengetahuan yang ditanamkan. Sistem akan memberikan hasil berupa probabilitas (kemungkinan) yang dihitung oleh algoritma Naive Bayes.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>
                    <div class="faq-item">
                        <h3>Apakah saya perlu membayar untuk menggunakan sistem ini?</h3>
                        <div class="faq-content">
                            <p>Tidak, sistem pakar ini disediakan secara gratis untuk membantu para pemilik kucing mendapatkan informasi dan diagnosis awal mengenai penyakit Panleukopenia.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>
                    <div class="faq-item">
                        <h3>Apa yang harus saya lakukan jika hasilnya menunjukkan probabilitas tinggi?</h3>
                        <div class="faq-content">
                            <p>Jika sistem menunjukkan kemungkinan tinggi kucing Anda menderita Panleukopenia, jangan panik. Segera isolasi kucing Anda dari kucing lain dan secepatnya bawa ke klinik hewan terdekat untuk pemeriksaan dan penanganan lebih lanjut.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>
                    <div class="faq-item">
                        <h3>Apakah semua kucing bisa terkena Panleukopenia?</h3>
                        <div class="faq-content">
                            <p>Semua kucing, terutama anak kucing dan kucing yang belum divaksin, sangat rentan terhadap penyakit ini. Kucing dewasa yang memiliki sistem imun kuat dan telah divaksin memiliki risiko yang jauh lebih rendah.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>
                </div>

            </div>
        </div>

    </div>

</section>