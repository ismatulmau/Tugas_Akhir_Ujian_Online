<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Kartu Peserta Ujian</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .kartu {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            border: 1px solid #333;
            page-break-after: always;
            position: relative; /* Tambahkan ini untuk positioning absolut foto */
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
            position: relative; /* Untuk mengatur posisi header relatif */
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
        }

        .header h3 {
            margin: 4px 0;
            font-size: 14px;
        }

        .info-section {
            margin-bottom: 16px;
        }

        .data-siswa {
            font-size: 12px;
            width: 70%; /* Lebarkan area data */
        }

        .data-siswa table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-siswa td {
            padding: 2px 0;
            vertical-align: top;
        }

        .data-siswa td:first-child {
            width: 35%;
            font-weight: bold;
        }

        .foto-container {
            position: absolute;
            top: 20px; /* Sesuaikan dengan padding kartu */
            right: 20px; /* Sesuaikan dengan padding kartu */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .foto {
            width: 100px;
            height: 120px;
            object-fit: cover;
            border: 1px solid #333;
        }

        .foto-placeholder {
            width: 100px;
            height: 120px;
            border: 1px dashed #999;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #666;
        }

        .jadwal {
            font-size: 11px;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .jadwal th,
        .jadwal td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .footer-note {
            font-size: 11px;
            margin-top: 8px;
        }

        .footer-note ul {
            margin: 0;
            padding-left: 16px;
        }
    </style>
</head>

<body>
    @foreach($siswas as $siswa)
    <div class="kartu">
        <!-- Foto dipindahkan ke sini untuk posisi absolut -->
        <div class="foto-container">
            @php $fotoPath = storage_path('app/public/' . $siswa->gambar); @endphp
            @if($siswa->gambar && file_exists($fotoPath))
                <img src="{{ $fotoPath }}" class="foto">
            @else
                <div class="foto-placeholder">Tidak Ada Foto</div>
            @endif
        </div>

        <div class="header">
            <h1>KARTU PESERTA {{ strtoupper($jenis_ujian) }}</h1>
            <h2>SMK TELEMATIKA INDRAMAYU</h2>
            <h3>Tahun Pelajaran {{ $tahun_pelajaran }}</h3>
        </div>

        <div class="info-section">
            <div class="data-siswa">
                <table>
                    <tr>
                        <td>Nomor Peserta</td>
                        <td>: {{ $siswa->nomor_ujian }}</td>
                    </tr>
                    <tr>
                        <td>Nama Peserta</td>
                        <td>: {{ strtoupper($siswa->nama_siswa) }}</td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>: {{ $siswa->kelas->nama_kelas ?? '-' }} ({{ $siswa->jurusan }})</td>
                    </tr>
                    <tr>
                        <td>Sesi & Ruang Ujian</td>
                        <td>: Sesi {{ $siswa->sesi_ujian }} - Ruang {{ $siswa->ruang_ujian }}</td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td>: {{ $siswa->nomor_ujian }}</td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>: {{ $siswa->password_asli }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <table class="jadwal">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Hari / Tanggal</th>
                    <th>Waktu</th>
                    <th>Mata Pelajaran</th>
                    <th>Paraf</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($jadwalUjian as $group => $items)
                    @php
                        $parts = explode('|', $group);
                        $hari = $parts[0] ?? '-';
                        $tanggal = $parts[1] ?? '-';
                        $rowspan = count($items);
                    @endphp
                    @foreach($items as $index => $jadwal)
                    <tr>
                        <td>{{ $no++ }}</td>
                        @if($index == 0)
                        <td rowspan="{{ $rowspan }}">
                            {{ $hari }}, {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}
                        </td>
                        @endif
                        <td>{{ $jadwal['jam'] ?? '-' }}</td>
                        <td>{{ $jadwal['mapel'] ?? '-' }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <div class="footer-note">
            <ul>
                <li>Kartu wajib dibawa saat melaksanakan ujian.</li>
                <li>Peserta ujian harus datang tepat waktu sesuai jadwal ujian.</li>
                <li>Kehilangan kartu ujian menjadi tanggung jawab siswa.</li>
            </ul>
        </div>
    </div>
    @endforeach
</body>
</html>