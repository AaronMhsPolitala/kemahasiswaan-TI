<!DOCTYPE html>
<html>
<head>
    <title>Laporan Mahasiswa Bermasalah</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
            word-wrap: break-word;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Laporan Mahasiswa Bermasalah</h1>
    <table>
        <colgroup>
            <col style="width: 10%;">
            <col style="width: 15%;">
            <col style="width: 10%;">
            <col style="width: 15%;">
            <col style="width: 10%;">
            <col style="width: 30%;">
            <col style="width: 10%;">
        </colgroup>
        <thead>
            <tr>
                <th>NIM Pelapor</th>
                <th>Nama Pelapor</th>
                <th>NIM Terlapor</th>
                <th>Nama Terlapor</th>
                <th>Jenis Masalah</th>
                <th>Jenis Pelanggaran / Keterangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduans as $pengaduan)
                <tr>
                    <td>{{ $pengaduan->nim ?? 'Anonim' }}</td>
                    <td>{{ $pengaduan->nama ?? 'Anonim' }}</td>
                    <td>{{ $pengaduan->nim_terlapor ?? 'N/A' }}</td>
                    <td>{{ $pengaduan->nama_terlapor ?? 'N/A' }}</td>
                    <td>{{ $pengaduan->jenis_masalah }}</td>
                    <td>{{ $pengaduan->keterangan }}</td>
                    <td>{{ $pengaduan->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>