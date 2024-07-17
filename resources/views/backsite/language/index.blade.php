@extends('layouts.backsite-layout')
@section('menuLang', 'active')
@section('menuSetting', 'active')
@section('collapseSetting', 'show')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <!-- <form>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Language</label>
                                    <select class="form-control select2" name="sel_status" id="sel_status">
                                        <option value="">All</option>
                                        <option value="en">EN</option>
                                        <option value="id">ID</option>
                                    </select>
                                </div>
                            </div>
                        </form> -->

                        <!-- Tabs navs -->
                        <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->query('lang') == 'en' ? "active" : "" }}" id="ex1-tab-1" data-mdb-toggle="tab" href="{{ route('backsite.language.index', ['lang' => 'en']) }}" role="tab" aria-controls="ex1-tabs-1" aria-selected="true">EN</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->query('lang') == 'id' ? "active" : "" }}" id="ex1-tab-2" data-mdb-toggle="tab" href="{{ route('backsite.language.index', ['lang' => 'id']) }}" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">ID</a>
                            </li>
                        </ul>
                        <!-- Tabs navs -->
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover dtable" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Key</th>
                                        <th>Value</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Key</th>
                                        <th>Value</th>
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

@include('backsite.language.modal')

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
                url: "{{ route(getLang() . 'backsite.language.datatable') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    lang: "{{ request()->query('lang') }}"
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'key',
                    key: 'key',
                },
                {
                    data: 'raw_text',
                    name: 'text'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return ` 
                                <a type="button" rel="tooltip" id="${row.id}" class="btn btn-sm btn-success btn-round btn-edit" data-original-title="" title="">
                                    <i class="mdi mdi-grease-pencil menu-icon"></i>
                                    <div class="ripple-container"></div>
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
            if (result.isConfirmed) {
                let id = $(this).attr('id')
                $("#form_" + id).submit()
            }
        });
    })

    let globId = null
    $(document).on('click', '.btn-edit', function(e) {
        let id = $(this).attr('id')
        globId = id

        $.ajax({
            type: "GET",
            url: route('backsite.language.show', id),
            dataType: "json",
            statusCode: {
                500: function() {
                    alert('Something went wrong!');
                }
            },
            success: function(data) {
                let res = data.data
                $('.modal-lang').modal('show')

                $('.txt-frag').val(res.key)
                $('.txt-lang').val(res.raw_text)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    })

    $(document).on('click', '.btn-modal-close', () => $('.modal-lang').modal('hide'))

    $(document).on('click', '.btn-modal-submit', (e) => {

        $.ajax({
            type: "PUT",
            url: route('backsite.language.update', globId),
            data: {
                value: $('.txt-lang').val(),
                lang: "{{ request()->query('lang') }}"
            },
            dataType: "json",
            statusCode: {
                500: function() {
                    alert('Something went wrong!');
                }
            },
            success: function(data) {
                let res = data.data

                if (data.success) {
                    $('.modal-lang').modal('hide')
                    
                    Swal.fire(
                        'Good job!',
                        'Updated Successfully !',
                        'success'
                    )

                    $('.dtable').DataTable().ajax.reload(null, false)
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    })
</script>
@endsection