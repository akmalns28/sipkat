@extends('layouts.app')
@push('breadcumb')
    <li class="breadcrumb-item active">{{ $header }}</li>
@endpush
@section('content')
    <div class="row mb-3 d-flex flex-wrap g-2">
        @if (Auth::user()->role == 'super admin')
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 d-flex flex-column">
                    <div class="d-flex align-items-center rounded p-1 flex-grow-1">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="rounded " width="52" height="52"
                                viewBox="0 0 24 24">
                                <g fill="rgb(202, 199, 120)" stroke="rgb(202, 199, 120)" stroke-width="1.5">
                                    <circle cx="12" cy="6" r="4" />
                                    <path d="M20 17.5c0 2.485 0 4.5-8 4.5s-8-2.015-8-4.5S7.582 13 12 13s8 2.015 8 4.5Z" />
                                </g>
                            </svg>
                        </div>
                        <div class="my-2 ms-2">
                            <p class="mb-2 text-black">{{ $tUser }}</p>
                            <h5 class="my-0">Total User</h5>
                        </div>
                    </div>
                    <div class="text-center rounded-bottom" style="background-color:rgb(255, 252, 151)">
                        <a href="#" class="text-black" style="font-weight: 300;">Lihat Selengkapnya</a>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-3 col-sm-6">
            <div class="card h-100 d-flex flex-column">
                <div class="d-flex align-items-center rounded p-1 flex-grow-1">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg class="rounded" width="64" height="64"
                            viewBox="0 0 24 24">
                            <path fill="#696cff" d="M12 20a6 6 0 0 1-6-6c0-4 6-10.75 6-10.75S18 10 18 14a6 6 0 0 1-6 6">
                            </path>
                        </svg>
                    </div>
                    <div class="my-2 ms-2">
                        <p class="mb-2 text-black">{{ $tSumurPantau }}</p>
                        <h5 class="my-0">Total Sumur Pantau</h5>
                    </div>
                </div>
                <div class="text-center rounded-bottom" style="background-color: #a1a3ff">
                    <a href="#" class="text-black" style="font-weight: 300;">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 d-flex flex-column">
                <div class="d-flex align-items-center rounded p-1 flex-grow-1">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="rounded" width="64" height="64"
                            viewBox="0 0 24 24">
                            <path fill="rgb(104, 188, 122)"
                                d="M12 20a6 6 0 0 1-6-6c0-4 6-10.75 6-10.75S18 10 18 14a6 6 0 0 1-6 6"></path>
                        </svg>
                    </div>
                    <div class="my-2 ms-2">
                        <p class="mb-2 text-black">{{ $tSumurPantauAktif }}</p>
                        <h5 class="my-0">Total Sumur Pantau Aktif</h5>
                    </div>
                </div>
                <div class="text-center rounded-bottom" style="background-color: rgb(141, 255, 166)">
                    <a href="#" class="text-black" style="font-weight: 300;">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 d-flex flex-column">
                <div class="d-flex align-items-center rounded p-1 flex-grow-1">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="rounded" width="64" height="64"
                            viewBox="0 0 24 24">
                            <path fill="#c05555" d="M12 20a6 6 0 0 1-6-6c0-4 6-10.75 6-10.75S18 10 18 14a6 6 0 0 1-6 6">
                            </path>
                        </svg>
                    </div>
                    <div class="my-2 ms-2">
                        <p class="mb-2 text-black">{{ $tSumurPantauNAktif }}</p>
                        <h5 class="my-0">Total Sumur Pantau Non Aktif</h5>
                    </div>
                </div>
                <div class="text-center rounded-bottom" style="background-color: #ff7c7c">
                    <a href="#" class="text-black" style="font-weight: 300;">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row MB-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Tabulasi Sumur Pantau</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">

                        <div class="col-md-4">
                            <canvas id="myChart" width="250" height="250"></canvas>
                        </div>
                        <div class="col-md-8">
                            <h6>Perbandingan Jumlah Sumur Pantau</h6>
                            <p>
                                Perubahan dari tahun {{ now()->year - 1 }} ke tahun {{ now()->year }}:
                                @if ($percentageChange > 0)
                                    Naik sebesar <span class="badge bg-success">{{ number_format($percentageChange, 2) }}%</span>
                                @elseif ($percentageChange < 0)
                                    Turun sebesar {{ number_format(abs($percentageChange), 2) }}%
                                @else
                                    Tidak ada perubahan
                                @endif
                            </p>
                            <canvas id="sumurPantauChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Function to generate random colors
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Setup the data for the chart
        let labels = @json($labels);
        let data = @json($data);
        let backgroundColors = labels.map(() => getRandomColor());

        // Check if the data is empty or contains only zeros
        if (data.every(value => value === 0) || data.length === 0) {
            labels = ['No Data'];
            data = [1];
            backgroundColors = ['#d3d3d3']; // Gray color for no data
        }

        const chartData = {
            labels: labels,
            datasets: [{
                label: 'Total Sumur Pantau',
                data: data,
                backgroundColor: backgroundColors,
                hoverOffset: 4
            }]
        };

        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'doughnut',
            data: chartData,
        });
    </script>
    <script>
        var ctx2 = document.getElementById('sumurPantauChart').getContext('2d');
        var sumurPantauChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Tahun {{ now()->year - 1 }}', 'Tahun {{ now()->year }}'],
                datasets: [{
                    label: 'Jumlah Sumur Pantau',
                    data: [{{ $previousYearCount }}, {{ $currentYearCount }}],
                    backgroundColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                        
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    
@endpush
