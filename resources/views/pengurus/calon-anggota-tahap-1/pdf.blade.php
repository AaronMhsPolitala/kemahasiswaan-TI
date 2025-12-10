<!DOCTYPE html>
<html>
<head>
    <title>Laporan Calon Anggota Tahap 1</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
    <h1>Laporan Calon Anggota Tahap 1</h1>
    <table>
        <thead>
            <tr>
                <th>Foto</th>
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
                    <td>
                        @if($candidate->gambar)
                            <img src="{{ public_path('storage/' . $candidate->gambar) }}" alt="Foto" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <span>N/A</span>
                        @endif
                    </td>
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
