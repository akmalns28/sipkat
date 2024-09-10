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
                    <h5>Data Pengguna</h5>
                    <button class="btn p-0 ms-1 border-0" id="refreshData">
                        <i class="bi bi-arrow-clockwise" style="cursor: pointer; font-size: 15px;"></i>
                    </button>
                </div>
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="datatable" style="width:100%">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>    
@endsection
@push('style')
    @vite(['resources\assets\compiled\css\table-datatable-jquery.css', 'resources\assets\extensions\datatables.net-bs5\css\dataTables.bootstrap5.min.css'])
@endpush
@push('script')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            let datatable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user.getUsers') }}",
                    type: "GET"
                },
                order: ['1', 'DESC'],
                pageLength: 10,
                searching: true,
                columns: [{
                        data: 'nik',
                        name: 'nik',
                    },
                    {
                        data: 'username',
                        name: 'username',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'role',
                        name: 'role',
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
                        const url = "{{ route('user.destroy', ['user' => ':data']) }}"
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
