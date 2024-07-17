@extends('layouts.frontsite-layout')
@section('menuSemester', 'active')
@section('menuSetting', 'active')
@section('collapseSetting', 'show')

@section('script-recaptcha')
{!! RecaptchaV3::initJs() !!}
@endsection

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-color: #232323">
        <div class="auto-container">
            <h1>Kuesioner</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="/">Home</a></li>
                <li>Kuesioner</li>
            </ul>
        </div>
    </section>
    <!--End Page Title-->

    <!-- Contact Page Section -->
    <section class="contact-page-section">
        <div class="auto-container">
            <div class="row clearfix">
                <!-- <div class="contact-column col-lg-4 col-md-12 col-sm-12 order-2">
                    <div class="inner-column">
                        <div class="sec-title">
                            <h2>Contact Info</h2>
                        </div>
                        <ul class="contact-info">
                            <li>
                                <span class="icon fa fa-map-marker-alt"></span>
                                <p><strong>32, Breaking Street,</strong></p>
                                <p>2nd cros, Newyork ,USA 10002</p>
                            </li>

                            <li>
                                <span class="icon fa fa-phone-volume"></span>
                                <p><strong>Call Us</strong></p>
                                <p>+321 4567 89 012 & 79 023</p>
                            </li>

                            <li>
                                <span class="icon fa fa-envelope"></span>
                                <p><strong>Mail Us</strong></p>
                                <p><a href="mailto:support@example.com">Support@example.com</a></p>
                            </li>

                            <li>
                                <span class="icon fa fa-clock"></span>
                                <p><strong>Opening Time</strong></p>
                                <p>Mon - Sat: 09.00am to 18.00pm</p>
                            </li>
                        </ul>

                        <ul class="social-icon-two social-icon-colored">
                            <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fab fa-pinterest"></i></a></li>
                        </ul>
                    </div>
                </div> -->

                <!-- Form Column -->
                <div class="form-column col-lg-8 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="contact-form">
                            <div class="sec-title">
                                <h2>Silahkan Isi Kuesioner Dibawah !</h2>
                            </div>
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                            <form method="post" action="{{ route('frontsite.quizioner.store') }}" id="contact-form">
                                @csrf
                                <div class="row clearfix">
                                    @forelse ($forms as $key => $form)
                                        <div class="col-md-12 row form-group">
                                            <strong><label class="col-md-12">{{ $loop->iteration }}. {{ $form->label }} <small class="text-danger">{{ !empty($form->caption) ? "*$form->caption" : "" }}</small></label></strong>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <!-- <input type="text" class="form-control" placeholder="Category" name="category" required> -->
                                                {!! formBuilder($form) !!}
                                            </div>
                                        </div>
                                        @empty
                                        <div class="col-md-12 row form-group">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <!-- <input type="text" class="form-control" placeholder="Category" name="category" required> -->
                                                <strong>@trans('frontsite.quizioner.empty')</strong>
                                            </div>
                                        </div>
                                    @endforelse
                                        <!-- <div class="col-md-12 row form-group">
                                        <label class="col-md-12">Category</label>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <input type="text" class="form-control" placeholder="Category" name="category" required>
                                        </div>
                                    </div> -->
                                    {!! RecaptchaV3::field('quizioner') !!}

                                    @if ($forms->count() > 0)
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                            <button class="theme-btn btn-style-one" type="submit" name="submit-form"><span class="btn-title">Submit Now</span></button>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Contact Page Section -->
@endsection