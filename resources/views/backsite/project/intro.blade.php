@extends('layouts.backsite-layout')
@section('menuProject', 'active')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover dtable" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Event</th>
                                        <th>Semester</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Event</th>
                                        <th>Semester</th>
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
                url: "{{ route(getLang() . 'backsite.semester.datatable') }}",
                data: {
                    _token: "{{ csrf_token() }}",
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
                    data: 'status_text',
                    name: 'status_text',
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            ${row.status_text == "Active" ? `<strong>${row.status_text}</strong>` : row.status_text}
                            `
                    }
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    className: 'text-right',
                    render: function(data, type, row) {
                        return `
                            <a rel="tooltip" class="btn btn-sm btn-primary btn-round" data-original-title="" href="${ route(getLang() + 'backsite.project.list-project', {
                                semester: row.id,
                                _query: {
                                    lang: "{{ getLang() ? request()->query('lang', str_replace('.', '', getLang())) : 'en' }}"
                                },
                            }) }">
                                <i class="mdi mdi-folder"></i> List Projects
                            </a>
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
            // if( result )
            let id = $(this).attr('id')
            $("#form_" + id).submit()
        });
    })
</script>
@endsection