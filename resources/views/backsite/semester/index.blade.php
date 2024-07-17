@extends('layouts.backsite-layout')
@section('menuSemester', 'active')
@section('menuSetting', 'active')
@section('collapseSetting', 'show')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route(getLang().'backsite.semester.create') }}" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-account-plus"></i> @trans('backsite.semester.addata') </a>
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:20px;">
                                <b> Danger - </b> {{ $error }}</span>
                                <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button> -->
                            </div>
                            @endforeach
                        @endif
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover dtable" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Semester</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Semester</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </tfoot> -->
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
</div>
@endsection

@section('styles')
    <style>
        .selectParent {
            width: 100px;
            overflow: hidden;
        }

        .sel_status {
            color: black !important;
        }

        .selectParent select {
            text-indent: 1px;
            text-overflow: '';
            width: 150px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding: 2px 2px 2px 2px;
            border: none;
            background: transparent url("http://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/br_down.png") no-repeat 80px center;
        }
    </style>
@endsection

@section('script')
<script>
    getDatatable()
    $(document).on('change', '.sel_status', function(e) {
        let id = $(this).data('id')

        $.ajax({
            type: "GET",
            url: route(getLang()+'backsite.semester.update-status', id),
            dataType: "json",
            success: function (data) {
                $('.dtable').DataTable().ajax.reload()
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    })

    $(document).on('change', '.sel_position', function(e) {
        let v = $(this).val()
        let id = $(this).data('id')

        $.ajax({
            type: "POST",
            url: route(getLang()+'backsite.semester.update-position', id),
            data: {
                position: v
            },
            dataType: "json",
            success: function (data) {
                $('.dtable').DataTable().ajax.reload()
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    })

    function getDatatable() {
        /*Datatable*/
        $('.dtable').DataTable().destroy();
        $('.dtable').DataTable({
            serverSide: true,
            processing: true,
            lengthChange: false,
            ajax: {
                type: 'GET',
                url: "{{ route(getLang().'backsite.semester.datatable') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    type: $('#type').val()
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title',
                },
                {
                    data: 'semester',
                    name: 'semester',
                },
                {
                    data: 'position',
                    name: 'position',
                    render: function( data, type, row, meta ) {
                        let opts = ``
                        for (let index = 1; index <= meta.settings.json.recordsTotal; index++) {
                            opts += `<option value="${index}" ${row.position == index ? "selected" : ""}>${index}</option>`
                        }

                        let sel = `
                            <div class="selectParent">
                                <select class="form-control sel_position" data-id="${row.id}" style="color:black;">
                                    ${opts}
                                </select>
                            </div>
                        `

                        return sel
                    }
                },
                {
                    name: 'status',
                    render: function(data, type, row) {
                        return `
                        <div class="selectParent">
                            <select class="form-control sel_status" data-id="${row.id}">
                                <option ${row.status == 1 ? "selected" : ""}>Active</option>
                                <option ${row.status == 0 ? "selected" : ""} disabled>Non-Active</option>
                            </select>
                        </div>
                        `
                    }
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return ` 
                                <form action="${route(getLang()+'backsite.semester.destroy', row.id)}" method="POST" id="form_${row.id}">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="role_ref" value="{{ request()->query('role') }}">
                                    <!--<a type="button" rel="tooltip" class="btn btn-sm btn-info btn-round" data-original-title="" title="">
                                        <i class="material-icons">visibility</i>
                                    </a>-->
                                    <a type="button" rel="tooltip" class="btn btn-sm btn-success btn-round" data-original-title="" title="" href="${route(getLang()+'backsite.semester.edit', {
                                        id: row.id
                                    })}">
                                        <i class="mdi mdi-grease-pencil menu-icon"></i>
                                        <div class="ripple-container"></div>
                                    </a>
                                    <button type="submit" rel="tooltip" class="btn btn-sm btn-danger btn-round btn_delete" id="${row.id}" data-original-title="" title="">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </form>
                            `
                    }
                },
            ],
        })
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
            // if( result )
            if (result.isConfirmed) {
                let id = $(this).attr('id')
                $("#form_" + id).submit()
            }
        });
    })
</script>
@endsection