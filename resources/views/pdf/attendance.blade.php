<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
            font-size: 9px;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .text-left {
            text-align: left;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 8px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $title }}</div>
        <div class="subtitle">Laporan Absensi Lengkap</div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama</th>
                <th width="15%">Tanggal</th>
                <th width="15%">Jam Masuk</th>
                <th width="15%">Jam Keluar</th>
                <th width="15%">Status</th>
                <th width="15%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($attendances as $attendance)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-left">{{ $attendance['user']['name'] ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($attendance['tanggal'])->format('d/m/Y') }}</td>
                <td>{{ $attendance['jam_masuk'] ?? '-' }}</td>
                <td>{{ $attendance['jam_keluar'] ?? '-' }}</td>
                <td>{{ $attendance['status'] }}</td>
                <td>
                    @if($attendance['status'] == 'Hadir')
                        Hadir Normal
                    @elseif($attendance['status'] == 'Ijin')
                        Izin
                    @elseif($attendance['status'] == 'Sakit')
                        Sakit
                    @else
                        Alfa
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan dibuat pada: {{ $datetime }} WIB</p>
        <p>Sistem Manajemen Magang - InTrack</p>
    </div>
</body>
</html>