<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Nilai</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table.info td {
            text-align: left;
        }

        table tbody td {
            text-align: left;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #0d47a1;
            color: #fff;
        }

        .info td {
            border: none;
            padding: 3px;
        }

        .judul {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="judul">REKAP NILAI UJIAN</div>

    <table class="info">
        <tr>
            <td>Nama Bank Soal</td>
            <td>: {{ $setting->bankSoal->nama_bank_soal }}</td>
            <td>Mata Pelajaran</td>
            <td>: {{ $setting->bankSoal->mapel->nama_mapel ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jurusan</td>
            <td>: {{ $setting->bankSoal->level }} - {{ $setting->bankSoal->jurusan }}</td>
            <td>Jenis Tes</td>
            <td>: {{ $setting->jenis_tes }}</td>
        </tr>
        <tr>
            <td>Waktu Mulai</td>
            <td>: {{ $setting->waktu_mulai }}</td>
            <td>Waktu Selesai</td>
            <td>: {{ $setting->waktu_selesai }}</td>
        </tr>
        <tr>
            <td>Durasi</td>
            <td>: {{ $setting->durasi }} menit</td>
            <td>Sesi</td>
            <td>: {{ $setting->sesi }}</td>
        </tr>
        <tr>
            <td>Token</td>
            <td colspan="3">: {{ $setting->token }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Ujian</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jumlah Soal</th>
                <th>Terjawab</th>
                <th>Jawaban Benar</th>
                <th>Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $key => $data)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $data['nomor_ujian'] }}</td>
                <td>{{ $data['nama_siswa'] }}</td>
                <td>{{ $data['kelas'] }}</td>
                <td>{{ $data['jml_soal'] }}</td>
                <td>{{ $data['terjawab'] }}</td>
                <td>{{ $data['benar'] }}</td>
                <td><strong>{{ $data['nilai'] }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>