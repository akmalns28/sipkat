<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\SumurPantau;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SumurPantauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['header'] = 'Sumur Pantau';
        return view('sumur-pantau.index', $data);
    }

    public function getSumurPantau()
    {
        $sumPantau = SumurPantau::all();
        return DataTables::of($sumPantau)
            ->addColumn('action', function ($row) {
                $hashid = $row->hashid; // Dapatkan hashid menggunakan accessor
                return '<a class="btn btn-outline-primary btn-sm btn-icon" title="Edit" href="' .
                    route('sumur-pantau.edit', ['sumur_pantau' => $hashid]) .
                    '"><i class="bx bx-pencil"></i></a>
                        <button type="button" title="Hapus" class="btn btn-outline-danger btn-icon btn-sm delete-button" data-id="' .
                    $hashid .
                    '"><i class="bx bx-trash"></i></button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['header'] = 'Tambah Sumur Pantau';
        return view('sumur-pantau.tambah-sumur-pantau', $data);
    }

    public function getProvinsi()
    {
        $provinsi = Provinsi::all();
        return response()->json($provinsi);
    }

    public function getKota($provinsi_id)
    {
        $kota = Kota::where('provinsi_id', $provinsi_id)->get();
        return response()->json($kota);
    }

    public function getKecamatan($kota_id)
    {
        $kecamatan = Kecamatan::where('kota_id', $kota_id)->get();
        return response()->json($kecamatan);
    }

    public function getKelurahan($kecamatan_id)
    {
        $kelurahan = Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
        return response()->json($kelurahan);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provinsi_id' => 'required',
            'kota_id' => 'required',
            'kecamatan_id' => 'required',
            'kelurahan_id' => 'required',
            'kode_sumur_pantau' => 'required|unique:sumur_pantaus',
            'no_inventarisasi' => 'required|unique:sumur_pantaus',
            'alamat' => 'required',
            'lokasi' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'foto' => 'required|unique:sumur_pantaus|max:1024',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $sumPantau = new SumurPantau();
        $sumPantau->provinsi_id = $request->provinsi_id;
        $sumPantau->kota_id = $request->kota_id;
        $sumPantau->kecamatan_id = $request->kecamatan_id;
        $sumPantau->kelurahan_id = $request->kelurahan_id;
        $sumPantau->kode_sumur_pantau = $request->kode_sumur_pantau;
        $sumPantau->no_inventarisasi = $request->no_inventarisasi;
        $sumPantau->alamat = $request->alamat;
        $sumPantau->lokasi = $request->lokasi;
        $sumPantau->longitude = $request->longitude;
        $sumPantau->latitude = $request->latitude;
        $sumPantau->status = 1;
        $sumPantau->id_user = auth()->user()->id;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $destination = 'public/img/sumur-pantau/';
            $imageName = time() . md5(rand(1000, 10000)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs($destination, $imageName);
            $sumPantau->foto = $imageName;
        } else {
            // Set a default value if no file is uploaded
            $sumPantau->foto = 'default-sumur-pantau.jpg';
        }

        $sumPantau->save();

        return redirect()->route('sumur-pantau.index')->with('success', 'Data Telah Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $hashid)
    {
        // Decode the hashid to get the real id
        $decodedId = SumurPantau::decodeHashid($hashid); // Decode hashid untuk mendapatkan ID asli
        $id = $decodedId[0] ?? null;
        if ($id) {
            $data['header'] = 'Detail Sumur Pantau';
            $data['sumurPantau'] = SumurPantau::findOrFail($id);

            // Return the data as JSON
            return view('sumur-pantau.detail', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $hashid)
    {
        $decodedId = SumurPantau::decodeHashid($hashid);
        $id = $decodedId[0] ?? null;

        if ($id) {
            $data['header'] = 'Edit Sumur Pantau';
            $data['sumPantau'] = SumurPantau::findOrFail($id);
            // $data['provinsis'] = Provinsi::all(); // Fetch all provinces
            // $data['selectedKota'] = Kota::where('provinsi_id', $data['sumurPantau']->provinsi_id)->get();
            // $data['selectedKecamatan'] = Kecamatan::where('kota_id', $data['sumurPantau']->kota_id)->get();
            // $data['selectedKelurahan'] = Kelurahan::where('kecamatan_id', $data['sumurPantau']->kecamatan_id)->get();
            return view('sumur-pantau.edit-sumur-pantau', $data);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the existing record
        $sumPantau = SumurPantau::find($id);

        if (!$sumPantau) {
            return redirect()->back()->with('failed', 'Record not found');
        }

        // Validate input, ignoring the current record for unique fields
        $validator = Validator::make($request->all(), [
            'provinsi_id' => 'required',
            'kota_id' => 'required',
            'kecamatan_id' => 'required',
            'kelurahan_id' => 'required',
            'kode_sumur_pantau' => 'required|unique:sumur_pantaus,kode_sumur_pantau,' . $sumPantau->id,
            'no_inventarisasi' => 'required|unique:sumur_pantaus,no_inventarisasi,' . $sumPantau->id,
            'alamat' => 'required',
            'lokasi' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'foto' => 'nullable|image|max:1024', // Foto validation should be image, not unique
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validData = $validator->validated();

        // Compare the data to check if anything changed
        $isChanged = false;
        foreach ($validData as $key => $value) {
            if ($sumPantau->$key != $value) {
                $isChanged = true;
                break;
            }
        }

        // Check if a new photo was uploaded
        if (!$isChanged && !$request->hasFile('foto')) {
            return redirect()->route('sumur-pantau.index')->with('failed', 'Tidak Ada Perubahan Data');
        }

        // Update the record with validated data
        $sumPantau->provinsi_id = $request->provinsi_id;
        $sumPantau->kota_id = $request->kota_id;
        $sumPantau->kecamatan_id = $request->kecamatan_id;
        $sumPantau->kelurahan_id = $request->kelurahan_id;
        $sumPantau->kode_sumur_pantau = $request->kode_sumur_pantau;
        $sumPantau->no_inventarisasi = $request->no_inventarisasi;
        $sumPantau->alamat = $request->alamat;
        $sumPantau->lokasi = $request->lokasi;
        $sumPantau->longitude = $request->longitude;
        $sumPantau->latitude = $request->latitude;
        $sumPantau->status = $request->status;
        $sumPantau->updated_by = auth()->user()->name . '/' . auth()->user()->nik;

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $destination = 'public/img/sumur-pantau/';
            $imageName = $sumPantau->foto ?: 'default-sumur-pantau.jpg'; // Use existing or default
            $file->storeAs($destination, $imageName);
            $sumPantau->foto = $imageName;
        }

        $sumPantau->save();

        return redirect()->route('sumur-pantau.index')->with('success', 'Data Telah Berhasil Diperbarui');
    }

    // public function updateStatus()
    // {
    //     $fiveMinutesAgo = Carbon::now()->subMinutes(5);
    //     $idsWithRecentMonitoring = DB::table('monitorings')->where('created_at', '>=', $fiveMinutesAgo)->pluck('id_spantau')->unique();

    //     SumurPantau::whereNotIn('id', $idsWithRecentMonitoring)->update(['status' => 0]);

    //     return response()->json(['message' => 'SumurPantau statuses updated successfully.']);
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $hashid)
    {
        try {
            $decodedId = SumurPantau::decodeHashid($hashid); // Decode hashid untuk mendapatkan ID asli
            $id = $decodedId[0] ?? null;
            if ($id) {
                $SPantau = SumurPantau::findOrFail($id);
                $SPantau->delete();

                return response()->json(['success' => 'Data Telah Berhasil Dihapus'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
