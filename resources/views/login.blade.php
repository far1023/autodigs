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
                    @if (session()->has('loginError'))
                        <div class="alert alert-danger alert-dismissible text-sm border-radius-0">
                            <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true"><i
                                    class="fa fa-times"></i></button>
                            {{ session('loginError') }}
                        </div>
                    @endif

                    <form action="/login" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="username" id="username" value="{{ old('username') }}"
                                class="form-control @error('username') border border-danger @enderror"
                                placeholder="Username">
                            <div class="input-group-append">
                                <div class="input-group-text @error('username') border border-danger @enderror">
                                    <span class="las la-user"></span>
                                </div>
                            </div>
                        </div>
                        @error('username')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                        <div class="input-group mt-3">
                            <input type="password" name="password" id="password" value="{{ old('password') }}"
                                class="form-control @error('password') border border-danger @enderror"
                                placeholder="Kata Sandi">
                            <div class="input-group-append">
                                <div class="input-group-text @error('password') border border-danger @enderror">
                                    <span class="las la-lock"></span>
                                </div>
                            </div>
                        </div>
                        @error('password')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                        <div class="mt-3 mb-4 text-center">
                            <button type="submit" class="btn btn-block btn-primary px-4">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
