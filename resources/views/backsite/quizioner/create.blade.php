@extends('layouts.backsite-layout')
@section('menuQuizioner', 'active')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Create Quizioner</h4>
                            <form method="post" action="{{ route('backsite.quizioner.store', $semId) }}" class="form-horizontal">
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
                                        <label class="col-sm-2 label-on-left">Question</label>
                                        <div class="col-sm-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control" placeholder="Question" name="label" required value="{{ old('label') }}">
                                                <!-- <textarea class="form-control" placeholder="Question" name="label"></textarea> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Type</label>
                                        <div class="col-sm-8">
                                            <div class="form-group label-floating is-empty">
                                                <select class="form-control select2" name="type" id="sel_type" required>
                                                    <option value="" selected disabled>- Choose One -</option>
                                                    <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                                                    <option value="textarea" {{ old('type') == 'textarea' ? 'selected' : '' }}>Textarea</option>
                                                    <option value="number" {{ old('type') == 'number' ? 'selected' : '' }}>Number</option>
                                                    <option value="linear_scale" {{ old('type') == 'linear_scale' ? 'selected' : '' }}>Linear Scale</option>
                                                    <option value="combobox" {{ old('type') == 'combobox' ? 'selected' : '' }}>Combobox</option>
                                                    <option value="radio" {{ old('type') == 'radio' ? 'selected' : '' }}>Radio</option>
                                                    <option value="checkbox" {{ old('type') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="{{ !in_array(old('type'), ['combobox', 'radio', 'checkbox']) ? 'display:none;' : '' }}" id="canvas_options">
                                        <label class="col-sm-2 label-on-left">Options</label>
                                        <div class="col-sm-8">
                                            <table class="form-table" style="width: 100%" id="customFields">
                                                <tr valign="top">
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control option_label" name="option_label[]" value="" placeholder="Option Label"/> &nbsp;
                                                            <input type="text" class="form-control option_value" name="option_value[]" value="" placeholder="Option Value"/> &nbsp;
                                                            <a href="javascript:void(0);" class="remCF btn btn-danger btn-sm mt-1">Remove</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="col-12 d-flex justify-content-between" style="padding-bottom:20px;">
                                                <a href="javascript:void(0);" class="addCF btn btn-primary btn-sm mt-1">Add</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="canvas_linear_scale" style="margin-bottom:20px;{{ old('type') == 'linear_scale' ? '' : 'display:none;' }}">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <label class="col-sm-2 label-on-left"></label>
                                                <div class="col-sm-2">
                                                    <select class="form-control" name="linear_start" id="sel_linear_start">
                                                        <option value="0">0</option>
                                                        <option value="1" selected>1</option>
                                                    </select>
                                                </div>
                                                to
                                                <div class="col-sm-2">
                                                    <select class="form-control" name="linear_end" id="sel_linear_end">
                                                        @foreach (range(2, 10) as $v)
                                                        <option value="{{ $v }}" {{ $v == 5 ? "selected" : "" }}>{{ $v }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" style="margin-top: 20px;">
                                            <div class="row">
                                                <label class="col-sm-2 label-on-left"></label>
                                                <div class="col-sm-4">
                                                    <div class="input-group mb-2 mr-sm-2">
                                                        <div class="">
                                                            <div class="input-group-text" id="txt_label_start">1</div>
                                                        </div>
                                                        <input type="text" class="form-control" name="label_start" placeholder="Label">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 label-on-left"></label>
                                                <div class="col-sm-4">
                                                    <div class="input-group mb-2 mr-sm-2">
                                                        <div class="">
                                                            <div class="input-group-text" id="txt_label_end">5</div>
                                                        </div>
                                                        <input type="text" class="form-control" name="label_end" placeholder="Label">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Name</label>
                                        <div class="col-sm-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control" placeholder="Name" name="name" required value="{{ old('name') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Placeholder</label>
                                        <div class="col-sm-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control" placeholder="Placeholder" name="placeholder" required value="{{ old('placeholder') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Caption</label>
                                        <div class="col-sm-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control" placeholder="Caption" name="caption" value="{{ old('caption') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Sequence</label>
                                        <div class="col-sm-8">
                                            <div class="form-group label-floating is-empty">
                                                <select class="form-control" name="seq" required>
                                                    <option value="" disabled selected>- Choose One-</option>
                                                    @if ($fc->count() > 0)
                                                    @forelse (range(1, $fc->count()+1) as $n)
                                                    <option value="{{ $n }}">{{ $n }}</option>
                                                    @empty
                                                    @endforelse
                                                    @else
                                                    <option value="1">1</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Status</label>
                                        <div class="col-sm-8">
                                            <div class="form-group label-floating is-empty">
                                                <select class="form-control" name="status">
                                                    <option value="" disabled selected>- Choose One -</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Non-Active</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Is Required ? </label>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <label class="el-switch cbx_status">
                                                    <input type="checkbox" name="is_required" value="1" checked>
                                                    <span class="el-switch-style"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
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

@section('script')
<script>
    // $(sel_validator).select2({
    //     placeholder: 'ex: required | in:1,2,3',
    //     tags: true,
    //     insertTag: function(data, tag) {
    //         // Insert the tag at the end of the results
    //         data.push(tag);
    //     },
    //     tokenSeparators: [';', ' ']
    // })

    $(sel_type).change(function(e) {
        let v = $(this).val()
        if ($.inArray(v, ['radio', 'checkbox', 'combobox']) != -1) {
            $(canvas_options).show()
            $(canvas_linear_scale).hide()
        } else if (v == 'linear_scale') {
            $(canvas_linear_scale).show()
            $(canvas_options).hide()
        } else {
            $(canvas_options).hide()
            $(canvas_linear_scale).hide()
        }
    })

    $(sel_linear_start).change(function(e) {
        let v = $(this).val()
        $(txt_label_start).text(v)
    })

    $(sel_linear_end).change(function(e) {
        let v = $(this).val()
        $(txt_label_end).text(v)
    })

    $(".addCF").click(function() {
        $("#customFields").append(
            `<tr valign="top">
                <td>
                    <div class="input-group">
                        <input type="text" class="form-control option_label" name="option_label[]" value="" placeholder="Option Label" /> &nbsp;
                        <input type="text" class="form-control option_value" name="option_value[]" value="" placeholder="Option Value" /> &nbsp;
                        <a href="javascript:void(0);" class="remCF btn btn-danger btn-sm mt-1">Remove</a>
                    </div>
                </td>
            </tr>`
        );
    });

    $("#customFields").on('click', '.remCF', function() {
        $(this).closest('tr').remove();
    });
</script>
@endsection