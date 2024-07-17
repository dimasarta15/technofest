@extends('layouts.backsite-layout')
@section('menuProject', 'active')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">@trans('backsite.project.create')</h4>
                            <form method="post" action="{{ route(getLang() . 'backsite.project.store', [
                                'semester' => $semesterId,
                                'lang' => request()->query('lang'),
                            ]) }}" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
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
                                                <label class="col-sm-3 label-on-left">
                                                    @trans('backsite.project.title')
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <input type="text" class="form-control" placeholder="@trans('backsite.project.title')" name="title" required value="{{ old('title') }}" maxlength="100">
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
                                                <label class="col-sm-3 label-on-left">
                                                    @trans('backsite.project.major')
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <select class="form-control select2 sel_major" name="major" required>
                                                            <option value="" disabled selected> -Choose One- </option>
                                                            @forelse ($majors as $major)
                                                            <option value="{{ $major->id }}" {{ old('major') == $major->id ? "selected" : "" }}>{{ $major->name }}</option>
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
                                                <label class="col-sm-3 label-on-left">
                                                    @trans('backsite.project.category')
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <select class="form-control select2" name="category" required>
                                                            <option value="" disabled selected> -Choose One- </option>
                                                            @forelse ($categories as $cat)
                                                            <option value="{{ $cat->id }}" value="{{ old('category') == $cat->id ? "selected" : "" }}">{{ $cat->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">
                                                    <small>@trans('backsite.project.desc')</small>
                                                    <span class="text-danger">*</span>
                                                    <br>
                                                    <small class="text-danger" style="font-size: 11px;">@trans('backsite.project.notice3')</small>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <textarea class="form-control desc" placeholder="@trans('backsite.project.desc')" name="desc">{{ old('desc') }}</textarea>
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
                                                            <option value="prototype">Prototype</option>
                                                            <option value="copyright">Copyright</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row canvas_copyright" style="display: none;">
                                                <label class="col-sm-3 label-on-left">
                                                    Copyright ID
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <input type="text" class="form-control copyright_id" placeholder="Copyright ID" name="copyright_id">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">
                                                    @trans('backsite.project.poster')
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                    @component('backsite.partials.uploader', [
                                                        'title' => 'Drop Images',
                                                        'desc' => '.jpg,.png only',
                                                        'acceptedFiles' => '.jpg,.png',
                                                    ])
                                                    @endcomponent
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">
                                                    <small>@trans('backsite.project.supervisor')</small>
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <select class="form-control sel_lecture" style="width:100% !important;" name="lecture[]" multiple="multiple" required></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-12"> -->
                                                <div class="row">
                                                    <label class="col-sm-3 label-on-left">
                                                        @trans('backsite.project.members')
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <div class="form-group label-floating is-empty">
                                                            <table class="form-table" style="width: 100%" id="customFields">
                                                            
                                                            @if (Auth::user()->role_id == \App\Models\Role::ROLES['participant'])
                                                                <tr valign="top">
                                                                    <td style="width:100% !important;padding-bottom:15px;">
                                                                        <!-- <input type="text" class="form-control option_value" name="members[]" required placeholder="Member" /> &nbsp; -->
                                                                        <input class="form-control" value="{{ Auth::user()->nrp .'-' .Auth::user()->name }}" disabled>
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                <tr valign="top">
                                                                    <td style="width:100% !important;">
                                                                        <!-- <input type="text" class="form-control option_value" name="members[]" required placeholder="Member" /> &nbsp; -->
                                                                        <select class="form-control sel_member" style="width:100% !important;" name="members[]"></select>
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            </table>
                                                            <a href="javascript:void(0)" class="addCF btn btn-primary btn-sm mt-2">@trans('backsite.project.addbtn') Member</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- </div> -->
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
                                                        <select class="form-control" data-style="btn btn-primary btn-round"
                                                        title="Choose One" data-size="7" name="thumbnail" id="sel_thumb" style="width:100%;" required>
                                                        </select>
                                                    </div>
                                                    <img id="img_thumb" src="http://www.bwikotamalang.net/assets/img/blank.jpg" style="height:auto;width:200px;padding-bottom:25px;">
                                                </div>
                                            </div>
                                            @can('access-superadmin-moderator')
                                                <div class="row">
                                                    <label class="col-sm-3 label-on-left"><small>Status</small></label>
                                                    <div class="col-sm-9">
                                                        <label class="control-label"></label>
                                                        <div class="form-group label-floating is-empty">
                                                            <select class="form-control select2" name="status" data-style="btn btn-primary btn-round"
                                                                title="Choose One" required>
                                                                <option value=""> Choose One </option>
                                                                <option value="1" {{ old('status') == 1 ? "selected" : "" }}> Active </option>
                                                                <option value="0" {{ old('status') == 0 ? "selected" : "" }}> Non-Active </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left"><small>@trans('backsite.project.linksourcecode')</small></label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <input type="text" class="form-control" name="github_link" placeholder="@trans('backsite.project.linksourcecode')" value="{{ old('github_link') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left"><small>@trans('backsite.project.linkdemo')</small></label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <input type="text" class="form-control" name="demo_link" placeholder="@trans('backsite.project.linkdemo')" value="{{ old('demo_link') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">@trans('backsite.project.linkvideo')</label>
                                                <div class="col-sm-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <input type="text" class="form-control" name="video_link" placeholder="@trans('backsite.project.linkvideo')" value="{{ old('demo_video') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-9">
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
        const lang = "{{ request()->query('lang') }}"

        $(document).ready(function(){
            initSelect2($(".sel_member"))

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

            $('.sel_lecture').select2({
                multiple:true,
                tags: true,
                tokenSeparators: ['\n']
            })
            
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

            // $('.sel_major').change((e) => {
            //     let v = $(e.target).val()

            //     if (v == 'other') {
            //         $('.canvas_custom_major').show()
            //         $('#custom_major').attr('required', true)
            //     } else {
            //         $('.canvas_custom_major').hide()
            //         $('#custom_major').removeAttr('required')
            //     }
            // })

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
                let selInput = $('#customFields').find('tr').find(':selected').text()
                let title = $(':input[name="title"]').val()
                let cat = $(':input[name="category"]').select2('data')
                let major = $(':input[name="major"]').val()
                let superVisor = $('.sel_lecture').select2('data')

                let count = $('#customFields').find('tr').length
                let content = `
                <p>Saya ${txtInput ?? selInput} dari Program Studi ${major} mempersembahkan maha karya pada kategori ${cat[0]?.text} dengan judul ${title}. </p>
                <p>Tak lupa ucapan terima kasih sebesar-besarnya kepada yang terhormat {Supervisor name} selaku dosen pembimbing (supervisor).</p>
                <br>
                ~Stay calm and keep ELANG (Expert, Loyal, Active, Nationalist, Gentle)
                `

                if (lang == 'en') {
                    content = `
                    <p>I am ${txtInput ?? selInput} majoring ${major} presenting a masterpiece in the ${cat[0]?.text} category, ${title}. </p>
                    <p>Thank you to Mr/Mrs. {Supervisor name} as the supervisor.</p>
                    <br>
                    ~Stay calm and keep ELANG (Expert, Loyal, Active, Nationalist, Gentle)
                    `
                }

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

                    if (lang == 'en') {
                        content = `
                        We 
                        ${canvasMems}
                        presenting a masterpiece in the ${cat[0]?.text} category, ${title}. </p>
                        <p>Thank you to Mr/Mrs. {Supervisor name} as the supervisor.</p>
                        <br>
                        ~Stay calm and keep ELANG (Expert, Loyal, Active, Nationalist, Gentle)
                        `
                    }
                }

                tinyMCE.activeEditor.setContent(content);
            })
        })


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