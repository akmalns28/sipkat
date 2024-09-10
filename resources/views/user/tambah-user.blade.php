@extends('layouts.app')
@push('style')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush
@push('breadcumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('user.index') }}">User</a>
    </li>
    <li class="breadcrumb-item active">{{ $header }}</li>
@endpush
@section('content')
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"></h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        {{-- col 1 --}}
                        <div class="d-flex flex-column gap-2 col-lg-6 mb-3">
                            <div>
                                <label class="form-label" for="nik">NIP</label>
                                <input type="number" min="0"
                                    class="form-control @error('nik')
                                  is-invalid
                                @enderror"
                                    value="{{ old('nik') }}" id="nik" name="nik" placeholder="Masukan nik">
                                @error('nik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="name">Nama Lengkap</label>
                                <input type="text"
                                    class="form-control @error('name') is-invalid
                                @enderror"
                                    value="{{ old('name') }}" id="name" name="name"
                                    placeholder="Masukan nama lengkap">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="email">Email</label>
                                <input type="text"
                                    class="form-control @error('email')
                                  is-invalid
                                @enderror"
                                    value="{{ old('email') }}" id="email" name="email" placeholder="Masukan email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- col 2 --}}
                        <div class="d-flex flex-column gap-2 col-lg-6 mb-3">
                            <div>
                                <label class="form-label" for="username">Username</label>
                                <input type="text"
                                    class="form-control @error('username')
                                  is-invalid
                                @enderror"
                                    value="{{ old('username') }}" id="username" name="username"
                                    placeholder="Masukan username">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label for="role" class="form-label">Role</label>
                                <select id="role" value="{{ old('role') }}" name="role"
                                    class="form-select @error('role')
                                  is-invalid
                                @enderror">
                                    <option>Pilih Role</option>
                                    <option value="super admin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="kepala bidang">Kepala Bidang</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('user.index') }}" class="btn btn-outline-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
