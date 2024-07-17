@extends('layouts.backsite-layout')
@section('menuSemester', 'active')
@section('menuMaster', 'in')
@section('collapseMaster', 'active')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form method="post" action="{{ route('backsite.year.store') }}" class="form-horizontal">
                        @csrf
                        <div class="card-header card-header-text" data-background-color="rose">
                            <h4 class="card-title">Create Year</h4>
                        </div>
                        <div class="card-content">
                            @if ($errors->any())
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <button type="button" aria-hidden="true" class="close">
                                    <i class="material-icons">close</i>
                                </button>
                                <span>
                                    <b> Danger - </b> {{ $error }}</span>
                            </div>
                            @endforeach
                            @endif
                            <div class="row">
                                <label class="col-sm-2 label-on-left">Year</label>
                                <div class="col-sm-10">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="number" class="form-control" placeholder="Year" name="year" required>
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
                                        <button type="submit" class="btn btn-fill btn-rose">Submit<div class="ripple-container"></div></button>
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
@endsection