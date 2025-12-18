<?php
// ==========================================
// 1. DATA INPUT & KONFIGURASI
// ==========================================

// Data Alternatif (Sesuai Excel Anda)
$alternatif = [
    ['nama' => 'Putri Rahmayani',           'angkatan' => 2022, 'tempat' => 'PT Mega Jasa Karya Bersama',              'nilai' => 5, 'jarak' => 592.4, 'fasilitas' => 5],
    ['nama' => 'Ainun Saela Majid',         'angkatan' => 2022, 'tempat' => 'PT. SAMUDERA Indonesia',                  'nilai' => 5, 'jarak' => 51.3,  'fasilitas' => 5],
    ['nama' => 'Normini',                   'angkatan' => 2022, 'tempat' => 'PT. Japfa Comfeed Indonesia Tbk',         'nilai' => 4, 'jarak' => 32,    'fasilitas' => 4],
    ['nama' => 'Lina Gina',                 'angkatan' => 2022, 'tempat' => 'PT Ambang Barito Nusapersada',            'nilai' => 5, 'jarak' => 61.9,  'fasilitas' => 5],
    ['nama' => 'Ismi Latipah',              'angkatan' => 2022, 'tempat' => 'PT. Bank Syariah Indonesia KCP Pelaihari','nilai' => 5, 'jarak' => 5.5,   'fasilitas' => 2],
    ['nama' => 'Ahda Kamalia',              'angkatan' => 2022, 'tempat' => 'RSUD H. Damanhuri Barabai',               'nilai' => 5, 'jarak' => 174,   'fasilitas' => 5],
    ['nama' => 'Hayat',                     'angkatan' => 2022, 'tempat' => 'Boejasin',                                'nilai' => 5, 'jarak' => 9.8,   'fasilitas' => 5],
    ['nama' => 'Muhammad Dian',             'angkatan' => 2022, 'tempat' => 'PT. Ciomas Adisatwa Bati-Bati',           'nilai' => 3, 'jarak' => 21.6,  'fasilitas' => 4],
    ['nama' => 'IMELIA APRIANAH',           'angkatan' => 2025, 'tempat' => 'PT PLN Persero ULP Gambut',               'nilai' => 5, 'jarak' => 40.6,  'fasilitas' => 5],
    ['nama' => 'Raisha Ardiani',            'angkatan' => 22,   'tempat' => 'PT. Pola Kahuripan Inti Sawit',           'nilai' => 5, 'jarak' => 83.2,  'fasilitas' => 5],
];

// Matriks Perbandingan AHP (SUDAH DIPERBAIKI AGAR KONSISTEN)
// Kriteria: [0] Kemudahan Nilai, [1] Jarak, [2] Fasilitas
// Perubahan: Kemudahan vs Fasilitas diubah dari 0.5 menjadi 0.2 (1/5)
// Alasan: Karena Jarak 2x lebih penting dari Kemudahan, dan Fasilitas 3x lebih penting dari Jarak.
// Secara logika transitif, Fasilitas harusnya 6x (atau 5x) lebih penting dari Kemudahan.
$matriks_ahp = [
    [1,     0.5,    0.2],       // Kemudahan
    [2,     1,      0.3333],    // Jarak
    [5,     3,      1]          // Fasilitas (Diubah dari 2 menjadi 5 agar CR Konsisten)
];
$labels = ['Kemudahan Pemberian Nilai', 'Jarak Kampus ke PKL', 'Fasilitas Tempat Magang'];

// ==========================================
// 2. PROSES HITUNG AHP
// ==========================================

$n = count($matriks_ahp);
$sum_col = [0, 0, 0];

// Hitung Jumlah Kolom
for ($i=0; $i<$n; $i++) {
    for ($j=0; $j<$n; $j++) {
        $sum_col[$i] += $matriks_ahp[$j][$i];
    }
}

// Normalisasi Matriks & Hitung Eigen Vector (Bobot)
$matriks_norm_ahp = [];
$bobot = [];
for ($i=0; $i<$n; $i++) {
    $row_sum = 0;
    for ($j=0; $j<$n; $j++) {
        $val = $matriks_ahp[$i][$j] / $sum_col[$j];
        $matriks_norm_ahp[$i][$j] = $val;
        $row_sum += $val;
    }
    $bobot[$i] = $row_sum / $n;
}

