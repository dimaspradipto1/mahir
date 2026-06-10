@extends('layouts.dashboard.template')

@section('content')

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Total Hibah Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card border border-light">
            <div class="card-body pt-3 pb-2">
              <h5 class="card-title text-secondary pb-0 mt-0 pt-0 mb-2" style="font-size: 14px; font-weight: 500;">Total Hibah</h5>
              <div class="d-flex align-items-center mt-2">
                <div class="ps-1">
                  <h4 class="fw-bold mb-1" style="font-size: 26px;">{{ $totalHibahStr }}</h4>
                  <span class="text-muted small pt-1 d-block mt-2" style="font-size: 13px;">3 tahun kumulatif</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Highest Year Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card border border-light">
            <div class="card-body pt-3 pb-2">
              <h5 class="card-title text-secondary pb-0 mt-0 pt-0 mb-2" style="font-size: 14px; font-weight: 500;">{{ $highestYear }}</h5>
              <div class="d-flex align-items-center mt-2">
                <div class="ps-1">
                  <h4 class="fw-bold mb-1" style="font-size: 26px;">{{ $highestYearStr }}</h4>
                  <span class="badge bg-warning bg-opacity-10 text-warning px-3 rounded-pill mt-2 d-inline-block" style="font-weight: 500;">Tertinggi</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Year 2 Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card border border-light">
            <div class="card-body pt-3 pb-2">
              <h5 class="card-title text-secondary pb-0 mt-0 pt-0 mb-2" style="font-size: 14px; font-weight: 500;">{{ $year2 }}</h5>
              <div class="d-flex align-items-center mt-2">
                <div class="ps-1">
                  <h4 class="fw-bold mb-1" style="font-size: 26px;">{{ $year2Str }}</h4>
                  <span class="badge bg-primary bg-opacity-10 text-primary px-3 rounded-pill mt-2 d-inline-block" style="font-weight: 500;">Tahun ke-2</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Year 3 Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card border border-light">
            <div class="card-body pt-3 pb-2">
              <h5 class="card-title text-secondary pb-0 mt-0 pt-0 mb-2" style="font-size: 14px; font-weight: 500;">{{ $year3 }}</h5>
              <div class="d-flex align-items-center mt-2">
                <div class="ps-1">
                  <h4 class="fw-bold mb-1" style="font-size: 26px;">{{ $year3Str }}</h4>
                  <span class="badge {{ $percentChangeStr[0] == '+' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $percentChangeStr[0] == '+' ? 'text-success' : 'text-danger' }} px-3 rounded-pill mt-2 d-inline-block" style="font-weight: 500;">{{ $percentChangeStr }} vs {{ $year2 }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="row">
        <!-- Bar Chart -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body pt-3">
              <h5 class="card-title text-secondary text-uppercase pb-0 mt-0 mb-3" style="font-size: 14px; font-weight: 500;">HIBAH PER TAHUN</h5>
              <div id="barChart" style="min-height: 380px;"></div>
            </div>
          </div>
        </div>

        <!-- Donut Chart -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body pt-3">
              <h5 class="card-title text-secondary text-uppercase pb-0 mt-0 mb-3" style="font-size: 14px; font-weight: 500;">KOMPOSISI SUMBER PENDANAAN</h5>
              <div class="row align-items-center h-100">
                <div class="col-md-7">
                   <div id="donutChart" style="min-height: 350px;"></div>
                </div>
                <div class="col-md-5 pe-4">
                   <div class="d-flex flex-column gap-4 justify-content-center h-100 mt-2">
                      @foreach($sumberList as $index => $sumber)
                        @php 
                          $colors = ['#3b7444', '#4154f1', '#858ce6'];
                          $color = $colors[$index] ?? '#3b7444';
                        @endphp
                        <div>
                            <div class="d-flex justify-content-between text-dark mb-2" style="font-size: 14px;">
                                <span>{{ $sumber }}</span>
                                <span class="fw-bold">{{ $donutTotal[$sumber] }}</span>
                            </div>
                            <div class="progress" style="height: 6px; background-color: #f6f6f6; border-radius: 10px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $donutPercent[$sumber] }}%; background-color: {{ $color }}; border-radius: 10px;" aria-valuenow="{{ $donutPercent[$sumber] }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                      @endforeach
                   </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

@endsection

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Bar Chart
    new ApexCharts(document.querySelector("#barChart"), {
      series: {!! json_encode($barSeries) !!},
      chart: {
        type: 'bar',
        height: 380,
        stacked: true,
        toolbar: { show: false },
        fontFamily: 'Inter, sans-serif'
      },
      colors: ['#3b7444', '#858ce6', '#4154f1'], // Updated colors based on screenshot: Perguruan tinggi (Dark Green), DIKTI (Purple), Eksternal (Blue)
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          borderRadius: 2
        },
      },
      xaxis: {
        categories: {!! json_encode($years) !!},
        axisBorder: { show: false },
        axisTicks: { show: false }
      },
      yaxis: {
        labels: {
          formatter: function(val) {
            return "Rp " + val + "jt";
          }
        }
      },
      grid: {
        borderColor: '#f1f1f1',
      },
      fill: { opacity: 1 },
      legend: { show: false }, 
      dataLabels: { enabled: false }
    }).render();

    // Donut Chart
    new ApexCharts(document.querySelector("#donutChart"), {
      series: {!! json_encode($donutData) !!},
      chart: {
        type: 'donut',
        height: 350,
        fontFamily: 'Inter, sans-serif'
      },
      labels: {!! json_encode($sumberList) !!},
      colors: ['#3b7444', '#4154f1', '#858ce6'],
      plotOptions: {
        pie: {
          donut: {
            size: '65%',
            labels: {
              show: false
            }
          }
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 4,
        colors: ['#fff']
      },
      legend: {
        show: false
      },
      tooltip: {
        y: {
          formatter: function(val) {
            // Very simple formatter for tooltip
            if (val >= 1000000000) {
              return "Rp " + (val / 1000000000).toFixed(2).replace('.', ',') + " M";
            } else if (val >= 1000000) {
              return "Rp " + (val / 1000000).toFixed(2).replace('.', ',') + " jt";
            }
            return "Rp " + val;
          }
        }
      }
    }).render();
  });
</script>
@endpush