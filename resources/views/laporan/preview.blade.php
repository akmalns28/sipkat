<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} - Laporan Kondisi Kerusakan Air Tanah</title>

    <link rel="icon" type="image/x-icon"
        href="https://esdm.go.id/assets/imagecache/bodyView/profil-arti-logo-cszkz2w.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .content {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .page,
            .page * {
                visibility: visible;
            }

            .page {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: auto;
                margin: 0;
            }

            .button-group {
                display: none;
            }
        }
    </style>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="page">
        <div class="button-group">
            <a href="{{ route('laporan.index') }}" class="btn">Kembali</a>
            <a href="#" class="btn" onclick="window.print()">Cetak Laporan</a>
        </div>

        <div class="content">
            <h1 style="text-align: center;">Laporan Kondisi Kerusakan Air Tanah</h1>
            <p style="text-align: center;">Periode: {{ $startDate }} - {{ $endDate }}</p>

            @if ($result->isNotEmpty())
                <table>
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
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['provinsi'] }}</td>
                                <td>{{ $item['total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-warning" style="margin-top: 20px;">Tidak ada data untuk periode yang dipilih.
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript Assets -->
    @include('layouts.partials.js')
</body>

</html>
