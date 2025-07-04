<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Perhitungan Bayesian</h2>
                <div class="card-tools">
                    <a href="<?= base_url('hasil'); ?>" class="btn btn-danger btn-sm">
                        Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($hasils as $hasil) : ?>
                        <div class="col-12">
                            <hr>
                            <h5>Hasil Diagnosa: <?= $hasil['user_nama']; ?></h5>

                            <h6>1. Data Gejala yang Dipilih</h6>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Gejala</th>
                                        <th>Nilai Pilihan</th>
                                        <th>Probabilitas Awal (P(Hi))</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($hasil['rules'] as $key => $rule) : ?>
                                        <tr>
                                            <td><?= $key + 1 ?>.</td>
                                            <td><?= $rule['gejala_kode']; ?></td>
                                            <td><?= $rule['gejala_selected']; ?></td>
                                            <td><?= $rule['ph_i']; ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                    <tr class="table-secondary">
                                        <td colspan="3"><strong>Total Semesta (Σ)</strong></td>
                                        <td><strong><?= $hasil['semesta']; ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>

                            <h6>2. Probabilitas Hipotesis (P(E|H))</h6>
                            <div class="callout callout-info">
                                <p class="mb-1"><strong>Rumus:</strong> <?= $hasil['probabilitas_hipotesis']['formula_text']; ?></p>
                                <p class="mb-1"><strong>Perhitungan:</strong> <?= $hasil['probabilitas_hipotesis']['formula_value']; ?></p>
                                <p class="mb-1"><strong>Hasil Perkalian:</strong> <?= $hasil['probabilitas_hipotesis']['perkalian']; ?></p>
                                <p class="mb-0"><strong>Total Probabilitas:</strong> <?= $hasil['probabilitas_hipotesis']['total']; ?></p>
                            </div>

                            <h6>3. Teorema Bayes per Gejala (P(H|E))</h6>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Gejala</th>
                                        <th>Rumus</th>
                                        <th>Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($hasil['phi_e'] as $phi) : ?>
                                        <tr>
                                            <td><?= $phi['kode_gejala']; ?></td>
                                            <td><?= $phi['rumus']; ?></td>
                                            <td><?= $phi['hasil']; ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>

                            <h6>4. Total Probabilitas Bayes & Kesimpulan</h6>

                            <?php
                            // Ambil nilai total probabilitas (format desimal, contoh: 0.65)
                            $nilai_bayes = $hasil['hitung_total_bayes']['total'];

                            // Siapkan variabel default untuk keterangan hasil
                            $keterangan_hasil = 'Tidak terdefinisi';

                            // Loop melalui data himpunan untuk menemukan kategori yang cocok
                            // Pastikan variabel $himpunan_data sudah dikirim dari controller
                            foreach ($himpunan_data as $himpunan) {
                                if ($nilai_bayes >= $himpunan['batas_bawah'] && $nilai_bayes <= $himpunan['batas_atas']) {
                                    $keterangan_hasil = $himpunan['variabel'];
                                    break; // Hentikan loop jika sudah menemukan yang cocok
                                }
                            }
                            ?>

                            <div class="callout callout-warning bg-info">
                                <p class="mb-1"><strong>Rumus Akhir:</strong> <?= $hasil['hitung_total_bayes']['formula']; ?></p>
                                <p class="mb-2"><strong>Total Nilai Bayes:</strong> <?= $nilai_bayes; ?></p>

                                <h5 class="mb-0">
                                    <strong>Kesimpulan:</strong>
                                    Kucing Anda terdiagnosa penyakit <strong>Panleukopenia</strong> dengan tingkat keparahan
                                    <strong>"<?= $keterangan_hasil; ?>"</strong>
                                    (probabilitas <?= $hasil['hitung_total_bayes']['persentase']; ?>).
                                </h5>
                            </div>

                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>