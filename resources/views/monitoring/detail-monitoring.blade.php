@extends('layouts.app')
@push('breadcumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('monitoring.index') }}">Monitoring</a>
    </li>
    <li class="breadcrumb-item active">{{ $header }}</li>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3 border-bottom">
                            <div class="pb-2 d-flex justify-content-between align-items-center">
                                <h3 class="card-title m-0">{{ $sumPantau->kode_sumur_pantau }}</h3>
                                @if ($sumPantau->status == 1)
                                    <small class="badge bg-success">Aktif</small>
                                @else
                                    <small class="badge bg-danger">Tidak Aktif</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="nav-align-top mb-4">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-top-deskripsi" aria-controls="navs-top-deskripsi"
                                            aria-selected="true">Deskripsi</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-top-pantauan" aria-controls="navs-top-pantauan"
                                            aria-selected="false" tabindex="-1">Pantauan</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    {{-- deskripsi --}}
                                    <div class="tab-pane fade active show" id="navs-top-deskripsi" role="tabpanel">
                                        <div class="d-flex flex-md-row gap-3 ">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="text-center">
                                                    <img class="d-block rounded img-thumbnail"
                                                        src="{{ asset('storage/img/sumur-pantau') . '/' . $sumPantau->foto }}"
                                                        height="300" />
                                                </div>
                                            </div>
                                            <div class="col-md-9 flex-sm-wrap">
                                                <div class="d-flex flex-column gap-2">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <address class="mb-2 mb-md-0">
                                                                <h6 class="mb-1">Kode Sumur Pantau</h6>
                                                                {{ $sumPantau->kode_sumur_pantau }}
                                                            </address>
                                                        </div>
                                                        <div class="col-md-6 right">
                                                            <address class="mb-2 mb-md-0">
                                                                <h6 class="mb-1">No Inventarisasi</h6>
                                                                {{ $sumPantau->no_inventarisasi }}
                                                            </address>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <address class="mb-2 mb-md-0">
                                                                <h6 class="mb-1">Alamat</h6>
                                                                {{ $sumPantau->alamat }}<br>
                                                            </address>
                                                        </div>
                                                        <div class="col-md-6 right">
                                                            <address class="mb-2 mb-md-0">
                                                                <h6 class="mb-1">Lokasi</h6>
                                                                {{ $sumPantau->lokasi }}<br>
                                                            </address>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <address class="mb-2 mb-md-0">
                                                                <h6 class="mb-1">Longitude</h6>
                                                                {{ $sumPantau->longitude }}<br>
                                                            </address>
                                                        </div>
                                                        <div class="col-md-6 right">
                                                            <address class="mb-2 mb-md-0">
                                                                <h6 class="mb-1">Latitude</h6>
                                                                {{ $sumPantau->latitude }}<br>
                                                            </address>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <address class="mb-2 mb-md-0">
                                                                <h6 class="mb-1">Provinsi</h6>
                                                                {{ $sumPantau->provinsi->name }}<br>
                                                            </address>
                                                        </div>
                                                        <div class="col-md-6 right">
                                                            <address class="mb-2 mb-md-0">
                                                                <h6 class="mb-1">Kota</h6>
                                                                {{ $sumPantau->kota->name }}<br>
                                                            </address>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <address class="mb-2 mb-md-0">
                                                                <h6 class="mb-1">Kecamatan</h6>
                                                                {{ $sumPantau->kecamatan->name }}<br>
                                                            </address>
                                                        </div>
                                                        <div class="col-md-6 right">
                                                            <address class="mb-2 mb-md-0">
                                                                <h6 class="mb-1">Kelurahan</h6>
                                                                {{ $sumPantau->kelurahan->name }}<br>
                                                            </address>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- pantauan --}}
                                    <div class="tab-pane fade" id="navs-top-pantauan" role="tabpanel">
                                        <div class="d-flex justify-content-end mb-3">
                                            {{-- modal --}}
                                            <div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel3">Logbook Sumur
                                                                Pantau {{ $sumPantau->kode_sumur_pantau }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="table-responsive text-nowrap">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Muka Air Tanah</th>
                                                                                <th>TDS</th>
                                                                                <th>Daya Hantar Listrik</th>
                                                                                <th>Kondisi</th>
                                                                                <th>Tanggal</th>
                                                                                <th>Input Oleh</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="table-border-bottom-0">
                                                                            @forelse ($logbooks as $lb)
                                                                                <tr>
                                                                                    <td>{{ $lb->muka_air_tanah }}
                                                                                    </td>
                                                                                    <td>{{ $lb->total_dissolve_solid }}
                                                                                    </td>
                                                                                    <td>{{ $lb->daya_hantar_listrik }}
                                                                                    </td>
                                                                                    <td>{{ $lb->kondisi }}</td>
                                                                                    <td>{{ \Carbon\Carbon::parse($lb->created_at)->format('d/m/Y H:i:s') }}
                                                                                    </td>
                                                                                    <td>{{ $lb->user->name . '(' . $lb->user->nik . ')' }}
                                                                                    </td>
                                                                                </tr>
                                                                            @empty
                                                                                <tr>
                                                                                    <td colspan="6" class="text-center">
                                                                                        No data
                                                                                        avaiable</td>
                                                                                </tr>
                                                                            @endforelse
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <form id="filter-form">
                                                        @csrf
                                                        <div class="input-group">
                                                            <input type="date" class="form-control" id="start_date"
                                                                name="start_date"
                                                                value="{{ request('start_date', now()->toDateString()) }}">
                                                            <input type="date" class="form-control" id="end_date"
                                                                name="end_date"
                                                                value="{{ request('start_date', now()->toDateString()) }}">
                                                            <button class="btn btn-outline-primary"
                                                                type="submit">Cari</button>
                                                        </div>
                                                    </form>
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <button type="button" class="btn btn-outline-secondary btn-icon "
                                                            data-bs-toggle="modal" title="Logbook"
                                                            data-bs-target="#exLargeModal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="22"
                                                                height="22" viewBox="0 0 48 48">
                                                                <path fill="currentColor"
                                                                    d="M14.25 4A6.25 6.25 0 0 0 8 10.25v27.5A6.25 6.25 0 0 0 14.25 44h24.5a1.25 1.25 0 1 0 0-2.5h-24.5a3.75 3.75 0 0 1-3.675-3H37.75A2.25 2.25 0 0 0 40 36.25v-26A6.25 6.25 0 0 0 33.75 4zM37.5 36h-27V10.25a3.75 3.75 0 0 1 3.75-3.75h19.5a3.75 3.75 0 0 1 3.75 3.75zM16.25 10A2.25 2.25 0 0 0 14 12.25v4.5A2.25 2.25 0 0 0 16.25 19h15.5A2.25 2.25 0 0 0 34 16.75v-4.5A2.25 2.25 0 0 0 31.75 10zm.25 6.5v-4h15v4z" />
                                                            </svg>
                                                        </button>
                                                        {{-- modal --}}
                                                        @if ($sumPantau->status == 0)
                                                            <a href="{{ route('monitoring.create') }}"
                                                                class="btn btn-outline-secondary btn-icon "><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="22"
                                                                    height="22" viewBox="0 0 256 256">
                                                                    <path fill="currentColor"
                                                                        d="M228 128a12 12 0 0 1-12 12h-76v76a12 12 0 0 1-24 0v-76H40a12 12 0 0 1 0-24h76V40a12 12 0 0 1 24 0v76h76a12 12 0 0 1 12 12" />
                                                                </svg></a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="mt-2">
                                                    <select id="per_page" name="form-select form-select-sm">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                        <option value="500">500</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="table-responsive text-nowrap">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Signal</th>
                                                        <th>Alarm</th>
                                                        <th>Power Supply</th>
                                                        <th>Temp</th>
                                                        <th>Muka Air Tanah</th>
                                                        <th>Total Dissolve Solid</th>
                                                        <th>Daya Hantar Listrik</th>
                                                        <th>Kondisi</th>
                                                        <th>Waktu Input</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="monitoring-data">

                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="pagination-controls">
                                            <button id="prev-page" disabled>Previous</button>
                                            <span id="current-page"></span>
                                            <button id="next-page" disabled>Next</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
         $(document).ready(function() {
        let currentPage = 1;
        let perPage = $('#per_page').val(); // Get selected per page value

        function fetchMonitoringData(page = 1) {
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var hashid = "{{ $hashid }}";

            $.ajax({
                url: '/monitoring/' + hashid + '/filter',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    start_date: startDate,
                    end_date: endDate,
                    per_page: perPage,
                    page: page // Include page number parameter
                },
                success: function(data) {
                    var tableBody = '';

                    if (data.data.length > 0) {
                        $.each(data.data, function(index, item) {
                            tableBody += '<tr>';
                            tableBody += '<td>' + (item.monitoring.signal ?? 'N/A') + '</td>';
                            tableBody += '<td>' + (item.monitoring.alarm ?? 'N/A') + '</td>';
                            tableBody += '<td>' + (item.monitoring.power_supply ?? 'N/A') + '</td>';
                            tableBody += '<td>' + (item.monitoring.temp ?? 'N/A') + '</td>';
                            tableBody += '<td>' + (item.monitoring.muka_air_tanah ?? 'N/A') + '</td>';
                            tableBody += '<td>' + (item.monitoring.total_dissolve_solid ?? 'N/A') + '</td>';
                            tableBody += '<td>' + (item.monitoring.daya_hantar_listrik ?? 'N/A') + '</td>';
                            tableBody += '<td>' + (item.kondisi ?? 'N/A') + '</td>';
                            tableBody += '<td>' + (item.created_at ? new Date(item.created_at).toLocaleString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' }) : 'N/A') + '</td>';
                            tableBody += '</tr>';
                        });

                        $('#pagination-controls').show();
                        $('#current-page').text('Page ' + data.current_page + ' of ' + data.last_page);
                        $('#prev-page').prop('disabled', data.current_page <= 1);
                        $('#next-page').prop('disabled', data.current_page >= data.last_page);
                    } else {
                        tableBody = '<tr><td colspan="9" class="text-center">No data available</td></tr>';
                        $('#pagination-controls').hide();
                    }

                    $('#monitoring-data').html(tableBody);
                },
                error: function(xhr) {
                    console.log('Error fetching data');
                }
            });
        }

        // Initial fetch
        fetchMonitoringData();

        // Polling every 60 seconds
        setInterval(fetchMonitoringData, 60000); // 60000 milliseconds = 60 seconds

        // Bind to form submit to manually trigger data fetch
        $('#filter-form').on('submit', function(e) {
            e.preventDefault();
            currentPage = 1; // Reset to first page on filter
            fetchMonitoringData(currentPage);
        });

        // Bind to per_page change to trigger data fetch
        $('#per_page').on('change', function() {
            perPage = $(this).val();
            currentPage = 1; // Reset to first page on per_page change
            fetchMonitoringData(currentPage);
        });

        // Pagination controls
        $('#prev-page').on('click', function() {
            if (currentPage > 1) {
                currentPage--;
                fetchMonitoringData(currentPage);
            }
        });

        $('#next-page').on('click', function() {
            if (currentPage < $('#pagination-controls').data('last-page')) {
                currentPage++;
                fetchMonitoringData(currentPage);
            }
        });
    });


    
    </script>
@endpush
