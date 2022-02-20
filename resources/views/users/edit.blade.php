@extends('layouts.master')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Edit user data') }}</h1>

<fieldset class="form-horizontal edit-user">
    <form id="user-form">
        <input type="hidden" name='id' value="{{request('id')}}"/>
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
            {!! Form::label('status', '*'.Lang::get('Status'), ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-6 col-lg-4">
                {!! Form::select('status', ['active' => 'Active','inactive' => 'Inactive'], '', ['class' =>
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
        checkPermissions('user_edit');
        $.ajax({
            type:'GET',
            url: '/api/get-user-data',
            data: {'id' : $("[name='id']").val()},
            headers: {
                'Authorization': getCookie('token')
            },
            success: function(data){
                $.each(data.data, function (key, value) {
                    $("[name="+key+"]").val(value);
                });
            },
        });
    })

    $("#user-form").on('submit',function(e){
        e.preventDefault();
        $(".errors").remove();
        let $_token = $("meta[name=csrf-token]").attr('content');
        console.log($_token);
        $.ajax({
            type:'PUT',
            url: '/api/user',
            data: $("#user-form").serialize(),
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
