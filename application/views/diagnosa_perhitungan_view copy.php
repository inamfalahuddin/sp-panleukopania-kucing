<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Rincian Perhitungan Diagnosa</h2>
                <div class="card-tools">
                    <a href="<?= base_url('hasil'); ?>" class="btn btn-danger btn-sm">
                        Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if (empty($hasils)) : ?>
                        <div class="col-12">
                            <div class="alert alert-info">Belum ada data riwayat untuk ditampilkan.</div>
                        </div>
                    <?php else : ?>
                        <?php foreach ($hasils as $hasil) : ?>
                            <div class="col-12">
                                <hr>
                                <h4 class="text-capitalize mb-4">Hasil untuk: <strong><?= $hasil['user_nama']; ?></strong></h4>

                                <h6>1. Nilai Probabilitas Gejala Terhadap Penyakit (P(E|Hi))</h6>
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Penyakit</th>
                                            <th>Probabilitas Gejala (Kode Gejala (Nilai CF))</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($hasil['perhitungan'] as $key => $perhitungan) : ?>
                                            <tr>
                                                <td><?= $key + 1 ?>.</td>
                                                <td><i><?= $perhitungan['penyakit_nama']; ?></i></td>
                                                <td>
                                                    <?php foreach ($perhitungan['gejala'] as $gejala) : ?>
                                                        <span class="badge bg-secondary mr-1"><?= $gejala['gejala_kode'] . ' (' . $gejala['p_e_hi'] . ')' ?></span>
                                                    <?php endforeach; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>

                                <h6>2. Perhitungan Nilai Bayes</h6>
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Penyakit</th>
                                            <th>P(Hi) * P(E|Hi)</th>
                                            <th>P(Hi|E) = (Hasil / Total)</th>
                                            <th>Persentase Keyakinan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // DIUBAH: Hitung total P(Hi) * P(E|Hi) secara dinamis
                                        $total_p_hi_p_e_hi = array_sum(array_column($hasil['perhitungan'], 'p_hi_p_e_hi'));
                                        ?>
                                        <?php foreach ($hasil['perhitungan'] as $perhitungan) : ?>
                                            <tr>
                                                <td><?= $perhitungan['penyakit_nama'] ?></td>
                                                <td><?= $perhitungan['p_hi_p_e_hi'] ?></td>
                                                <td>
                                                    <?php if ($total_p_hi_p_e_hi > 0) : ?>
                                                        <?= $perhitungan['p_hi_p_e_hi'] ?> / <?= $total_p_hi_p_e_hi ?> = <strong><?= $perhitungan['p_hi_e'] ?></strong>
                                                    <?php else : ?>
                                                        0
                                                    <?php endif; ?>
                                                </td>
                                                <td><strong><?= round($perhitungan['p_hi_e'] * 100, 2) ?>%</strong></td>
                                            </tr>
                                        <?php endforeach ?>
                                        <tr class="table-info">
                                            <td colspan="2" class="text-end fw-bold">Total</td>
                                            <td><strong><?= $total_p_hi_p_e_hi ?></strong></td>
                                            <td><strong><?= round(array_sum(array_column($hasil['perhitungan'], 'p_hi_e')) * 100, 2) ?>%</strong></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <h6>3. Hasil Akhir Diagnosa</h6>
                                <?php
                                // DIUBAH: Logika untuk menentukan warna alert secara dinamis
                                $diagnosa_lower = strtolower($hasil['diagnosa']);
                                $alert_class = 'alert-secondary'; // Default
                                if (strpos($diagnosa_lower, 'tidak terjangkit') !== false) {
                                    $alert_class = 'alert-success';
                                } elseif (strpos($diagnosa_lower, 'mungkin') !== false) {
                                    $alert_class = 'alert-warning';
                                } elseif (strpos($diagnosa_lower, 'parah') !== false || strpos($diagnosa_lower, 'tinggi') !== false) {
                                    $alert_class = 'alert-danger';
                                } elseif (strpos($diagnosa_lower, 'terjangkit') !== false) {
                                    $alert_class = 'alert-info';
                                }
                                ?>
                                <div class="alert <?= $alert_class ?>">
                                    <h5 class="alert-heading">Kesimpulan</h5>
                                    <p>
                                        Berdasarkan gejala yang ada, sistem mendiagnosa pasien <strong><?= $hasil['user_nama'] ?></strong> kemungkinan besar menderita penyakit:
                                    </p>
                                    <p class="fs-5 fw-bold">
                                        <i class="fas fa-pills"></i> <?= $hasil['penyakit_nama'] ?> (<?= $hasil['penyakit_kode'] ?>)
                                    </p>
                                    <hr>
                                    <p class="mb-0">
                                        Tingkat keyakinan sistem adalah <strong><?= $hasil['persentase'] ?>%</strong>,
                                        yang masuk dalam kategori: <strong><?= $hasil['diagnosa'] ?></strong>.
                                    </p>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>