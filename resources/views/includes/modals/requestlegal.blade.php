<!-- Request Entry Modal Legal (INSERT/EDIT) -->
<div class="modal fade" id="modalRequestLegalEntryInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header warning-color">
        <h5 class="modal-title" id="exampleModalLabel">Legal Request Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="md-form" id="addRequestLegalEntry" action="documentrequest/legal/store" method="POST" enctype="multipart/form-data">
      @csrf
        <div class="modal-body">
          <input id="requestLegalEntry_User" name="requestLegalEntry_User" type="hidden" value="{{ Auth::user()->id }}"/>
          <div class="row">
            <div class="col-sm-12" hidden>
              <div class="md-form">
                <i class="fa-solid fa-address-card prefix"></i>
                <div class="md-form py-0 ml-5">
                  <select id="requestLegalEntry_Requestor" name="requestLegalEntry_Requestor" class="mdb-select disabled" searchable="Search requestor">
                    <option class="mr-1" value="" disabled selected>Requestor</option>
                    @foreach ($users as $user)
                      <option value={{$user->id}}>{{$user->name}}</option>
                    @endforeach
                  </select>
                  <label class="mdb-main-label">Requestor</label>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-6" hidden>
              <div class="md-form">
                <i class="fa-solid fa-calendar prefix"></i>
                <input type="text" id="requestLegalEntry_DateRequest" name="requestLegalEntry_DateRequest" class="form-control datepicker" value="{{$dateToday}}" required>
                <label for="requestLegalEntry_DateRequest">Date Request</label>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="md-form">
                <i class="fa-solid fa-square-caret-down prefix"></i>
                <div class="md-form py-0 ml-5">
                  <select id="requestLegalEntry_DocumentType" name="requestLegalEntry_DocumentType" class="mdb-select" searchable="Search Documented Information Type" required>
                    <option class="mr-1" value="" disabled selected>Documented Information Type</option>
                    @foreach ($document_legal_categories as $document_legal_category)
                      <option value={{$document_legal_category->id}}>{{$document_legal_category->category_description}}</option>
                    @endforeach
                  </select>
                  <label class="mdb-main-label">Documented Information Type</label>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            
            {{-- <div class="col-sm-6">
              <div class="md-form">
                <i class="fa-solid fa-square-caret-down prefix"></i>
                <div class="md-form py-0 ml-5">
                  <select id="requestLegalEntry_Status" class="mdb-select" searchable="Search status">
                    <option class="mr-1" value="" disabled selected>Status</option>
                    @foreach ($request_legal_statuses as $request_legal_status)
                      <option value={{$request_legal_status->id}}>{{$request_legal_status->status}}</option>
                    @endforeach
                  </select>
                  <label class="mdb-main-label">Status</label>
                </div>
              </div>
            </div> --}}
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="file-field">
                <div class="btn btn-primary btn-sm float-left">
                  <span>Choose file</span>
                  <input type="file" name="requestLegalEntry_Attachment" required>
                </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text" placeholder="Attachment">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="md-form">
                <i class="fa-solid fa-input-text prefix"></i>
                <input type="text" id="requestLegalEntry_Remarks" name="requestLegalEntry_Remarks" class="form-control" required>
                <label for="requestLegalEntry_Remarks">Remarks</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-requestLegalEntrySummaryInsert">Submit</button>
          <button type="button" class="btn btn-warning btn-requestLegalEntrySummaryEdit">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Request Entry Modal ISO (UPDATE) -->
<div class="modal fade" id="modalRequestLegalEntryUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header warning-color">
        <h5 class="modal-title" id="exampleModalLabel">Update Request Legal Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="md-form" id="updateRequestLegalEntry" action="{{ route('requestentryhistory_legal') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <input id="updateLegal_ID" name="updateLegal_ID" type="hidden" value=""/>
          <div class="container">
            <div class="row">
              <div class="col-sm-4">
                <div class="md-form">
                  <i class="fa-solid fa-square-caret-down prefix"></i>
                  <div class="md-form py-0 ml-5">
                    <select id="requestLegalEntry_StatusUpdate" name="requestLegalEntry_StatusUpdate" class="mdb-select" searchable="Search status" required>
                      <option class="mr-1" value="" disabled selected>Status</option>
                      @foreach ($request_legal_statuses as $request_legal_status)
                        <option value={{$request_legal_status->id}}>{{$request_legal_status->status}}</option>
                      @endforeach
                    </select>
                    <label class="mdb-main-label">Status</label>
                  </div>
                </div>
              </div>
              <div class="col-sm-8">
                <div class="md-form">
                  <i class="fa-solid fa-align-left prefix"></i>
                  <input type="text" id="requestLegalEntry_RemarksUpdate" name="requestLegalEntry_RemarksUpdate" class="form-control" required>
                <label for="requestLegalEntry_RemarksUpdate">Remarks</label>
                </div>
              </div>
              {{-- <div class="col-sm-12">
                <div class="file-field">
                  <div class="btn btn-primary btn-sm float-left">
                    <span>Choose file</span>
                    <input type="file" name="requestLegalEntry_FileUploadUpdate">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Upload your file">
                  </div>
                </div>
              </div> --}}
            </div>
          </div>

          <hr>

          <ul id="requestLegalEntryHistory" class="stepper stepper-vertical">
            {{-- <input id="" type="text" value="{{$request_iso_history->id}}"/> --}}
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="" class="btn btn-primary btn-requestLegalEntrySummaryUpdate">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Request Entry Display Attached File -->
<div class="modal fade" id="filePreviewModal_Legal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div id="requestLegalEntry_ModalFilePreview" class="modal-body">
        {{-- <object data="{{ asset('pdf/PCHI-CM-CMG-01F1 Documented Info Change Request _rev0.pdf') }}" width="100%"></object> --}}
      </div>
    </div>
  </div>
</div>