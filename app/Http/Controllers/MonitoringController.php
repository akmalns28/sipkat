<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kondisi;
use App\Models\Logbook;
use App\Models\Monitoring;
use App\Models\SumurPantau;
use Illuminate\Http\Request;
use App\Mail\WarningNotification;
use Illuminate\Support\Facades\DB;
use App\Services\MonitoringService;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MonitoringController extends Controller
{
    protected $monitoringService;

    public function __construct(MonitoringService $monitoringService)
    {
        $this->monitoringService = $monitoringService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['header'] = 'Monitoring Sumur Pantau';
        return view('monitoring.index', $data);
    }

    public function getMonitoring()
    {
        // $spantau = DB::table('monitorings')->leftJoin('sumur_pantaus', 'monitorings.id_spantau', '=', 'sumur_pantaus.id')->select('monitorings.*', 'sumur_pantaus.*')->get();
        $spantau = SumurPantau::all();
        return DataTables::of($spantau)
            ->addColumn('action', function ($row) {
                $hashid = $row->hashid; // Dapatkan hashid menggunakan accessor
                return '<a class="btn btn-outline-primary  btn-sm btn-icon" title="Detail" href="' .
                    route('monitoring.show', ['monitoring' => $hashid]) .
                    '"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
 <path fill="currentColor" d="M15.729 3.884c1.434-1.44 3.532-1.47 4.693-.304c1.164 1.168 1.133 3.28-.303 4.72l-2.423 2.433a.75.75 0 0 0 1.062 1.059l2.424-2.433c1.911-1.919 2.151-4.982.303-6.838c-1.85-1.857-4.907-1.615-6.82.304L9.819 7.692c-1.911 1.919-2.151 4.982-.303 6.837a.75.75 0 1 0 1.063-1.058c-1.164-1.168-1.132-3.28.303-4.72z" />
 <path fill="currentColor" d="M14.485 9.47a.75.75 0 0 0-1.063 1.06c1.164 1.168 1.133 3.279-.303 4.72l-4.847 4.866c-1.435 1.44-3.533 1.47-4.694.304c-1.164-1.168-1.132-3.28.303-4.72l2.424-2.433a.75.75 0 0 0-1.063-1.059l-2.424 2.433c-1.911 1.92-2.151 4.982-.303 6.838c1.85 1.858 4.907 1.615 6.82-.304l4.847-4.867c1.911-1.918 2.151-4.982.303-6.837" />
</svg></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['header'] = 'Tambah Monitoring Sumur Pantau';
        $data['spantau'] = SumurPantau::where('status', 0)->get();
        return view('monitoring.tambah-monitoring', $data);
    }

    public function insertMonitoringData()
    {
        $result = $this->monitoringService->insertMonitoringData();

        if ($result['status'] == 'error') {
            return response()->json(['message' => $result['message']], 400);
        }

        return response()->json(['message' => $result['message']], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_spantau' => 'required',
            'muka_air_tanah' => 'required',
            'total_dissolve_solid' => 'required',
            'daya_hantar_listrik' => 'required',
        ]);

        $qualityAssessment = function ($total_dissolve_solid, $daya_hantar_listrik) {
            if ($total_dissolve_solid < 1000 || $daya_hantar_listrik < 1000) {
                return 'Aman';
            } elseif (($total_dissolve_solid >= 1000 && $total_dissolve_solid <= 10000) || ($daya_hantar_listrik >= 1000 && $daya_hantar_listrik <= 1500)) {
                return 'Rawan';
            } elseif (($total_dissolve_solid > 10000 && $total_dissolve_solid <= 100000) || ($daya_hantar_listrik > 1500 && $daya_hantar_listrik <= 5000)) {
                return 'Kritis';
            } elseif ($total_dissolve_solid > 100000 || $daya_hantar_listrik > 5000) {
                return 'Rusak';
            }
            return 'Unknown';
        };

        $adminUsers = DB::table('users')->where('role', 'admin')->pluck('email')->toArray();

        $kondisi = $qualityAssessment($request->total_dissolve_solid, $request->daya_hantar_listrik);

        $monitoring = new Logbook();
        $monitoring->id_user = auth()->id();
        $monitoring->id_spantau = $request->id_spantau;
        $monitoring->muka_air_tanah = $request->muka_air_tanah;
        $monitoring->total_dissolve_solid = $request->total_dissolve_solid;
        $monitoring->daya_hantar_listrik = $request->daya_hantar_listrik;
        $monitoring->kondisi = $kondisi;
        $monitoring->save();

        if ($kondisi === 'Rusak') {
            foreach ($adminUsers as $email) {
                Mail::to($email)->send(new WarningNotification($request->id_spantau, $request->muka_air_tanah, $request->total_dissolve_solid, $request->daya_hantar_listrik, $kondisi, Carbon::now()));
            }
        }

        return redirect()->route('monitoring.index')->with('success', 'Monitoring Telah Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $hashid)
    {
        $decodedId = Monitoring::decodeHashid($hashid);
        $id = $decodedId[0] ?? null;

        if ($id) {
            $data['header'] = 'Monitoring Sumur Pantau';
            $data['hashid'] = $hashid;

            $data['sumPantau'] = SumurPantau::with('provinsi', 'kota', 'kecamatan', 'kelurahan')->findOrFail($id);
            $data['logbooks'] = Logbook::where('id_spantau', $id)->orderBy('created_at', 'desc')->get();
            $data['logbooksLast'] = Logbook::where('id_spantau', $id)->orderBy('created_at', 'desc')->first();
            $data['monitoringLast'] = Monitoring::where('id_spantau', $id)->orderBy('created_at', 'desc')->first();

            $today = Carbon::today()->format('Y-m-d'); // Mendapatkan tanggal hari ini dalam format string
            // Ambil data kondisi berdasarkan id_monitoring dari data monitoring yang diambil
            $data['kondisiData'] = Kondisi::whereHas('monitoring', function ($query) use ($id, $today) {
                $query->where('id_spantau', $id)->whereDate('created_at', $today);
            })->get();
            // Ambil data dari tabel kondisi berdasarkan id_monitoring dan rentang tanggal
            $data['startDate'] = $today;
            $data['endDate'] = $today;

            return view('monitoring.detail-monitoring', $data);
        }

        return redirect()
            ->back()
            ->withErrors(['msg' => 'Data tidak ditemukan']);
    }

    public function filter(Request $request, string $hashid)
    {
        $decodedId = Monitoring::decodeHashid($hashid);
        $id = $decodedId[0] ?? null;

        if ($id) {
            $startDate = $request->input('start_date') ?? Carbon::today()->format('Y-m-d');
            $endDate = $request->input('end_date') ?? Carbon::today()->format('Y-m-d');
            $perPage = $request->input('per_page', 10); // Default to 10 if not specified

            // Ambil data dari tabel kondisi berdasarkan id_monitoring dan rentang tanggal dengan pagination
            $kondisiData = Kondisi::with('monitoring')
                ->whereHas('monitoring', function ($query) use ($id, $startDate, $endDate) {
                    $query->where('id_spantau', $id)
                          ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
                })
                ->orderBy('created_at', 'desc') // Menambahkan orderBy desc
                ->paginate($perPage);

            return response()->json($kondisiData);
        }

        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
