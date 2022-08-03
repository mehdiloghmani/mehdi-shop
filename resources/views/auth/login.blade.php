
@extends('auth')
@section('content')

<body class="hold-transition login-page">
<div class="login-box">
    @include('errors.message')
    <div class="login-title">
        <i class="fa fa-user"></i>
        ورود به پنل مدیریت
    </div>

    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <form action="{{route('login.create')}}" method="post">
               @csrf
                <input type="mobile" name="mobile" class="form-control mb-2" placeholder="ایمیل">
                <input type="password" name="password" class="form-control mb-4" placeholder="رمز عبور">
                <div class="row">
                    <div class="col-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> مرا به خاطر بسپار
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">ورود</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mb-1">
                <a href="#" class="remember">رمز عبورم را فراموش کرده ام</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>


@endsection