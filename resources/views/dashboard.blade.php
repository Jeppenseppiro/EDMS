@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <div id="content" class="heavy-rain-gradient color-block content" style="padding-top: 20px;">
    <section>
      <section class="">
        <div class="row">

          <div class="col-lg-3">
            <div class="card mt-3">
              <div class="">
                <i class="fas fa-chart-line fa-lg teal z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
                <div class="float-right text-right p-3">
                  <p class="text-uppercase text-muted mb-1"><small>subscriptions</small></p>
                  <h4 class="font-weight-bold mb-0">3534</h4>
                </div>
              </div>

              <div class="card-body pt-0">
                <div class="progress md-progress">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 16%" aria-valuenow="46" aria-valuemin="0"
                    aria-valuemax="100"></div>
                </div>
                <p class="card-text">Worse than last week (46%)</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="card mt-3">
              <div class="">
                <i class="fas fa-chart-line fa-lg teal z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
                <div class="float-right text-right p-3">
                  <p class="text-uppercase text-muted mb-1"><small>subscriptions</small></p>
                  <h4 class="font-weight-bold mb-0">3534</h4>
                </div>
              </div>

              <div class="card-body pt-0">
                <div class="progress md-progress">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 46%" aria-valuenow="46" aria-valuemin="0"
                    aria-valuemax="100"></div>
                </div>
                <p class="card-text">Worse than last week (46%)</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="card mt-3">
              <div class="">
                <i class="fas fa-chart-pie fa-lg purple z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
                <div class="float-right text-right p-3">
                  <p class="text-uppercase text-muted mb-1"><small>traffic</small></p>
                  <h4 class="font-weight-bold mb-0">656 234</h4>
                </div>
              </div>

              <div class="card-body pt-0">
                <div class="progress md-progress">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0"
                    aria-valuemax="100"></div>
                </div>
                <p class="card-text">Better than last week (31%)</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="card mt-3">
              <div class="">
                <i class="fas fa-chart-pie fa-lg purple z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
                <div class="float-right text-right p-3">
                  <p class="text-uppercase text-muted mb-1"><small>traffic</small></p>
                  <h4 class="font-weight-bold mb-0">656 234</h4>
                </div>
              </div>

              <div class="card-body pt-0">
                <div class="progress md-progress">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0"
                    aria-valuemax="100"></div>
                </div>
                <p class="card-text">Better than last week (31%)</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="row">
        <div class="col-xl-6 col-lg-5 mr-0 pb-2">
          <div class="card card-cascade narrower">
            <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
            <!-- <div class="view view-cascade gradient-card-header blue narrower py-2 mx-12 mb-12"> -->
              <div>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-th-large mt-0"></i></button>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-columns mt-0"></i></button>
              </div>

              <a href="" class="white-text mx-3">Bar Chart</a>

              <div>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-pencil-alt mt-0"></i></button>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-eraser mt-0"></i></button>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-info-circle mt-0"></i></button>
              </div>
            </div>

            <div class="card-body card-body-cascade text-center">

              {{-- <canvas id="myChart" height="200px"></canvas> --}}

            </div>
          </div>
        </div>

        <div class="col-xl-6 col-lg-5 mr-0 pb-2">
          <div class="card card-cascade narrower">
            <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
            <!-- <div class="view view-cascade gradient-card-header blue narrower py-2 mx-12 mb-12"> -->
              <div>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-th-large mt-0"></i></button>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-columns mt-0"></i></button>
              </div>

              <a href="" class="white-text mx-3">Bar Chart</a>

              <div>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-pencil-alt mt-0"></i></button>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-eraser mt-0"></i></button>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-info-circle mt-0"></i></button>
              </div>
            </div>

            <div class="card-body card-body-cascade text-center">

              <canvas id="barChart" height="200px"></canvas>

            </div>
          </div>
        </div>
      </div>

      
    </section>

  </div>
@endsection

@section('script')
  
  <script>
      
    var ctxB = document.getElementById("barChart").getContext('2d');
    var myBarChart = new Chart(ctxB, {
      plugins: [ChartDataLabels],
      type: 'bar',
      data: {
        labels: ,
        datasets: [{
          label: 'Entry Documents',
          data : [300,700,2000,5000,6000,4000,2000,1000,200,100],
          borderWidth: 2
        }],
      }
    });
  </script>
@endsection