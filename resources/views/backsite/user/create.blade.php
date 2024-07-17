@extends('layouts.backsite-layout')
@section('menu'.str_replace(' ', '', ucfirst($role->role)), 'active')
@section('menuUser', 'in')
@section('collapseUser', 'show')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">@trans('backsite.user.create') {{ $role->role }}</h4>
                            <form method="post" action="{{ route(getLang() . 'backsite.user.store') }}" class="form-horizontal">
                                @csrf
                                <input type="hidden" value="{{ request()->query('role') }}" name="role_ref">
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
                                        <label class="col-sm-2 label-on-left">@trans('backsite.user.name')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="ref" class="form-control" placeholder="@trans('backsite.user.name')" name="name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.user.email')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" placeholder="@trans('backsite.user.email')" name="email" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.user.password')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="password" class="form-control" placeholder="@trans('backsite.user.password')" name="password" required>
                                            </div>
                                        </div>
                                    </div>
                                    @if (request()->query('role') == \App\Models\Role::ROLES['participant'])
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.user.nrp')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" placeholder="@trans('backsite.user.nrp')" name="nrp" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.user.college')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" placeholder="@trans('backsite.user.college')" name="college_origin" required>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">@trans('backsite.user.telp')</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" placeholder="@trans('backsite.user.telp')" name="telephone" required>
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
                                                <!-- <button type="submit" class="btn btn-fill btn-rose">Submit<div class="ripple-container"></div></button> -->
                                                <button type="submit" class="btn btn-primary me-2">Submit</button>
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