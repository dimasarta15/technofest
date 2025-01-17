@extends('layouts.backsite-layout')
@section('menuSpeaker', 'active')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route(getLang() . 'backsite.speaker.create') }}" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-account-plus"></i> @trans('backsite.speaker.addata') </a>
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover dtable" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Photo</th>
                                        <th>Position</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Photo</th>
                                        <th>Position</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </tfoot> -->
                                <tbody>
                                </tbody>
                            </table>
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
    getDatatable()

    function getDatatable() {
        /*Datatable*/
        $('.dtable').DataTable().destroy();
        $('.dtable').DataTable({
            serverSide: true,
            processing: true,
            lengthChange: false,
            ajax: {
                type: 'GET',
                url: "{{ route(getLang() . 'backsite.speaker.datatable') }}",
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
                    data: 'name',
                    name: 'name',
                },
                {
                    data: null,
                    name: 'image',
                    render: function(data, type, row) {
                        return `
                            <a class="fancybox" href="/storage/${row.image}" data-fancybox-group="gallery" title="">
                                <img src="/storage/${row.image}" alt="" style="width:100px !important;height:auto;"/>
                            </a>
                        `
                    }
                },
                {
                    data: 'position',
                    name: 'position'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return ` 
                                <form action="${route(getLang() + 'backsite.speaker.destroy', row.id)}" method="POST" id="form_${row.id}">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="role_ref" value="{{ request()->query('role') }}">
                                    <!--<a type="button" rel="tooltip" class="btn btn-sm btn-info btn-round" data-original-title="" title="">
                                        <i class="material-icons">visibility</i>
                                    </a>-->
                                    <a type="button" rel="tooltip" class="btn btn-sm btn-success btn-round" data-original-title="" title="" href="${route(getLang() + 'backsite.speaker.edit', {
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
            "drawCallback": function( settings ) {
                $(".fancybox").fancybox();
            }
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
            if( result.isConfirmed ) {
                let id = $(this).attr('id')
                $("#form_" + id).submit()
            }
        });
    })
</script>
@endsection