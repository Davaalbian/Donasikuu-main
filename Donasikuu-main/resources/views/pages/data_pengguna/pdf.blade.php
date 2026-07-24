<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Pengguna</title>

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

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
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
        <h2>LAPORAN DATA PENGGUNA</h2>
        <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>
    </div>

    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama</th>
                <th width="12%">Jenis Kelamin</th>
                <th width="23%">Email</th>
                <th width="15%">No HP</th>
                <th width="25%">Alamat</th>
            </tr>
        </thead>

        <tbody>

            @forelse($users as $item)

            <tr>
                <td>{{ $loop->iteration }}</td>

                <td class="text-left">
                    {{ $item->name }}
                </td>

                <td>
                    @if($item->jenis_kelamin == 'L')
                        Laki-laki
                    @elseif($item->jenis_kelamin == 'P')
                        Perempuan
                    @else
                        -
                    @endif
                </td>

                <td class="text-left">
                    {{ $item->email }}
                </td>

                <td>
                    {{ $item->no_telp ?? '-' }}
                </td>

                <td class="text-left">
                    {{ $item->alamat ?? '-' }}
                </td>
            </tr>

            @empty

            <tr>
                <td colspan="6">
                    Tidak ada data donatur
                </td>
            </tr>

            @endforelse

        </tbody>
    </table>

    <p style="margin-top:10px;">
        Total Data: <b>{{ $users->count() }}</b>
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