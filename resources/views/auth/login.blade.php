<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mazer Admin Dashboard</title>

    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/auth.css') }}">
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="auth">

<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="index.html"><img src="{{ asset('assets/static/images/logo/logo.svg') }}" width="100" alt="Logo"></a>
            </div>
            <h1 class="auth-title">Log in.</h1>

            <form action="{{ route('auth.login') }}" method="POST">
                @csrf
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" class="form-control form-control-xl" placeholder="Email" name="email">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" class="form-control form-control-xl" placeholder="Password" name="password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                @if (session('error'))
                <div class="text-center">
                    <small class="text-danger">Account not found!</small>
                </div>
                @endif
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class="text-gray-600">Don't have an account? Contact The Admin PT JNE</p>
            </div>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
    <div id="auth-right" class="h-100">
        <img
            src="{{ asset('assets/static/images/logo/cover_w1296_h540_banner-web-jne_page-0001.jpg') }}"
            alt="bg"
            class="img-fluid w-100 h-100 object-fit-cover" style="object-position: right center">
    </div>
</div>

</div>

    </div>
</body>

</html>
