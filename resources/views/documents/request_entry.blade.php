@extends('layouts.app')

@section('title', 'Request Entry')

@section('head')
  <link href="{{ url('css/addons/datatables.min.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
  <div id="content" class="heavy-rain-gradient color-block content" style="padding-top: 20px;">
    <section>
      <!-- Request Entry Modal ISO (INSERT/EDIT) -->
      <div class="modal fade" id="modalRequestIsoEntryInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header warning-color">
              <h5 class="modal-title" id="exampleModalLabel">Request Entry</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="addRequestEntry" method="POST">
                <input id="ISO_ID" type="hidden" value=""/>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-address-card prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="requestEntry_Requestor" class="mdb-select disabled" searchable="Search requestor">
                          <option class="mr-1" value="" disabled selected>Requestor</option>
                          @foreach ($users as $user)
                            <option value={{$user->id}}>{{$user->name}}</option>
                          @endforeach
                        </select>
                        <label class="mdb-main-label">Requestor</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-calendar prefix"></i>
                      <input type="text" id="requestEntry_DateRequest" class="form-control datepicker">
                      <label for="requestEntry_DateRequest">Date Request</label>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-input-text prefix"></i>
                      <input type="text" id="requestEntry_Title" class="form-control">
                      <label for="requestEntry_Title">Title</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-calendar prefix"></i>
                      <input type="text" id="requestEntry_DateEffective" class="form-control datepicker">
                      <label for="requestEntry_DateEffective">Proposed Effective Date</label>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="requestEntry_RequestType" class="mdb-select" searchable="Search Request Type">
                          <option class="mr-1" value="" disabled selected>Request Type</option>
                          @foreach ($request_types as $request_type)
                            <option value={{$request_type->id}}>{{$request_type->description}}</option>
                          @endforeach
                        </select>
                        <label class="mdb-main-label">Request Type</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="requestEntry_Status" class="mdb-select" searchable="Search status">
                          <option class="mr-1" value="" disabled selected>Status</option>
                          @foreach ($request_statuses as $request_status)
                            <option value={{$request_status->id}}>{{$request_status->status}}</option>
                          @endforeach
                        </select>
                        <label class="mdb-main-label">Status</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="requestEntry_DocumentType" class="mdb-select" searchable="Search Documented Information Type">
                          <option class="mr-1" value="" disabled selected>Documented Information Type</option>
                          @foreach ($document_categories as $document_category)
                            <option value={{$document_category->id}}>{{$document_category->category_description}}</option>
                          @endforeach
                        </select>
                        <label class="mdb-main-label">Documented Information Type</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="requestEntry_DocumentRevised" class="mdb-select" searchable="Search document to be Revised">
                          <option class="mr-1" value="" disabled selected>Document to be Revised</option>
                          @foreach ($document_libraries as $document_library)
                            <option value={{$document_library->id}}>{{$document_library->document_number_series}}</option>
                          @endforeach
                        </select>
                        <label class="mdb-main-label">Document to be Revised</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="md-form">
                  <i class="fa-solid fa-align-left prefix"></i>
                  <textarea id="requestEntry_DocumentPurposeRequest" class="md-textarea form-control" rows="2"></textarea>
                  <label for="form10">Purpose of Documentation Request</label>
                </div>

              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-info btn-requestISOEntrySummaryInsert">Submit</button>
              <button type="button" class="btn btn-warning btn-requestISOEntrySummaryEdit">Edit</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Request Entry Modal ISO (UPDATE) -->
      <div class="modal fade" id="modalRequestIsoEntryUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header warning-color">
              <h5 class="modal-title" id="exampleModalLabel">Update Request Entry</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="updateRequestEntry" method="POST">
                <input id="updateISO_ID" type="hidden" value=""/><br>
                
                <div class="container">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="md-form">
                        <i class="fa-solid fa-square-caret-down prefix"></i>
                        <div class="md-form py-0 ml-5">
                          <select id="requestEntry_StatusUpdate" class="mdb-select" searchable="Search status">
                            <option class="mr-1" value="" disabled selected>Status</option>
                            @foreach ($request_statuses as $request_status)
                              <option value={{$request_status->id}}>{{$request_status->status}}</option>
                            @endforeach
                          </select>
                          <label class="mdb-main-label">Status</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="md-form">
                        <i class="fa-solid fa-align-left prefix"></i>
                        <textarea id="requestEntry_RemarksUpdate" class="md-textarea form-control" rows="2"></textarea>
                        <label for="form10">Remarks</label>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <ul id="requestIsoEntryHistory" class="stepper stepper-vertical">
                  {{-- <input id="" type="text" value="{{$request_iso_history->id}}"/> --}}
                </ul>


              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" id="" class="btn btn-info btn-requestISOEntrySummaryUpdate">Submit</button>
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

                  <b style="font-size: 24px;" class="float-left">Request Entries</b>

                  <div>
                    <button type="button" class="btn btn-outline-white btn-sm px-3 btn-requestEntryInsert" style="font-weight: bold;" data-toggle="modal" data-target="#modalRequestIsoEntryInsert"><i class="fa-solid fa-plus"></i></button>
                  </div>

                </div>

                <div class="px-4">
                  <div class="table-responsive">

                    <table id="datatable" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th class="th-sm" width="1%">ID</th>
                          <th class="th-sm" width="">Date Request</th>
                          <th class="th-sm" width="">Requestor</th>
                          <th class="th-sm" width="">Description</th>
                          <th class="th-sm" width="">Proposed Effective Date</th>
                          <th class="th-sm" width="">Request Type</th>
                          <th class="th-sm" width="">Document Type</th>
                          <th class="th-sm" width="">Document to Revise</th>
                          <th class="th-sm" width="">Document Purpose Request</th>
                          <th class="th-sm" width="">Status</th>
                          <th class="th-sm" width="">Action</th>
                        </tr>
                      </thead>
                      <tbody id="requestISOEntry">
                        @foreach ($request_entries as $key => $request_entry)
                          <tr>
                            <td>{{$request_entry->id}}</td>
                            <td>{{$request_entry->date_request}}</td>
                            <td>{{$request_entry->user->name}}</td>
                            <td>{{$request_entry->title}}</td>
                            <td>{{$request_entry->proposed_effective_date}}</td>
                            <td>{{$request_entry->requestType->description}}</td>
                            <td>{{$request_entry->documentType->category_description}}</td>
                            <td>{{$request_entry->documentToRevise}}</td>
                            <td>{{$request_entry->document_purpose_request}}</td>
                            <td>{{$request_entry->requestIsoEntryLatestHistory->status}}</td>
                            <td >
                              <button id="{{$key}}" data-id="{{$request_entry->id}}" style="text-align: center" type="button" class="btn btn-sm btn-success px-2 btn-request_isoView"><i class="fa-solid fa-eye"></i></button>
                              <button id="{{$key}}" data-id="{{$request_entry->id}}" style="color: black; text-align: center" type="button" class="btn btn-sm btn-warning px-2 btn-request_isoEdit"><i class="fa-solid fa-pen-line"></i></button>
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
    var requestISO =  {!! json_encode($request_entries->toArray()) !!};
    console.log(requestISO);
    requestISOUser = {{ Auth::user()->id }};
    $('#requestEntry_Requestor option[value="{{ Auth::user()->id }}"]').attr("selected",true);

    

    $('.btn-requestEntryInsert').on('click', function(e){
      $(".btn-requestISOEntrySummaryInsert").css({display: "block"});
      $(".btn-requestISOEntrySummaryEdit").css({display: "none"});

      $('#requestEntry_Title').val('').trigger("change");
      $('#requestEntry_DateRequest').val('').trigger("change");
      $('#requestEntry_DateEffective').val('').trigger("change");
      $('#requestEntry_RequestType').val('').trigger("change");
      $('#requestEntry_DocumentType').val('').trigger("change");
      $('#requestEntry_DocumentRevised').val('').trigger("change");
      $('#requestEntry_DocumentPurposeRequest').val('').trigger("change");
    });

    // -- Datatable Action Buttons --//

    $('.btn-request_isoView').on('click', function(e){
      var requestISOID = $(this).attr('id');
      //console.log(requestISO[requestISOID]);

      $('#updateISO_ID').val(requestISO[requestISOID].id).trigger("change");
      
      $('#modalRequestIsoEntryUpdate').modal('show');

      requestEntryHistory_RequestEntryID = $('#updateISO_ID').val();
      requestEntryHistory = {};
        requestEntryHistory.RequestEntryID = requestEntryHistory_RequestEntryID;

      $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url:  'documentrequest/requesthistory/'+requestEntryHistory_RequestEntryID,
        data: requestEntryHistory,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      }).done(function(data){
        $(".completed").remove();

        for(var i = 0; i < data.length; i++){
          var requestEntryHistoryData = '<li class="completed">';
              requestEntryHistoryData += '<a>';
              requestEntryHistoryData += '<span class="circle">+</span>';
              requestEntryHistoryData += '<span class="label">'+data[i].request_status.status+'</span>';
              requestEntryHistoryData += '</a>';
              requestEntryHistoryData += '<div class="step-content" style="background-color: #e8e8e8; min-width:90%;">';
              requestEntryHistoryData += '<p>'+data[i].remarks+'</p>';
              requestEntryHistoryData += '<hr>';
              requestEntryHistoryData += '<span class="label float-right" style="font-size: 10px;">'+data[i].user.name+'</span><br>';
              requestEntryHistoryData += '<span class="label float-right" style="font-size: 10px;">'+data[i].created_at+'</span>';
              requestEntryHistoryData += '</div>';
              requestEntryHistoryData += '</li>';

          $('#requestIsoEntryHistory').append(requestEntryHistoryData);
        }
        
        $('#requestEntry_StatusUpdate').val(data[0].request_status.id).trigger("change");
        $('#requestEntry_RemarksUpdate').val(data[0].remarks).trigger("change");
        console.log(data);

      });
    });
 
    $('.btn-request_isoEdit').on('click', function(e){
      $(".btn-requestISOEntrySummaryInsert").css({display: "none"});
      $(".btn-requestISOEntrySummaryEdit").css({display: "block"});

      var requestISOID = $(this).attr('id');
      console.log(requestISO[requestISOID]);
      $('#ISO_ID').val(requestISO[requestISOID].id).trigger("change");

      $('#requestEntry_Requestor').val(requestISO[requestISOID].user.id).trigger("change");
      $('#requestEntry_Title').val(requestISO[requestISOID].title).trigger("change");
      $('#requestEntry_DateRequest').val(requestISO[requestISOID].date_request).trigger("change");
      $('#requestEntry_DateEffective').val(requestISO[requestISOID].proposed_effective_date).trigger("change");
      $('#requestEntry_RequestType').val(requestISO[requestISOID].request_type.id).trigger("change");
      $('#requestEntry_Status').val(requestISO[requestISOID].status).trigger("change");
      $('#requestEntry_DocumentType').val(requestISO[requestISOID].document_type.id).trigger("change");
      $('#requestEntry_DocumentRevised').val(requestISO[requestISOID].document_to_revise).trigger("change");
      $('#requestEntry_DocumentPurposeRequest').val(requestISO[requestISOID].document_purpose_request).trigger("change");
      $('#modalRequestIsoEntryInsert').modal('show');
    });

    // -- Datatable Modal Buttons --//

    $('.btn-requestISOEntrySummaryInsert').on('click', function(e){
      requestEntry_Requestor = $('#requestEntry_Requestor option:selected').not('option:disabled').text();
      requestEntry_RequestorID = $('#requestEntry_Requestor option:selected').not('option:disabled').val();
      requestEntry_DateRequest = $('#requestEntry_DateRequest').val();
      requestEntry_Title = $('#requestEntry_Title').val();
      requestEntry_DateEffective = $('#requestEntry_DateEffective').val();
      requestEntry_RequestType = $('#requestEntry_RequestType option:selected').not('option:disabled').text();
      requestEntry_RequestTypeID = $('#requestEntry_RequestType option:selected').not('option:disabled').val();
      requestEntry_Status = $('#requestEntry_Status option:selected').not('option:disabled').text();
      requestEntry_StatusID = $('#requestEntry_Status option:selected').not('option:disabled').val();
      requestEntry_DocumentType = $('#requestEntry_DocumentType option:selected').not('option:disabled').text();
      requestEntry_DocumentTypeID = $('#requestEntry_DocumentType option:selected').not('option:disabled').val();
      requestEntry_DocumentRevised = $('#requestEntry_DocumentRevised option:selected').not('option:disabled').text();
      requestEntry_DocumentRevisedID = $('#requestEntry_DocumentRevised option:selected').not('option:disabled').val();
      requestEntry_DocumentPurposeRequest = $('#requestEntry_DocumentPurposeRequest').val();
      requestEntry = {};
        requestEntry.Requestor = requestEntry_RequestorID;
        requestEntry.DateRequest = requestEntry_DateRequest;
        requestEntry.Title = requestEntry_Title;
        requestEntry.DateEffective = requestEntry_DateEffective;
        requestEntry.RequestType = requestEntry_RequestTypeID;
        requestEntry.Status = requestEntry_StatusID;
        requestEntry.DocumentType = requestEntry_DocumentTypeID;
        requestEntry.DocumentRevised = requestEntry_DocumentRevisedID;
        requestEntry.DocumentPurposeRequest = requestEntry_DocumentPurposeRequest;
      Swal.fire({
        title: 'Summary',
        html: `<table class="table table-sm" width="100%">
                <tr>
                  <td width="50%" class="text-right">Requestor:</td>
                  <td width="50%" class="text-left">`+requestEntry_Requestor+`</td>
                </tr>
                <tr>
                  <td class="text-right">Date Request:</td>
                  <td class="text-left">`+requestEntry_DateRequest+`</td>
                </tr>
                <tr>
                  <td class="text-right">Title:</td>
                  <td class="text-left">`+requestEntry_Title+`</td>
                </tr>
                <tr>
                  <td class="text-right">Proposed Effective Date:</td>
                  <td class="text-left">`+requestEntry_DateEffective+`</td>
                </tr>
                <tr>
                  <td class="text-right">Request Type:</td>
                  <td class="text-left">`+requestEntry_RequestType+`</td>
                </tr>
                <tr>
                  <td class="text-right">Status:</td>
                  <td class="text-left">`+requestEntry_Status+`</td>
                </tr>
                <tr>
                  <td class="text-right">Documented Information Type:</td>
                  <td class="text-left">`+requestEntry_DocumentType+`</td>
                </tr>
                <tr>
                  <td class="text-right">Document to be Revised:</td>
                  <td class="text-left">`+requestEntry_DocumentRevised+`</td>
                </tr>
                <tr>
                  <td class="text-right">Purpose of Documentation Request:</td>
                  <td class="text-left">`+requestEntry_DocumentPurposeRequest+`</td>
                </tr>
              </table>`,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Submit'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire(
            'Success!',
            'You have requested a document entry',
            'success'
          )
          //$("#addRequestEntry").submit();
          $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url:  'documentrequest/store',
            data: requestEntry,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          }).done(function(data){
            console.log(data);         
          });
          $('#modalRequestIsoEntryInsert').modal('hide');
        }
      })
    });

    $('.btn-requestISOEntrySummaryEdit').on('click', function(e){
      var requestISOID = $('#ISO_ID').val();
      requestEntry_Requestor = $('#requestEntry_Requestor option:selected').not('option:disabled').text();
      requestEntry_RequestorID = $('#requestEntry_Requestor option:selected').not('option:disabled').val();
      requestEntry_DateRequest = $('#requestEntry_DateRequest').val();
      requestEntry_Title = $('#requestEntry_Title').val();
      requestEntry_DateEffective = $('#requestEntry_DateEffective').val();
      requestEntry_RequestType = $('#requestEntry_RequestType option:selected').not('option:disabled').text();
      requestEntry_RequestTypeID = $('#requestEntry_RequestType option:selected').not('option:disabled').val();
      requestEntry_Status = $('#requestEntry_Status option:selected').not('option:disabled').text();
      requestEntry_StatusID = $('#requestEntry_Status option:selected').not('option:disabled').val();
      requestEntry_DocumentType = $('#requestEntry_DocumentType option:selected').not('option:disabled').text();
      requestEntry_DocumentTypeID = $('#requestEntry_DocumentType option:selected').not('option:disabled').val();
      requestEntry_DocumentRevised = $('#requestEntry_DocumentRevised option:selected').not('option:disabled').text();
      requestEntry_DocumentPurposeRequest = $('#requestEntry_DocumentPurposeRequest').val();
      requestEntry = {};
        requestEntry.Requestor = requestEntry_RequestorID;
        requestEntry.DateRequest = requestEntry_DateRequest;
        requestEntry.Title = requestEntry_Title;
        requestEntry.DateEffective = requestEntry_DateEffective;
        requestEntry.RequestType = requestEntry_RequestTypeID;
        requestEntry.Status = requestEntry_StatusID;
        requestEntry.DocumentType = requestEntry_DocumentTypeID;
        requestEntry.DocumentRevised = requestEntry_DocumentRevised;
        requestEntry.DocumentPurposeRequest = requestEntry_DocumentPurposeRequest;
      //console.log(requestISO[requestISO.ID]);
      $.ajax({
        type: 'PUT',
        url:  'documentrequest/'+requestISOID,
        data: requestEntry,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      }).done(function(data){
        console.log(data);         
      });
    });

    $('.btn-requestISOEntrySummaryUpdate').on('click', function(e){
      requestEntryUpdate_RequestEntryID = $('#updateISO_ID').val();
      requestEntryUpdate_StatusID = $('#requestEntry_StatusUpdate option:selected').not('option:disabled').val();
      requestEntryUpdate_RemarksUpdate = $('#requestEntry_RemarksUpdate').val();
      requestEntryUpdate = {};
        requestEntryUpdate.RequestEntryID = requestEntryUpdate_RequestEntryID;
        requestEntryUpdate.StatusID = requestEntryUpdate_StatusID;
        requestEntryUpdate.RemarksUpdate = requestEntryUpdate_RemarksUpdate;
        requestEntryUpdate.RequestEntryUser = requestISOUser;
        console.log(requestEntryUpdate);
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Submit'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire(
            'Success!',
            'You have requested a document entry',
            'success'
          )
          //$("#addRequestEntry").submit();
          $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url:  'requestentryhistory/store',
            data: requestEntryUpdate,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          }).done(function(data){
            console.log(data);         
          }); 
          $('#modalRequestIsoEntryUpdate').modal('hide');
        }
      })
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