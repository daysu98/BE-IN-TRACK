<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absensi Magang - {{ $title }}</title>
    <style type="text/css">
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12px;
        }

        p, h1, h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>LAPORAN ABSENSI MAGANG</h1>
    <h3>{{ $title }}</h3>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                @if(isset($attendances[0]['user']['name']))
                    <th>Nama</th>
                @endif
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($attendances as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    @if(isset($item['user']['name']))
                        <td style="text-align: left;">{{ $item['user']['name'] }}</td>
                    @endif
                    <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d F Y') }}</td>
                    <td>{{ $item['jam_masuk'] ?? '-' }}</td>
                    <td>{{ $item['jam_keluar'] ?? '-' }}</td>
                    <td>{{ $item['status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Laporan dibuat pada: {{ $datetime }} WITA</p>
</body>
</html>