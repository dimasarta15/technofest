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
                    <a href="{{ route('backsite.year.create') }}">
                        <div class="card-header card-header-icon" data-background-color="purple">
                            <i class="material-icons">add</i>
                        </div>
                    </a>
                    <div class="card-content">
                        <h4 class="card-title">Year</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover dtable" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Year</th>
                                        <th>Created At</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Year</th>
                                        <th>Created At</th>
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
            ajax: {
                type: 'GET',
                url: "{{ route('backsite.year.datatable') }}",
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
                    data: 'year',
                    name: 'year',
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return ` 
                                <form action="${route('backsite.year.destroy', row.id)}" method="POST" id="form_${row.id}">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete">
                                    <!--<a type="button" rel="tooltip" class="btn btn-sm btn-info btn-round" data-original-title="" title="">
                                        <i class="material-icons">visibility</i>
                                    </a>-->
                                    <a type="button" rel="tooltip" class="btn btn-sm btn-success btn-round" data-original-title="" title="" href="${route('backsite.year.edit', row.id)}">
                                        <i class="material-icons">edit</i>
                                        <div class="ripple-container"></div>
                                    </a>
                                    <button type="submit" rel="tooltip" class="btn btn-sm btn-danger btn-round btn_delete" id="${row.id}" data-original-title="" title="">
                                        <i class="material-icons">close</i>
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
            // if( result )
            if( result.isConfirmed ) {
                let id = $(this).attr('id')
                $("#form_" + id).submit()
            }
        });
    })
</script>
@endsection