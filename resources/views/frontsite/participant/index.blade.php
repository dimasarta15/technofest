@extends('layouts.frontsite-layout')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <style>
        #navbarSupportedContent > ul > li > a{
            color: black;
        }
    </style>
@endsection

@section('content')
    <section class="features-section" id="sect-kategori-lomba">
        <div class="auto-container">
            <div class="anim-icons">
                <span class="icon icon-shape-3 wow fadeIn"></span>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <h1 class="text-center"><b>@trans('frontsite.participant')</b></h1>
                </div>
            </div>

            <div class="row my-5">
                <div class="col-md-12">
                    {{-- <center>
                            <h1>- Belum Ada Data -</h1>
                        </center> --}}

                    {{-- <div class="subscribe-section" style="margin: 0 -15px 50px -15px !important; background-color: unset !important;">
                            <div class="auto-container">
                                <div class="content-box" style="background-color: #C6A22F">
                                    <div class="row">
                                        <div class="title-column col-lg-12 col-md-12">
                                            <div class="sec-title text-white">
                                                <span class="icon fa fa-trophy" style="font-size: 3rem; color: #d4af37"></span>
                                                <h2>Juara Umum</h2>
                                                <h1>Universitas Indonesia</h1>
                                                <span>Pemenang Piala Samyakbya Padesa Widya (Informasi yang Benar untuk Pengetahuan)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h3>@trans('frontsite.participanttable')</h3>
                        </div>
                        <div class="card-body p-4">
                            <table class="table table-responsive table-stripped table-hover dtable">
                                <colgroup>
                                    <col span="1" style="width: 2%;">
                                    <col span="1" style="width: 4%;">
                                    <col span="1" style="width: 92%;">
                                </colgroup>
                                <thead class="bg-info text-white text-center">
                                    <tr>
                                        <th>No.</th>
                                        <th>NRP</th>
                                        <th>Nama Peserta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- <div class="card shadow mb-4">
                            <div class="card-header">
                                <h3>Daftar Perolehan Medali</h3>
                            </div>
                            <table class="table table-responsive table-stripped table-hover" id="tableProgramming">
                                <colgroup>
                                    <col span="1" style="width: 2%;">
                                    <col span="1" style="width: 92%;">
                                    <col span="1" style="width: 4%;">
                                    <col span="1" style="width: 4%;">
                                    <col span="1" style="width: 4%;">
                                    <col span="1" style="width: 4%;">
                                </colgroup>
                                <thead class="bg-info text-white text-center">
                                    <tr>
                                        <th>Rank</th>
                                        <th>Perguruan Tinggi</th>
                                        <th class="text-center">
                                            <span class="rank text-gold">G</span>
                                        </th>
                                        <th class="text-center">
                                            <span class="rank text-silver">S</span>
                                        </th>
                                        <th class="text-center">
                                            <span class="rank text-bronze">B</span>
                                        </th>
                                        <th class="text-center">
                                            <span class="rank text-harapan">H</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-left">I</td>
                                        <td class="text-left">Institut Teknologi Bandung</td>
                                        <td class="text-center"><center>3</center></td>
                                        <td class="text-center"><center>2</center></td>
                                        <td class="text-center"><center>1</center></td>
                                        <td class="text-center"><center>1</center></td>
                                    </tr>
                                        <td class="text-left">II</td>
                                        <td class="text-left">Universitas Indonesia</td>
                                        <td class="text-center"><center>3</center></td>
                                        <td class="text-center"><center>2</center></td>
                                        <td class="text-center"><center>1</center></td>
                                        <td class="text-center"><center>1</center></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">III</td>
                                        <td class="text-left">Universitas Bina Nusantara</td>
                                        <td class="text-center"><center>3</center></td>
                                        <td class="text-center"><center>2</center></td>
                                        <td class="text-center"><center>1</center></td>
                                        <td class="text-center"><center>1</center></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> --}}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
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
                    url: route('frontsite.participant.datatable'),
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
                        data: 'nrp',
                        name: 'nrp'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            return `<a href="${ route('frontsite.user.index', row.email) }">${row.name}</a>`
                        }
                    },
                    // {
                    //     data: null,
                    //     name: 'aksi',
                    //     orderable: false,
                    //     searchable: false,
                    //     render: function(data, type, row) {
                    //        return ''
                    //     }
                    // },
                ]
            })
        }
    </script>
@endsection