@extends('layouts.app')

@section('title', 'Request Entry')

@section('head')
  <link href="{{ url('css/addons/datatables.min.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
  <div id="content" class="heavy-rain-gradient color-block content" style="padding-top: 20px;">
    <section>

      <!-- Request Entry Modal ISO (UPDATE) -->
      <div class="modal fade" id="modalDocumentLibraryInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header warning-color">
              <h5 class="modal-title" id="exampleModalLabel">Insert Document Library</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="md-form" id="updateRequestEntry" method="POST">
                
                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-input-text prefix"></i>
                      <input type="text" id="documentLibrary_Description" class="form-control">
                      <label for="documentLibrary_Description">Description</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="documentLibrary_Category" class="mdb-select" searchable="Search category">
                          <option class="mr-1" value="" disabled selected>Category</option>
                            @foreach ($document_categories as $document_category)
                              <option value={{$document_category->id}}>{{$document_category->category_description}}</option>
                            @endforeach
                        </select>
                        <label class="mdb-main-label">Category</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-input-text prefix"></i>
                      <input type="text" id="documentLibrary_DocumentNumberSeries" class="form-control">
                      <label for="documentLibrary_DocumentNumberSeries">Document Number Series</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="documentLibrary_Tag" class="mdb-select" searchable="Search category">
                          <option class="mr-1" value="" disabled selected>Tag</option>
                            @foreach ($tags as $tag)
                              <option value={{$tag->id}}>{{$tag->description}}</option>
                            @endforeach
                        </select>
                        <label class="mdb-main-label">Tag</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-input-text prefix"></i>
                      <input type="text" id="documentLibrary_Revision" class="form-control">
                      <label for="documentLibrary_Revision">Revision</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="documentLibrary_Control" class="mdb-select" searchable="Search category">
                          <option class="mr-1" value="" disabled selected>Control</option>
                            <option value="1">asd</option>
                        </select>
                        <label class="mdb-main-label">Control</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="file-field">
                  <div class="btn btn-primary btn-sm float-left">
                    <span>Attachment</span>
                    <input type="file" multiple>
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Upload one or more files">
                  </div>
                </div>

              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" id="" class="btn btn-info btn-documentLibrarySubmit">Submit</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Request Entry Datatable -->
      <div class="row">
        <div class="col-xl-12 col-lg-7 mr-0 pb-2">
          <div class="card card-cascade narrower">
            <div class="row">
              <div class="col-xl-12 col-lg-12 mr-0 pb-2">
                <div class="view view-cascade gradient-card-header success-color narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">

                  <div>
                    <div id="datatableButtons"></div>
                  </div>

                  <b style="font-size: 24px;" class="float-left">Document Library</b>

                  <div>
                    <button type="button" class="btn btn-outline-white btn-sm px-3 btn-documentLibraryInsert" style="font-weight: bold;" data-toggle="modal" data-target="#modalfileUploadInsert"><i class="fa-solid fa-plus"></i></button>
                  </div>

                </div>

                <div class="px-4">
                  <div class="table-responsive">

                    <table id="datatable" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th class="th-sm" width="1%">ID</th>
                          <th class="th-sm" width="">Description</th>
                          <th class="th-sm" width="">Category</th>
                          <th class="th-sm" width="">Document Number Series</th>
                          <th class="th-sm" width="">Tag</th>
                          <th class="th-sm" width="">Revision</th>
                          <th class="th-sm" width="">Attachment</th>
                          <th class="th-sm" width="">Control</th>
                          <th class="th-sm" width="">Action</th>
                        </tr>
                      </thead>
                      <tbody id="fileUpload">
                        {{-- @foreach ($request_entry_histories as $key => $request_entry_history)
                          <tr>
                            <td>{{$request_entry_history->id}}</td>
                            <td>{{$request_entry_history->date_request}}</td>
                            <td>{{$request_entry_history->user->name}}</td>
                            <td>{{$request_entry_history->title}}</td>
                            <td>{{$request_entry_history->proposed_effective_date}}</td>
                            <td>{{$request_entry_history->requestType->description}}</td>
                            <td>{{$request_entry_history->documentType->category_description}}</td>
                            <td>{{$request_entry_history->document_to_revise}}</td>
                            <td>{{$request_entry_history->document_purpose_request}}</td>
                            <td>{{$request_entry_history->requestStatus->status}}</td>
                            <td >
                              <button id="" data-id="" style="text-align: center" type="button" class="btn btn-sm btn-success px-2 btn-request_isoView"><i class="fa-solid fa-eye"></i></button>
                              <button id="" data-id="" style="color: black; text-align: center" type="button" class="btn btn-sm btn-warning px-2 btn-request_isoEdit"><i class="fa-solid fa-pen-line"></i></button>
                            </td>
                          </tr>
                        @endforeach --}}
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
  {{-- <script src="{{ url('js/addons/datatables.min.js') }}" type="text/javascript"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script> --}}

  <script src="{{ url('js/addons/datatables.min.js') }}" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
  <script>
    $('.btn-documentLibraryInsert').on('click', function(e){
      $('#modalDocumentLibraryInsert').modal('show');
    });

    $('.btn-documentLibrarySubmit').on('click', function(e){
      documentLibrary_Description = $('#documentLibrary_Description').val();
      documentLibrary_Category = $('#documentLibrary_Category option:selected').not('option:disabled').val();
      documentLibrary_DocumentNumberSeries = $('#documentLibrary_DocumentNumberSeries').val();
      documentLibrary_Tag = $('#documentLibrary_Tag option:selected').not('option:disabled').val();
      documentLibrary_Revision = $('#documentLibrary_Revision').val();
      documentLibrary_Control = $('#documentLibrary_Control option:selected').not('option:disabled').val();

      documentLibrary = {};
      documentLibrary.Description = documentLibrary_Description;
      documentLibrary.Category = documentLibrary_Category;
      documentLibrary.DocumentNumberSeries = documentLibrary_DocumentNumberSeries;
      documentLibrary.Tag = documentLibrary_Tag;
      documentLibrary.Revision = documentLibrary_Revision;
      documentLibrary.Control = documentLibrary_Control;

      $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url:  'documentlibrary/store',
        data: documentLibrary,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      }).done(function(data){
        console.log(data);
      });

      $('#modalDocumentLibraryInsert').modal('show');
    });
  </script>
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