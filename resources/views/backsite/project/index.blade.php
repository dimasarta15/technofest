@extends('layouts.backsite-layout')
@section('menuProject', 'active')
@section('styles')
    <style>
        .selectParent {
            width: 180px;
            overflow: hidden;
        }

        .sel_status {
            color: black !important;
        }

        .selectParent select {
            text-indent: 1px;
            text-overflow: '';
            width: 180px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding: 2px 2px 2px 2px;
            border: none;
            background: transparent url("http://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/br_down.png") no-repeat 150px center;
        }
    </style>
@endsection
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="card-content float-sm-right">
                            <h4 class="card-title">@trans('backsite.project.titleindex') {{ $semester->semester }}</h4>

                            <!-- Tabs navs -->
                            <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request()->query('lang') == 'en' ? "active" : "" }}" id="ex1-tab-1" data-mdb-toggle="tab" href="{{ route('backsite.project.list-project', [
                                        'lang' => 'en',
                                        'semester' => $semester
                                    ]) }}" role="tab" aria-controls="ex1-tabs-1" aria-selected="true">EN</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request()->query('lang') == 'id' ? "active" : "" }}" id="ex1-tab-2" data-mdb-toggle="tab" href="{{ route('backsite.project.list-project', [
                                        'lang' => 'id',
                                        'semester' => $semester
                                    ]) }}" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">ID</a>
                                </li>
                            </ul>
                            <!-- Tabs navs -->
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="d-flex text-right" >
                                        <div style="margin-left:auto !important">
                                            @can('access-upload')
                                                <a class="btn btn-sm btn-primary " href="{{ route(getLang() . 'backsite.project.create',
                                                    [
                                                        'semester' => $semester->id,
                                                        'lang' => request()->query('lang') ?? "en"
                                                    ]) }}">
                                                    <i class="mdi mdi-plus-circle-outline "></i> @trans('backsite.project.addata')
                                                </a>
                                            @endcan
                                            @can('access-superadmin-moderator')
                                                <button class="btn btn-sm btn-warning "  type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    <i class="mdi mdi-file-excel"></i> Export
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Status</label>
                                        <select class="form-control select2" name="sel_status" id="sel_status">
                                            <option value="">All</option>
                                            <option value="1">Active</option>
                                            <option value="0">Non-Active</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Category</label>
                                        <select class="form-control select2" name="sel_cat" id="sel_cat">
                                            <option value="">All</option>
                                            @forelse ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover dtable" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            @can('access-superadmin-moderator')
                                            <th width="180px">Active</th>
                                            @endcan
                                            <th class="disabled-sorting text-right">Actions</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Category</th>
                                            <th>Major</th>
                                            <th>Supervisor</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <!-- <tfoot>
                                        <tr>
                                            <th>No</th>
                                            @can('access-superadmin-moderator')
                                            <th>Active</th>
                                            @endcan
                                            <th class="disabled-sorting text-right" width="20%">Actions</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Category</th>
                                            <th>Major</th>
                                            <th>Supervisor</th>
                                            <th>Created At</th>
                                        </tr>
                                    </tfoot> -->
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end content-->
                        </div>
                    </div>
                    <!--  end card  -->
                </div>
                <!-- end col-md-12 -->
            </div>
            <!-- end row -->
        </div>
    </div>
