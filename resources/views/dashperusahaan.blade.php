<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perusahaan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* CSS Reset dan Pengaturan Dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            background-color: #f4f7fc;
            min-height: 100vh;
        }

        /* --- Sidebar (Menu Kiri) --- */
        .sidebar {
            width: 260px;
            background-color: #1a73e8;
            color: white;
            height: 100vh;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin-bottom: 15px;
        }

        .sidebar ul li a {
            color: #d4e3ff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar ul li a i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        /* Memberi highlight pada menu yang aktif */
        .sidebar ul li.active a,
        .sidebar ul li a:hover {
            background-color: #ffffff;
            color: #1a73e8;
            transform: translateX(5px);
        }

        /* --- Konten Utama (Bagian Kanan) --- */
        .main-content {
            flex-grow: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: #ffffff;
            padding: 15px 30px;
            border-bottom: 1px solid #e0e0e0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .header .left-section {
            display: flex;
            align-items: center;
        }

        .header .left-section h1 {
            font-size: 24px;
            color: #333;
            margin: 0;
        }

        .header .right-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header .user-info .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #1a73e8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .header .user-info .user-details {
            display: flex;
            flex-direction: column;
        }

        .header .user-info .user-name {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .header .user-info .user-role {
            color: #666;
            font-size: 12px;
        }

        .content-body {
            padding: 30px;
            flex-grow: 1;
            background-color: #f8f9fa;
        }

        .content-body h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 25px;
            font-weight: 600;
        }

        /* --- Card Statistik --- */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.15);
        }

        .card i {
            font-size: 3em;
            opacity: 0.9;
        }

        .card .card-content {
            margin-left: 20px;
        }

        .card .card-title {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 5px;
            opacity: 0.9;
        }

        .card .card-value {
            font-size: 2.2em;
            font-weight: 700;
        }

        /* Warna untuk setiap card */
        .card.blue { background: linear-gradient(135deg, #1a73e8 0%, #4285f4 100%); }
        .card.green { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
        .card.yellow { background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); }
        .card.red { background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%); }
        .card.purple { background: linear-gradient(135deg, #6f42c1 0%, #8e44ad 100%); }
        .card.teal { background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); }

        /* --- Tabel Daftar Mahasiswa --- */
        .recent-list {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        .recent-list h2 {
            margin-bottom: 20px;
            font-size: 20px;
            color: #333;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th, td {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        thead th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr:hover {
            background-color: #f8f9fa;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody td {
            color: #555;
            font-size: 15px;
        }

        /* --- Label Status --- */
        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Warna untuk setiap status */
        .status.menunggu { background-color: #fff3cd; color: #856404; }
        .status.diterima { background-color: #d4edda; color: #155724; }
        .status.berjalan { background-color: #cce5ff; color: #004085; }
        .status.ditolak { background-color: #f8d7da; color: #721c24; }

        /* --- Responsivitas --- */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }

            .stats-cards {
                grid-template-columns: 1fr;
            }

            .header {
                padding: 15px 20px;
            }

            .header .left-section h1 {
                font-size: 20px;
            }

            .content-body {
                padding: 20px;
            }

            .card {
                padding: 20px;
            }

            .card .card-value {
                font-size: 1.8em;
            }
        }

        @media (max-width: 480px) {
            .header .right-section {
                display: none;
            }

            .content-body h1 {
                font-size: 24px;
            }

            .recent-list {
                padding: 15px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }
        }

        /* Button Styles */
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn-primary { background-color: #007bff; color: white; }

        /* Badge Styles */
        .badge {
            display: inline-block;
            padding: 3px 6px;
            font-size: 12px;
            font-weight: bold;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 4px;
        }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: #212529; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li class="active"><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ route('proposal.index') }}"><i class="fas fa-star"></i> Proposal</a></li>
            <li><a href="{{ route('nilai.index') }}"><i class="fas fa-calendar-alt"></i>Nilai</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #d4e3ff; text-decoration: none; display: flex; align-items: center; padding: 12px 15px; border-radius: 8px; transition: all 0.3s ease; width: 100%; cursor: pointer;" onmouseover="this.style.backgroundColor='#ffffff'; this.style.color='#1a73e8';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#d4e3ff';">
                        <i class="fas fa-sign-out-alt" style="margin-right: 15px; width: 20px; text-align: center;"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="left-section">
                <h1>Selamat Datang di Dashboard Perusahaan</h1>
            </div>
            <div class="right-section">
                <div class="user-info">
                    <div class="user-avatar">P</div>
                    <div class="user-details">
                        <div class="user-name">Perusahaan</div>
                        <div class="user-role">perusahaan@gmail.com</div>
                    </div>
                </div>

            </div>
        </div>

        <div class="content-body">
            <div class="stats-cards">
                <div class="card purple">
                    <i class="fas fa-file-upload"></i>
                    <div class="card-content">
                        <div class="card-title">Dokumen Diunggah</div>
                        <div class="card-value">0</div>
                    </div>
                </div>
                <div class="card teal">
                    <i class="fas fa-chart-line"></i>
                    <div class="card-content">
                        <div class="card-title">Nilai Rata-rata</div>
                        <div class="card-value">0</div>
                    </div>
                </div>
            </div>

            <div class="recent-list" style="margin-top: 30px;">
                <h2>Status Dokumen</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Dokumen</th>
                            <th>Tanggal Upload</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #666;">Belum ada dokumen diunggah</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>