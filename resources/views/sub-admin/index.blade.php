<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Design by foolishdeveloper.com -->
    {{-- <title>login page</title> --}}
    <!-- links -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome link corrected -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/fontawesome.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css" integrity="sha512-5v1op2E5fO4YeHY/ViMn9mvHjHF9ONymCfWq6QAN0U8/5RBuMzOxAOsrOqq+JY09joXLhkaEp9ll2sfxoAaPZg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    @if($dName ==='swcworlds.com' || $dName === 'skilledworkerscloud.co.uk') 
        <title>Login - SWCH Partner</title>
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/img/swch_logo.png') }}">
    @else
        <title>Login</title>
        <!-- Favicon -->
        {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/app/public/' . $domain_name->logo) }}"> --}}
        @if($domain_name && $domain_name->logo) 
            <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/app/public/' . $domain_name->logo) }}">
        @else
            <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/assets/img/logo2.png')}}">
        @endif
    @endif
    <!--Stylesheet-->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/index.css') }}">
    {{-- <link rel="stylesheet" href="style.css"> --}}
</head>

<body>
    <div class="main_login_screen_wrapper">
        <div class="background">
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        <div class="main_login_page">
            <form action="{{url('subadmin-login')}}" method="post" style="margin-top: 30px;" id="my_captcha_form">
                <h3>Login Here</h3>
                {{csrf_field()}}
                {{-- @include('sub-admin.layout.message') --}}
                @if(session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
            
                <!-- Show Login Error -->
                @if ($errors->has('login_error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $errors->first('login_error') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <label for="username">
                            <i class="fa-solid fa-user"></i> Username
                        </label>
                        <input type="text" placeholder="Email or Phone" id="email" name="email">
                        @if ($errors->has('email'))
                            <div class="error" style="color:red;">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <label for="password">
                            <i class="fa-solid fa-lock"></i> Password
                        </label>
                        <input type="password" placeholder="Password" id="password" name="psw">
                        @if ($errors->has('psw'))
                            <div class="error" style="color:red;">{{ $errors->first('psw') }}</div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <button type="submit" id="loginButton">Log In</button>
                    </div>
                    {{-- <div class="col-12">
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="termsAgreement">
                            <label class="form-check-label" for="termsAgreement">
                                I confirm that I have read the Privacy Policy and I agree to the website Terms of Use and License Agreement
                            </label>
                        </div>
                    </div>
                    </div> --}}
                </div>
            </form>
        </div>
    </div>
</body>

</html>