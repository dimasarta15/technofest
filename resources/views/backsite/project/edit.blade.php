@extends('layouts.backsite-layout')
@section('menuProject', 'active')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <h4 class="card-title">@trans('backsite.project.update') {{ $project->title }}</h4>
                            <form method="post" action="{{ route( getLang() . 'backsite.project.update', [
                                    'semester' => $semesterId, 
                                    'id' => $project->id,
                                    'lang' => request()->query('lang')
                                ]) }}" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                <div class="alert alert-fill-primary alert-dismissible fade show" role="alert">
                                    <i class="ti-info-alt"></i>
                                    @trans('backsite.project.notice')
                                </div>

                                <div class="alert alert-fill-info alert-dismissible fade show" role="alert">
                                    <i class="ti-info-alt"></i>
                                    @trans('backsite.project.notice2') {{ str_replace('.', '', strtoupper(getLang())) }} 
                                    @if (getLang() == 'en.')
                                        visitor
                                    @endif
                                </div>
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
                                        <div class="col-sm-12 col-md-12">
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">@trans('backsite.project.title')</label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" class="form-control" placeholder="@trans('backsite.project.title')" name="title" value="{{ $project->title }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">
                                                    @trans('backsite.project.major')
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <input type="text" name="major" class="form-control" value="{{ auth()->user()->major->name ?? auth()->user()->custom_major }}" readonly>
                                                    </div>
                                                </div>
                                            </div> 
                                            <!-- <div class="row">
                                                <label class="col-sm-3 label-on-left">@trans('backsite.project.major')</label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <select class="form-control select2 sel_major" name="major">
                                                            <option value="" disabled selected> -Choose One- </option>
                                                            @forelse ($majors as $major)
                                                            <option value="{{ $major->id }}" {{ $project->major_id == $major->id ? "selected" : "" }}>{{ $major->name }}</option>
                                                            @endforeach

                                                            <option value="other">@trans('backsite.project.major_other')</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="row canvas_custom_major" style="display: none;">
                                                <label class="col-sm-3 label-on-left">
                                                    @trans('backsite.project.custom_major')
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <input type="text" class="form-control" placeholder="Other Major" name="custom_major" id="custom_major">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">@trans('backsite.project.category')</label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <select class="form-control select2" name="category">
                                                            <option value="" disabled selected> -Choose One- </option>
                                                            @forelse ($categories as $cat)
                                                            <option value="{{ $cat->id }}" {{ $project->category_id == $cat->id ? "selected" : "" }}>{{ $cat->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">
                                                    @trans('backsite.project.desc')
                                                    <br>
                                                    <small class="text-danger" style="font-size: 11px;">@trans('backsite.project.notice3')</small>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <textarea class="form-control" placeholder="@trans('backsite.project.desc')" name="desc" required>{{ $project->desc }}</textarea>
                                                    </div>
                                                    <!-- <button class="btn btn-sm btn-success btn-gen-desc" style="margin-bottom:20px;">Generate Desc<div class="ripple-container"></div></button> -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">
                                                    @trans('backsite.project.type')
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <select class="form-control sel_project_type select2" name="project_type" required>
                                                            <option value="prototype" {{ $project->type == "prototype" ? "selected" : "" }}>Prototype</option>
                                                            <option value="copyright" {{ $project->type == "copyright" ? "selected" : "" }}>Copyright</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row canvas_copyright" {{ $project->type == "prototype" ? 'style="display: none;"': "" }}>
                                                <label class="col-sm-3 label-on-left">
                                                    Copyright ID
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <input type="text" class="form-control copyright_id" placeholder="Copyright ID" name="copyright_id" value="{{ $project->copyright_id }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">@trans('backsite.project.poster')</label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                    @component('backsite.partials.uploader', [
                                                        'title' => 'Drop Images',
                                                        'desc' => '.jpg,.png only',
                                                        'thumb' => $thumb,
                                                        'params' => [
                                                            'parent_id' => $project->id,
                                                            'sid' => !empty($img = $project->images->first()) ? $img->sid : $dzSess
                                                        ],
                                                        'acceptedFiles' => '.jpg,.png',
                                                        'uploadedFiles' => $project->images->toArray()
                                                    ])
                                                    @endcomponent
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">@trans('backsite.project.supervisor')</label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <select class="form-control sel_lecture" style="width:100% !important;" name="lecture[]" multiple="multiple" required></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">@trans('backsite.project.members')</label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <table class="form-table" style="width: 100%" id="customFields">
                                                            @forelse ($project->projectUsers as $member)
                                                                <tr valign="top">
                                                                    <td style="width:100% !important;">
                                                                        <br>
                                                                        <select class="form-control sel_member" style="width:100% !important;" name="members[]" id="member_{{ $member->id }}">
                                                                        </select> &nbsp;
                                                                    </td>
                                                                    @if ($loop->iteration != 1)
                                                                        <td>
                                                                            &nbsp; <a href="javascript:void(0);" class="remCF btn btn-danger btn-sm mt-1" style="width:30% !important;padding-right: 30px;margin-top:20px !important;"><i class="mdi mdi-delete"></i></a>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @empty
                                                                <tr valign="top">
                                                                    <td style="width:100% !important;">
                                                                        <!-- <input type="text" class="form-control option_value" name="members[]" required placeholder="Member" /> &nbsp; -->
                                                                        <select class="form-control sel_member" style="width:100% !important;" name="members[]"></select>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </table>
                                                        <a href="javascript:void(0)" class="addCF btn btn-primary btn-sm mt-2">@trans('backsite.project.addbtn')</a>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (Auth::user()->role_id == \App\Models\Role::ROLES['participant'])
                                                <div class="row">
                                                    <label class="col-sm-3 label-on-left">@trans('backsite.user.college')</label>
                                                    <div class="col-sm-9">
                                                        <div class="form-group label-floating is-empty">
                                                                <input type="text" class="form-control" placeholder="@trans('backsite.user.college')" name="college_origin" required value="{{ auth()->user()->college_origin }}" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">@trans('backsite.user.country')</label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                            <input type="text" class="form-control" placeholder="@trans('backsite.user.country')" name="college_origin" required value="{{ auth()->user()->country->name }}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">
                                                    @trans('backsite.project.thumbnail')
                                                    <span class="text-danger">*</span>
                                                    <br>
                                                    <small class="text-danger" style="font-size: 11px;">You have to upload poster first to choose the thumbnail</small>
                                                </label>
                                                <div class="col-sm-5">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <select class="form-control" data-style="btn btn-primary btn-round"
                                                        title="Choose One" name="thumbnail" id="sel_thumb" style="width:100%;">
                                                            {{-- @foreach ($single->images as $img)
                                                                <option value="{{ $img->file }}">{{ $img->file }}</option>
                                                            @endforeach --}}
                                                        </select>
                                                    </div>
                                                    <img id="img_thumb" src="https://www.mauchampions.com/wp-content/uploads/2017/04/default-image-620x600.jpg" style="height:auto;width:200px;">
                                                </div>
                                            </div>
                                            @can('access-superadmin-moderator')
                                                <div class="row">
                                                    <label class="col-sm-3 label-on-left"><small>Status</small></label>
                                                    <div class="col-sm-9">
                                                        <div class="form-group label-floating is-empty">
                                                            <label class="control-label"></label>
                                                            <select class="form-control select2" name="status" data-style="btn btn-primary btn-round"
                                                                title="Choose One" required>
                                                                <option value="1" {{ $project->status == 1 ? "selected" : "" }}> Active </option>
                                                                <option value="0" {{ $project->status == 0 ? "selected" : "" }}> Non-Active </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left"><small>@trans('backsite.project.linksourcecode')</small></label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" class="form-control" name="github_link" placeholder="@trans('backsite.project.linksourcecode')" value="{{ $project->github_link }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">@trans('backsite.project.linkdemo')</label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" class="form-control" name="demo_link" placeholder="@trans('backsite.project.linkdemo')" value="{{ $project->demo_link }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">@trans('backsite.project.linkvideo')</label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" class="form-control" name="video_link" placeholder="@trans('backsite.project.linkvideo')" value="{{ $project->video_link }}">
                                                    </div>
                                                </div>
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

@section('script')
    <script>
        let members = '{!! $project->projectUsers !!}'
        let supervisor = '{!! $project->lecture !!}'

        $(document).ready(function(){
            if (members != '[]') {
                let json = JSON.parse(members)
                for (let index = 0; index < $('.sel_member').length; index++) {
                    var $newOption = $("<option selected='selected'></option>").val(json[index].id).text(json[index].nrp + '-'+ json[index].name)
                    $('.sel_member').eq(index).append($newOption).trigger('change');
                }
            }

            initSelect2($(".sel_member"))

            $('.sel_major').change((e) => {
                let v = $(e.target).val()

                if (v == 'other') {
                    $('.canvas_custom_major').show()
                    $('#custom_major').attr('required', true)
                } else {
                    $('.canvas_custom_major').hide()
                    $('#custom_major').removeAttr('required')
                }
            })

            $(".addCF").click(function() {
                $("#customFields").append(
                    `
                    <tr valign="top">
                        <td style="width:100% !important;">
                            <br>
                            <select class="form-control sel_member" style="width:100% !important;" name="members[]">
                            </select> &nbsp;
                        </td>
                        <td>
                            &nbsp; <a href="javascript:void(0);" class="remCF btn btn-danger btn-sm mt-1" style="width:30% !important;padding-right: 30px;margin-top:20px !important;"><i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>`
                );
                
                initSelect2($(".sel_member"))
            });

            $("#customFields").on('click', '.remCF', function() {
                $(this).closest('tr').remove();
            });

            $('.btn-gen-desc').click(function(e) {
                e.preventDefault()
                
                let txtInput = $('#customFields').find('tr').find('input').val()
                let selInput = $('#customFields').find('tr').find('select').text()
                let title = $(':input[name="title"]').val()
                let cat = $(':input[name="category"]').select2('data')
                let major = $(':input[name="major"]').select2('data')
                let superVisor = $('.sel_lecture').select2('data')

                let count = $('#customFields').find('tr').length
                let content = `
                <p>Saya ${txtInput ?? selInput} dari Program Studi ${major[0]?.text} mempersembahkan maha karya pada kategori ${cat[0]?.text} dengan judul ${title}. </p>
                <p>Tak lupa ucapan terima kasih sebesar-besarnya kepada yang terhormat {Supervisor name} selaku dosen pembimbing (supervisor).</p>
                <br>
                ~Stay calm and keep ELANG (Expert, Loyal, Active, Nationalist, Gentle)
                `

                if (count > 1) {
                    let canvasMems = ``
                    $('#customFields').find('tr').each(function(i, v) {
                        let vInput = $(v).find('input').val()
                        let vSel = String($(v).find('select').find(':selected').text()).trim()
                        
                        if (vInput != "" && vInput != undefined)
                            canvasMems += `<p>- ${ $(v).find('input').val() }</p>`
                        if (vSel != "" && vSel != undefined)
                            canvasMems += `<p>- ${ vSel }</p>`
                    })

                    content = `
                    Kami 
                    ${canvasMems}
                    mempersembahkan maha karya pada kategori ${cat[0]?.text} dengan judul ${title}. </p>
                    <p>Tak lupa ucapan terima kasih sebesar-besarnya kepada yang terhormat {Supervisor name} selaku dosen pembimbing (supervisor).</p>
                    <br>
                    ~Stay calm and keep ELANG (Expert, Loyal, Active, Nationalist, Gentle)
                    `
                }

                tinyMCE.activeEditor.setContent(content);
            })
        })

        // $('.sel_lecture').select2({
        //     placeholder: '@trans("backsite.project.placeholdersupervisor")',
        //     allowClear: true,
        //     ajax: {
        //         url: '{{ route(getLang() . "backsite.select2.get-lecture") }}',
        //         dataType: 'json',
        //         data: function(params) {
        //             return {
        //                 term: params.term || '',
        //                 page: params.page || 1
        //             }
        //         },
        //         // processResults: function (data) {
        //         //     return {
        //         //         pagination: {
        //         //             more: true
        //         //         },
        //         //         results: data.results
        //         //     };
        //         // },
        //         cache: true
        //     },
        // })

        // let jsonSupervisor = JSON.parse(supervisor)
        // var $newOption = $("<option selected='selected'></option>").val(jsonSupervisor.id).text(jsonSupervisor.name)
        // $('.sel_lecture').append($newOption).trigger('change');

        /* $('.sel_lecture').select2({
            multiple:true,
            tags: true,
            tokenSeparators: [',']
        }) */

        $('.sel_project_type').change((e) => {
            let v = $(e.target).val()
            if(v == 'copyright') {
                $('.canvas_copyright').show()
                $('.copyright_id').attr('required', true)
            } else {
                $('.canvas_copyright').hide()
                $('.copyright_id').removeAttr('required')
            }
        })

        let dataSupervisors = JSON.parse('{!! $projectSupervisor !!}')
        $('.sel_lecture').select2({
            data: dataSupervisors,
            multiple:true,
            tags: true,
            tokenSeparators: ['\n']
        });
        $('.sel_lecture').val(dataSupervisors).trigger('change')
        
        function initSelect2(selectElementObj) {
            selectElementObj.select2({
                placeholder: '@trans("backsite.project.placeholdermembers")',
                allowClear: true,
                ajax: {
                    url: '{{ route(getLang() . "backsite.select2.get-user") }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                },
            })
        }

        $("#sel_thumb").change(function(e){
            let val = $("#sel_thumb :selected").attr('id')
            $(img_thumb).attr('src', '/storage/'+val);
        });
    </script>
@endsection