<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\AccountCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $data['header'] = 'User';
        return view('user.index', $data);
    }

    public function getUsers()
    {
        $users = User::whereNot('nik', auth()->user()->nik)->get();
        return DataTables::of($users)
            ->addColumn('action', function ($row) {
                $hashid = $row->hashid; // Dapatkan hashid menggunakan accessor
                if ($row->role === 'super admin') {
                    return '<span class="small text-muted text-center fst-italic">View only</span>';
                } else {
                    return '<a class="btn btn-outline-primary btn-icon btn-sm" title="edit" href="' .
                        route('user.edit', ['user' => $hashid]) .
                        '"><i class="bx bx-pencil"></i></a>
                        <button type="button" class="btn btn-outline-danger btn-icon btn-sm delete-button" title="Hapus" data-id="' .
                        $hashid .
                        '"><i class="bx bx-trash"></i></button>';
                }
            })
            ->editColumn('created_at', function ($row) {
                return '<span class="small text-muted">' . $row->created_at->format('d-m-Y H:i') . '</span>';
            })
            ->rawColumns(['action', 'created_at'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['header'] = 'Tambah User';
        return view('user.tambah-user', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = substr(str_shuffle($string), 0, 8);
        $hashPassword = Hash::make($password);

        User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $hashPassword,
            'role' => $request->role,
        ]);

        Mail::to($request->email)->send(new AccountCreated($request->name, $request->username, $password));

        return redirect()->route('user.index')->with('success', 'Data Telah Berhasil Ditambahkan');
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($request->current_password == $user->password) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = substr(str_shuffle($string), 0, 8);
        $hashPassword = Hash::make($password);

        $user->password = Hash::make($hashPassword);
        $user->update();

        return back()->with('success', 'Password updated successfully');
    }

    public function setting()
    {
        $user = Auth::user(); // Get the authenticated user

        if ($user) {
            $data['user'] = $user;
            return view('user.setting', $data);
        } else {
            abort(404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $hashid)
    {
        $decodedId = User::decodeHashid($hashid); // Decode hashid untuk mendapatkan ID asli
        $id = $decodedId[0] ?? null; // Mengambil ID pertama dari hasil decode

        if ($id) {
            $data['header'] = 'Edit User';
            $data['user'] = User::findOrFail($id);
            return view('user.edit-user', $data);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|unique:users,nik,' . $user->id,
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|unique:users,username,' . $user->id . '|max:10',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validData = $validator->validated();

        // Prepare the data to compare with the existing user data
        $updateData = [
            'nik' => $validData['nik'],
            'name' => $validData['name'],
            'email' => $validData['email'],
            'username' => $validData['username'],
            'role' => $validData['role'],
        ];

        // Only add password to update data if it's provided
        if (!empty($validData['password'])) {
            $updateData['password'] = bcrypt($validData['password']);
        }

        // Compare the data
        $isChanged = false;
        foreach ($updateData as $key => $value) {
            if ($user->$key != $value) {
                $isChanged = true;
                break;
            }
        }

        if (!$isChanged) {
            return redirect()->route('user.index')->with('failed', 'Tidak Ada Perubahan Data');
        }

        $user->update($updateData);

        $currentUrl = $request->url();

        if (str_contains($currentUrl, 'profil')) {
            // If the current URL contains 'setting', redirect back
            return redirect()->back()->with('success', 'Data Telah Berhasil Diperbarui');
        } elseif (str_contains($currentUrl, 'user')) {
            // If the current URL contains 'user/edit', redirect to the index
            return redirect()->route('user.index')->with('success', 'Data Telah Berhasil Diperbarui');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $hashid)
    {
        try {
            $decodedId = User::decodeHashid($hashid); // Decode hashid untuk mendapatkan ID asli
            $id = $decodedId[0] ?? null; // Mengambil ID pertama dari hasil decode

            if ($id) {
                $user = User::findOrFail($id);
                $user->delete();

                return response()->json(['success' => 'Data Telah Berhasil Dihapus'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 422);
        }
    }
}
