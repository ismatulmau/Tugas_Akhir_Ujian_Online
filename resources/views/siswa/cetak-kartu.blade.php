<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Kartu Peserta Ujian Tengah Semester</title>
    <style>
        @page {
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .kartu {
            border: 1px solid #333;
            padding: 10px;
            width: 90mm;
            height: 90mm;
            box-sizing: border-box;
            background-color: white;
            margin: 10mm auto;
            page-break-inside: avoid;
        }

        .header-kartu {
            text-align: center;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px solid #333;
        }

        .header-kartu h1 {
            font-size: 13px;
            margin: 2px 0;
            font-weight: bold;
        }

        .header-kartu h2 {
            font-size: 12px;
            margin: 2px 0;
        }

        .header-kartu h3 {
            font-size: 11px;
            margin: 2px 0;
        }

        table {
            width: 100%;
            font-size: 10px;
            margin-bottom: 10px;
        }

        table td {
            padding: 2px 0;
            vertical-align: top;
        }

        table tr td:first-child {
            width: 35%;
            font-weight: bold;
        }

        .signature-section {
            margin-top: 10px;
        }

        .signature-table {
            width: 100%;
            font-size: 9px;
            text-align: center;
        }

        .signature-table img {
            width: 60px;
            height: 80px;
            object-fit: cover;
            border: 1px solid #333;
            margin-bottom: 5px;
        }

        .foto-placeholder {
            width: 60px;
            height: 80px;
            background-color: #eee;
            border: 1px dashed #999;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #666;
            margin: auto;
        }

        .tanggal {
            font-size: 9px;
            margin-bottom: 5px;
        }

        .ttd-nama {
            font-size: 9px;
            margin-top: 30px;
        }

        .ttd-nip {
            font-size: 8px;
        }

        .catatan {
            font-size: 8px;
            margin-top: 8px;
            text-align: center;
            font-style: italic;
        }
    </style>
</head>

<body>
    @foreach($siswas as $siswa)
    <div class="kartu">
        <div class="header-kartu">
            <h1>KARTU PESERTA {{ strtoupper($jenis_ujian) }}</h1>
            <h2>SMK TELEMATIKA INDRAMAYU</h2>
            <h3>Tahun Pelajaran {{ $tahun_pelajaran }}</h3>
        </div>

        <table>
            <tr>
                <td><strong>Nomor Peserta</strong></td>
                <td>: {{ $siswa->nomor_ujian }}</td>
            </tr>
            <tr>
                <td><strong>Nama Peserta</strong></td>
                <td>: {{ strtoupper($siswa->nama_siswa) }}</td>
            </tr>
            <tr>
                <td width="30%"><strong>Kelas</strong></td>
                <td>: {{ $siswa->kelas->nama_kelas ?? '-' }} ({{ $siswa->jurusan }})</td>
            </tr>
            <tr>
                <td><strong>Sesi & Ruang Ujian</strong></td>
                <td>: Sesi {{ $siswa->sesi_ujian }} - Ruang {{ $siswa->ruang_ujian }}</td>
            </tr>
            <tr>
                <td><strong>Username</strong></td>
                <td>: {{ $siswa->nomor_ujian }}</td>
            </tr>
            <tr>
                <td><strong>Password</strong></td>
                <td>: {{ $siswa->password_asli }}</td>
            </tr>
        </table>


        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    @php
                    $fotoPath = storage_path('app/public/' . $siswa->gambar);
                    @endphp

                    <td>
                        @if($siswa->gambar && file_exists($fotoPath))
                        <img src="{{ $fotoPath }}">
                        @endif
                    </td>
                    <td></td>
                    <td>
                        <div class="tanggal">Indramayu, {{ date('d F Y') }}</div>
                        <div>Kepala Sekolah</div>
                        <div class="ttd-nama">{{ $nama_kepala }}</div>
                        <div class="ttd-nip">{{ $nip_kepala }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="catatan">
            Kartu ini wajib dibawa selama ujian berlangsung
        </div>
    </div>
    {{-- Halaman Belakang (Jadwal Ujian) --}}
    <div class="kartu">
        <div class="header-kartu">
            <h2>JADWAL UJIAN</h2>
        </div>
        <table border="1" cellspacing="0" cellpadding="4" style="font-size:9px; width:100%; border-collapse: collapse; text-align:center;">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th> <!-- Lebar kolom No diset ke 30px -->
                    <th>Hari / Tanggal</th>
                    <th>Waktu</th>
                    <th>Mata Pelajaran</th>
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
                </tr>
                @endforeach
                @endforeach


            </tbody>
        </table>
    </div>
    @endforeach
</body>

</html>