@extends('layouts.app')

@section('title', 'Request Entry')

@section('head')
  <link href="{{ url('css/addons/datatables.min.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
  <div id="content" class="heavy-rain-gradient color-block content" style="padding-top: 20px;">
    <section>
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="iso-tab" data-toggle="tab" href="#iso" role="tab" aria-controls="iso"
            aria-selected="true">ISO</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="legal-tab" data-toggle="tab" href="#legal" role="tab" aria-controls="legal"
            aria-selected="false">Legal</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="iso" role="tabpanel" aria-labelledby="iso-tab">
          @include('includes.requestiso')
        </div>
        <div class="tab-pane fade" id="legal" role="tabpanel" aria-labelledby="legal-tab">
          @include('includes.requestlegal')
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
    var requestISO =  {!! json_encode($request_iso_entries->toArray()) !!};
    var requestLegal =  {!! json_encode($request_legal_entries->toArray()) !!};
    console.log(requestLegal);
    requestUser = {{ Auth::user()->id }};
    $('#requestEntry_Requestor option[value="{{ Auth::user()->id }}"]').attr("selected",true);

    

    $('.btn-requestIsoEntryInsert').on('click', function(e){
      $(".btn-requestISOEntrySummaryInsert").css({display: "block"});
      $(".btn-requestISOEntrySummaryEdit").css({display: "none"});

      $('#requestEntry_Title').val('').trigger("change");
      $('#requestEntry_DateRequest').val('').trigger("change");
      $('#requestEntry_DateEffective').val('').trigger("change");
      $('#requestEntry_RequestType').val('').trigger("change");
      $('#requestEntry_DocumentType').val('').trigger("change");
      $('#requestEntry_DocumentRevised').val('').trigger("change");
      $('#requestEntry_DocumentPurposeRequest').val('').trigger("change");

      $("#requestEntry_RequestType").change(function() {
        if($('#requestEntry_RequestType').val() == 1){
          $('#requestEntry_DocumentRevised').val('');
          $(".requestType_New").hide();
        } else {
          $(".requestType_New").show();
        }
      });
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
        url:  'documentrequest/requesthistory/iso/'+requestEntryHistory_RequestEntryID,
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
        
        //$('#requestEntry_StatusUpdate').val(data[0].request_status.id).trigger("change");
        //$('#requestEntry_RemarksUpdate').val(data[0].remarks).trigger("change");
        console.log(data);

      });
    });
 
    $('.btn-request_isoEdit').on('click', function(e){
      $('#modalRequestIsoEntryInsert').modal('show');
      
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
      $('#requestEntry_DocumentPurposeRequest').val(requestISO[requestISOID].title).trigger("change");
      $('#requestEntry_DocumentRevised').val(requestISO[requestISOID].document_to_revise.id).trigger("change");
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
        requestEntry.RequestEntryUser = requestUser;
        requestEntry.RemarksUpdate = "Created new request entry";
        requestEntry.TagID = 1;
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
            url:  'documentrequest/iso/store',
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
      //console.log(requestISO[requestISO.ID]);

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
            'You have edited the request document entry',
            'success'
          )
          //$("#addRequestEntry").submit();
          $.ajax({
            type: 'PUT',
            url:  'documentrequest/'+requestISOID,
            data: requestEntry,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          }).done(function(data){
            console.log(data);         
          });
          $('#modalRequestIsoEntryInsert').modal('hide');
        }
      })
      
    });

    $('.btn-requestISOEntrySummaryUpdate').on('click', function(e){
      requestEntryUpdate_RequestEntryID = $('#updateISO_ID').val();
      requestEntryUpdate_StatusID = $('#requestEntry_StatusUpdate option:selected').not('option:disabled').val();
      requestEntryUpdate_RemarksUpdate = $('#requestEntry_RemarksUpdate').val();
      requestEntryUpdate = {};
        requestEntryUpdate.RequestEntryID = requestEntryUpdate_RequestEntryID;
        requestEntryUpdate.StatusID = requestEntryUpdate_StatusID;
        requestEntryUpdate.RemarksUpdate = requestEntryUpdate_RemarksUpdate;
        requestEntryUpdate.RequestEntryUser = requestUser;
        requestEntryUpdate.TagID = 1;
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
            'You have updated the status of a request document entry',
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

      var datatable = $('#datatableISO').DataTable({
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
      }).container().appendTo($('#datatableISOButtons'));
    });
  </script>








  <script>
    $('#requestLegalEntry_Requestor option[value="{{ Auth::user()->id }}"]').attr("selected",true);

    $('.btn-request_legalView').on('click', function(e){
      var requestLegalID = $(this).attr('id');
      //console.log(requestISO[requestISOID]);

      $('#updateLegal_ID').val(requestLegal[requestLegalID].id).trigger("change");
      
      $('#modalRequestLegalEntryUpdate').modal('show');

      requestEntryHistory_RequestEntryID = $('#updateLegal_ID').val();
      requestEntryHistory = {};
        requestEntryHistory.RequestEntryID = requestEntryHistory_RequestEntryID;

      $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url:  'documentrequest/requesthistory/legal/'+requestEntryHistory_RequestEntryID,
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

          $('#requestLegalEntryHistory').append(requestEntryHistoryData);
        }
        
        //$('#requestEntry_StatusUpdate').val(data[0].request_status.id).trigger("change");
        //$('#requestEntry_RemarksUpdate').val(data[0].remarks).trigger("change");
        console.log(data);

      });
    });

    $('.btn-requestLegalEntrySummaryUpdate').on('click', function(e){
      requestEntryUpdate_RequestEntryID = $('#updateLegal_ID').val();
      requestEntryUpdate_StatusID = $('#requestLegalEntry_StatusUpdate option:selected').not('option:disabled').val();
      requestEntryUpdate_RemarksUpdate = $('#requestLegalEntry_RemarksUpdate').val();
      requestEntryUpdate = {};
        requestEntryUpdate.RequestEntryID = requestEntryUpdate_RequestEntryID;
        requestEntryUpdate.StatusID = requestEntryUpdate_StatusID;
        requestEntryUpdate.RemarksUpdate = requestEntryUpdate_RemarksUpdate;
        requestEntryUpdate.RequestEntryUser = requestUser;
        requestEntryUpdate.TagID = 2;
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
            'You have updated the status of a request document entry',
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

    $('.btn-requestLegalEntrySummaryInsert').on('click', function(e){
      //$('#modalRequestLegalEntryInsert').modal('show');
      requestLegalEntry_Requestor = $('#requestLegalEntry_Requestor option:selected').not('option:disabled').text();
      requestLegalEntry_RequestorID = $('#requestLegalEntry_Requestor option:selected').not('option:disabled').val();
      requestLegalEntry_DateRequest = $('#requestLegalEntry_DateRequest').val();

      requestLegalEntry_DocumentType = $('#requestLegalEntry_DocumentType option:selected').not('option:disabled').text();
      requestLegalEntry_DocumentTypeID = $('#requestLegalEntry_DocumentType option:selected').not('option:disabled').val();
      requestLegalEntry_Status = $('#requestLegalEntry_Status option:selected').not('option:disabled').text();
      requestLegalEntry_StatusID = $('#requestLegalEntry_Status option:selected').not('option:disabled').val();

      requestLegalEntry_Attachment = $('#requestLegalEntry_Attachment').val();
      requestLegalEntry_Remarks = $('#requestLegalEntry_Remarks').val();
      requestLegalEntry = {};
        requestLegalEntry.Requestor = requestLegalEntry_RequestorID;
        requestLegalEntry.DateRequest = requestLegalEntry_DateRequest;
        requestLegalEntry.DocumentType = requestLegalEntry_DocumentTypeID;
        requestLegalEntry.Status = requestLegalEntry_StatusID;
        requestLegalEntry.Attachment = requestLegalEntry_Attachment;
        requestLegalEntry.Remarks = requestLegalEntry_Remarks;

        console.log(requestLegalEntry);
      Swal.fire({
        title: 'Summary',
        html: `<table class="table table-sm" width="100%">
                <tr>
                  <td width="50%" class="text-right">Requestor:</td>
                  <td width="50%" class="text-left">`+requestLegalEntry_Requestor+`</td>
                </tr>
                <tr>
                  <td class="text-right">Date Request:</td>
                  <td class="text-left">`+requestLegalEntry_DateRequest+`</td>
                </tr>
                <tr>
                  <td class="text-right">Category:</td>
                  <td class="text-left">`+requestLegalEntry_DocumentType+`</td>
                </tr>
                <tr>
                  <td class="text-right">Status:</td>
                  <td class="text-left">`+requestLegalEntry_Status+`</td>
                </tr>
                <tr>
                  <td class="text-right">Attachment:</td>
                  <td class="text-left">`+requestLegalEntry_Attachment+`</td>
                </tr>
                <tr>
                  <td class="text-right">Remarks:</td>
                  <td class="text-left">`+requestLegalEntry_Remarks+`</td>
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
            'You have requested a legal document entry',
            'success'
          )
          //$("#addRequestEntry").submit();
          $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url:  'documentrequest/legal/store',
            data: requestLegalEntry,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          }).done(function(data){
            console.log(data);         
          });
          $('#modalRequestLegalEntryInsert').modal('hide');
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

      var datatable = $('#datatableLegal').DataTable({
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
      }).container().appendTo($('#datatableLegalButtons'));
    });
  </script>
@endsection