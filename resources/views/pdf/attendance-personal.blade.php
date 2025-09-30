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
        .user-info {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .user-info h3 {
            margin: 0 0 10px 0;
            font-size: 12px;
        }
        .user-info p {
            margin: 5px 0;
            font-size: 10px;
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
        <div class="subtitle">Laporan Absensi Personal</div>
    </div>

    <div class="user-info">
        <h3>Informasi Peserta Magang</h3>
        <p><strong>Nama:</strong> {{ $user['name'] }}</p>
        <p><strong>Email:</strong> {{ $user['email'] }}</p>
        <p><strong>Tanggal Bergabung:</strong> {{ $user['date'] ?? 'Tidak Ada' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="25%">Tanggal</th>
                <th width="20%">Jam Masuk</th>
                <th width="20%">Jam Keluar</th>
                <th width="25%">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($attendances as $attendance)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ \Carbon\Carbon::parse($attendance['tanggal'])->format('d/m/Y') }}</td>
                <td>{{ $attendance['jam_masuk'] ?? '-' }}</td>
                <td>{{ $attendance['jam_keluar'] ?? '-' }}</td>
                <td>
                    @if($attendance['status'] == 'Hadir')
                        Present
                    @elseif($attendance['status'] == 'Alpa')
                        Alfa
                    @else
                        {{ $attendance['status'] }}
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