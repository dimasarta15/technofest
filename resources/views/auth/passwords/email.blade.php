@extends('layouts.frontsite-layout')

@section('content')
    <section class="page-title" style="background-color: #232323">
        <div class="auto-container">
            <h1>Reset Password</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="/">Home</a></li>
                <li>Reset Password</li>
            </ul>
        </div>
    </section>
    <!--End Page Title-->

    <!-- Register Section -->
    <section class="register-section">
        <div class="auto-container">

            <!-- Form Box -->
            <div class="form-box">
                <div class="box-inner">
                    <h1>Reset Password</h1>

                    <!--Login Form-->
                    <div class="styled-form login-form" id="login-form">
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>{{ $error }}</strong>
                            </div>
                        @endforeach
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('status') }} </strong>
                            </div>
                        @endif

                        <form method="post" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <span class="adon-icon"><span class="fa fa-envelope"></span></span>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address*">
                            </div>
                            <div class="clearfix">
                                <div class="form-group pull-left">
                                    <button type="submit" class="theme-btn btn-style-two"><span class="btn-title">Kirim Link</span></button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!-- End Register Section -->
@endsection