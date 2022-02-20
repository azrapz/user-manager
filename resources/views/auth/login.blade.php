<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>User manager</title>

    <!-- Favicon -->
    <link href="https://www.mistral.ba/m/u/2020/03/cropped-mistral-logo-200x200.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/css/sb-admin.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</head>

<body class="bg-gradient-primary min-vh-100 d-flex justify-content-center align-items-center"
    data-new-gr-c-s-check-loaded="14.1046.0" data-gr-ext-installed="" cz-shortcut-listen="true">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block p-5">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="data:image/png;base64,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" width="250">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">
                                            <strong>Welcome!</strong>
                                        </h1>

                                    </div>

                                    <form id="login-form" class="user">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <div class="form-group">
                                            <input type="username" class="form-control form-control-user"
                                                name="username" placeholder="{{ __('Username') }}" required autofocus>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                name="password" placeholder="{{ __('Password') }}" required>
                                        </div>

                                        <p class="errors"></p>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                                Sign in
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</html>

<script>
    $("#login-form").on("submit",function(e){
        e.preventDefault();
        let formData = $(this).serialize();
        let $_token = $("meta[name=csrf-token]").attr('content');
        $(".errors").html();
        $.ajax({
            type:'POST',
            url: '/api/login',
            data: formData,
            headers: {
            'X-CSRF-TOKEN': $_token
            },
            success: function(data){
                if(data.token){
                    setCookie('token','Bearer '+data.token);
                    window.location.href="/users";
                }
            },
            error: function(data){
                console.log(data);
                if(data.responseJSON.errors){
                    $(".errors").html(data.responseJSON.errors);
                }
            }
        })
    });

</script>
