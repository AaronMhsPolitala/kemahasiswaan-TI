<!DOCTYPE html>
<html>
<head>
    <title>Laporan Prestasi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Prestasi</h1>
    <table>
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>IPK</th>
                <th>Nama Kegiatan</th>
                <th>Waktu Penyelenggaraan</th>
                <th>Tingkat Kegiatan</th>
                <th>Prestasi yang Dicapai</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestasis as $prestasi)
                <tr>
                    <td>{{ $prestasi->nim }}</td>
                    <td>{{ $prestasi->nama_mahasiswa }}</td>
                    <td>{{ $prestasi->ipk }}</td>
                    <td>{{ $prestasi->nama_kegiatan }}</td>
                    <td>{{ $prestasi->waktu_penyelenggaraan }}</td>
                    <td>{{ $prestasi->tingkat_kegiatan }}</td>
                    <td>{{ $prestasi->prestasi_yang_dicapai }}</td>
                    <td>{{ $prestasi->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>