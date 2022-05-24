<!-- Request Entry Modal ISO (INSERT/EDIT) -->
<div class="modal fade" id="modalRequestIsoEntryInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header warning-color">
        <h5 class="modal-title" id="exampleModalLabel">Document Request Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="md-form" id="addRequestEntry" action="documentrequest/iso/store" method="POST" enctype="multipart/form-data">
        @csrf
          <input id="ISO_ID" type="hidden" value=""/>
          <div class="row">
            <div class="col-sm-12" hidden>
              <div class="md-form">
                <i class="fa-solid fa-address-card prefix"></i>
                <div class="md-form py-0 ml-5">
                  <select id="requestEntry_Requestor" name="requestEntry_Requestor" class="mdb-select disabled" searchable="Search requestor">
                    <option class="mr-1" value="" disabled selected>Requestor</option>
                    @foreach ($users as $user)
                      <option value={{$user->id}}>{{$user->name}}</option>
                    @endforeach
                  </select>
                  <label class="mdb-main-label">Requestor</label>
                </div>
              </div>
            </div>
            {{-- <div class="col-sm-6">
              <div class="md-form">
                <i class="fa-solid fa-input-text prefix"></i>
                <input type="text" id="requestEntry_DICR" class="form-control">
                <label for="requestEntry_DICR">DICR No.</label>
              </div>
            </div> --}}
          </div>
          
          <div class="row">
            <div class="col-sm-6" hidden>
              <div class="md-form">
                <i class="fa-solid fa-calendar prefix"></i>
                <input type="text" id="requestEntry_DateRequest" name="requestEntry_DateRequest" class="form-control datepicker" value="{{$dateToday}}" required>
                <label for="requestEntry_DateRequest">Date Request</label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="md-form">
                <i class="fa-solid fa-square-caret-down prefix"></i>
                <div class="md-form py-0 ml-5">
                  <select id="requestEntry_RequestType" name="requestEntry_RequestType" class="mdb-select" searchable="Search Request Type" required>
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
                <i class="fa-solid fa-calendar prefix"></i>
                <input type="text" id="requestEntry_DateEffective" name="requestEntry_DateEffective" class="form-control datepicker">
                <label for="requestEntry_DateEffective">Proposed Effective Date</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="md-form">
                <i class="fa-solid fa-input-text prefix"></i>
                <input type="text" id="requestEntry_Title" name="requestEntry_Title" class="form-control" required>
                <label for="requestEntry_Title">Document Title</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="md-form">
                <i class="fa-solid fa-square-caret-down prefix"></i>
                <div class="md-form py-0 ml-5">
                  <select id="requestEntry_DocumentType" name="requestEntry_DocumentType" class="mdb-select" searchable="Search Documented Information Type" required>
                    <option class="mr-1" value="" disabled selected>Documented Information Type</option>
                    @foreach ($document_iso_categories as $document_iso_category)
                      <option value={{$document_iso_category->id}}>{{$document_iso_category->category_description}}</option>
                    @endforeach
                  </select>
                  <label class="mdb-main-label">Documented Information Type</label>
                </div>
              </div>
            </div>
            <div class="col-sm-6 requestEntryDocumentRevised">
              <div class="md-form">
                <i class="fa-solid fa-square-caret-down prefix"></i>
                <div class="md-form py-0 ml-5">
                  <select id="requestEntry_DocumentRevised" name="requestEntry_DocumentRevised" class="mdb-select" searchable="Search document to be Revised">
                    <option class="mr-1 requestEntry_DocumentReference" value="" disabled selected>Document to be Revised</option>
                    @foreach ($document_libraries as $document_library)
                      <option value={{$document_library->id}}>{{$document_library->document_number_series}} | {{$document_library->description}} | {{$document_library->revision}}</option>
                    @endforeach
                  </select>
                  <label class="mdb-main-label requestEntry_DocumentReference">Document to be Revised</label>
                  <div class="red-text requestEntry_DocumentReferenceNote"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 requestEntryAttachment">
              <div class="file-field">
                <div class="btn btn-primary btn-sm float-left">
                  <span>Choose file</span>
                  <input type="file" id="requestEntry_Attachment" name="requestEntry_Attachment" required>
                </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text" placeholder="Attachment">
                </div>
              </div>
            </div>
          </div>

          <div class="md-form">
            <i class="fa-solid fa-align-left prefix"></i>
            <input type="text" id="requestEntry_DocumentPurposeRequest" name="requestEntry_DocumentPurposeRequest" class="form-control" required>
            {{-- <textarea id="requestEntry_DocumentPurposeRequest" name="requestEntry_DocumentPurposeRequest" class="md-textarea form-control" rows="2" required></textarea> --}}
            <label for="requestEntry_DocumentPurposeRequest">Purpose of Documentation Request</label>
          </div>

        </form>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-requestISOEntrySummaryInsert">Submit</button>
        @if(in_array(1, $role) || in_array(3, $role))
        <button type="button" class="btn btn-warning btn-requestISOEntrySummaryEdit">Edit</button>
        @endif
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
      <form class="md-form" id="updateRequestISOEntry" action="{{ route('requestentryhistory_iso') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <input id="updateISO_ID" name="updateISO_ID" type="hidden" value=""/>
          <input id="updateISO_TagID" name="updateISO_TagID" type="hidden" value="1"/>
          <div class="container">
            <div class="row">
              <div class="col-sm-4">
                <div class="md-form">
                  <i class="fa-solid fa-square-caret-down prefix"></i>
                  <div class="md-form py-0 ml-5">
                    <select id="requestEntry_StatusUpdate" name="requestEntry_StatusUpdate" class="mdb-select" searchable="Search status" required>
                      <option class="mr-1" value="" disabled selected>Status</option>
                      @foreach ($request_iso_statuses as $request_iso_status)
                        @if($request_iso_status->id != 1) 
                          <option value={{$request_iso_status->id}}>{{$request_iso_status->status}}</option>
                        @endif
                      @endforeach
                    </select>
                    <label class="mdb-main-label">Status</label>
                  </div>
                </div>
              </div>
              <div class="col-sm-8">
                <div class="md-form">
                  <i class="fa-solid fa-align-left prefix"></i>
                  {{-- <textarea id="requestEntry_RemarksUpdate" class="md-textarea form-control" rows="1"></textarea>
                  <label for="form10">Remarks</label> --}}

                  <input type="text" id="requestEntry_RemarksUpdate" name="requestEntry_RemarksUpdate" class="form-control" required>
                <label for="requestEntry_RemarksUpdate">Remarks</label>
                </div>
              </div>
              <div class="col-sm-12" hidden>
                <div class="file-field">
                  <div class="btn btn-primary btn-sm float-left">
                    <span>Choose file</span>
                    <input type="file" name="requestEntry_FileUploadUpdate">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Upload your file">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <ul id="requestIsoEntryHistory" class="stepper stepper-vertical">
            {{-- <input id="" type="text" value="{{$request_iso_history->id}}"/> --}}
          </ul>

        </div>
        @if(in_array(1, $role) || in_array(3, $role))
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="" class="btn btn-primary btn-requestISOEntrySummaryUpdate">Submit</button>
        </div>
        @endif
      </form>
    </div>
  </div>
</div>

<!-- Request Entry Display Attached File -->
<div class="modal fade" id="filePreviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div id="requestEntry_ModalFilePreview" class="modal-body">
        {{-- <object data="{{ asset('pdf/PCHI-CM-CMG-01F1 Documented Info Change Request _rev0.pdf') }}" width="100%"></object> --}}
      </div>
    </div>
  </div>
</div>