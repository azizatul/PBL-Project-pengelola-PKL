<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK: Student & Company Data + AHP & SAW</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* CSS DASAR */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { display: flex; background-color: #f4f7fc; min-height: 100vh; }
        
        /* SIDEBAR */
        .sidebar { width: 260px; background-color: #1a73e8; color: white; height: 100vh; padding: 20px; position: fixed; top: 0; left: 0; overflow-y: auto; z-index: 1000; }
        .sidebar h2 { text-align: center; margin-bottom: 30px; font-weight: 600; font-size: 20px;}
        .sidebar ul { list-style: none; }
        .sidebar ul li { margin-bottom: 15px; }
        .sidebar ul li a { color: #d4e3ff; text-decoration: none; display: flex; align-items: center; padding: 12px 15px; border-radius: 8px; transition: all 0.3s ease; }
        .sidebar ul li a i { margin-right: 15px; width: 20px; text-align: center; }
        .sidebar ul li.active a, .sidebar ul li a:hover { background-color: #ffffff; color: #1a73e8; transform: translateX(5px); }

        /* MAIN CONTENT */
        .main-content { flex-grow: 1; margin-left: 260px; display: flex; flex-direction: column; min-height: 100vh; }
        
        /* HEADER */
        .header { background-color: #ffffff; padding: 15px 30px; border-bottom: 1px solid #e0e0e0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; height: 70px; }
        .header h1 { font-size: 24px; color: #333; margin: 0; }
        
        /* CONTENT AREA */
        .content { flex-grow: 1; padding: 30px; background-color: #f4f7fc; }
        .card { background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px; }
        
        /* FORM ELEMENTS */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px; color: #555;}
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; transition: border 0.3s; }
        .form-control:focus { border-color: #1a73e8; outline: none; }
        
        /* BUTTONS */
        .btn { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 500; transition: background 0.3s; }
        .btn-primary { background-color: #1a73e8; color: white; }
        .btn-primary:hover { background-color: #1557b0; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-success:hover { background-color: #218838; }
        .btn-warning { background-color: #f39c12; color: white; }
        .btn-warning:hover { background-color: #e67e22; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-danger:hover { background-color: #c82333; }
        .btn-info { background-color: #17a2b8; color: white; }
        .btn-info:hover { background-color: #138496; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .btn-secondary:hover { background-color: #5a6268; }

        /* TABS & TABLES */
        .nav-tabs { display: flex; border-bottom: 2px solid #ddd; margin-bottom: 20px; }
        .nav-link { padding: 10px 20px; cursor: pointer; background: none; border: none; font-weight: 600; color: #666; border-bottom: 3px solid transparent; transition: all 0.3s; }
        .nav-link.active { color: #1a73e8; border-bottom-color: #1a73e8; }
        .nav-link:hover { color: #1a73e8; }

        .step-section { display: none; animation: fadeIn 0.5s; }
        .step-section.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 14px; }
        .table th, .table td { padding: 12px; text-align: left; border: 1px solid #eee; }
        .table th { background-color: #f8f9fa; font-weight: 600; color: #333; }
        
        .matrix-input { width: 60px; text-align: center; }
        .alert-info { background-color: #e3f2fd; color: #0d47a1; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 13px; }
        
        .saaty-table th { background-color: #e9ecef; text-align: center; }
        .saaty-table td { vertical-align: middle; }
        .saaty-row-odd { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Teknik pengambilan keputusan</h2>
        <ul>
            <li class="active"><a href="#"><i class="fas fa-calculator"></i>Data Real AHP & SAW</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="left-section">
                <h1>Kalkulator SPK (Dinamis)</h1>
            </div>
            <div class="right-section">
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="width:35px; height:35px; background:#1a73e8; color:white; border-radius:50%; display:flex; justify-content:center; align-items:center; font-weight:bold;">A</div>
                    <div>Admin</div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="card">
                <div class="nav-tabs">
                    <button class="nav-link active" onclick="switchTab('step1')">1. Filter & Kriteria</button>
                    <button class="nav-link" onclick="switchTab('step2')" id="btn-step2" disabled>2. Pembobotan AHP</button>
                    <button class="nav-link" onclick="switchTab('step3')" id="btn-step3" disabled>3. Perhitungan SAW</button>
                </div>

                <div id="step1" class="step-section active">
                    <div class="alert-info">
                        <i class="fas fa-info-circle"></i> Pilih Tahun Angkatan. Anda dapat <b>Menambah</b>, <b>Mengedit</b>, atau <b>Menghapus</b> kriteria sebelum lanjut.
                    </div>
                    
                    <div class="row" style="display:flex; gap:20px; align-items: flex-end; margin-bottom: 20px;">
                        <div class="col" style="flex:1">
                            <div class="form-group">
                                <label>Pilih Tahun Angkatan</label>
                                <select id="year-filter" class="form-control">
                                    <option value="2022">2022</option>
                                    <option value="2025">2025</option>
                                    <option value="all">Semua Data</option>
                                </select>
                            </div>
                        </div>
                        <div class="col" style="flex:0 0 200px;">
                            <button class="btn btn-primary w-100" style="margin-bottom: 15px;" onclick="loadDataByYear()">
                                <i class="fas fa-search"></i> Tampilkan Data
                            </button>
                        </div>
                    </div>

                    <div id="data-preview-container" style="display:none;">
                        <div style="display:flex; gap:30px; flex-wrap: wrap;">
                            <div style="flex:1; min-width: 300px;">
                                <h5 class="text-muted" style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                    <span>Konfigurasi Kriteria</span>
                                </h5>
                                
                                <div style="background: #eef2f7; padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px dashed #ccc;">
                                    <h6 style="margin-bottom:10px;">Tambah Kriteria Baru</h6>
                                    <div class="form-group">
                                        <input type="text" id="new-crit-name" class="form-control" placeholder="Nama Kriteria (misal: Disiplin)">
                                    </div>
                                    <div style="display: flex; gap: 10px;">
                                        <select id="new-crit-type" class="form-control">
                                            <option value="benefit">Benefit (Untung)</option>
                                            <option value="cost">Cost (Biaya)</option>
                                        </select>
                                        <button class="btn btn-info" onclick="addNewCriteria()">
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>

                                <div id="criteria-config" style="max-height: 400px; overflow-y: auto;"></div>
                            </div>
                            
                            <div style="flex:1; min-width: 300px;">
                                <h5 class="text-muted">Data Alternatif Terpilih: <span id="count-alt"></span></h5>
                                <div style="background: #fff; border: 1px solid #eee; border-radius: 8px; max-height: 500px; overflow-y: auto;">
                                    <ul id="alt-list" class="list-group" style="padding: 15px; list-style: none;"></ul>
                                </div>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-success" onclick="goToAHP()">Lanjut ke AHP <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <div id="step2" class="step-section">
                    <div class="alert-info">
                        Masukkan nilai perbandingan kriteria berdasarkan tingkat kepentingan.
                    </div>
                    <button class="btn btn-info btn-sm mb-3" onclick="toggleSaatyTable()">
                        <i class="fas fa-list"></i> Lihat Referensi Skala Saaty
                    </button>
                    <div id="saaty-table-container" style="display: none; margin-bottom: 20px; border: 1px solid #ddd; padding: 15px; border-radius: 8px; background: #fff;">
                         <table class="table table-bordered saaty-table text-center" style="font-size: 13px;">
                            <thead><tr><th>Nilai</th><th>Definisi</th></tr></thead>
                            <tbody>
                                <tr><td>1</td><td>Sama Penting</td></tr>
                                <tr><td>3</td><td>Sedikit Lebih Penting</td></tr>
                                <tr><td>5</td><td>Lebih Penting</td></tr>
                                <tr><td>7</td><td>Sangat Penting</td></tr>
                                <tr><td>9</td><td>Mutlak Penting</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <h4>Matriks Perbandingan Berpasangan</h4>
                    <div style="overflow-x:auto;">
                        <table class="table" id="ahp-matrix-table"></table>
                    </div>

                    <button class="btn btn-primary" onclick="calculateAHPWeights()">Hitung Bobot Prioritas</button>
                    
                    <div id="ahp-result" style="display:none; margin-top:20px;">
                        <h4>Hasil Bobot Kriteria</h4>
                        <table class="table">
                            <thead><tr><th>Kriteria</th><th>Bobot Normalisasi</th></tr></thead>
                            <tbody id="ahp-weights-body"></tbody>
                        </table>
                        
                        <div id="consistency-result" style="margin-top: 20px;"></div>
                        <br>
                        <button class="btn btn-success" onclick="goToSAW()">Lanjut ke SAW <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <div id="step3" class="step-section">
                    <div class="alert-info">
                        Isi nilai untuk kriteria. Kolom <b>Tempat PKL</b> ditampilkan sebagai referensi penilaian.
                    </div>
                    
                    <h4>Matriks Data Asli</h4>
                    <button class="btn btn-warning btn-sm mb-2" onclick="fillRealDataFromDatabase()">
                         <i class="fas fa-database"></i> Isi Otomatis (C1-C3 Database)
                    </button>

                    <div style="overflow-x:auto;">
                        <table class="table">
                            <thead id="saw-input-head"></thead>
                            <tbody id="saw-input-body"></tbody>
                        </table>
                    </div>
                    
                    <button class="btn btn-primary mt-3" onclick="calculateFinalSAW()">Hitung Ranking</button>

                    <div id="final-results" style="display:none; margin-top:30px; border-top: 2px dashed #ddd; padding-top:20px;">
                        <h3 style="color:#1a73e8; text-align:center;">Hasil Keputusan Akhir</h3>
                        <table class="table table-striped">
                            <thead><tr><th>Peringkat</th><th>Nama Mahasiswa</th><th>Tempat PKL</th><th>Nilai Akhir</th></tr></thead>
                            <tbody id="ranking-body"></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // --- DATA SUMBER DIPERBARUI DENGAN PERUSAHAAN ---
        const sourceData = [
            { nama: "Putri Rahmayani", angkatan: "2022", perusahaan: "PT Mega Jasa Karya Bersama", c1: 5, c2: 592.4, c3: 5 },
            { nama: "Ainun Saela Majid", angkatan: "2022", perusahaan: "PT. SAMUDERA Indonesia", c1: 5, c2: 51.3, c3: 5 },
            { nama: "Normini", angkatan: "2022", perusahaan: "PT. Japfa Comfeed Indonesia", c1: 4, c2: 32, c3: 4 },
            { nama: "Lina Gina", angkatan: "2022", perusahaan: "PT Ambang Barito Nusapersada", c1: 5, c2: 61.9, c3: 5 },
            { nama: "Ismi Latipah", angkatan: "2022", perusahaan: "PT. BSI KCP Pelaihari", c1: 5, c2: 5.5, c3: 2 },
            { nama: "Ahda Kamalia", angkatan: "2022", perusahaan: "RSUD H. Damanhuri Barabai", c1: 5, c2: 174, c3: 5 },
            { nama: "Hayat", angkatan: "2022", perusahaan: "Boejasin", c1: 5, c2: 9.8, c3: 5 },
            { nama: "Muhammad Dian", angkatan: "2022", perusahaan: "PT. Ciomas Adisatwa Bati-Bati", c1: 3, c2: 21.6, c3: 4 },
            { nama: "IMELIA APRIANAH", angkatan: "2025", perusahaan: "PT PLN Persero ULP Gambut", c1: 5, c2: 40.6, c3: 5 },
            { nama: "Raisha Ardiani", angkatan: "2022", perusahaan: "PT. Pola Kahuripan Inti Sawit", c1: 5, c2: 83.2, c3: 5 }
        ];

        // --- STATE MANAGEMEN ---
        let criteriaData = [
            { id: 0, name: "Kemudahan Pemberian Nilai", type: "benefit", weight: 0 },
            { id: 1, name: "Jarak dari Kampus (km)", type: "cost", weight: 0 },
            { id: 2, name: "Fasilitas Tempat Magang", type: "benefit", weight: 0 }
        ];

        let filteredAlternatives = [];
        let editingIndex = -1; 

        // --- NAVIGATION ---
        function switchTab(tabId) {
            if(tabId === 'step2' && document.getElementById('btn-step2').disabled) return;
            if(tabId === 'step3' && document.getElementById('btn-step3').disabled) return;
            document.querySelectorAll('.step-section').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            document.querySelector(`button[onclick="switchTab('${tabId}')"]`).classList.add('active');
        }

        function toggleSaatyTable() {
            let tableDiv = document.getElementById('saaty-table-container');
            tableDiv.style.display = (tableDiv.style.display === "none") ? "block" : "none";
        }

        // --- STEP 1: FILTER & CRITERIA MANAGEMENT ---
        function loadDataByYear() {
            const selectedYear = document.getElementById('year-filter').value;
            if (selectedYear === 'all') {
                filteredAlternatives = [...sourceData];
            } else {
                filteredAlternatives = sourceData.filter(item => item.angkatan === selectedYear);
            }
            if (filteredAlternatives.length === 0) {
                alert("Tidak ada data untuk tahun angkatan ini.");
                return;
            }
            renderCriteriaList();
            renderAlternativeList();
            document.getElementById('data-preview-container').style.display = 'block';
        }

        function renderCriteriaList() {
            let listContainer = document.getElementById('criteria-config');
            listContainer.innerHTML = '';

            criteriaData.forEach((c, index) => {
                let row = document.createElement('div');
                row.className = 'form-group';
                row.style.cssText = "display:flex; justify-content:space-between; align-items:center; border:1px solid #eee; padding:10px; border-radius:4px; background:#f9f9f9; margin-bottom:10px;";

                if(index === editingIndex) {
                    row.innerHTML = `
                        <div style="flex-grow:1; margin-right:10px; display:flex; gap:5px; flex-direction:column;">
                            <input type="text" id="edit-name-${index}" class="form-control" value="${c.name}">
                            <select id="edit-type-${index}" class="form-control">
                                <option value="benefit" ${c.type === 'benefit' ? 'selected' : ''}>Benefit</option>
                                <option value="cost" ${c.type === 'cost' ? 'selected' : ''}>Cost</option>
                            </select>
                        </div>
                        <div style="display:flex; gap:5px;">
                            <button class="btn btn-success" onclick="saveCriteria(${index})" title="Simpan"><i class="fas fa-check"></i></button>
                            <button class="btn btn-secondary" onclick="cancelEdit()" title="Batal"><i class="fas fa-times"></i></button>
                        </div>
                    `;
                } else {
                    row.innerHTML = `
                        <div>
                            <strong>${c.name}</strong> <br>
                            <small class="badge" style="background:${c.type === 'benefit' ? '#28a745' : '#dc3545'}; color:white; padding:2px 5px; border-radius:3px;">${c.type.toUpperCase()}</small>
                        </div>
                        <div style="display:flex; gap:5px;">
                            <button class="btn btn-warning" onclick="editCriteria(${index})" style="color:white;" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger" onclick="deleteCriteria(${index})" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    `;
                }
                listContainer.appendChild(row);
            });
        }

        function addNewCriteria() {
            const nameInput = document.getElementById('new-crit-name');
            const typeInput = document.getElementById('new-crit-type');
            if(nameInput.value.trim() === "") { alert("Nama kriteria tidak boleh kosong!"); return; }
            criteriaData.push({ id: Date.now(), name: nameInput.value, type: typeInput.value, weight: 0 });
            resetSteps();
            renderCriteriaList();
            nameInput.value = "";
        }

        function editCriteria(index) { editingIndex = index; renderCriteriaList(); }

        function saveCriteria(index) {
            const newName = document.getElementById(`edit-name-${index}`).value;
            const newType = document.getElementById(`edit-type-${index}`).value;
            if(newName.trim() === "") { alert("Nama tidak boleh kosong"); return; }
            criteriaData[index].name = newName;
            criteriaData[index].type = newType;
            editingIndex = -1;
            resetSteps();
            renderCriteriaList();
        }

        function cancelEdit() { editingIndex = -1; renderCriteriaList(); }

        function deleteCriteria(index) {
            if(criteriaData.length <= 1) { alert("Minimal harus ada 1 kriteria!"); return; }
            if(confirm(`Hapus kriteria "${criteriaData[index].name}"?`)) {
                criteriaData.splice(index, 1);
                resetSteps();
                renderCriteriaList();
            }
        }

        function resetSteps() {
            document.getElementById('btn-step2').disabled = true;
            document.getElementById('btn-step3').disabled = true;
            document.getElementById('ahp-result').style.display = 'none';
        }

        function renderAlternativeList() {
            let aHtml = '';
            filteredAlternatives.forEach(item => {
                aHtml += `<li style="margin-bottom:5px; border-bottom:1px solid #f0f0f0; padding-bottom:5px;">
                    <strong>${item.nama}</strong> <br> 
                    <small class="text-muted"><i class="fas fa-building"></i> ${item.perusahaan}</small>
                </li>`;
            });
            document.getElementById('alt-list').innerHTML = aHtml;
            document.getElementById('count-alt').innerText = filteredAlternatives.length;
        }

        function goToAHP() {
            if(criteriaData.length < 2) { alert("Minimal dibutuhkan 2 kriteria untuk perbandingan AHP."); return; }
            generateAHPMatrixTable();
            document.getElementById('btn-step2').disabled = false;
            switchTab('step2');
        }

        // --- STEP 2: AHP LOGIC ---
        function generateAHPMatrixTable() {
            const saatyOptions = [ {v:9, l:"9"}, {v:8, l:"8"}, {v:7, l:"7"}, {v:6, l:"6"}, {v:5, l:"5"}, {v:4, l:"4"}, {v:3, l:"3"}, {v:2, l:"2"}, {v:1, l:"1"}, {v:1/2, l:"1/2"}, {v:1/3, l:"1/3"}, {v:1/4, l:"1/4"}, {v:1/5, l:"1/5"}, {v:1/6, l:"1/6"}, {v:1/7, l:"1/7"}, {v:1/8, l:"1/8"}, {v:1/9, l:"1/9"} ];
            let table = document.getElementById('ahp-matrix-table');
            let thead = '<thead><tr><th>Kriteria</th>';
            criteriaData.forEach(c => thead += `<th>${c.name}</th>`);
            thead += '</tr></thead><tbody>';
            criteriaData.forEach((rowCrit, i) => {
                let row = `<tr><td><strong>${rowCrit.name}</strong></td>`;
                criteriaData.forEach((colCrit, j) => {
                    if (i === j) row += `<td><input type="number" value="1" disabled class="form-control matrix-input" style="background:#eee;"></td>`;
                    else if (j > i) {
                        let selectHtml = `<select id="ahp-${i}-${j}" class="form-control matrix-input" onchange="updateMirror(${i}, ${j})" style="min-width:70px;">`;
                        saatyOptions.forEach(opt => { let selected = (opt.v === 1) ? 'selected' : ''; selectHtml += `<option value="${opt.v}" ${selected}>${opt.l}</option>`; });
                        selectHtml += '</select>';
                        row += `<td>${selectHtml}</td>`;
                    } else row += `<td><input type="number" id="ahp-${i}-${j}" class="form-control matrix-input" value="1" disabled style="background:#eee;"></td>`;
                });
                row += '</tr>'; thead += row;
            });
            table.innerHTML = thead + '</tbody>';
        }

        function updateMirror(i, j) {
            let val = parseFloat(document.getElementById(`ahp-${i}-${j}`).value);
            if(val !== 0) document.getElementById(`ahp-${j}-${i}`).value = (1 / val);
        }

        function calculateAHPWeights() {
            let n = criteriaData.length;
            let matrix = [], colSums = new Array(n).fill(0);
            for(let i=0; i<n; i++) {
                let row = [];
                for(let j=0; j<n; j++) {
                    let val = (i===j) ? 1 : ((j>i) ? parseFloat(document.getElementById(`ahp-${i}-${j}`).value) : parseFloat(document.getElementById(`ahp-${i}-${j}`).value));
                    row.push(val); colSums[j] += val;
                }
                matrix.push(row);
            }
            let weightsBody = document.getElementById('ahp-weights-body'); weightsBody.innerHTML = '';
            let localWeights = [];
            for(let i=0; i<n; i++) {
                let rowSum = 0; for(let j=0; j<n; j++) rowSum += matrix[i][j] / colSums[j];
                let weight = rowSum / n; localWeights.push(weight); criteriaData[i].weight = weight;
                weightsBody.innerHTML += `<tr><td>${criteriaData[i].name}</td><td style="font-weight:bold; color:#1a73e8;">${weight.toFixed(4)}</td></tr>`;
            }
            
            // Consistency Check
            let lambdaMax = 0;
            for(let i=0; i<n; i++) lambdaMax += colSums[i] * localWeights[i];
            let CI = (lambdaMax - n) / (n - 1);
            const RI_Values = [0, 0, 0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];
            let RI = (n < RI_Values.length) ? RI_Values[n] : 1.49;
            let CR = (RI === 0) ? 0 : (CI / RI);
            let isConsistent = CR <= 0.1;
            let statusColor = isConsistent ? '#d4edda' : '#f8d7da';
            let textColor = isConsistent ? '#155724' : '#721c24';
            let statusText = isConsistent ? 'KONSISTEN' : 'TIDAK KONSISTEN';
            
            document.getElementById('consistency-result').innerHTML = `
                <div style="background-color: ${statusColor}; color: ${textColor}; padding: 15px; border-radius: 8px; border: 1px solid ${textColor};">
                    <h5 style="margin-bottom:10px; font-weight:bold; border-bottom:1px solid ${textColor}; padding-bottom:5px;">Uji Konsistensi AHP: ${statusText}</h5>
                    <div style="display:flex; justify-content:space-between; text-align:center;">
                        <div style="flex:1;"><small>Lambda Max</small><br><strong>${lambdaMax.toFixed(4)}</strong></div>
                        <div style="flex:1; border-left:1px solid ${textColor};"><small>CI</small><br><strong>${CI.toFixed(4)}</strong></div>
                        <div style="flex:1; border-left:1px solid ${textColor};"><small>CR</small><br><strong style="font-size:16px;">${CR.toFixed(4)}</strong></div>
                    </div>
                </div>`;
            document.getElementById('ahp-result').style.display = 'block';
        }

        function goToSAW() {
            generateSAWInputTable();
            document.getElementById('btn-step3').disabled = false;
            switchTab('step3');
        }

        // --- STEP 3: SAW LOGIC (UPDATED WITH COMPANY COLUMN) ---
        function generateSAWInputTable() {
            let thead = document.getElementById('saw-input-head');
            let headRow = '<tr><th style="width:200px;">Nama Mahasiswa</th><th style="width:250px; background:#e9ecef;">Tempat PKL</th>';
            criteriaData.forEach(c => {
                headRow += `<th>${c.name}<br><small>Bobot: ${c.weight.toFixed(3)}</small></th>`;
            });
            headRow += '</tr>';
            thead.innerHTML = headRow;

            let tbody = document.getElementById('saw-input-body');
            tbody.innerHTML = '';
            
            filteredAlternatives.forEach((item, i) => {
                let row = `<tr>
                    <td><strong>${item.nama}</strong></td>
                    <td style="background:#f8f9fa; color:#555;">${item.perusahaan}</td>`;
                criteriaData.forEach((c, j) => {
                    row += `<td><input type="number" id="saw-val-${i}-${j}" class="form-control" placeholder="0"></td>`;
                });
                row += '</tr>';
                tbody.innerHTML += row;
            });
        }

        function fillRealDataFromDatabase() {
            filteredAlternatives.forEach((item, i) => {
                if(criteriaData.length > 0) document.getElementById(`saw-val-${i}-0`).value = item.c1 || 0;
                if(criteriaData.length > 1) document.getElementById(`saw-val-${i}-1`).value = item.c2 || 0;
                if(criteriaData.length > 2) document.getElementById(`saw-val-${i}-2`).value = item.c3 || 0;
            });
            alert("Data C1, C2, dan C3 telah diisi. Kriteria tambahan harus diisi manual.");
        }

        function calculateFinalSAW() {
            let nAlt = filteredAlternatives.length;
            let nCrit = criteriaData.length;
            let rawData = [];
            for(let i=0; i<nAlt; i++) {
                let row = [];
                for(let j=0; j<nCrit; j++) {
                    let val = parseFloat(document.getElementById(`saw-val-${i}-${j}`).value);
                    if(isNaN(val)) val = 0;
                    row.push(val);
                }
                rawData.push(row);
            }
            let maxVals = new Array(nCrit).fill(-Infinity);
            let minVals = new Array(nCrit).fill(Infinity);
            for(let j=0; j<nCrit; j++) {
                for(let i=0; i<nAlt; i++) {
                    if(rawData[i][j] > maxVals[j]) maxVals[j] = rawData[i][j];
                    if(rawData[i][j] < minVals[j]) minVals[j] = rawData[i][j];
                }
            }
            let finalScores = [];
            for(let i=0; i<nAlt; i++) {
                let score = 0;
                for(let j=0; j<nCrit; j++) {
                    let normalizedVal = 0;
                    if(criteriaData[j].type === 'benefit') normalizedVal = maxVals[j] === 0 ? 0 : (rawData[i][j] / maxVals[j]);
                    else normalizedVal = rawData[i][j] === 0 ? 0 : (minVals[j] / rawData[i][j]);
                    score += normalizedVal * criteriaData[j].weight;
                }
                finalScores.push({ name: filteredAlternatives[i].nama, perusahaan: filteredAlternatives[i].perusahaan, score: score });
            }
            finalScores.sort((a, b) => b.score - a.score);

            let resBody = document.getElementById('ranking-body');
            resBody.innerHTML = '';
            finalScores.forEach((item, index) => {
                resBody.innerHTML += `
                    <tr>
                        <td style="font-weight:bold; font-size:16px;">#${index + 1}</td>
                        <td>${item.name}</td>
                        <td>${item.perusahaan}</td>
                        <td style="color:#1a73e8; font-weight:bold;">${item.score.toFixed(4)}</td>
                    </tr>`;
            });
            document.getElementById('final-results').style.display = 'block';
        }
    </script>
</body>
</html>