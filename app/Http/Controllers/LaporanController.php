<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Kondisi;
use App\Models\Provinsi;
use App\Models\Monitoring;
use App\Models\SumurPantau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfDay()->toDateString());
        $endDate = $request->input('end_date', now()->endOfDay()->toDateString());
        // Validasi tanggal
        if (!$startDate || !$endDate) {
            return response()->json(['error' => 'Tanggal mulai dan akhir diperlukan'], 400);
        }

        // Mengambil ID provinsi dan jumlah kondisi rusak
        $data = Kondisi::select('sumur_pantaus.provinsi_id', DB::raw('COUNT(*) as total'))
            ->join('monitorings', 'kondisis.id_monitoring', '=', 'monitorings.id')
            ->join('sumur_pantaus', 'monitorings.id_spantau', '=', 'sumur_pantaus.id')
            ->where('kondisis.kondisi', 'Rusak')
            ->whereBetween('kondisis.created_at', [$startDate, $endDate])
            ->groupBy('sumur_pantaus.provinsi_id') // Tambahkan kolom ke GROUP BY
            ->get();

        // Mengambil nama provinsi berdasarkan ID provinsi
        $provinsi = Provinsi::whereIn('id', $data->pluck('provinsi_id'))->pluck('name', 'id')->toArray();

        // Menyusun data akhir
        $data['result'] = $data->map(function ($item) use ($provinsi) {
            return [
                'provinsi' => $provinsi[$item->provinsi_id] ?? 'Unknown',
                'total' => $item->total,
            ];
        });

        $data['header'] = 'Laporan';

        return view('laporan.index', $data);
    }

    public function preview(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfDay()->toDateString());
        $endDate = $request->input('end_date', now()->endOfDay()->toDateString());

        $data = Kondisi::select('sumur_pantaus.provinsi_id', DB::raw('COUNT(*) as total'))
            ->join('monitorings', 'kondisis.id_monitoring', '=', 'monitorings.id')
            ->join('sumur_pantaus', 'monitorings.id_spantau', '=', 'sumur_pantaus.id')
            ->where('kondisis.kondisi', 'Rusak')
            ->whereBetween('kondisis.created_at', [$startDate, $endDate])
            ->groupBy('sumur_pantaus.provinsi_id') // Tambahkan kolom ke GROUP BY
            ->get();

        $provinsi = Provinsi::whereIn('id', $data->pluck('provinsi_id'))->pluck('name', 'id')->toArray();

        $result = $data->map(function ($item) use ($provinsi) {
            return [
                'provinsi' => $provinsi[$item->provinsi_id] ?? 'Unknown',
                'total' => $item->total,
            ];
        });

        return view('laporan.preview', ['result' => $result, 'startDate' => $startDate, 'endDate' => $endDate]);
    }
}
