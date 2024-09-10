@extends('layouts.app')
@push('breadcumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">{{ $header }}</li>
@endpush
@section('content')
    <div class="card">
        <div class="card-body">

            <form id="filter-form" action="{{ route('laporan.index') }}">
                @csrf
                <div class="input-group">
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date', now()->toDateString()) }}">
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date', now()->toDateString()) }}">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                </div>
            </form>
            <div class="d-flex justify-content-end">
                <button class="btn btn-outline-primary btn-sm mt-3" onclick="previewLaporan()">Cetak</button>
            </div>

            @forelse ($result as $data)
                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Provinsi</th>
                            <th>Total Kondisi Rusak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $index => $item)
                            <tr>
                                <td>{{ $index +1 }}</td>
                                <td>{{ $item['provinsi'] }}</td>
                                <td>{{ $item['total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @empty
                <div class="alert alert-warning mt-4">Tidak ada data untuk periode yang dipilih.</div>
            @endforelse
        </div>
    </div>
@endsection
@push('script')
<script>
    function previewLaporan() {
        // Mengambil nilai start_date dan end_date dari form input
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;

        // Redirect ke halaman preview dengan membawa parameter start_date dan end_date
        window.location.href = "{{ route('laporan.preview') }}?start_date=" + startDate + "&end_date=" + endDate;
    }
</script>
@endpush