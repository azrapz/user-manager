@extends('layouts.master')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Assign Role</h1>

<fieldset class="form-horizontal edit-user">
    <form id="assign-role-form">
        <input type="hidden" name='id' value="{{request('id')}}" />
        <div class="form-group">
            {!! Form::label('role', '*'.Lang::get('Role'), ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-6 col-lg-4">
                {!! Form::select('role', ['admin' => 'Admin','user' => 'User'], '', ['class' =>
                'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <a href="{{ url()->previous() }}" class="btn btn-info">Back</a>
                    {!! Form::submit(Lang::get('Save'), array('class' => 'btn btn-primary')) !!}
                </div>
            </div>
        </div>
    </form>
</fieldset>

<script>
    $(document).ready(function(){
        checkPermissions('user_assign_role');
    });

    $("#assign-role-form").on('submit',function(e){
        e.preventDefault();
        $(".errors").remove();
        let $_token = $("meta[name=csrf-token]").attr('content');
        $.ajax({
            type:'POST',
            url: '/api/assign-role',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $_token,
                'Authorization': getCookie('token')
            },
            success: function(data){
                window.location.href = '/users';
            },
            error: function(data){
                if(data.responseJSON.errors){
                    $.each(data.responseJSON.errors, function (key, value) {
                        $("[name='" + key + "']").after('<p class="errors">'+value+'</p>');
                    });
                }
            }
        });
    });
</script>
@endsection