</div>
@include('backsite.project.modal')
@endsection
@section('script')
<script>
    let status = ""
    let category = ""
    const lang = "{{ request()->query('lang') }}"

    if (localStorage.getItem("filterStatus") === null)
        localStorage.setItem('filterStatus', '')

    if (localStorage.getItem("filterCat") === null)
        localStorage.setItem('filterCat', '')

    if (localStorage.getItem('filterStatus') != "") {
        status = localStorage.getItem('filterStatus')
        $("#sel_status").select2().select2('val', localStorage.getItem('filterStatus'))
    }

    if (localStorage.getItem('filterCat') != "") {
        category = localStorage.getItem('filterCat')
        $("#sel_cat").select2().select2('val', localStorage.getItem('filterCat'))
    }

    $('#sel_status').change(function(e) {
        status = $(this).val()
        localStorage.setItem('filterStatus', status)
        getDatatable()
    })

    $('#sel_cat').change(function(e) {
        category = $(this).val()
        localStorage.setItem('filterCat', category)
        getDatatable()
    })

    $('#btn_export').click(function(e) {
        e.preventDefault()
        let v = $('#sel_export_status').val()
        if (v == null) {
            alert('Choose Status First !')
            return
        }
        window.open(route(getLang() + 'backsite.project.export', {semester: '{{ $semester->id }}', status: v}), '_blank').focus();
    })

    getDatatable()

    function getDatatable() {
        /*Datatable*/
        // $('.dtable').DataTable().destroy();
        if (!$.fn.dataTable.isDataTable($('.dtable'))) {
            $('.dtable').DataTable({
                serverSide: true,
                processing: true,
                lengthChange: false,
                ajax: {
                    type: 'GET',
                    url: "{{ route(getLang() . 'backsite.project.datatable') }}",
                    data: function(data) {
                        data._token = "{{ csrf_token() }}"
                        data.semester_id = '{{ $semester->id }}'
                        data.category = category
                        data.status = status
                        data.lang = lang
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    @can('access-superadmin-moderator') 
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            return ` 
                            <div class="selectParent">
                                <select class="form-control sel_project_status" style="color:black;width:180px !important;" data-id=${row.id}>
                                    <option value="" ${ row.approved_at == null ? "selected" : "" }>Waiting for Approval</option>
                                    <option value="1" ${ row.status == 1 ? "selected" : "" }>Active</option>
                                    <option value="0" ${ row.status == 0 ? "selected" : "" }>Non-Active</option>
                                </select>
                            </div>
                            <!--<label class="el-switch cbx_status" id="${row.id}">
                                <input type="checkbox" name="status" id="${row.id}" ${row.status == 1 ? "checked" : "" }>
                                <span class="el-switch-style"></span>
                            </label>-->
                        `
                        },
                        orderable: false,
                        searchable: false
                    },
                    @endcan {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return ` 
                                    <form action="${route(getLang() + 'backsite.project.destroy', {id: row.id, semester: row.semester_id, lang: lang})}" method="POST" id="form_${row.id}">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete">
                                        <a type="button" rel="tooltip" class="btn btn-sm btn-info btn-round" data-original-title="" title="" href="${route(getLang() + 'backsite.project.show', {id: row.id, semester: row.semester_id, lang: lang})}">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <a type="button" rel="tooltip" class="btn btn-sm btn-success btn-round" data-original-title="" title="" href="${route(getLang() + 'backsite.project.edit', {
                                            id: row.id, 
                                            semester: row.semester_id,
                                            lang: lang
                                        })}">
                                            <i class="mdi mdi-pencil"></i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        <button type="submit" rel="tooltip" class="btn btn-sm btn-danger btn-round btn_delete" id="${row.id}" data-original-title="" title="">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                `
                        }
                    },
                    {
                        data: 'title',
                        name: 'title',
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row) {
                            let ret = ``
                            if (row.status == 1)
                                ret = `Active`
                            else if (row.status == 0) 
                                ret = `Non-Active`
                            else
                                ret = `Waiting Approval`

                            return ret
                        }
                    },
                    {
                        data: 'category.name',
                        name: 'category.name',
                        orderable: false,
                    },
                    {
                        data: null,
                        searchable: false,
                        // name: 'user.major',
                        orderable: false,
                        render: function(data, type, row) {
                            let ret = ``
                            console.log(row)
                            if (row?.user?.major != null)
                                ret = row?.user?.major?.name
                            else
                                ret = row?.user?.custom_major
                            
                            return ret ?? ``
                        }
                    },
                    {
                        data: null,
                        // name: 'lecture.name',
                        render: function(data, type, row) {
                            let ret = ``

                            if (row.lecture == null) {
                                let arrSups = []
                                $.each(row.project_supervisors, (i, v) => {
                                    arrSups.push(v.supervisor)
                                })

                                ret = arrSups.join(', ')
                                // console.log('xx', row?.lecture?.name)
                            } else {
                                ret = row?.lecture?.name
                                // console.log('y', row?.lecture?.name)
                            }

                            return ret
                        },
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                ],
                "drawCallback": function(settings) {

                    $('.cbx_status').change(function() {
                        let v = $(this).attr('id')
                        updatestatus(v)
                    })
                }
            })
        }
        $('.dtable').DataTable().ajax.reload();
    }

    $(document).on('click', '.btn_delete', function(e) {
        e.preventDefault()

        Swal.fire({
            icon: 'warning',
            title: 'Are You Sure ?',
            text: "Are you sure to delete this item!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it !'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $(this).attr('id')
                $("#form_" + id).submit()
            }
        });
    })

    $(document).on('change', '.sel_project_status', function(e) {
        let id = $(this).data('id')
        let v = $(this).val()

        $.ajax({
            type: "POST",
            url: "{{ route(getLang() . 'backsite.project.update-status') }}",
            data: { id: id, status: v },
            dataType: "json",
            success: function (data) {
                // console.log(data)
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success !',
                        text: data.data,
                        type: 'success'
                    }).then((result) => {
                        // if (result.isConfirmed) {
                        // }
                        getDatatable()
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    })

    // function updatestatus(id) {
    //     $.ajax({
    //         type: "POST",
    //         url: "{{-- route(getLang() . 'backsite.project.update-status') --}}",
    //         data: {
    //             id: id
    //         },
    //         dataType: "json",
    //         success: function(data) {
    //             if (data.success) {
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'Success !',
    //                     text: data.data,
    //                     type: 'success'
    //                 }).then((result) => {
    //                     if (result.isConfirmed) {
    //                         getDatatable()
    //                     }
    //                 });
    //             }
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             console.log(textStatus);
    //             console.log(errorThrown);
    //         }
    //     });
    // }
</script>
@endsection