@extends('layouts.app')
@push('breadcumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('monitoring.index') }}">Monitoring Sumur Pantau</a>
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
                <form action="{{ route('monitoring.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- col 1 --}}
                        <div class="d-flex flex-column gap-2 col-lg-12 mb-3">
                            <div>
                                <label for="id_spantau" class="form-label">Sumur Pantau</label>
                                <select id="id_spantau" value="{{ old('id_spantau') }}" name="id_spantau"
                                    class="form-select @error('id_spantau')
                                  is-invalid
                                @enderror">
                                    <option>Pilih Sumur Pantau</option>
                                    @forelse ($spantau as $sp)
                                        <option value="{{ $sp->id }}">
                                            {{ $sp->kode_sumur_pantau . ' | ' . $sp->no_inventarisasi }}</option>
                                    @empty
                                        <option disabled>Data Tidak Tersedia</option>
                                    @endforelse
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="muka_air_tanah">Muka Air Tanah</label>
                                <input type="number" min="0"
                                    class="form-control @error('muka_air_tanah')
                                  is-invalid
                                @enderror"
                                    value="{{ old('muka_air_tanah') }}" id="muka_air_tanah" name="muka_air_tanah"
                                    placeholder="Masukan kode sumur pantau">
                                @error('muka_air_tanah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="total_dissolve_solid">Total Dissolve Solid (TDS)</label>
                                <input type="number" min="0"
                                    class="form-control @error('total_dissolve_solid')
                                  is-invalid
                                @enderror"
                                    value="{{ old('total_dissolve_solid') }}" id="total_dissolve_solid"
                                    name="total_dissolve_solid" placeholder="Masukan tds">
                                @error('total_dissolve_solid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="daya_hantar_listrik">Daya Hantar Listrik</label>
                                <input type="number" min="0"
                                    class="form-control @error('daya_hantar_listrik')
                                  is-invalid
                                @enderror"
                                    value="{{ old('daya_hantar_listrik') }}" id="daya_hantar_listrik"
                                    name="daya_hantar_listrik" placeholder="Masukan daya hantar listrik">
                                @error('daya_hantar_listrik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="" onclick="window.history.go(-1); return false;"
                            class="btn btn-outline-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
