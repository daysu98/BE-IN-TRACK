<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }} - {{ $monthName }} {{ $year }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            margin: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
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
            padding: 6px;
            text-align: center;
            font-size: 8px;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .text-left {
            text-align: left;
        }
        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 8px;
            color: #666;
        }
        .summary {
            margin-top: 20px;
            font-size: 9px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $title }}</div>
        <div class="subtitle">Periode: {{ $monthName }} {{ $year }}</div>
    </div>

    @if(empty($recapData))
        <div style="text-align: center; margin: 50px 0;">
            <p>Tidak ada data absensi untuk periode {{ $monthName }} {{ $year }}</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Nama</th>
                    <th width="20%">Email</th>
                    <th width="15%">Institusi</th>
                    <th width="7%">Hadir</th>
                    <th width="7%">Ijin</th>
                    <th width="7%">Sakit</th>
                    <th width="7%">Alfa</th>
                    <th width="7%">Total</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $no = 1; 
                    $totalHadir = 0;
                    $totalIjin = 0;
                    $totalSakit = 0;
                    $totalAlfa = 0;
                    $totalKeseluruhan = 0;
                @endphp
                @foreach($recapData as $data)
                @php
                    $totalHadir += $data['hadir'];
                    $totalIjin += $data['ijin'];
                    $totalSakit += $data['sakit'];
                    $totalAlfa += $data['alpa'];
                    $totalKeseluruhan += $data['total'];
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td class="text-left">{{ $data['name'] ?? 'N/A' }}</td>
                    <td class="text-left">{{ $data['email'] ?? 'N/A' }}</td>
                    <td class="text-left">{{ $data['institution'] ?? 'N/A' }}</td>
                    <td>{{ $data['hadir'] ?? 0 }}</td>
                    <td>{{ $data['ijin'] ?? 0 }}</td>
                    <td>{{ $data['sakit'] ?? 0 }}</td>
                    <td>{{ $data['alpa'] ?? 0 }}</td>
                    <td>{{ $data['total'] ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f0f0f0; font-weight: bold;">
                    <td colspan="4">TOTAL</td>
                    <td>{{ $totalHadir }}</td>
                    <td>{{ $totalIjin }}</td>
                    <td>{{ $totalSakit }}</td>
                    <td>{{ $totalAlfa }}</td>
                    <td>{{ $totalKeseluruhan }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="summary">
            <h4>Ringkasan:</h4>
            <p>- Total Peserta Magang: {{ count($recapData) }} orang</p>
            <p>- Total Kehadiran: {{ $totalHadir }} hari</p>
            <p>- Total Izin: {{ $totalIjin }} hari</p>
            <p>- Total Sakit: {{ $totalSakit }} hari</p>
            <p>- Total Alfa: {{ $totalAlfa }} hari</p>
        </div>
    @endif

    <div class="footer">
        <p>Laporan dibuat pada: {{ $datetime }} WIB</p>
        <p>Sistem Manajemen Magang - InTrack</p>
    </div>
</body>
</html>