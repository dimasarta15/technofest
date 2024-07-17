@extends('layouts.backsite-layout')
@section('menuSemester', 'active')
@section('menuSetting', 'active')
@section('collapseSetting', 'show')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Update Semester {{ $item->semester }}</h4>
                            <form method="post" action="{{ route(getLang().'backsite.semester.update', $item->id) }}" class="form-horizontal">
                                @csrf
                                @method('PUT')
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
                                        <label class="col-sm-2 label-on-left">@trans('backsite.semester')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" placeholder="Semester" name="semester" required value="{{ $item->semester }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.semester.title')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" placeholder="Title" name="title" required value="{{ $item->title }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.semester.position')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="number" class="form-control" placeholder="Position" name="position" required value="{{ $item->position }}">
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
                                                    <option value="1" {{ $item->visible == '1' ? "selected" : "" }}> Visible </option>
                                                    <option value="0" {{ $item->visible == '0' ? "selected" : "" }}> Hidden </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <label class="col-sm-2 label-on-left">Status</label>
                                        <div class="col-sm-10">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionsRadios"> Active
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionsRadios" checked="true"> Non-Active
                                                </label>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="row">
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