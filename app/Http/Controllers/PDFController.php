<?php

namespace App\Http\Controllers;

use App\Models\InternAttend;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generatePDF()
    {
        try {
            $attendances = InternAttend::with(['user'])->latest('created_at')->get();

            $data = [
                'title' => 'ABSENSI MAGANG ' . now('Asia/Kuala_Lumpur')->year,
                'datetime' => now('Asia/Kuala_Lumpur')->format('l, d F Y H:i'),
                'attendances' => $attendances->toArray(),
            ];

            $pdf = Pdf::loadView('pdf.myPDF', $data)
                ->setPaper('a4', 'portrait')
                ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

            $fileName = 'Absensi-Magang-' . now('Asia/Kuala_Lumpur')->format('Y-m-d') . '.pdf';

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat PDF: ' . $e->getMessage()], 500);
        }
    }

    public function generatePDFByUserId($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $attendances = InternAttend::where('user_id', $userId)
                ->with(['user'])
                ->latest('created_at')
                ->get();

            $data = [
                'title' => 'ABSENSI MAGANG - ' . strtoupper($user->name),
                'datetime' => now('Asia/Kuala_Lumpur')->format('l, d F Y H:i'),
                'attendances' => $attendances->toArray(),
                'user' => $user->toArray(),
            ];

            $pdf = Pdf::loadView('pdf.attendance-personal', $data)
                ->setPaper('a4', 'portrait')
                ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

            $fileName = 'Absensi-' . str_replace(' ', '-', $user->name) . '-' . now('Asia/Kuala_Lumpur')->format('Y-m-d') . '.pdf';

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error for User ' . $userId . ': ' . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat PDF: ' . $e->getMessage()], 500);
        }
    }

    public function generateMonthlyRecap($year, $month)
    {
        try {
            \Log::info('Starting monthly recap generation', ['year' => $year, 'month' => $month]);

            if (!is_numeric($year) || !is_numeric($month)) {
                \Log::error('Invalid year or month format', ['year' => $year, 'month' => $month]);
                return response()->json(['error' => 'Format tahun atau bulan tidak valid'], 400);
            }

            if ($month < 1 || $month > 12) {
                \Log::error('Invalid month range', ['month' => $month]);
                return response()->json(['error' => 'Bulan harus antara 1-12'], 400);
            }

            $interns = User::where('role', 'intern')->get();
            \Log::info('Found interns', ['count' => $interns->count()]);

            if ($interns->isEmpty()) {
                \Log::warning('No interns found');
                return response()->json(['error' => 'Tidak ada data intern'], 404);
            }

            $recapData = [];

            foreach ($interns as $intern) {
                \Log::info('Processing intern', ['intern_id' => $intern->id, 'name' => $intern->name]);

                $attendances = InternAttend::where('user_id', $intern->id)
                    ->whereYear('tanggal', $year)
                    ->whereMonth('tanggal', $month)
                    ->get();

                \Log::info('Found attendances', ['intern_id' => $intern->id, 'count' => $attendances->count()]);

                $hadir = $attendances->where('status', 'Hadir')->count();
                $ijin = $attendances->where('status', 'Ijin')->count();
                $sakit = $attendances->where('status', 'Sakit')->count();
                $alpa = $attendances->where('status', 'Alpa')->count();

                $recapData[] = [
                    'name' => $intern->name ?? 'Unknown',
                    'email' => $intern->email ?? 'Unknown',
                    'institution' => $intern->institution ?? 'Tidak Ada',
                    'hadir' => $hadir,
                    'ijin' => $ijin,
                    'sakit' => $sakit,
                    'alpa' => $alpa,
                    'total' => $attendances->count(),
                ];
            }

            $monthNames = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember'
            ];

            $monthName = $monthNames[(int) $month] ?? 'Unknown';

            $data = [
                'title' => 'REKAP ABSENSI MAGANG',
                'monthName' => $monthName,
                'year' => $year,
                'datetime' => now('Asia/Kuala_Lumpur')->format('l, d F Y H:i'),
                'recapData' => $recapData,
            ];

            \Log::info('Preparing PDF data', ['data_count' => count($recapData)]);

            $pdf = Pdf::loadView('pdf.recapPDF', $data)
                ->setPaper('a4', 'landscape')
                ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

            $fileName = 'Rekap-Absensi-' . $monthName . '-' . $year . '.pdf';

            \Log::info('PDF generation successful', ['filename' => $fileName]);

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            \Log::error('Monthly Recap PDF Generation Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Gagal membuat rekap PDF: ' . $e->getMessage()], 500);
        }
    }
}
