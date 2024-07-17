@extends('layouts.backsite-layout')
@section('menu'.str_replace(' ', '', ucfirst($role->role)), 'active')
@section('menuUser', 'active')
@section('collapseUser', 'show')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $role->role }}</h4>
                        <a href="{{ route(getLang() . 'backsite.user.create', ['role=' . $role->ref]) }}" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-account-plus"></i> @trans('backsite.user.addata') </a>
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover dtable" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Telp</th>
                                        @if (request()->query('role') == \App\Models\Role::ROLES['participant'])
                                        <th>NRP</th>
                                        <th>College Origin</th>
                                        @endif
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Telp</th>
                                        @if (request()->query('role') == \App\Models\Role::ROLES['participant'])
                                        <th>NRP</th>
                                        <th>College Origin</th>
                                        @endif
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
    let role = '{{ request()->query("role") }}'
    
    getDatatable()

    function getDatatable() {
        /*Datatable*/
        $('.dtable').DataTable().destroy();
        cols = [
                {
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
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'telephone',
                    name: 'telephone'
                },
            ]

            if (role == 3) {
                cols.push({
                    data: 'nrp',
                    name: 'nrp'
                })
                cols.push({
                    data: 'college_origin',
                    name: 'college_origin'
                })
            }

            cols.push({
                data: 'aksi',
                name: 'aksi',
                className: 'text-right',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return ` 
                            <form action="${route(getLang() + 'backsite.user.destroy', {
                                id: row.id,
                                role: role
                            })}" method="GET" id="form_${row.id}">
                                <!-- <input type="hidden" name="_method" value="delete"> -->
                                <input type="hidden" name="role_ref" value="{{ request()->query('role') }}">
                                <!--<a type="button" rel="tooltip" class="btn btn-sm btn-info btn-round" data-original-title="" title="">
                                    <i class="material-icons">visibility</i>
                                </a>-->
                                <a type="button" rel="tooltip" class="btn btn-sm btn-success btn-round" data-original-title="" title="" href="${route(getLang() + 'backsite.user.edit', {
                                    id: row.id,
                                    _query: {
                                        role: "{{ request()->query('role') }}"
                                    }
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
            })
        $('.dtable').DataTable({
            serverSide: true,
            processing: true,
            lengthChange: false,
            ajax: {
                type: 'GET',
                url: "{{ route(getLang() . 'backsite.user.datatable') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    ref: role
                }
            },
            columns: cols
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