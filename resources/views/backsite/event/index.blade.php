@extends('layouts.backsite-layout')
@section('menuEvent', 'active')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <!-- Tabs navs -->
                        <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->query('lang') == 'en' ? "active" : "" }}" id="ex1-tab-1" data-mdb-toggle="tab" href="{{ route('backsite.event.list-event', [
                                    'lang' => 'en',
                                    'semester' => $semester
                                ]) }}" role="tab" aria-controls="ex1-tabs-1" aria-selected="true">EN</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->query('lang') == 'id' ? "active" : "" }}" id="ex1-tab-2" data-mdb-toggle="tab" href="{{ route('backsite.event.list-event', [
                                    'lang' => 'id',
                                    'semester' => $semester
                                ]) }}" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">ID</a>
                            </li>
                        </ul>
                        <!-- Tabs navs -->

                        <a href="{{ route(getLang() . 'backsite.event.create', [
                            'semester' => $semester->id,
                            'lang' => request()->query('lang')
                        ]) }}" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-account-plus"></i> @trans('backsite.event.addata') </a>
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover dtable" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Media</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Media</th>
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

    <!-- Modal -->
    <div id="popup-video" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <center>
                    <div class="modal-body modal-play-video">
                    </div>
                </center>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const lang = "{{ request()->query('lang') }}"
    let btnColor = '{{ setting('style_btn_style_one')->value ?? "#ec167f" }}'

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
                url: "{{ route(getLang() . 'backsite.event.datatable') }}",
                data: function(data) {
                    data._token = "{{ csrf_token() }}"
                    data.semester_id = '{{ $semester->id }}'
                    data.lang = lang
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
                    name: 'title'
                },
                {
                    data: 'photo',
                    name: 'photo',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        let ret = ""
                        if (row.photo != null) {
                            ret = `
                                <a class="fancybox" href="/storage/${row.photo}" data-fancybox-group="gallery" title="">
                                    <img src="/storage/${row.photo}" alt="" style="width:100px !important;height:auto;"/>
                                </a>
                            `
                        } else {
                            ret = `
                                <div class="item-video">
                                    <a href="#" class="box-video popup-play-video" data-toggle="modal" data-target="#popup-video" data-src="${ytParseJs(row.youtube)}">
                                        <div class="overlay-video" style="height: 190px;">
                                            <i class="fa fa-play-circle" style="font-size: 60px; color: ${btnColor}; position: absolute; top: 35%; left: 42%;"></i>
                                        </div>
                                        <iframe width="120" height="90px" src="https://www.youtube.com/embed/${ytParseJs(row.youtube)}" title="Killing Me Inside - Biarlah (Official Music Video)" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </a>
                                </div>
                            `
                        }

                        return ret
                    }
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return ` 
                            <form action="${route(getLang() + 'backsite.event.destroy', {
                                    id: row.id,
                                    semester: '{{ $semester->id }}',
                                    lang: lang
                                })}" method="POST" id="form_${row.id}">
                                @csrf
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="role_ref" value="{{ request()->query('role') }}">
                                <!--<a type="button" rel="tooltip" class="btn btn-sm btn-info btn-round" data-original-title="" title="">
                                    <i class="material-icons">visibility</i>
                                </a>-->
                                <a type="button" rel="tooltip" class="btn btn-sm btn-success btn-round" data-original-title="" title="" href="${route(getLang() + 'backsite.event.edit', {
                                    id: row.id,
                                    semester: '{{ $semester->id }}',
                                    lang: lang
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

    $(document).on('click', '.popup-play-video', function(e) {
        e.preventDefault()

        let src = $(this).data('src')
        let canv = `
        <iframe width="727" 
            height="409" 
            src="https://www.youtube.com/embed/${src}"
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        </iframe>
        `
        $('.modal-play-video').html(canv)
        $('#popup-video').modal('show')
    })

    $('#popup-video').on('hidden.bs.modal', function () {
        $('.modal-play-video').html(``)
    })

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

    function ytParseJs(url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        var match = url.match(regExp);
        return (match&&match[7].length==11)? match[7] : false;
    }
</script>
@endsection