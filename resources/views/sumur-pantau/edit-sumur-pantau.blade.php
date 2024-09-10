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
        <a href="{{ route('sumur-pantau.index') }}">Sumur Pantau</a>
    </li>
    <li class="breadcrumb-item active">{{ $header }}</li>
@endpush
@section('content')
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"></h5><small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form action="{{ route('sumur-pantau.update', $sumPantau->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div>
                                <label for="upload" class="form-label">Foto</label>
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <img src="{{ asset('storage/img/sumur-pantau') . '/' . $sumPantau->foto }}"
                                        alt="user-avatar" class="d-block rounded" width="100px" id="uploadedAvatar">
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-4 btn-sm" tabindex="0">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" name="foto" id="upload" hidden=""
                                                accept="image/png, image/jpeg"
                                                class="account-file-input form-control @error('foto')
                                    is-invalid
                                @enderror">
                                            @error('foto')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </label>
                                        <button type="button"
                                            class="btn btn-outline-secondary btn-sm account-image-reset mb-4">
                                            <i class="bx bx-reset d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>

                                        <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 1MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- col 1 --}}
                        <div class="d-flex flex-column gap-2 col-lg-6 mb-3">
                            <div>
                                <label class="form-label" for="kode_sumur_pantau">Kode Sumur Pantau</label>
                                <input type="text" min="0"
                                    class="form-control @error('kode_sumur_pantau')
                                  is-invalid
                                @enderror"
                                    value="{{ $sumPantau->kode_sumur_pantau }}" id="kode_sumur_pantau"
                                    name="kode_sumur_pantau" placeholder="Masukan kode sumur pantau">
                                @error('kode_sumur_pantau')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="no_inventarisasi">No Inventarisasi</label>
                                <input type="number" min="0" inputmode="numeric"
                                    class="form-control @error('no_inventarisasi')
                                  is-invalid
                                @enderror"
                                    value="{{ $sumPantau->no_inventarisasi }}" id="no_inventarisasi" name="no_inventarisasi"
                                    placeholder="Masukan no inventarisasi">
                                @error('no_inventarisasi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="longitude">Longitude</label>
                                <input type="text" min="0"
                                    class="form-control @error('longitude')
                                  is-invalid
                                @enderror"
                                    value="{{ $sumPantau->longitude }}" id="longitude" name="longitude"
                                    placeholder="Masukan longitude">
                                @error('longitude')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="latitude">Latitude</label>
                                <input type="text" min="0"
                                    class="form-control @error('latitude')
                                  is-invalid
                                @enderror"
                                    value="{{ $sumPantau->latitude }}" id="latitude" name="latitude"
                                    placeholder="Masukan latitude">
                                @error('latitude')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="lokasi">Lokasi</label>
                                <input type="text"
                                    class="form-control @error('lokasi')
                                  is-invalid
                                @enderror"
                                    value="{{ $sumPantau->lokasi }}" id="lokasi" name="lokasi"
                                    placeholder="Masukan lokasi">
                                @error('lokasi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        {{-- col 2 --}}
                        <div class="d-flex flex-column gap-2 col-lg-6 mb-3">
                            <div class="">
                                <label class="form-label" for="provinsi">Provinsi</label>
                                <select id="provinsi_id" name="provinsi_id" class="form-select select2"
                                    @error('provinsi_id')
                                    
                                @enderror
                                    value="{{old('provinsi_id') }}">

                                    <option value="">Pilih Provinsi</option>
                                </select>
                                @error('pronvisi_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="">
                                <label class="form-label" for="kota">Kota</label>
                                <select id="kota_id" name="kota_id" class="form-select select2"
                                    @error('kota_id')
                                
                            @enderror
                                    value="{{ old('kota_id') }}">
                                    <option value="">Pilih Kota</option>
                                </select>
                                @error('kota_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="">
                                <label class="form-label" for="kecamatan">Kecamatan</label>
                                <select id="kecamatan_id" name="kecamatan_id" class="form-select select2"
                                    @error('kecamatan_id')
                                
                            @enderror
                                    value="{{ old('kecamatan_id') }}">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                @error('kecamatan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="">
                                <label class="form-label" for="kelurahan">Kelurahan</label>
                                <select id="kelurahan_id" name="kelurahan_id" class="form-select select2"
                                    @error('kelurahan_id')
                                
                            @enderror
                                    value="{{ old('kelurahan_id') }}">
                                    <option value="{{ old('kelurahan_id') }}">Pilih Kelurahan</option>
                                </select>
                                @error('kelurahan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="alamat">Alamat</label>
                                <input type="text"
                                    class="form-control @error('alamat')
                                  is-invalid
                                @enderror"
                                    value="{{ $sumPantau->alamat }}" id="alamat" name="alamat"
                                    placeholder="Masukan alamat">
                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div>
                                <div class="col-md-5">
                                    <h5 class="form-label">Status</h5>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-check">
                                            <input name="status" class="form-check-input" type="radio" value="0"
                                                {{ $sumPantau->status == 0 ? 'checked' : '' }} id="defaultRadio1">
                                            <label class="form-check-label" for="defaultRadio1">
                                                Tidak Aktif
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input name="status" class="form-check-input" type="radio" value="1"
                                                {{ $sumPantau->status == 1 ? 'checked' : '' }} id="defaultRadio2">
                                            <label class="form-check-label" for="defaultRadio2">
                                                Aktif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('sumur-pantau.index') }}" class="btn btn-outline-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Load provinsis on page load
            $.ajax({
                url: '/provinsi',
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#provinsi_id').empty().append('<option value="">Pilih Provinsi</option>');
                    $.each(data, function(key, value) {
                        $('#provinsi_id').append('<option value="' + value.id + '">' + value
                            .name +
                            '</option>');
                    });
                }
            });

            $('#provinsi_id').on('change', function() {
                var provinsiId = $(this).val();
                if (provinsiId) {
                    $.ajax({
                        url: '/kota/' + provinsiId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#kota_id').empty().append(
                                '<option value="">Pilih Kota</option>');
                            $('#kecamatan_id').empty().append(
                                '<option value="">Pilih Kecamatan</option>');
                            $('#kelurahan_id').empty().append(
                                '<option value="">Pilih Kelurahan</option>');
                            $.each(data, function(key, value) {
                                $('#kota_id').append('<option value="' + value.id +
                                    '">' +
                                    value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#kota_id').empty().append('<option value="">Pilih Kota</option>');
                    $('#kecamatan_id').empty().append('<option value="">Pilih Kecamatan</option>');
                    $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                }
            });

            $('#kota_id').on('change', function() {
                var kotaId = $(this).val();
                if (kotaId) {
                    $.ajax({
                        url: '/kecamatan/' + kotaId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#kecamatan_id').empty().append(
                                '<option value="">Pilih Kecamatan</option>');
                            $('#kelurahan_id').empty().append(
                                '<option value="">Pilih Kelurahan</option>');
                            $.each(data, function(key, value) {
                                $('#kecamatan_id').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#kecamatan_id').empty().append('<option value="">Pilih Kecamatan</option>');
                    $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                }
            });

            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: '/kelurahan/' + kecamatanId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#kelurahan_id').empty().append(
                                '<option value="">Pilih Kelurahan</option>');
                            $.each(data, function(key, value) {
                                $('#kelurahan_id').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                }
            });
        });
    </script>
@endpush
