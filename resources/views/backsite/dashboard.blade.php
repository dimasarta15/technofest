@extends('layouts.backsite-layout')
@section('menuDashboard', 'active')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">
                    <div class="tab-content tab-content-basic">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                            <div class="row">
                                @if (auth()->user()->role_id != \App\Models\Role::ROLES['participant'])
                                <div class="col-sm-12 col-md-3">
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <h4 class="card-title">@trans('backsite.dashboard.active_project')</h4>
                                            <div class="template-demo">
                                                {{ $projectActiveTotal }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <h4 class="card-title">@trans('backsite.dashboard.nonactive_project')</h4>
                                            <div class="template-demo">
                                                {{ $projectNonActiveTotal }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <h4 class="card-title">@trans('backsite.dashboard.total_speaker')</h4>
                                            <div class="template-demo">
                                                {{ $speakerTotal }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <h4 class="card-title">@trans('backsite.dashboard.total_agenda')</h4>
                                            <div class="template-demo">
                                                {{ $agendaActiveTotal }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                    <div class="col-sm-12 col-md-6">
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <h4 class="card-title">@trans('backsite.dashboard.active_project')</h4>
                                                <div class="template-demo d-flex justify-content-between align-items-center">
                                                    {{ $projectActiveTotal }}
                                                    <a href="{{ route('backsite.project.create', 
                                                    [
                                                        'semester' => semesterActive()->id,
                                                        'lang' => !empty(getLang()) ? str_replace('.', '', getLang()) : "en"
                                                    ]
                                                    ) }}" class="btn btn-primary btn-icon-text text-white">
                                                        @trans('backsite.dashboard.add_project')
                                                        <i class="ti-file btn-icon-append"></i>                          
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <h4 class="card-title">@trans('backsite.dashboard.nonactive_project')</h4>
                                                <div class="template-demo" style="height:60px;">
                                                    {{ $projectNonActiveTotal }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if (auth()->user()->role_id != \App\Models\Role::ROLES['participant'])
                            <div class="row">
                                <div class="col-lg-12 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">@trans('backsite.dashboard.statistic_title')</h4>
                                                        <h5 class="card-subtitle card-subtitle-dash">@trans('backsite.dashboard.statistic_desc')</h5>
                                                    </div>
                                                    <div id="performance-line-legend"></div>
                                                    </div>
                                                    <div class="chartjs-wrapper mt-5">
                                                        <canvas id="performaneLine"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
@endsection
@section('script')

@if (auth()->user()->role_id != \App\Models\Role::ROLES['participant'])
<script>
    if ($("#performaneLine").length) {
        var graphGradient = document.getElementById("performaneLine").getContext('2d');
        var graphGradient2 = document.getElementById("performaneLine").getContext('2d');
        var saleGradientBg = graphGradient.createLinearGradient(5, 0, 5, 100);
        saleGradientBg.addColorStop(0, 'rgba(26, 115, 232, 0.18)');
        saleGradientBg.addColorStop(1, 'rgba(26, 115, 232, 0.02)');
        var saleGradientBg2 = graphGradient2.createLinearGradient(100, 0, 50, 150);
        saleGradientBg2.addColorStop(0, 'rgba(0, 208, 255, 0.19)');
        saleGradientBg2.addColorStop(1, 'rgba(0, 208, 255, 0.03)');
        @php
            $semesterLabels = [];
            $semesterTotal = [];

            foreach ($semesters as $s) {
                $semesterLabels[] = $s->semester." ".$s->title;
            }
            $semesterLabels = array_reverse($semesterLabels);

            foreach ($semesters as $s) {
                $semesterTotal[] = $s->total_project;
            }
            $semesterTotal = array_reverse($semesterTotal);

            $semesterLabelArray = json_encode($semesterLabels);
            $semesterTotalArray = json_encode($semesterTotal);
            echo "var semesterLabels = ". $semesterLabelArray . ";\n";
            echo "var semesterTotal = ". $semesterTotalArray . ";\n";

        @endphp

        var salesTopData = {
            labels: semesterLabels,
            datasets: [{
                label: 'Total Karya',
                data: semesterTotal,
                backgroundColor: saleGradientBg,
                borderColor: [
                    '#1F3BB3',
                ],
                borderWidth: 1.5,
                fill: true, // 3: no fill
                pointBorderWidth: 4,
                pointBorderColor: '#1F3BB3',
            }]
        };
  
      var salesTopOptions = {
        responsive: true,
        maintainAspectRatio: false,
          scales: {
              yAxes: [{
                  gridLines: {
                      display: true,
                      drawBorder: false,
                      color:"#F0F0F0",
                      zeroLineColor: '#F0F0F0',
                  },
                  ticks: {
                    beginAtZero: false,
                    autoSkip: true,
                    maxTicksLimit: 4,
                    fontSize: 10,
                    color:"#6B778C"
                  }
              }],
              xAxes: [{
                gridLines: {
                    display: false,
                    drawBorder: false,
                },
                ticks: {
                  beginAtZero: false,
                  autoSkip: true,
                  maxTicksLimit: 7,
                  fontSize: 10,
                  color:"#6B778C"
                }
            }],
          },
          legend:false,
          legendCallback: function (chart) {
            var text = [];
            text.push('<div class="chartjs-legend"><ul>');
            for (var i = 0; i < chart.data.datasets.length; i++) {
              console.log(chart.data.datasets[i]); // see what's inside the obj.
              text.push('<li>');
              text.push('<span style="background-color:' + chart.data.datasets[i].borderColor + '">' + '</span>');
              text.push(chart.data.datasets[i].label);
              text.push('</li>');
            }
            text.push('</ul></div>');
            return text.join("");
          },
          
          elements: {
              line: {
                  tension: 0.4,
              }
          },
          tooltips: {
              backgroundColor: 'rgba(31, 59, 179, 1)',
          }
      }
      var salesTop = new Chart(graphGradient, {
          type: 'line',
          data: salesTopData,
          options: salesTopOptions
      });
      document.getElementById('performance-line-legend').innerHTML = salesTop.generateLegend();
    }
</script>
@endif
@endsection