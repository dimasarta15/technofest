@extends('layouts.backsite-layout')
@section('menuQuizioner', 'active')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="card-content float-sm-right">
                            <h4 class="card-title">Quizioner on {{ $semester->semester }}</h4>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="d-flex text-right" style="padding-bottom:20px;">
                                        <div style="margin-left:auto !important">
                                            <a class="btn btn-sm btn-primary btn_copas">
                                                <i class="mdi mdi-content-copy"></i> Copy-Paste Quizioner
                                            </a>
                                            <a class="btn btn-sm btn-primary " href="{{ route('backsite.quizioner.create', $semester->id) }}">
                                                <i class="mdi mdi-plus-circle-outline "></i> Add Item
                                            </a>
                                            <a class="btn btn-sm btn-warning " href="{{ route('backsite.quizioner.export', $semester->id) }}">
                                                <i class="mdi mdi-file-excel"></i> Export
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover dtable" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Label</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Sequence</th>
                                            <th>Status</th>
                                            <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <!-- <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Label</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Sequence</th>
                                            <th>Status</th>
                                            <th class="disabled-sorting text-right" width="20%">Actions</th>
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

@include('backsite.quizioner.modal', ['semesters' => $semesters])
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
                url: "{{ route('backsite.quizioner.datatable') }}",
                data: {
                    semester_id: '{{ $semester->id }}',
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
                    data: 'label',
                    name: 'label',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'seq',
                    name: 'seq',
                    orderable: false
                },
                {
                    data: 'status_text',
                    name: 'status_text'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    className: 'text-right',
                    render: function(data, type, row) {
                        return `
                        <form action="${route('backsite.quizioner.destroy', {id: row.id, semester: row.semester_id})}" method="POST" id="form_${row.id}">
                            @csrf
                            <input type="hidden" name="_method" value="delete">
                            <a type="button" rel="tooltip" class="btn btn-sm btn-success btn-round" data-original-title="" title="" href="${route('backsite.quizioner.edit', {id: row.id, semester: row.semester_id})}">
                                <i class="mdi mdi-pencil"></i>
                                <div class="ripple-container"></div>
                            </a>
                            <button type="submit" rel="tooltip" class="btn btn-sm btn-danger btn-round btn_delete" id="${row.id}" data-original-title="" title="">
                                <i class="mdi mdi-delete"></i>
                            </button>
                            <a type="button" rel="tooltip" class="btn btn-sm btn-success btn-round" data-original-title="" title="" href="${route('backsite.quizioner.response', {id: row.id, semester: row.semester_id})}">
                                <i class="mdi mdi-clipboard-outline"></i>
                                <div class="ripple-container"></div>
                            </a>
                        </form>
                        `
                    }
                },
            ]
        })
    }

    $('.btn_copas').click((e) => {
        $('#popup-copas').modal('show')
    })

    $('#btn_paste').click((e) => {
        e.preventDefault()
        
        $.ajax({
            type: "POST",
            url: route(getLang() + 'backsite.quizioner.copas'),
            data: { source_semester_id: $('#sel_source').val(), semester_id: '{{ $semester->id }}' },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    $('#popup-copas').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Success !',
                        text: data.data,
                        type: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            getDatatable()
                        }
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    })

    $(document).on('click', '.btn_delete', function(e) {
        e.preventDefault()
        let id = $(this).attr('id')

        $.ajax({
            type: "POST",
            url: route('backsite.quizioner.check-has-response-quizioner'),
            data: { check_type: 'form', id: id },
            dataType: "json",
            success: function (data) {
                let msg = "Your action would be delete this item in the database"
                if (data.data) { //jika responden memilih option ini
                    msg = "Your action would be delete this item in the database and ALL RESPONSES of respondent !"
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure ?',
                    text: msg,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it !'
                }).then((result) => {
                    // if( result )
                    if (result.isConfirmed) {
                        $("#form_" + id).submit()
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
        
    })
</script>
@endsection