// Hitung Konsistensi
$lambda_max = 0;
for ($i=0; $i<$n; $i++) {
    $lambda_max += $sum_col[$i] * $bobot[$i];
}
$CI = ($lambda_max - $n) / ($n - 1);
$RI = 0.58; // RI untuk n=3
$CR = $CI / $RI;


// ==========================================
// 3. PROSES HITUNG SAW
// ==========================================

// Cari Min/Max untuk Normalisasi SAW
$max_nilai = 0; $min_jarak = 99999; $max_fas = 0;
foreach ($alternatif as $a) {
    if ($a['nilai'] > $max_nilai) $max_nilai = $a['nilai'];
    if ($a['jarak'] < $min_jarak) $min_jarak = $a['jarak'];
    if ($a['fasilitas'] > $max_fas) $max_fas = $a['fasilitas'];
}

// Normalisasi & Perankingan SAW
$hasil_saw = [];
foreach ($alternatif as $idx => $a) {
    // Rumus SAW: Benefit (Val/Max), Cost (Min/Val)
    $norm_n = $a['nilai'] / $max_nilai;         // Benefit
    $norm_j = $min_jarak / $a['jarak'];         // Cost
    $norm_f = $a['fasilitas'] / $max_fas;       // Benefit

    // Hitung Skor Akhir pakai Bobot AHP
    $skor = ($norm_n * $bobot[0]) + ($norm_j * $bobot[1]) + ($norm_f * $bobot[2]);

    $hasil_saw[] = [
        'data' => $a,
        'norm' => ['n' => $norm_n, 'j' => $norm_j, 'f' => $norm_f],
        'skor' => $skor
    ];
}

