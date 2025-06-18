<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid black;
        padding: 5px;
        text-align: left;
    }
    .info-table {
        border: none;
        margin-bottom: 20px;
    }
    .info-table td {
        border: none;
        padding: 5px 10px;
    }
</style>

<table class="info-table">
    <tr>
        <td><strong>Nama Bank Soal:</strong> {{ $banksoal->nama_bank_soal }}</td>
        <td><strong>Mata Pelajaran:</strong> {{ $banksoal->mapel->nama_mapel ?? '-' }}</td>
    </tr>
    <tr>
        <td><strong>Level:</strong> {{ $banksoal->level }} - {{ $banksoal->jurusan }}</td>
        <td><strong>Jenis Tes:</strong> {{ $setting->jenis_tes }}</td>
    </tr>
    <tr>
        <td><strong>Waktu Mulai:</strong> {{ $setting->waktu_mulai }}</td>
        <td><strong>Waktu Selesai:</strong> {{ $setting->waktu_selesai }}</td>
    </tr>
    <tr>
        <td><strong>Durasi:</strong> {{ $setting->durasi }} menit</td>
        <td><strong>Sesi:</strong> {{ $setting->sesi }}</td>
    </tr>
    <tr>
        <td><strong>Token:</strong> {{ $setting->token }}</td>
        <td></td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>No. Ujian</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>Sesi</th>
            <th>Jumlah Soal</th>
            <th>Terjawab</th>
            <th>Jawaban Benar</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rekap as $i => $r)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $r['no_ujian'] }}</td>
            <td>{{ $r['nama'] }}</td>
            <td>{{ $r['kelas'] }}</td>
            <td>{{ $r['jurusan'] }}</td>
            <td>{{ $r['sesi'] }}</td>
            <td>{{ $r['total_soal'] }}</td>
            <td>{{ $r['menjawab'] }}</td>
            <td>{{ $r['benar'] }}</td>
            <td>{{ $r['nilai'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
