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
                            <div height="50px">
                                <canvas id="myChart" width="100px" height="100px"></canvas>
                            </div>
                            <hr>
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
        let questionType = '{{ $question->type }}'
        let labels = []
        let arrLabels = []
        let arrValues = []
        let arrData = []
        let arrBgs = [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(130, 247,59, 0.5)',
            'rgba(30, 185,244, 0.5)',
            'rgba(169,180,47, 0.5)',
            'rgba(102, 0, 8, 0.5)',
        ]
        let stats = []
        if ($.inArray(questionType, ['textarea', 'number', 'text']) == -1) {
            stats = JSON.parse('{!! $stats !!}')
            let n = 0

            $.each(stats, function(i, v) {
                arrLabels.push(i)
                arrValues.push(v)

                /* if (n != 0) {
                    let vv = [v]
                    for (let index = 0; index <= Object.keys(stats).length; index++) {
                        if (index != n) 
                            vv.splice( index, 0, null );
                    }
                    arrData.push({
                        label: arrLabels[n],
                        fill: false,
                        data: vv,
                        backgroundColor: arrBgs[n],
                        borderWidth: 1
                    })
                } else {
                    arrData.push({
                        label: arrLabels[n],
                        fill: false,
                        data: z.concat([v]),
                        backgroundColor: arrBgs[n],
                        borderWidth: 1
                    })
                }
                console.log(z.concat([v])) */
                n++
            })
            labels = arrLabels
        }

        console.log(arrData)

        const ctx = document.getElementById('myChart');
        ctx.height = 20;
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: 
            // {
            //     labels: labels,
            //     datasets: arrData
            // },
            {
                labels: labels,
                datasets: [{
                    label: 'Data Response',
                    data: arrValues,
                    backgroundColor: arrBgs,
                    borderWidth: 1
                }]
            },
            options: {
                spanGaps: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
            },
        });

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
                        name: 'value'
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