// Sorting Ranking
usort($hasil_saw, function($a, $b) {
    return $b['skor'] <=> $a['skor'];
});
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SPK Kombinasi AHP & SAW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; padding: 20px; font-family: 'Segoe UI', sans-serif; }
        .nav-tabs .nav-link.active { background-color: #0d6efd; color: white; border-bottom-color: transparent; }
        .nav-tabs .nav-link { color: #555; font-weight: 600; }
        .card { border: none; box-shadow: 0 0 15px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .card-header { background-color: #fff; border-bottom: 1px solid #eee; font-weight: bold; color: #333; }
        .table-head-dark { background-color: #343a40; color: white; }
        .highlight-score { font-size: 1.1em; font-weight: bold; color: #0d6efd; }
    </style>
</head>
<body>

<div class="container-fluid">
    <h3 class="text-center mb-4">Sistem Pendukung Keputusan Pemilihan Tempat PKL <br><small class="text-muted fs-6">Metode: AHP (Bobot) & SAW (Ranking)</small></h3>

    <ul class="nav nav-tabs mb-3" id="spkTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button">1. Data Awal</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ahp-tab" data-bs-toggle="tab" data-bs-target="#ahp" type="button">2. Perhitungan AHP</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="saw-tab" data-bs-toggle="tab" data-bs-target="#saw" type="button">3. Perhitungan SAW & Ranking</button>
        </li>
    </ul>

    <div class="tab-content" id="spkTabContent">

        <div class="tab-pane fade show active" id="data" role="tabpanel">
            <div class="card">
                <div class="card-header">Data Mahasiswa & Tempat PKL</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <thead class="table-head-dark text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Angkatan</th>
                                    <th>Tempat PKL</th>
                                    <th>Kemudahan Nilai</th>
                                    <th>Jarak (Km)</th>
                                    <th>Fasilitas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($alternatif as $k => $row): ?>
                                <tr>
                                    <td class="text-center"><?= $k+1 ?></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td class="text-center"><?= $row['angkatan'] ?></td>
                                    <td><?= $row['tempat'] ?></td>
                                    <td class="text-center"><?= $row['nilai'] ?></td>
                                    <td class="text-center"><?= $row['jarak'] ?></td>
                                    <td class="text-center"><?= $row['fasilitas'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="ahp" role="tabpanel">
            
            <div class="card">
                <div class="card-header">A. Matriks Perbandingan Berpasangan (Telah Disesuaikan Agar Konsisten)</div>
                <div class="card-body">
                    <div class="alert alert-info py-2 small">
                        <strong>Catatan:</strong> Nilai perbandingan "Fasilitas vs Kemudahan" disesuaikan menjadi 5 (Mutlak) agar memenuhi logika transitif dan Consistency Ratio (CR) < 0.1.
                    </div>
                    <table class="table table-bordered text-center table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Kriteria</th>
                                <?php foreach($labels as $l) echo "<th>$l</th>"; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<$n; $i++): ?>
                            <tr>
                                <td class="fw-bold text-start"><?= $labels[$i] ?></td>
                                <?php for($j=0; $j<$n; $j++) echo "<td>".round($matriks_ahp[$i][$j], 4)."</td>"; ?>
                            </tr>
                            <?php endfor; ?>
                            <tr class="table-secondary fw-bold">
                                <td class="text-start">Jumlah</td>
                                <?php foreach($sum_col as $sum) echo "<td>".number_format($sum, 4)."</td>"; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">B. Matriks Perbandingan Ternormalisasi</div>
                <div class="card-body">
                    <table class="table table-bordered text-center table-sm">
                        <thead class="table-info">
                            <tr>
                                <th>Kriteria</th>
                                <?php foreach($labels as $l) echo "<th>$l</th>"; ?>
                                <th class="bg-warning">Eigen Vector (Bobot)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<$n; $i++): ?>
                            <tr>
                                <td class="fw-bold text-start"><?= $labels[$i] ?></td>
                                <?php for($j=0; $j<$n; $j++) echo "<td>".number_format($matriks_norm_ahp[$i][$j], 4)."</td>"; ?>
                                <td class="bg-warning fw-bold"><?= number_format($bobot[$i], 4) ?></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">C. Uji Konsistensi AHP</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered table-sm">
                                <tr><th>Lambda Max (λ max)</th><td><?= number_format($lambda_max, 9) ?></td></tr>
                                <tr><th>Consistency Index (CI)</th><td><?= number_format($CI, 9) ?></td></tr>
                                <tr><th>Consistency Ratio (CR)</th><td class="<?= ($CR<=0.1)?'text-success fw-bold':'text-danger' ?>"><?= number_format($CR, 9) ?></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="alert alert-<?= ($CR<=0.1)?'success':'danger' ?> w-100 text-center">
                                STATUS: <strong><?= ($CR<=0.1) ? "KONSISTEN" : "TIDAK KONSISTEN" ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="saw" role="tabpanel">
            
            <div class="card">
                <div class="card-header">A. Nilai Min/Max (Cost/Benefit)</div>
                <div class="card-body">
                    <ul>
                        <li><strong>Kemudahan Nilai (Benefit):</strong> Max = <?= $max_nilai ?></li>
                        <li><strong>Jarak (Cost):</strong> Min = <?= $min_jarak ?></li>
                        <li><strong>Fasilitas (Benefit):</strong> Max = <?= $max_fas ?></li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">B. Matriks Normalisasi SAW (R)</div>
                <div class="card-body">
                    <table class="table table-bordered table-sm text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Norm. Nilai</th>
                                <th>Norm. Jarak</th>
                                <th>Norm. Fasilitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Loop data asli untuk tabel normalisasi agar urutan sesuai input
                            foreach($alternatif as $a): 
                                $n_val = $a['nilai'] / $max_nilai;
                                $n_dis = $min_jarak / $a['jarak'];
                                $n_fac = $a['fasilitas'] / $max_fas;
                            ?>
                            <tr>
                                <td class="text-start"><?= $a['nama'] ?></td>
                                <td><?= number_format($n_val, 5) ?></td>
                                <td><?= number_format($n_dis, 5) ?></td>
                                <td><?= number_format($n_fac, 5) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">C. Hasil Akhir & Perankingan</div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-secondary text-center">
                            <tr>
                                <th>Rank</th>
                                <th>Nama Mahasiswa</th>
                                <th>Tempat PKL</th>
                                <th>Skor Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($hasil_saw as $rank => $res): ?>
                            <tr>
                                <td class="text-center fw-bold"><?= $rank+1 ?></td>
                                <td><?= $res['data']['nama'] ?></td>
                                <td><?= $res['data']['tempat'] ?></td>
                                <td class="text-center highlight-score"><?= number_format($res['skor'], 5) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div> </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>