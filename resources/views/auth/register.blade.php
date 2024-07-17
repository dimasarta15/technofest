@extends('layouts.frontsite-layout')

@section('content')
<section class="page-title" style="background-color: #232323">
    <div class="auto-container">
        <h1>@trans('frontsite.register')</h1>
        <ul class="bread-crumb clearfix">
            <li><a href="/">@trans('frontsite.home')</a></li>
            <li>@trans('frontsite.register')</li>
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
                <h1>@trans('frontsite.register')</h1>

                <!--Login Form-->
                <div class="styled-form login-form">
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
                    <form method="post" action="{{ route('register') }}">
                        @csrf

                        <div class="clearfix">
                            <input type="radio" name="origin_college" class="origin_college" id="is_eagle" checked><label class="is_eagle" for="is_eagle" style="margin-right:20px;">&nbsp; @trans('frontsite.register.iameagle')</label>
                            <input type="radio" name="origin_college" class="origin_college" id="non_eagle"><label class="non_eagle" for="non_eagle">&nbsp; @trans('frontsite.register.iamnoteagle')</label>
                        </div>

                        <div id="canvas-college"></div>
                        <div class="form-group canvas-country" style="display: none;">
                            <span class="adon-icon"><span class="fa fa-globe"></span></span>
                            <select class="form-control select-country" name="country" style="width: 100%;">

                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <span class="adon-icon"><span class="fa fa-user"></span></span>
                                    <input type="text" name="name" value="{{ old('name') }}" placeholder="@trans('frontsite.register.name')*">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <span class="adon-icon"><span class="fa fa-book"></span></span>
                                    <select class="form-control select2 sel_major" name="major" required>
                                        <option value="" disabled selected> Major* </option>
                                        @forelse ($majors as $major)
                                        <option value="{{ $major->id }}" {{ old('major') == $major->id ? "selected" : "" }}>{{ $major->name }}</option>
                                        @endforeach

                                        <option value="other">@trans('backsite.project.major_other')</option>
                                    </select>
                                    <!-- <input type="text" name="major" value="{{ old('major') }}" placeholder="@trans('frontsite.project.major')*"> -->
                                </div>
                            </div>
                        </div>

                        <div class="row canvas_custom_major" style="display: none;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <span class="adon-icon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="custom_major" id="custom_major" value="{{ old('custom_major') }}" placeholder="@trans('backsite.project.custom_major')">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="adon-icon"><span class="fa fa-graduation-cap"></span></span>
                                    <input type="text" name="nrp" value="{{ old('nrp') }}" placeholder="@trans('frontsite.register.nrp')*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="adon-icon"><span class="fa fa-phone"></span></span>
                                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="@trans('frontsite.register.telp')*" onkeypress="return isNumber(event)" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="adon-icon"><span class="fa fa-envelope"></span></span>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="@trans('frontsite.register.email')*">
                            <small class="text-danger">@trans('frontsite.register.emailnotice')</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="adon-icon"><span class="fa fa-unlock"></span></span>
                                    <input type="password" name="password" value="" placeholder="@trans('frontsite.register.password')" id="txt-password">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="adon-icon"><span class="fa fa-unlock"></span></span>
                                    <input type="password" name="password_confirmation" id="txt-cpassword" value="" placeholder="@trans('frontsite.register.cpassword')">
                                    <small class="text-danger" id="txt-check-match"></small>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="form-group pull-left">
                                <button type="submit" class="theme-btn btn-style-two"><span class="btn-title">@trans('frontsite.register')</span></button>
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

@section('script')
    <script>
        $('.origin_college').click(function(e) {
            
            if ($(this).attr('id') == 'non_eagle') {
                $('#canvas-college').html(`
                    <div class="form-group">
                        <span class="adon-icon"><span class="fa fa-building"></span></span>
                        <input type="text" name="college_origin" value="" placeholder="@trans('frontsite.register.college_origin')">
                    </div>
                `)
                $('.canvas-country').show()
                $('#custom_major').removeAttr('required')
                $('.canvas_custom_major').hide()
                $('.sel_major').prop('selectedIndex',0)
                // $('.select-country').attr('required', true)
            } else {
                $('#canvas-college').html(``)
                $('.canvas-country').hide()
                $('.select-country').removeAttr('required')
                $('#custom_major').removeAttr('required')
                $('.canvas_custom_major').hide()
                $('.sel_major').prop('selectedIndex',0)
            }
        })

        $("#txt-cpassword").keyup(checkPasswordMatch);

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }        

        function checkPasswordMatch() {
            var password = $("#txt-password").val();
            var confirmPassword = $("#txt-cpassword").val();
            if (password != confirmPassword)
                $("#txt-check-match").html("Password tidak sama !");
            else
                $("#txt-check-match").html("");
        }

        $(".select-country").select2({
            placeholder: '@trans("frontsite.register.country")',
            minimumInputLength: 3,
            ajax: {
                url: '{{ route("select2.country") }}',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function (params) {
                    console.log(params);
                    return {
                        search: params.term,
                        // prodi: prodi,
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {
                    let obj = {
                        pagination: {more: true},
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    }

                    if (data.data.length == 0) {
                        obj['pagination']['more'] = false;
                    }

                    return obj;
                },
                error: function (err) {
                    if (err.status === 500) {
                        swal.fire('Gagal', "Ada Yang Bermasalah, Coba Lagi Nanti Ya.", 'warning');
                    }

                    if (err.status === 504) {
                        swal.fire('Gagal', "Trafik Server Sedang Tinggi, Coba Lagi Nanti Ya.", 'warning');
                    }
                },
            }
        }).on('select2:select', function(e){
            /* let v = $(this).val()
            let t = $(this).select2('data')[0].text.split('-')[0].trim()
            let parent = $(this).parent().attr('id')
            let n = parent.split('-').pop()

            $('#canvas-raw-input-'+n).html(`
                <input type="hidden" name="anggota[${n}][nama_mhs]" value="${t}">
            `) */
        });

        $('.sel_major').change((e) => {
            let v = $(e.target).val()

            if (v == 'other') {
                $('.canvas_custom_major').show()
                $('#custom_major').attr('required', true)
            } else {
                $('.canvas_custom_major').hide()
                $('#custom_major').removeAttr('required')
                $('#custom_major').val('')
            }
        })
    </script>
@endsection