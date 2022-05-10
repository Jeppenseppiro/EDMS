@extends('layouts.app')

@section('title', 'Permitting and Licenses')

@section('head')
  <link href="{{ url('css/addons/datatables.min.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
  <div id="content" class="heavy-rain-gradient color-block content" style="padding-top: 20px;">
    <section>
      @include('includes.errormessage')

      <!-- E-Transmittal (INSERT/EDIT) -->
      <div class="modal fade" id="modalPermitLicenseInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header warning-color">
              <h5 class="modal-title" id="exampleModalLabel">New Permitting and Licenses</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="md-form" action="{{ route('permittingandlicenses.store')}}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="md-form">
                      <i class="fa-solid fa-input-text prefix"></i>
                      <input type="text" id="permitlicense_FileTitle" name="permitlicense_FileTitle" value="{{ old('permitlicense_FileTitle')}}" class="form-control" required>
                      <label for="permitlicense_FileTitle">File Title</label>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-calendar prefix"></i>
                      <input type="text" id="permitlicense_EffectiveDate" name="permitlicense_EffectiveDate" value="{{ old('permitlicense_EffectiveDate')}}" class="form-control datepicker" required>
                      <label for="permitlicense_EffectiveDate">Effective Date</label>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-calendar prefix"></i>
                      <input type="text" id="permitlicense_ExpirationDate" name="permitlicense_ExpirationDate" value="{{ old('permitlicense_ExpirationDate')}}" class="form-control datepicker" required>
                      <label for="permitlicense_ExpirationDate">Expiration Date</label>
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="file-field">
                      <div class="btn btn-primary btn-sm float-left">
                        <span>Choose file</span>
                        <input type="file" name="permitlicense_Attachment" required>
                      </div>
                      <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Attachment">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="" class="btn btn-primary btn-permitlicenseSubmitInsert">Submit</button>
                {{-- <button type="submit" id="" class="btn btn-primary btn-etransmittalSubmitUpdate">Update</button> --}}
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Permitting and Licenses Datatable -->
      <div class="row">
        <div class="col-xl-12 col-lg-7 mr-0 pb-2">
          <div class="card card-cascade narrower">
            <div class="row">
              <div class="col-xl-12 col-lg-12 mr-0 pb-2">
                <div class="view view-cascade gradient-card-header success-color narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">

                  <div>
                    <div id="datatableButtons"></div>
                  </div>

                  <b style="font-size: 24px;" class="float-left">Permitting and Licenses</b>

                  <div>
                  {{-- @if(auth()->user()->role != 2) --}}
                    <button type="button" class="btn btn-outline-white btn-sm px-3 btn-permitlicenseInsert" style="font-weight: bold;" data-toggle="modal" data-target="#modalPermitLicenseInsert"><i class="fa-solid fa-plus"></i></button>
                  {{-- @endif --}}
                  </div>

                </div>

                <div class="px-4">
                  <div class="table-responsive">

                    <table id="datatable" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th class="th-sm" width="">File Title</th>
                          <th class="th-sm" width="">Attachment</th>
                          <th class="th-sm" width="">Effective Date</th>
                          <th class="th-sm" width="">Expiration Date</th>
                          <th class="th-sm" width="">File</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($permitandlicenses as $key => $permitandlicense)
                          <tr>
                            <td>{{$permitandlicense->file_title}}</td>
                            <td>{{$permitandlicense->attachment}}</td>
                            <td>{{$permitandlicense->effective_date}}</td>
                            <td>{{$permitandlicense->expiration_date}}</td>
                            <td>
                              <a target="_blank" href="{{url("/file/permittinglicenses/".$permitandlicense->attachment_mask)}}">
                                <span class="badge badge-success">{{$permitandlicense->attachment}}</span>
                              </a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
                <!-- <canvas id="myChart" style="max-width: 500px;"></canvas> -->
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function () {
      // Setup - add a text input to each footer cell
     /*  $('#datatable thead tr')
          .clone(true)
          .addClass('filters')
          .appendTo('#datatable thead'); */

      var datatable = $('#datatable').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        
        initComplete: function () {
          var api = this.api();

          // For each column
          api
            .columns()
            .eq(0)
            .each(function (colIdx) {
                // Set the header cell to contain the input element
                var cell = $('.filters th').eq(
                    $(api.column(colIdx).header()).index()
                );
                var title = $(cell).text();
                $(cell).html('<input type="text" placeholder="' + title + '" />');

                // On every keypress in this input
                $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                  .off('keyup change')
                  .on('keyup change', function (e) {
                      e.stopPropagation();

                      // Get the search value
                      $(this).attr('title', $(this).val());
                      var regexr = '({search})'; //$(this).parents('th').find('select').val();

                      var cursorPosition = this.selectionStart;
                      // Search the column for that value
                      api
                          .column(colIdx)
                          .search(
                              this.value != ''
                                  ? regexr.replace('{search}', '(((' + this.value + ')))')
                                  : '',
                              this.value != '',
                              this.value == ''
                          )
                          .draw();

                      $(this)
                          .focus()[0]
                          .setSelectionRange(cursorPosition, cursorPosition);
                  });
            });
        },
      });

      var buttons = new $.fn.dataTable.Buttons(datatable, {
        buttons: [
          {
            extend: 'copy',
            text: 'COPY',
            className: 'btn btn-outline-white btn-rounded btn-sm px-2',
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
          },
          {
            extend: 'csv',
            text: 'CSV',
            className: 'btn btn-outline-white btn-rounded btn-sm px-2',
            title: 'CSV_'+today,
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
          },
          {
            extend: 'excel',
            text: 'EXCEL',
            className: 'btn btn-outline-white btn-rounded btn-sm px-2',
            title: 'EXCEL_'+today,
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
          },
          {
            extend: 'pdf',
            text: 'PDF',
            className: 'btn btn-outline-white btn-rounded btn-sm px-2',
            title: 'PDF_'+today,
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
          },
          {
            extend: 'print',
            text: 'PRINT',
            className: 'btn btn-outline-white btn-rounded btn-sm px-2',
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
          },
        ]
        /* buttons: [
          'copyHtml5',
          'excelHtml5',
          'csvHtml5',
          'pdfHtml5'
        ] */
      }).container().appendTo($('#datatableButtons'));
    });
  </script>
@endsection