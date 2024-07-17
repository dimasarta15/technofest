@extends('layouts.backsite-layout')
@section('menuGeneral', 'active')
@section('collapseSetting', 'show')
@section('menuSetting', 'active')


@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Form Setting</h4>
                            <form method="post" action="{{ route('backsite.setting.store') }}" class="form-horizontal" enctype='multipart/form-data'>
                                @csrf
                                <div class="card-content">
                                    @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <b> Danger - </b> {{ $error }}</span>
                                        <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button> -->
                                    </div>
                                    @endforeach
                                    @endif
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.general.webtitle')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" placeholder="Website Title" name="title" required value="{{ $setting->key('title')->value }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.general.about')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <textarea class="editor" title="Type markdown here" name="about">{{ $setting->key('about')->value }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.general.about_en')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <textarea class="editor" title="Type markdown here" name="about_en">{{ $setting->key('about_en')->value ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.general.eventdate')</label>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">@trans('backsite.general.eventstart')</label>
                                                <input type="text" class="form-control datepicker" placeholder="Event Start" name="event_start" required value="{{ $setting->key('event_start')->value }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">@trans('backsite.general.eventend')</label>
                                                <input type="text" class="form-control datepicker" placeholder="Event End" name="event_end" required value="{{ $setting->key('event_end')->value }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.general.logo')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput" style="margin-left:-30px;width:300px;">
                                                    
                                                    @if (empty($setting->key('logo')->value))
                                                        <img id="preview_img" src="https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg" width="200px">
                                                    @else
                                                        <img id="preview_img" src="/storage/{{ $setting->key('logo')->value }}" width="200px">
                                                    @endif
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <input type="file" accept="image/*" id="imgInp"/ name="logo_img">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.general.logohomepage')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput" style="margin-left:-30px;width:300px;">
                                                    
                                                    @if (empty($setting->key('logo_home')->value))
                                                        <img id="preview_img_home" src="https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg" width="200px">
                                                    @else
                                                        <img id="preview_img_home" src="/storage/{{ $setting->key('logo_home')->value }}" width="200px">
                                                    @endif
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <input type="file" accept="image/*" id="imgInpHome"/ name="logo_img_home">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.general.allowupload')</label>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <label class="el-switch cbx_status" id="{{ $setting->key('allow_upload')->value }}">
                                                    <input type="checkbox" name="allow_upload" value="1" {{ $setting->key('allow_upload')->value == 1 ? "checked" : "" }}>
                                                    <span class="el-switch-style"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h3>@trans('backsite.general.styling')</h3>
                                    <div class="row">
                                        @foreach ($setting->where('is_css', 1)->get() as $setting)
                                            <div class="col-md-4">
                                                <label class="col-sm-12 label-on-left">{{ \App\Models\Setting::LABELS[$setting->key] }}</label>
                                                <div class="col-sm-4">
                                                    <div class="form-group label-floating is-empty">
                                                        <input type="color" 
                                                            placeholder="{{ \App\Models\Setting::LABELS[$setting->key] }}" 
                                                            name="{{ $setting->key }}" required 
                                                            value="{{ $setting->value ?? \App\Models\Setting::DEFAULT_COLOR[$setting->key] }}"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <textarea class="form-control" placeholder="Editor Custom CSS" name="custom_css">{{ empty($setting->key('custom_css')->value) ? old('custom_css')  : $setting->key('custom_css')->value }}</textarea>
                                            </div>
                                        </div>
                                    </div>
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