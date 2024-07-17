@extends('layouts.backsite-layout')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="offset-3 col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Profil Saya</h4>
                                <form method="post" action="{{ route('backsite.user.update-profile') }}" class="form-sample" enctype='multipart/form-data'>
                                    @csrf
                                    <div class="card-content">
                                        @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <b> Danger - </b> {{ $error }}</span>
                                        </div>
                                        @endforeach
                                        @endif
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputUsername1">@trans('backsite.user.country')</label>
                                                <select class="form-control select-country" name="country" required>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">@trans('backsite.user.name')</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="@trans('backsite.user.name')" value="{{ $user->name }}" name="name">
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputUsername1">@trans('backsite.user.major')</label>
                                                <select class="form-control select2 sel_major" name="major" required>
                                                    <option value="" disabled selected> Major* </option>

                                                    @if (!empty(auth()->user()->major->name))
                                                        @forelse ($majors as $major)
                                                            <option value="{{ $major->id }}" {{ auth()->user()->major->id == $major->id ? "selected" : "" }}>{{ $major->name }}</option>
                                                        @endforeach
                                                        <option value="other">@trans('backsite.user.major_other')</option>
                                                    @else
                                                        @forelse ($majors as $major)
                                                            <option value="{{ $major->id }}">{{ $major->name }}</option>
                                                        @endforeach
                                                        <option value="other" selected>@trans('backsite.user.major_other')</option>
                                                    @endif

                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 canvas_custom_major" {!! !empty(auth()->user()->major->name) ? 'style="display: none;"' : "" !!}>
                                            <div class="form-group">
                                                <label for="exampleInputUsername1">@trans('backsite.user.custom_major')</label>
                                                <input type="text" class="form-control" name="custom_major" id="custom_major" value="{{ auth()->user()->custom_major }}" placeholder="@trans('backsite.user.custom_major')">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">@trans('backsite.user.telp')</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="@trans('backsite.user.telp')" value="{{ $user->telephone }}" name="telephone">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">@trans('backsite.user.email')</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="@trans('backsite.user.email')" value="{{ $user->email }}" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">@trans('backsite.user.password')</label>
                                            <input type="password" class="form-control" id="exampleInputUsername1" placeholder="@trans('backsite.user.password')" name="password">
                                        </div>

                                        @if (auth()->user()->role_id == \App\Models\Role::ROLES['participant'])
                                            <div class="row" id="canvas-nrp-college">
                                                @if ($isEagle != 1)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">@trans('backsite.user.nrp')</label>
                                                            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="@trans('backsite.user.nrp')" value="{{ $user->nrp }}" name="nrp">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">@trans('backsite.user.college')</label>
                                                            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="@trans('backsite.user.college')" value="{{ $user->college_origin }}" name="college_origin">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">@trans('backsite.user.nrp')</label>
                                                            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="@trans('backsite.user.nrp')" value="{{ $user->nrp }}" name="nrp">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <input type="checkbox" id="is_eagle" name="is_eagle" {{ $isEagle == 1 ? "checked" : "" }}> @trans('frontsite.register.iameagle')
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <button type="submit" class="btn btn-fill btn-primary">Submit<div class="ripple-container"></div></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const userCountryId = '{{ $user->country()->first()->id ?? null }}'
        const userCountryTxt = '{{ $user->country()->first()->name ?? null }}'

        let $optionCountry = $("<option selected></option>").val(userCountryId).text(userCountryTxt);
        $(".select-country").empty()
        $(".select-country").append($optionCountry).trigger('change');
        
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

        $('#is_eagle').change(function(e) {
            let checked = $(this).is(':checked')
            if (!checked) {
                $('#canvas-nrp-college').html(`
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputUsername1">NRP / NIM</label>
                            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="NRP / NIM" value="{{ $user->nrp }}" name="nrp">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Asal Perguruan Tinggi</label>
                            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Asal Perguruan Tinggi" value="{{ $user->college_origin }}" name="college_origin">
                        </div>
                    </div>
                `)
            } else {
                $('#canvas-nrp-college').html(`
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputUsername1">NRP / NIM</label>
                            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="NRP / NIM" value="{{ $user->nrp }}" name="nrp">
                        </div>
                    </div>
                `)
            }
        })
    </script>
@endsection