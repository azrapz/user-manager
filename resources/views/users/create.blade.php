@extends('layouts.master')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Create form') }}</h1>

<fieldset class="form-horizontal  create">
    <form id="user-form">
        <div class="form-group">
            {!! Form::label('name', '*'.Lang::get('First Name'), ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-6 col-lg-4">
                {!! Form::text('first_name', '', array('class' => 'form-control', 'maxlength' => 128)) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('last_name', '*'.Lang::get('Last Name'), ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-6 col-lg-4">
                {!! Form::text('last_name', '', array('class' => 'form-control', 'maxlength' => 128)) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('email', '*'.Lang::get('Email'), ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-6 col-lg-4">
                {!! Form::text('email', '', ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('username', '*'.Lang::get('Username'), ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-6 col-lg-4">
                {!! Form::text('username', '', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('password', '*'.Lang::get('Password'), ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-6 col-lg-4">
                {!! Form::input('password', 'password', '',['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('input-password-confirmation', '*'.Lang::get('Confirm password'), array('class'=>'col-sm-2
            control-label')) !!}
            <div class="col-md-6 col-lg-4">
                {!! Form::input('password','password_confirmation', '', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
                {!! Form::label('status', '*'.Lang::get('Status'), ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-md-6 col-lg-4">
                    {!! Form::select('status', ['active' => 'Active','inactive' => 'Inactive'], '', ['class' => 'form-control']) !!}
                </div>
            </div>

        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                {!! Form::submit(Lang::get('Save'), array('class' => 'btn btn-primary')) !!}
            </div>
        </div>
    </form>
</fieldset>

<script>
    $(document).ready(function(){
        checkPermissions('user_create');
    });
    $("#user-form").on('submit',function(e){
        e.preventDefault();
        $(".errors").remove();
        let $_token = $("meta[name=csrf-token]").attr('content');

        $.ajax({
            type:'POST',
            url: '/api/user',
            data: $("#user-form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $_token,
                'Authorization': getCookie('token')
            },
            success: function(data){
                window.location.href = 'users';
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
