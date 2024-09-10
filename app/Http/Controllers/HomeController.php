<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SumurPantau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['header'] = 'Dashboard';

        $data['tSumurPantau'] = SumurPantau::count();
        $data['tUser'] = User::count();
        $data['tSumurPantauAktif'] = SumurPantau::where('status', 1)->count();
        $data['tSumurPantauNAktif'] = SumurPantau::where('status', 0)->count();

        // Get the count of Sumur Pantau per province
        $sumurPantauPerProvinsi = SumurPantau::select(DB::raw('count(*) as total, provinsi_id'))->groupBy('provinsi_id')->with('provinsi')->get();

        // Prepare data for the chart
        $data['labels'] = $sumurPantauPerProvinsi->pluck('provinsi.name');
        $data['data'] = $sumurPantauPerProvinsi->pluck('total');

        $currentYear = now()->year;
        $previousYear = $currentYear - 1;

        // Menghitung jumlah SumurPantau per tahun
        $currentYearCount = DB::table('sumur_pantaus')->whereYear('created_at', $currentYear)->count();

        $previousYearCount = DB::table('sumur_pantaus')->whereYear('created_at', $previousYear)->count();

        // Menghitung persentase perubahan
        if ($previousYearCount > 0) {
            $percentageChange = (($currentYearCount - $previousYearCount) / $previousYearCount) * 100;
        } else {
            $percentageChange = $currentYearCount > 0 ? 100 : 0; // Jika data tahun lalu tidak ada, dan ada data tahun ini
        }

        return view('dashboard', $data, [
            'currentYearCount' => $currentYearCount,
            'previousYearCount' => $previousYearCount,
            'percentageChange' => $percentageChange,
        ]);
    }
}
