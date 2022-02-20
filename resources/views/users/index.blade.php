@extends('layouts.master')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Users') }}</h1>
<div class="col-12">
    <a href="{{route('create-user')}}" class="btn btn-success">Create new user</a>
</div>


@if (session('status'))
<div class="alert alert-success border-left-success" role="alert">
    {{ session('status') }}
</div>
@endif

<!-- Database table -->
<table id="data-table" class="table table-striped table-bordered dataTable table-hover" cellspacing="0" width="100%">
    <thead class="thead-light">
        <tr>
            <th>{{ Lang::get('First name') }}</th>
            <th>{{ Lang::get('Last name') }}</th>
            <th>{{ Lang::get('Username') }}</th>
            <th>{{ Lang::get('Email') }}</th>
            <th>{{ Lang::get('Status') }}</th>
            <th>
                Details
            </th>
        </tr>
    </thead>
    <tbody></tbody>
    <tfoot>
        <tr>
            <th>{{ Lang::get('First name') }}</th>
            <th>{{ Lang::get('Last name') }}</th>
            <th>{{ Lang::get('Username') }}</th>
            <th>{{ Lang::get('Email') }}</th>
            <th>{{ Lang::get('Status') }}</th>
            <th>
                Details
            </th>
        </tr>
    </tfoot>
</table>
@include('users.modal')
<script>
        $(document).ready(function () {
            checkPermissions('user_index');
            $('#data-table tfoot th').each( function (i) {
                var title = $('#data-table thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" />' );
            });

            let table = $('#data-table').DataTable({
                ajax: {
                    url: '/api/users',
                    dataSrc: 'users',
                    'beforeSend': function (request) {
                        request.setRequestHeader("Authorization", getCookie('token'));
                    }
                },
                columns: [
                    { data: 'first_name'},
                    { data: 'last_name'},
                    { data: 'username'},
                    { data: 'email'},
                    { data: 'status'},
                    {
                        "targets": -1, "data": null,
                        "defaultContent": "<button id='delete-user' class='btn btn-danger' width='25px'>Delete user</button><span class='pl-2'></span><button id='edit-user' class='btn btn-success' width='25px'>Edit user</button><span class='pl-2'></span><button id='assign-role' class='btn btn-info' width='25px'>Assign role</button>"
                    }
                ],
                orderCellsTop: true,
                fixedHeader: true,

            });

            table.order( );

            // Filter event handler
            $( table.table().container() ).on( 'keyup', 'tfoot input', function () {
                table
                .column( $(this).data('index') )
                .search( this.value )
                .draw();
            });

            $('#data-table tbody').on('click', '[id*=edit-user]', function () {
                let data = table.row($(this).parents('tr')).data();
                window.location.href = '/edit-user/'+data.id;
            });

            $('#data-table tbody').on('click', '[id*=assign-role]', function () {
                let data = table.row($(this).parents('tr')).data();
                window.location.href = '/assign-role/'+data.id;
            });

            $('#data-table tbody').on('click', '[id*=delete-user]', function () {
                $('#delete-user-modal').modal('show');
                let data = table.row($(this).parents('tr')).data();
                let userID = data.id;
                let username = data['username'];

                $("#confirm-delete").on('click',function(){
                    let $_token = $("meta[name=csrf-token]").attr('content');
                    $.ajax({
                        type:'DELETE',
                        url: '/api/user',
                        headers: {
                            'X-CSRF-TOKEN': $_token,
                            'Authorization': getCookie('token')
                        },
                        data: {'id':userID},
                        success: function(data){
                            $('#data-table').DataTable().ajax.reload();
                            $('#delete-user-modal').modal('hide');
                        },
                        errors: function(data){
                            console.log(data);
                        }
                    });
                });
            });
        });
</script>
@endsection
