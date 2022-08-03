
@extends('auth')
@section('content')
    
<body class="hold-transition login-page">
    <div class="login-box">
        @include('errors.message')
        <div class="login-title">
            <i class="fa fa-user"></i>
           ثبت نام
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <form action="{{route('register.create')}}" method="POST">
            @csrf

            <input name="mobile" class="form-control mb-4" placeholder="شماره موبایل" type="mobile">
           <input name="password" class="form-control mb-2" placeholder="رمز عبور" type="password">
            <input name="password_confirmation" class="form-control mb-4" placeholder="تکرار رمز عبور" type="password">
            <div class="remember">
                <div class="checkbox">
                    <label>
                        <input name="remember" type="checkbox">
                        مرا به خاطر بسپار
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-flat">ثبت نام</button>
        </form>
    </div>
</div>

</div>





@endsection


