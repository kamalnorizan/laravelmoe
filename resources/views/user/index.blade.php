@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('res/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="user-list">
                            <thead>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Sekolah
                                </th>
                                <th>
                                    Action
                                </th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('res/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script>
        $('#user-list').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('user.ajaxLoadUsers') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                }
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'sekolah', name: 'sekolah.nama_sekolah' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    </script>
@endsection
