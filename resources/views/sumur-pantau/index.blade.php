@extends('layouts.app')
@push('breadcumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">{{ $header }}</li>
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <h5>Data Sumur Pantau</h5>
                    <button class="btn p-0 ms-1 border-0" id="refreshData">
                        <i class="bi bi-arrow-clockwise" style="cursor: pointer; font-size: 15px;"></i>
                    </button>
                </div>
                <a href="{{ route('sumur-pantau.create') }}" class="btn btn-primary btn-sm">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="datatable" style="width:100%">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Kode</th>
                            <th>No Inventarisasi</th>
                            <th>Alamat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('style')
    {{-- @vite(['resources/assets/compiled/css/table-datatable-jquery.css', 'resources/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css']) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/bs5/1.13.1/css/dataTables.bootstrap5.min.css">

    <!-- Include DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
@endpush
@push('script')
    <!-- Include jQuery first -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>

    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net-bs5/1.13.1/js/dataTables.bootstrap5.min.js"></script> --}}

    <!-- Include DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            var assetImg = "{{ asset('storage/img/sumur-pantau') }}";
            let datatable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('sumur-pantau.getSumurPantau') }}",
                    type: "GET"
                },
                order: ['1', 'DESC'],
                lengthMenu: [10, 25, 50, 100], // Menambahkan opsi untuk page length
                pageLength: 10,
                searching: true,
                columns: [{
                        data: 'foto',
                        name: 'foto',
                        render: function(data, type, full, meta) {
                            return data ? '<img class="rounded" src="' +
                                '{{ asset('storage/img/sumur-pantau/') }}' + '/' + data +
                                '" height="100px"/>' : '';
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_sumur_pantau',
                        name: 'kode_sumur_pantau',
                    },
                    {
                        data: 'no_inventarisasi',
                        name: 'no_inventarisasi',
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: "15%",
                        orderable: false,
                    }
                ],
                order: [
                    [0, "asc"]
                ],
                dom: 'Bfrtip', // Add this line to include the buttons
                buttons: [{
                        extend: 'excelHtml5',
                        text: 'Excel',
                        titleAttr: 'Excel',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                // Exclude columns with index 0 (foto) and last (action)
                                return idx > 0 && idx < 4;
                            }
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        titleAttr: 'CSV',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                // Exclude columns with index 0 (foto) and last (action)
                                return idx > 0 && idx < 4;
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        titleAttr: 'PDF',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                // Exclude columns with index 0 (foto) and last (action)
                                return idx > 0 && idx < 4;
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        titleAttr: 'Print',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                // Exclude columns with index 0 (foto) and last (action)
                                return idx > 0 && idx < 4;
                            }
                        }
                    }
                ]
            });

            const setTableColor = () => {
                document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
                    dt.classList.add('pagination-primary')
                })
            }
            setTableColor()
            datatable.on('draw', setTableColor)

            $('#datatable').on('click', '.delete-button', function() {
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Semua data yang berkaitan akan ikut terhapus",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#233446',
                    cancelButtonColor: '#8592a3',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.value) {
                        const dataId = $(this).data('id')
                        const data = {
                            id: dataId
                        }
                        const url =
                            "{{ route('sumur-pantau.destroy', ['sumur_pantau' => ':data']) }}"
                        const bindUrl = url.replace(':data', dataId)
                        var btn = $(this)
                        $.ajax({
                            url: bindUrl,
                            type: "DELETE",
                            data: JSON.stringify(data),
                            dataType: "JSON",
                            proccessData: false,
                            contentType: "application/json",
                            beforeSend: () => {
                                btn.attr('disabled', true).html(
                                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                                )
                            },
                            success: (response) => {
                                refreshData(datatable)
                                showSuccessToast('Data Berhasil Dihapus', undefined)
                            },
                            error: function(xhr, status, error) {
                                var errors = xhr.responseJSON.errors;
                                btn.removeAttr('disabled').text('Hapus')
                                showErrorToast("Failed", errors)
                            }
                        })
                    }
                })
            });

            $('#refreshData').on('click', async () => {
                $('#refreshData').attr('disabled', true)
                await refreshData(datatable)
                $('#refreshData').attr('disabled', false)
            })

            async function refreshData(table) {
                await new Promise((resolve) => {
                    table.ajax.reload(resolve)
                })
            }
        });
    </script>
@endpush
