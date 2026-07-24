<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Donasi</title>

    <style>
        @page {
            size: A4;
            margin: 20px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .line {
            border-top: 2px solid black;
            margin: 10px 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background-color: #eaeaea;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 6px;
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .footer {
            margin-top: 30px;
            width: 100%;
        }

        .ttd {
            width: 200px;
            float: right;
            text-align: center;
        }
        
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN DATA DONASI</h2>
        <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>
        <p><b>RT:</b> {{ $rt ? 'RT ' . $rt : 'Semua RT' }}</p>
    </div>

    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Donatur</th>
                <th>No HP</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-left">{{ $item->user->name ?? '-' }}</td>
                <td>{{ $item->user->no_telp ?? '-' }}</td>
                <td class="text-left">{{ $item->nama_barang }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->format('d-m-Y') }}</td>
                <td>{{ ucfirst($item->status_donasi) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:10px;">
        Total Data: <b>{{ count($data) }}</b>
    </p>

    <div class="footer">
        <div class="ttd">
            <p>Tangerang, {{ date('d-m-Y') }}</p>
            <br><br><br>
            <p><b>Admin Donasiku</b></p>
        </div>
    </div>

</body>
</html>