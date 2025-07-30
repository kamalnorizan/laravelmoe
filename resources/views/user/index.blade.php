@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('res/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-4">User Management
                    <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal"
                        data-target="#userModel">
                        Register User</button>
                </h1>
                <p class="lead">Manage users in the system.</p>
                <!-- Button trigger modal -->

                </button>

            </div>
        </div>
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

    <!-- Modal -->
    <div class="modal fade" id="userModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control"
                            required="required">
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                    </div>
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control"
                            required placeholder="eg: foo@bar.com">
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                    </div>
                    <div class="form-group {{ $errors->has('sekolah_id') ? 'has-error' : '' }}">
                        <label for="sekolah_id">Sekolah</label>
                        <select id="sekolah_id" name="sekolah_id" class="form-control" required>
                            <option value="">Select Sekolah</option>
                            @foreach ($sekolah as $sek)
                                <option value="{{ $sek->id }}" {{ old('sek_id') == $sek->id ? 'selected' : '' }}>
                                    {{ $sek->nama_sekolah }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('sekolah_id') }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="saveBtn" class="btn btn-primary">Save</button>
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
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'sekolah',
                    name: 'sekolah.nama_sekolah'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $('.form-control').removeClass('is-invalid');
            $('.text-danger').text('');
            $.ajax({
                type: "POST",
                url: "{{ route('user.store') }}",
                data: {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    sekolah_id: $('#sekolah_id').val(),
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (response) {

                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next('.text-danger').text(value[0]);
                        });
                    } else {
                        alert('An error occurred while saving the user.');
                    }
                }
            });
        });
    </script>
@endsection
