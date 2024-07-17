@extends('layouts.backsite-layout')
@section('menuEvent', 'active')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">@trans('backsite.event.create')</h4>
                            <form method="post" action="{{ route(getLang() . 'backsite.event.store', [
                                'semester' => $semester->id,
                                'lang' => request()->query('lang'),
                            ]) }}" class="form-horizontal" enctype="multipart/form-data">
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
                                        <label class="col-sm-2 label-on-left">@trans('backsite.event.event')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control" placeholder="@trans('backsite.event.event')" name="Event" value="{{ $semester->title }}" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.event.semester')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control" placeholder="@trans('backsite.event.semester')" name="Semester" value="{{ $semester->semester }}" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.event.title')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control" placeholder="@trans('backsite.event.title')" name="title" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.event.isyt')</label>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <label class="el-switch cbx_status">
                                                    <input type="checkbox" id="is-yt">
                                                    <span class="el-switch-style"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row canvas-photo">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.event.photo')</label>
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput" style="margin-left:-30px;width:300px;">
                                            <img id="preview_img" src="https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg" width="200px">
                                            <div>
                                                <span class="btn btn-rose btn-round btn-file">
                                                    <input type="file" name="photo" accept="image/*" id="imgInp"/>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row canvas-yt" style="display:none;">
                                        <label class="col-sm-2 label-on-left">Youtube</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control" placeholder="Youtube" name="youtube">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.semester.visible')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control select2" name="visible" required>
                                                    <option value="" disabled selected> -Choose One- </option>
                                                    <option value="1"> Visible </option>
                                                    <option value="0"> Hidden </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <br>
                                        <label class="col-md-2"></label>
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
        $('#is-yt').click(function(e) {
            let v = $(this).is(':checked')

            if (v) {
                $('.canvas-yt').show()
                $('.canvas-photo').hide()
            } else{
                $('.canvas-yt').hide()
                $('.canvas-photo').show()
            }
        })
    </script>
@endsection