@extends('layouts.backsite-layout')
@section('menuAgenda', 'active')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route(getLang() . 'backsite.agenda.create', $semester->id) }}" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-account-plus"></i> @trans('backsite.agenda.addata') </a>
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover dtable" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Speaker Name</th>
                                        <th>Title</th>
                                        <th>Event Date</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Speaker Name</th>
                                        <th>Title</th>
                                        <th>Event Date</th>
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
                url: "{{ route(getLang() . 'backsite.agenda.datatable') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    semester_id: '{{ $semester->id }}'
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'speaker.name',
                    name: 'speaker.name',
                    render: function(data, type, row) {
                        let ret = "<strong>Speaker not available</strong>"
                        if (row.speaker != null) {
                            ret = row.speaker.name
                        }

                        return ret
                    }
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'event_date',
                    name: 'event_date'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return ` 
                            <form action="${route(getLang() + 'backsite.agenda.destroy', {
                                id: row.id,
                                semester: row.semester_id
                            })}" method="POST" id="form_${row.id}">
                                @csrf
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="role_ref" value="{{ request()->query('role') }}">
                                <!--<a type="button" rel="tooltip" class="btn btn-sm btn-info btn-round" data-original-title="" title="">
                                    <i class="material-icons">visibility</i>
                                </a>-->
                                <a type="button" rel="tooltip" class="btn btn-sm btn-success btn-round" data-original-title="" title="" href="${route(getLang() + 'backsite.agenda.edit', {
                                    id: row.id,
                                    semester: row.semester_id
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
            ]
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
            if (result.isConfirmed) {
                let id = $(this).attr('id')
                $("#form_" + id).submit()
            }
        });
    })
</script>
@endsection