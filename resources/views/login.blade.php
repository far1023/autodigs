<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Log in</title>

    <link href="" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
        rel="stylesheet" />
    <link href="{{ asset('vendor/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}" rel="stylesheet" />
</head>

<body class="hold-transition container bg-light p-5">
    <div class="row justify-content-center mt-xl-5">
        <div class="col-sm-12 col-md-5 col-lg-6 mt-xl-4 pb-5">
            <h1 class="text-primary">Autodig</h1>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing.</p>
        </div>
        <div class="col-sm-12 col-md-8 col-lg-4">
            <div class="card">
                <div class="card-body login-card-body">
                    <div id="message" class=""></div>

                    <form id="formLogin">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="username" id="username" class="form-control"
                                placeholder="Username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="las la-user"></span>
                                </div>
                            </div>
                        </div>
                        <small class="text-danger err-msg" id="username_error"></small>
                        <div class="input-group mt-3">
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Kata Sandi">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="las la-lock"></span>
                                </div>
                            </div>
                        </div>
                        <small class="text-danger err-msg" id="password_error"></small>
                        <div class="mt-3 mb-4 text-center">
                            <button type="submit" id="loginBtn"
                                class="btn btn-block btn-primary cta px-4">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script>
        $('#formLogin').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "{{ route('login.attempt') }}",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $("#message").html("")
                    $(".err-msg").html("");
                    $(".form-control").removeClass("is-invalid");
                    $(".cta").attr("disabled", true);
                    $("#loginBtn").html("<span class='spinner-border spinner-border-sm'></span>");
                },
                success: function(res) {
                    let message = "somthing wnet wrong";
                    let type = "danger";

                    if (res.code == 200) {
                        message = res.message;
                        type = "success";
                        $("#loginBtn").html(
                            "<span class='spinner-border spinner-border-sm'></span> mengalihkan...");

                        window.location.href = res.redirect;
                    } else {
                        $(".cta").attr("disabled", false);
                        $("#loginBtn").html('Login');
                    }

                    $("#message").html(
                        '<div class="alert alert-' + type +
                        ' alert-dismissible text-sm border-radius-0"><button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true"><iclass="fa fa-times"></i class=></button>' +
                        message + '</div>'
                    );
                },
                error: function(res) {
                    let message = "Periksa kembali form";

                    $(".cta").attr("disabled", false);
                    $("#loginBtn").html('Login');

                    if (res.responseJSON.code == 401) {
                        message = res.responseJSON.message;
                    }

                    $("#message").html(
                        '<div class="alert alert-danger alert-dismissible text-sm border-radius-0"><button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true"><iclass="fa fa-times"></i class=></button>' +
                        message + '</div>'
                    );

                    $.each(res.responseJSON.errors, function(i, val) {
                        $("#" + i + "_error").html(val);
                        $("#" + i).addClass("is-invalid");
                    });
                }
            });
        });
    </script>
</body>

</html>
