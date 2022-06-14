@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <div id="content" class="heavy-rain-gradient color-block content" style="padding-top: 20px;">
    <section>
      <div class="card-deck">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="fa-solid fa-file-pen"></i> Request Entry</h5>
            <hr>
            <h1>{{ $requestEntries_Total->count() }}</h1>
            {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="fa-solid fa-copy"></i> Request Copy</h5>
            <hr>
            <h1>{{ $requestCopies_Total->count() }}</h1>
            {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="fa-solid fa-database"></i> Document Library</h5>
            <hr>
            <h1>{{ $documentLibraries_Total->count() }}</h1>
            {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="fa-solid fa-file-export"></i> E-Transmittal</h5>
            <hr>
            <h1>{{ $eTransmittals_Total->count() }}</h1>
            {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xl-12 col-lg-5 mr-0 pb-2">
          <div class="card card-cascade narrower">
            {{-- <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
            <!-- <div class="view view-cascade gradient-card-header blue narrower py-2 mx-12 mb-12"> -->
              <div>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-th-large mt-0"></i></button>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-columns mt-0"></i></button>
              </div>

              <a href="" class="white-text mx-3">Line Chart</a>

              <div>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-pencil-alt mt-0"></i></button>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-eraser mt-0"></i></button>
                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><i
                    class="fas fa-info-circle mt-0"></i></button>
              </div>
            </div> --}}

            <div class="card-body card-body-cascade text-center">

              <canvas id="dashboardChart" height="100px"></canvas>

            </div>
          </div>
        </div>
      </div>


    </section>

  </div>
@endsection

@section('script')

  <script>
    var months = JSON.parse('{!! json_encode($months) !!}');
    var finalData = JSON.parse('{!! json_encode($finalData) !!}');

    var requestEntryCount = [];
    var requestCopyCount = [];
    var documentLibraryCount = [];
    var eTransmittalCount = [];

    // console.log(finalData);
    for (var i = 0; i < finalData.length; i++) {
      requestEntryCount[i] = finalData[i].countEntries;
      requestCopyCount[i] = finalData[i].countCopies;
      documentLibraryCount[i] = finalData[i].countDocumentLibraries;
      eTransmittalCount[i] = finalData[i].countEtransmittals;
    }
    var ctxB = document.getElementById("dashboardChart").getContext('2d');
    var myChart = new Chart(ctxB, {
      plugins: [ChartDataLabels],
      type: 'bar',
      data: {
        labels: months,
        datasets: [{
            label: 'Request Entry',
            data: requestEntryCount,
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
              'rgba(255,99,132,1)'
            ],
            borderWidth: 2
          },
          {
            label: 'Request Entry',
            data: requestCopyCount,
            backgroundColor: [
              'rgba(255, 157, 0, 0.2)'
            ],
            borderColor: [
              'rgba(255, 157, 0, 1)'
            ],
            borderWidth: 2
          },
          {
            label: 'Document Library',
            data: documentLibraryCount,
            backgroundColor: [
              'rgba(7, 129, 230, 0.2)'
            ],
            borderColor: [
              'rgba(7, 129, 230, 1)'
            ],
            borderWidth: 2
          },
          {
            label: 'E-Transmittal',
            data: eTransmittalCount,
            backgroundColor: [
              'rgba(69, 158, 41, 0.2)'
            ],
            borderColor: [
              'rgba(69, 158, 41, 1)'
            ],
            borderWidth: 2
          }
        ],
      }
    });
    /*
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(255, 159, 64, 0.2)'
    */
  </script>
@endsection
