@extends('layouts.backsite-layout')
@section('menuQuizioner', 'active')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Data Response</h4>
                            <h5>Quizioner : {{ $question->label }}</h5>

                            <div class="table-responsive">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover dtable" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="10%">No</th>
                                            <th>Answer</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <!-- <tfoot>
                                        <tr>
                                            <th width="10%">No</th>
                                            <th>Answer</th>
                                            <th>Created At</th>
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
</div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.esm.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/helpers.esm.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
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
                    url: "{{ route('backsite.quizioner.datatable-quizioner-response') }}",
                    data: {
                        quizioner_id: '{{ $question->id }}',
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
                        data: 'value',
                        name: 'value',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                ]
            })
        }
    </script>
@endsection