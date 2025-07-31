@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('res/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-4">User Management
                    @canany(['create users', 'delete users'])
                        <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal"
                            data-target="#userModel">
                            Register User</button>
                    @endcanany
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
                                    Roles/Permissions
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="user_id" value="">
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
                    <hr>
                    <h4>Roles</h4>
                    <div class="row">
                        @foreach ($roles as $role)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input role" type="checkbox" value="{{ $role->name }}"
                                        id="role_{{ $role->id }}" name="roles[]">
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ strtoupper($role->name) }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <h4>Permissions</h4>
                    <div class="row">
                        @foreach ($permissions as $permission)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input permission" type="checkbox"
                                        value="{{ $permission->name }}" id="permission_{{ $permission->id }}"
                                        name="permissions[]">
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        {{ strtoupper($permission->name) }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('res/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script>
        var userTbl = $('#user-list').DataTable({
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
                    data: 'roles_permissions',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $(document).on("click", ".delete-user", function(e) {
            e.preventDefault();
            var id = $(this).data("id");

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this user again!",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, i'm sure!",
                        value: true,
                        visible: true,
                        className: "btn-danger",
                        closeModal: true
                    }
                }
            }).then((value) => {
                if (!value) {
                    return;
                }

                $.ajax({
                    type: "post",
                    url: "{{ route('user.delete') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {

                        userTbl.ajax.reload(function() {
                            swal("Deleted!", "The user has been deleted successfully.", "success");
                        }, false);

                    }
                });
            });
        });


        $(document).on("click", ".edit-user", function(e) {
            var userId = $(this).data("id");

            $.ajax({
                type: "post",
                url: "{{ route('user.ajaxLoadUser') }}",
                data: {
                    id: userId,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $('#name').val(response.data.name);
                        $('#email').val(response.data.email);
                        $('#sekolah_id').val(response.data.sekolah_id);
                        $('#user_id').val(response.data.id);

                        $('.role').prop('checked', false);
                        response.data.roles.forEach(function(role) {
                            $('#role_' + role.id).prop('checked', true);
                        });

                        $('.permission').prop('checked', false);
                        response.data.permissions.forEach(function(permission) {
                            $('#permission_' + permission.id).prop('checked',
                                true);
                        });

                        $('#userModel').modal('show');

                    } else {
                        swal({
                            title: "User could not be loaded",
                            text: "User data could not be loaded.",
                            icon: "danger",
                        });
                    }
                }
            });
        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $('.form-control').removeClass('is-invalid');
            $('.text-danger').text('');
            var roles = [];
            $('.role:checked').each(function() {
                roles.push($(this).val());
            });

            var permissions = [];
            $('.permission:checked').each(function() {
                permissions.push($(this).val());
            });
            $.ajax({
                type: "POST",
                url: "{{ route('user.store') }}",
                data: {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    sekolah_id: $('#sekolah_id').val(),
                    id: $('#user_id').val(),
                    roles: roles,
                    permissions: permissions,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        swal({
                            title: "User Loaded",
                            text: "User data has been loaded successfully.",
                            icon: "success",
                        });
                        $('#userModel').modal('hide');
                        userTbl.ajax.reload();
                    } else {
                        swal({
                            title: "User could not be saved",
                            text: "Please check the form for errors.",
                            icon: "warning",
                        }); // Show warning if user could not be saved
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
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
