@extends('layouts.backsite-layout')
@section('menuAgenda', 'active')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">@trans('backsite.agenda.create')</h4>
                            <form method="post" action="{{ route(getLang() . 'backsite.agenda.store', ['semester' => $semesterId]) }}" class="form-horizontal" enctype="multipart/form-data">
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
                                        <label class="col-sm-2 label-on-left">@trans('backsite.agenda.title')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" placeholder="Title" name="title" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.agenda.speaker')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control select2" name="speaker">
                                                    <option disabled selected> -Choose One- </option>
                                                    @forelse ($speakers as $speaker)
                                                    <option value="{{ $speaker->id }}">{{ $speaker->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.agenda.poster')</label>
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput" style="margin-left:-30px;width:300px;">
                                            <img id="preview_img" src="https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg" width="200px">
                                            <div>
                                                <span class="btn btn-rose btn-round btn-file">
                                                    <input type="file" name="poster" required accept="image/*" id="imgInp"/>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.agenda.eventdate')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control datepicker" placeholder="@trans('backsite.agenda.eventdate')" name="event_date" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Status</label>
                                        <div class="col-sm-10">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="1" checked="true"> Active
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="0"> Non-Active
                                                </label>
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