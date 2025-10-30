<!DOCTYPE html>
<html>
<head>
    <title>Laporan Calon Anggota Tahap 1</title>
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
    <h1>Laporan Calon Anggota Tahap 1</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>NIM</th>
                <th>Nomor HP</th>
                <th>Divisi Tujuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidates as $candidate)
                <tr>
                    <td>{{ $candidate->name }}</td>
                    <td>{{ $candidate->nim ?? 'N/A' }}</td>
                    <td>{{ $candidate->hp ?? 'N/A' }}</td>
                    <td>{{ $candidate->divisi->nama_divisi ?? 'N/A' }}</td>
                    <td>{{ $candidate->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
