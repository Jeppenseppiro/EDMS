@extends('layouts.app')

@section('title', 'Request Copy')

@section('head')
  <link href="{{ url('css/addons/datatables.min.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
 
  <div id="content" class="heavy-rain-gradient color-block content" style="padding-top: 20px;">
    <section>
      @include('includes.errormessage')
      
      <!-- Document Copy (INSERT) -->
      <div class="modal fade" id="modalDocumentCopyInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header warning-color">
              <h5 class="modal-title" id="exampleModalLabel">Request Document Copy</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="md-form" action="{{ route('documentcopy_iso') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input id="updateDocumentLibrary_UserID" name="updateDocumentLibrary_UserID" type="hidden" value="{{ Auth::user()->id }}"/>
              <div class="modal-body">
                <input type="text" id="requestISOCopy_TagID" name="requestISOCopy_TagID" value="{{$tagID}}" hidden>
                <div class="row">
                  <div class="col-sm-12 requestCopy_Requestor" hidden>
                    <div class="md-form">
                      <i class="fa-solid fa-address-card prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="requestCopy_Requestor" name="requestCopy_Requestor" class="mdb-select" searchable="Search requestor" required>
                          <option class="mr-1" value="" disabled selected>Requestor</option>
                          @foreach ($users as $user)
                            <option value={{$user->id}}>{{$user->name}}</option>
                          @endforeach
                        </select>
                        <label class="mdb-main-label">Requestor</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6" hidden>
                    <div class="md-form">
                      <i class="fa-solid fa-calendar prefix"></i>
                      <input type="text" id="requestISOCopy_DateRequest" name="requestISOCopy_DateRequest" class="form-control datepicker" value="{{$dateToday}}" required>
                      <label for="requestCopy_DateRequest">Date Request</label>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="requestCopy_FileRequest" name="requestCopy_FileRequest" class="mdb-select" searchable="Search document to request copy" required>
                          <option class="mr-1" value="" disabled selected>File Request</option>
                          {{-- @foreach ($document_libraries as $document_library)
                            
                            <option value={{$document_library->id}}>{{$document_library->document_number_series}} | {{$document_library->description}} | {{$document_library->documentMultipleRevision->first()->revision}}</option>
                          @endforeach --}}
                        </select>
                        <label class="mdb-main-label">File Request</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="requestCopy_FileRequestType" name="requestCopy_FileRequestType" class="mdb-select" searchable="Select file document type" required>
                          <option class="mr-1" value="" disabled selected>File Copy Type</option>
                          @foreach ($request_iso_copy_types as $request_iso_copy_type)
                            <option value={{$request_iso_copy_type->id}}>{{$request_iso_copy_type->type}}</option>
                          @endforeach
                        </select>
                        <label class="mdb-main-label">File Copy Type</label>
                      </div>
                    </div>
                  </div>
                </div>

                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="" class="btn btn-primary btn-documentLibrarySubmit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Document Copy (UPDATE) -->
      <div class="modal fade" id="modalRequestIsoCopyUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header warning-color">
              <h5 class="modal-title" id="exampleModalLabel">Update Request Copy</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="md-form" id="updateRequestEntry" action="{{ route('requestcopyhistory_iso') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <input id="updateRequestCopy_ID" name="updateRequestCopy_ID" type="hidden" value=""/>
                <input id="updateRequestCopy_UserID" name="updateRequestCopy_UserID" type="hidden" value="{{ Auth::user()->id }}"/>
                <div class="container">
                  {{-- @if(in_array(1, $role) || in_array(3, $role)) --}}
                    <div class="row statusRemark">
                      <div class="col-sm-4">
                        <div class="md-form">
                          <i class="fa-solid fa-square-caret-down prefix"></i>
                          <div class="md-form py-0 ml-5">
                            <select id="requestCopy_StatusUpdate" name="requestCopy_StatusUpdate" class="mdb-select" searchable="Search status" required>
                              <option class="mr-1" value="" disabled selected>Status</option>
                              @foreach ($request_iso_copy_statuses as $request_iso_copy_status)
                                @if(auth()->user()->role == 3 && ($request_iso_copy_status->id == 3 || $request_iso_copy_status->id == 4))
                                  <option value={{$request_iso_copy_status->id}}>{{$request_iso_copy_status->status}}</option>
                                @elseif(auth()->user()->role == 5 && ($request_iso_copy_status->id == 6 || $request_iso_copy_status->id == 7))
                                  <option value={{$request_iso_copy_status->id}}>{{$request_iso_copy_status->status}}</option>
                                @elseif(auth()->user()->role == 1)
                                  <option value={{$request_iso_copy_status->id}}>{{$request_iso_copy_status->status}}</option>
                                @endif
                              @endforeach
                            </select>
                            <label class="mdb-main-label">Status</label>
                            <input id="requestCopy_FileTypeID" type="hidden" value=""/>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-8">
                        <div class="md-form">
                          <i class="fa-solid fa-align-left prefix"></i>
                          <input type="text" id="requestCopy_RemarksUpdate" name="requestCopy_RemarksUpdate" class="form-control" required>
                        <label for="requestEntry_RemarksUpdate">Remarks</label>
                        </div>
                      </div>
                    </div>

                    <div class="row dateExpirationGenerateLink">
                      <div class="col-sm-4">
                        <div class="md-form">
                          <i class="fa-solid fa-calendar prefix"></i>
                          <input type="text" id="requestCopy_DateExpiration" name="requestCopy_DateExpiration" class="form-control datepicker" required>
                          <label for="requestCopy_DateExpiration">Date Expiration</label>
                        </div>
                      </div>
                      <div class="col-sm-8">
                        <div class="md-form input-group mb-3">
                          <div class="input-group-prepend">
                            <button class="btn btn-md btn-primary m-0 px-2" type="button" id="requestCopy_GenerateLinkButton">Generate</button>
                          </div>
                          <input type="text" class="form-control disabled" id="requestCopy_GenerateLink" name="requestCopy_GenerateLink" placeholder="Generate Link" required>
                        </div>
                      </div>
                    </div>
                  {{-- @endif --}}
                </div>
                <ul id="requestIsoCopyHistory" class="stepper stepper-vertical">
                  {{-- <input id="" type="text" value="{{$request_iso_history->id}}"/> --}}
                </ul>

              </div>
              <div class="modal-footer requestCopyFooterButton">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="" class="btn btn-primary btn-requestISOCopySummaryUpdate">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Document Copy (CONFIGURATION) -->
      <div class="modal fade" id="modalRequestIsoCopyConfigure" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header warning-color">
              <h5 class="modal-title" id="exampleModalLabel">Configure Request Copy</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="md-form" id="updateRequestEntry" action="#" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <input id="updateRequestCopy_ID" name="updateRequestCopy_ID" type="hidden" value=""/>
                <input id="updateRequestCopy_UserID" name="updateRequestCopy_UserID" type="hidden" value="{{ Auth::user()->id }}"/>
                <ul id="requestIsoCopyConfiguration">
                  
                </ul>
              </div>
            </form>
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

                  <b style="font-size: 24px;" class="float-left">Request Copies</b>

                  <div>
                    {{-- @if(auth()->user()->role == 8) --}}

                    @if ($tagID == 1)
                      @if(in_array(1, $role) || in_array(8, $role))
                        <button type="button" class="btn btn-outline-white btn-sm px-3 btn-documentLibraryInsert" style="font-weight: bold;" data-toggle="modal" data-target="#modalDocumentCopyInsert"><i class="fa-solid fa-plus"></i></button>
                      @endif
                    @elseif ($tagID == 2)
                      <button type="button" class="btn btn-outline-white btn-sm px-3 btn-documentLibraryInsert" style="font-weight: bold;" data-toggle="modal" data-target="#modalDocumentCopyInsert"><i class="fa-solid fa-plus"></i></button>
                    @endif
                    {{-- @endif --}}
                  </div>

                </div>

                <div class="px-4">
                  <div class="table-responsive">

                    <table id="datatable" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          {{-- <th class="th-sm" width="">ID</th> --}}
                          <th class="th-sm" width="">Code</th>
                          <th class="th-sm" width="">Requestor</th>
                          <th class="th-sm" width="">Date Request</th>
                          <th class="th-sm" width="">Date Expiration</th>
                          <th class="th-sm" width="">File Request</th>
                          <th class="th-sm" width="">File Copy Type</th>
                          <th class="th-sm" width="">Link</th>
                          <th class="th-sm" width="">Status</th>
                          <th class="th-sm" width="">Action</th>
                        </tr>
                      </thead>
                      <tbody id="fileUpload">
                        @foreach ($request_iso_copies as $key => $request_iso_copy)
                          <tr>
                            {{-- <td>{{$request_iso_copy->id}}</td> --}}
                            <td>{{$request_iso_copy->code}}</td>
                            <td>{{$request_iso_copy->userRequestor->name}}</td>
                            <td>{{$request_iso_copy->date_request}}</td>
                            <td>{{$request_iso_copy->requestIsoCopyLatestHistory->date_expiration}}</td>
                            <td>{{$request_iso_copy->documentRequested->document_number_series}} | {{$request_iso_copy->documentRequested->description}} | {{$request_iso_copy->documentRevision->revision}}</td>
                            <td>{{$request_iso_copy->requestCopyType->type}}</td>
                            <td>
                              {{-- {{$request_iso_copy->documentRevision->documentFileRevision}} --}}
                              @foreach ($request_iso_copy->documentRevision->documentFileRevision as $key => $link)
                                @if($request_iso_copy->requestIsoCopyLatestHistory->status == "Emailed")
                                  <a target="_blank" href="{{url("/file/".$link->attachment_mask."/".$request_iso_copy->requestIsoCopyLatestHistory->request_copy_uniquelink)}}">
                                    @if($link->type == 1 && $request_iso_copy->toggle_approved == 1)
                                      <span class="badge badge-success">Approved</span>
                                    @elseif($link->type == 2 && $request_iso_copy->toggle_fillable == 1)
                                      <span class="badge badge-primary">Fillable</span>
                                    @elseif($link->type == 3 && $request_iso_copy->toggle_rawfile == 1)
                                      <span class="badge badge-dark">Raw File</span>
                                    @endif
                                  </a>
                                  @if(in_array(1, $role) || in_array(3, $role))
                                    Password: {{$request_iso_copy->password}}
                                  @endif
                                  <br> 
                                @endif 
                                {{-- <a target="_blank" href="{{url("/file/requestcopy/".$request_iso_copy->requestIsoCopyLatestHistory->request_copy_uniquelink)}}">s</a><br> --}}
                              @endforeach
                            </td>
                            <td>{{$request_iso_copy->requestIsoCopyLatestHistory->status}}</td>
                            <td>
                              <button id="{{$key}}" data-id="{{$request_iso_copy->id}}" data-filetype="{{$request_iso_copy->requestCopyType->id}}" style="text-align: center" type="button" title="Update Request Copy" class="btn btn-sm btn-success px-2 btn-requestCopy_View"><i class="fa-solid fa-arrows-rotate"></i></button>
                              @if(in_array(1, $role) || in_array(3, $role))
                                <button id="{{$key}}" data-id="{{$request_iso_copy->id}}" data-filetype="{{$request_iso_copy->requestCopyType->id}}" data-fileid="{{$request_iso_copy->documentRequested->id}}" style="text-align: center" type="button" title="Configure Request Copy" class="btn btn-sm btn-info px-2 btn-requestCopy_Config"><i class="fa-solid fa-cog"></i></button>
                              @endif
                              {{-- <button id="{{$key}}" data-id="{{$request_iso_copy->id}}" style="color: black; text-align: center" type="button" class="btn btn-sm btn-warning px-2 btn-requestCopy_Edit"><i class="fa-solid fa-pen-line"></i></button> --}}
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
  <script>
    requestCopy_JSON =  {!! json_encode($request_iso_copies->toArray()) !!};
    role = {!! json_encode(auth()->user()->role) !!};
    tagID = {!! json_encode($tagID) !!};
    
    if(tagID == 2){
      $('#requestCopy_Requestor option[value="{{ Auth::user()->id }}"]').attr("selected",true);
    }
    var userRoles = role.split(',');
    //console.log(requestCopy_JSON);
    $('#requestCopy_Requestor option[value="{{ Auth::user()->id }}"]').attr("selected",true);
    
    $('.btn-documentLibraryInsert').on('click', function(e){
      $('#modalDocumentLibraryInsert').modal('show');
    });

    $('.btn-requestCopy_View').on('click', function(e){
      $('.requestCopy_Admin').show();
      $('#modalRequestIsoCopyUpdate').modal('show');
      $('.statusRemark').hide();
      $('.dateExpirationGenerateLink').hide();
      $('.requestCopyFooterButton').hide();
      
      

      var requestCopyID_Array = $(this).attr("id");
      var requestCopyID = $(this).data("id");
      var requestCopyFileType = $(this).data("filetype");
      var requestCopyFileID = $(this).data("fileid");

      $('#requestCopy_GenerateLinkButton').on('click', function(e){
        var generate_random = Math.random().toString(36).substr(2).toUpperCase();
        var generate_url = window.location.origin;
        //$('#requestCopy_GenerateLink').val(generate_url+"/"+requestCopy_JSON[requestCopyID_Array].document_requested.document_revision.attachment_mask+"/"+generate_random);
        $('#requestCopy_GenerateLink').val(generate_random);
      });
      
      $('#updateRequestCopy_ID').val(requestCopyID);
      $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url:  'documentcopy/requesthistory/iso/'+requestCopyID,
        data: requestCopyID,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      }).done(function(data){
        $(".completed").remove();
        $('#requestCopy_FileTypeID').val(requestCopyFileType);
        $('#updateRequestCopy_ID').val(requestCopyID);
        
        for(var i = 0; i < data.length; i++){
          var requestCopyHistoryData = '<li class="completed">';
              requestCopyHistoryData += '<a>';
              requestCopyHistoryData += '<span class="circle">+</span>';
              requestCopyHistoryData += '<span class="label">'+data[i].request_status.status+'</span>';
              requestCopyHistoryData += '</a>';
              requestCopyHistoryData += '<div class="step-content" style="background-color: #e8e8e8; min-width:90%;">';
              requestCopyHistoryData += '<div class="row">';
              requestCopyHistoryData += '<div class="col-sm">';
              requestCopyHistoryData += '<span class="label">'+data[i].remarks+'</span>';
              requestCopyHistoryData += '</div>';
              requestCopyHistoryData += '<div class="col-sm">';
              requestCopyHistoryData += '<span class="label float-right" style="font-size: 10px;">'+data[i].user.name+'</span><br>';
              requestCopyHistoryData += '<span class="label float-right" style="font-size: 10px;">'+data[i].created_at+'</span>';
              requestCopyHistoryData += '</div>';
              requestCopyHistoryData += '</div>';
              requestCopyHistoryData += '</div>';
              requestCopyHistoryData += '</li>';
          $('#requestIsoCopyHistory').append(requestCopyHistoryData);
        }
        
        if(requestCopyFileType == 1){
          $('#requestCopy_StatusUpdate option[value="4"]').remove();
        } else {
          $('#requestCopy_StatusUpdate option[value="3"]').remove();
        }
      
        if(data[0].request_status.status == "Approved"){
          $(".requestCopy_Admin").show();
        } else {
          $(".requestCopy_Admin").hide();
        }

        var statusApproved = data.filter(function (data) {
          return data.status == 1 || data.status == 3 || data.status == 6 || data.status == 7;
        });
        if(statusApproved[0].status == 1){
          $('.statusRemark').show();
          $('#requestCopy_StatusUpdate').prop('required',true);
          $('#requestCopy_RemarksUpdate').prop('required',true);

          $('#requestCopy_DateExpiration').prop('required',false);
          $('#requestCopy_GenerateLink').prop('required',false);

          $('.requestCopyFooterButton').show();
        } if(statusApproved[0].status == 6){
          if(userRoles.includes("3") == true){
            $('.statusRemark').show();
            $('#requestCopy_StatusUpdate').prop('required',true);
            $('#requestCopy_RemarksUpdate').prop('required',true);
            $('.dateExpirationGenerateLink').show();
            $('#requestCopy_DateExpiration').prop('required',true);
            $('#requestCopy_GenerateLink').prop('required',true);
            $('.requestCopyFooterButton').show();
          } else {
            $('.dateExpirationGenerateLink').hide();
          }
          
        } if(((statusApproved[0].status == 1) && userRoles.includes("5") != true) || statusApproved[0].status == 3 || statusApproved[0].status == 7){
          $('.statusRemark').hide();
          $('.requestCopyFooterButton').hide();
        }
      });
    });

    $('.btn-requestCopy_Config').on('click', function(e){
      $('#modalRequestIsoCopyConfigure').modal('show');
      requestCopyID_Array = $(this).attr("id");
      requestCopyID = $(this).data("id");
      requestCopyFileType = $(this).data("filetype");
      requestCopyFileID = $(this).data("fileid");
      requestCopyConfig = {};
        requestCopyConfig.requestCopyFileType = requestCopyFileType;
        requestCopyConfig.requestCopyFileID = requestCopyFileID;
      $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url:  'documentcopy/requestconfig/iso/'+requestCopyID,
        data: requestCopyConfig,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      }).done(function(data){
        $(".requestCopyConfiguration_Container").remove();
        data[0].toggle_approved == 1 ? toggleApproved = 'checked' : toggleApproved = '';
        data[0].toggle_fillable == 1 ? toggleFillable = 'checked' : toggleFillable = '';
        data[0].toggle_rawfile == 1 ? toggleRawFile = 'checked' : toggleRawFile = '';

        var requestCopyConfig = '<div class="requestCopyConfiguration_Container">';
            requestCopyConfig += '<div class="custom-control custom-switch">';
            requestCopyConfig += '<input type="checkbox" class="custom-control-input" data-id="'+data[0].id+'" id="requestCopy_Approved"'+toggleApproved+'>';
            requestCopyConfig += '<label class="custom-control-label" for="requestCopy_Approved">Approved (Signed)</label>';
            requestCopyConfig += '</div>';

            requestCopyConfig += '<div class="custom-control custom-switch">';
            requestCopyConfig += '<input type="checkbox" class="custom-control-input" data-id="'+data[0].id+'" id="requestCopy_Fillable"'+toggleFillable+'>';
            requestCopyConfig += '<label class="custom-control-label" for="requestCopy_Fillable">Fillable</label>';
            requestCopyConfig += '</div>';

            requestCopyConfig += '<div class="custom-control custom-switch">';
            requestCopyConfig += '<input type="checkbox" class="custom-control-input" data-id="'+data[0].id+'" id="requestCopy_RawFile"'+toggleRawFile+'>';
            requestCopyConfig += '<label class="custom-control-label" for="requestCopy_RawFile">Raw File</label>';
            requestCopyConfig += '</div>';
            requestCopyConfig += '</div>';

            $('#requestIsoCopyConfiguration').append(requestCopyConfig);

        console.log(data);
      });
      
      $('#requestIsoCopyConfiguration').on('click', '#requestCopy_Approved', function() {
        $(this).prop("checked") == true ? toggleApproved = 1 : toggleApproved = 0;

        edit_requestCopy = {};
        edit_requestCopy.toggleApproved = toggleApproved;
        $.ajax({
          type: 'PUT',
          url:  'documentcopy/requestconfig/iso/'+requestCopyID+'/edit',
          data: edit_requestCopy,
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        });
      });

      $('#requestIsoCopyConfiguration').on('click', '#requestCopy_Fillable', function() {
        $(this).prop("checked") == true ? toggleFillable = 1 : toggleFillable = 0;

        edit_requestCopy = {};
        edit_requestCopy.toggleFillable = toggleFillable;
        $.ajax({
          type: 'PUT',
          url:  'documentcopy/requestconfig/iso/'+requestCopyID+'/edit',
          data: edit_requestCopy,
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        });
      });

      $('#requestIsoCopyConfiguration').on('click', '#requestCopy_RawFile', function() {
        $(this).prop("checked") == true ? toggleRawFile = 1 : toggleRawFile = 0;

        edit_requestCopy = {};
        edit_requestCopy.toggleRawFile = toggleRawFile;
        $.ajax({
          type: 'PUT',
          url:  'documentcopy/requestconfig/iso/'+requestCopyID+'/edit',
          data: edit_requestCopy,
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        });
      });
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
        "order": [[ 0, "desc" ]],
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