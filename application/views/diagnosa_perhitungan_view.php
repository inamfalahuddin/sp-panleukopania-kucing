<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Perhitungan</h2>
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
                            <h5><?= $hasil['user_nama']; ?></h5>

                            <h6>1. Menentukan Probabilitas Gejala (P(E|Hi))</h6>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Penyakit</th>
                                        <th>Gejala</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($hasil['perhitungan'] as $key => $perhitungan) : ?>
                                        <tr>
                                            <td><?= $key + 1 ?>.</td>
                                            <td><i><?= $perhitungan['penyakit_nama']; ?></i></td>
                                            <td class="p-0 m-0">
                                                <table class="m-0 p-0">
                                                    <tr>
                                                        <?php foreach ($perhitungan['gejala'] as $gejala) : ?>
                                                            <td><?= $gejala['gejala_kode'] . ' (' . $gejala['p_e_hi'] . ')' ?></td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>

                            <h6>2. Menghitung Nilai Semesta (Total Probabilitas Gejala)</h6>
                            <p>Total Probabilitas: <?= array_sum(array_map(function ($p) {
                                                        return array_sum(array_column($p['gejala'], 'p_e_hi'));
                                                    }, $hasil['perhitungan'])) ?></p>

                            <h6>3. Menghitung P(Hi) untuk setiap penyakit</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Penyakit</th>
                                        <th>Total Probabilitas Gejala</th>
                                        <th>P(Hi)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($hasil['perhitungan'] as $perhitungan) : ?>
                                        <tr>
                                            <td><?= $perhitungan['penyakit_nama'] ?></td>
                                            <td><?= array_sum(array_column($perhitungan['gejala'], 'p_e_hi')) ?></td>
                                            <td><?= $perhitungan['p_hi'] ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>

                            <h6>4. Menghitung P(Hi) x P(E|Hi) untuk setiap penyakit</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Penyakit</th>
                                        <th>Perhitungan</th>
                                        <th>Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($hasil['perhitungan'] as $perhitungan) : ?>
                                        <tr>
                                            <td><?= $perhitungan['penyakit_nama'] ?></td>
                                            <td>
                                                <?= $perhitungan['p_hi'] ?> x
                                                <?php foreach ($perhitungan['gejala'] as $i => $gejala): ?>
                                                    <?= $gejala['p_e_hi'] ?>
                                                    <?php if ($i < count($perhitungan['gejala']) - 1): ?> x <?php endif; ?>
                                                <?php endforeach; ?>
                                            </td>
                                            <td><?= $perhitungan['p_hi_p_e_hi'] ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                    <tr class="table-info">
                                        <td colspan="2" class="text-end">Total P(Hi) x P(E|Hi)</td>
                                        <td><?= $hasil['total_bayes'] ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <h6>5. Menghitung P(Hi|E) untuk setiap penyakit</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Penyakit</th>
                                        <th>Perhitungan</th>
                                        <th>Hasil</th>
                                        <th>Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($hasil['perhitungan'] as $perhitungan) : ?>
                                        <tr>
                                            <td><?= $perhitungan['penyakit_nama'] ?></td>
                                            <td><?= $perhitungan['p_hi_p_e_hi'] ?> / <?= $hasil['total_bayes'] ?></td>
                                            <td><?= $perhitungan['p_hi_e'] ?></td>
                                            <td><?= round($perhitungan['p_hi_e'] * 100, 2) ?>%</td>
                                        </tr>
                                    <?php endforeach ?>
                                    <tr class="table-info">
                                        <td colspan="3" class="text-end">Total Probabilitas</td>
                                        <td><?= $hasil['total_persentase'] ?>%</td>
                                    </tr>
                                </tbody>
                            </table>

                            <h6>6. Hasil Diagnosa</h6>
                            <div class="alert 
                                <?= $hasil['diagnosa'] == 'Terjangkit Tinggi' ? 'alert-danger' : ($hasil['diagnosa'] == 'Terjangkit Rendah' ? 'alert-warning' : 'alert-success') ?>">
                                <p class="p-0 m-0 fw-bold">
                                    <?= $hasil['user_nama'] ?> ----
                                    Penyakit: <i><?= $hasil['penyakit_nama'] ?></i> (<?= $hasil['penyakit_kode'] ?>) ----
                                    Probabilitas: <?= round($hasil['probabilitas'] * 100, 2) ?>% ----
                                    Diagnosa: <?= $hasil['diagnosa'] ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>