@extends('layouts.frontsite-layout')

@section('content')
    <section class="page-title" style="background-color: #232323">
        <div class="auto-container">
            <h1>@trans('frontsite.login')</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="/">@trans('frontsite.home')</a></li>
                <li>@trans('frontsite.login')</li>
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
                    <h1>@trans('frontsite.login')</h1>

                    <!--Login Form-->
                    <div class="styled-form login-form" id="login-form">
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>{{ $error }}</strong>
                            </div>
                        @endforeach
                        
                        <!-- @if (session('success')) 
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }} </strong>
                            </div>
                        @endif -->
                        <form method="post" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <span class="adon-icon"><span class="fa fa-envelope"></span></span>
                                <input type="email" name="email" placeholder="Email Address*" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <span class="adon-icon"><span class="fa fa-unlock"></span></span>
                                <input type="password" name="password" value="" placeholder="Enter Password">
                            </div>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <label class="remember-me" for="remember-me">&nbsp; <a href="{{ route('password.request') }}">@trans('frontsite.forgot')</a></label>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="form-group pull-left">
                                    <button type="submit" class="theme-btn btn-style-two"><span class="btn-title">@trans('frontsite.login')</span></button>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <label class="remember-me" for="remember-me">&nbsp; @trans('frontsite.noaccount') @trans('frontsite.registerhere')</label>
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