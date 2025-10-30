<!DOCTYPE html>
<html>
<head>
    <title>Laporan Mahasiswa Bermasalah</title>
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
    <h1>Laporan Mahasiswa Bermasalah</h1>
    <table>
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jenis Masalah</th>
                <th>Keterangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduans as $pengaduan)
                <tr>
                    <td>{{ $pengaduan->nim ?? 'Anonim' }}</td>
                    <td>{{ $pengaduan->nama ?? 'Anonim' }}</td>
                    <td>{{ $pengaduan->jenis_masalah }}</td>
                    <td>{{ $pengaduan->keterangan }}</td>
                    <td>{{ $pengaduan->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>