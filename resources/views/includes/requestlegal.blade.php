<!-- Request Entry Modal ISO (INSERT/EDIT) -->
<div class="modal fade" id="modalRequestLegalEntryInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header warning-color">
        <h5 class="modal-title" id="exampleModalLabel">Legal Request Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addRequestLegalEntry" method="POST">
          <input id="ISO_ID" type="hidden" value=""/>
          <div class="row">
            <div class="col-sm-12">
              <div class="md-form">
                <i class="fa-solid fa-address-card prefix"></i>
                <div class="md-form py-0 ml-5">
                  <select id="requestLegalEntry_Requestor" class="mdb-select disabled" searchable="Search requestor">
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
            <div class="col-sm-6">
              <div class="md-form">
                <i class="fa-solid fa-calendar prefix"></i>
                <input type="text" id="requestLegalEntry_DateRequest" class="form-control datepicker">
                <label for="requestLegalEntry_DateRequest">Date Request</label>
              </div>
            </div>
            
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="md-form">
                <i class="fa-solid fa-square-caret-down prefix"></i>
                <div class="md-form py-0 ml-5">
                  <select id="requestLegalEntry_DocumentType" class="mdb-select" searchable="Search Documented Information Type">
                    <option class="mr-1" value="" disabled selected>Documented Information Type</option>
                    @foreach ($document_legal_categories as $document_legal_category)
                      <option value={{$document_legal_category->id}}>{{$document_legal_category->category_description}}</option>
                    @endforeach
                  </select>
                  <label class="mdb-main-label">Documented Information Type</label>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
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
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="md-form">
                <i class="fa-solid fa-input-text prefix"></i>
                <input type="text" id="requestLegalEntry_Attachment" class="form-control">
                <label for="requestLegalEntry_Attachment">Attachment</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="md-form">
                <i class="fa-solid fa-input-text prefix"></i>
                <input type="text" id="requestLegalEntry_Remarks" class="form-control">
                <label for="requestLegalEntry_Remarks">Remarks</label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info btn-requestLegalEntrySummaryInsert">Submit</button>
        <button type="button" class="btn btn-warning btn-requestLegalEntrySummaryEdit">Edit</button>
      </div>
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
      <div class="modal-body">
        <form id="updateRequestEntry" method="POST">
          <input id="updateLegal_ID" type="hidden" value=""/><br>
          
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <div class="md-form">
                  <i class="fa-solid fa-square-caret-down prefix"></i>
                  <div class="md-form py-0 ml-5">
                    <select id="requestLegalEntry_StatusUpdate" class="mdb-select" searchable="Search status">
                      <option class="mr-1" value="" disabled selected>Status</option>
                      @foreach ($request_legal_statuses as $request_legal_status)
                        <option value={{$request_legal_status->id}}>{{$request_legal_status->status}}</option>
                      @endforeach
                    </select>
                    <label class="mdb-main-label">Status</label>
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="md-form">
                  <i class="fa-solid fa-align-left prefix"></i>
                  <textarea id="requestLegalEntry_RemarksUpdate" class="md-textarea form-control" rows="2"></textarea>
                  <label for="requestLegalEntry_RemarksUpdate">Remarks</label>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <ul id="requestLegalEntryHistory" class="stepper stepper-vertical">
            {{-- <input id="" type="text" value="{{$request_iso_history->id}}"/> --}}
          </ul>


        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="" class="btn btn-info btn-requestLegalEntrySummaryUpdate">Submit</button>
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
              <div id="datatableLegalButtons"></div>
            </div>

            <b style="font-size: 24px;" class="float-left"></b>

            <div>
              <button type="button" class="btn btn-outline-white btn-sm px-3 btn-requestLegalEntryInsert" style="font-weight: bold;" data-toggle="modal" data-target="#modalRequestLegalEntryInsert"><i class="fa-solid fa-plus"></i></button>
            </div>

          </div>

          <div class="px-4">
            <div class="table-responsive">

              <table id="datatableLegal" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm" width="">ID</th>
                    <th class="th-sm" width="">Date Request</th>
                    <th class="th-sm" width="">Requestor</th>
                    <th class="th-sm" width="">Document Type</th>
                    <th class="th-sm" width="">Status</th>
                    <th class="th-sm" width="">Attachment</th>
                    <th class="th-sm" width="">Remarks</th>
                    <th class="th-sm" width="">Action</th>
                  </tr>
                </thead>
                <tbody id="requestLegalEntry">
                  @foreach ($request_legal_entries as $key => $request_legal_entry)
                    <tr>
                      <td width="1%">{{$request_legal_entry->id}}</td>
                      <td>{{$request_legal_entry->date_request}}</td>
                      <td>{{$request_legal_entry->user->name}}</td>
                      <td>{{$request_legal_entry->documentType->category_description}}</td>
                      <td>{{$request_legal_entry->requestStatus->status}}</td>
                      <td>Attachment</td>
                      <td>Remarks</td>
                      <td width="1%">
                        <button id="{{$key}}" data-id="{{$request_legal_entry->id}}" style="text-align: center" type="button" class="btn btn-sm btn-success px-2 btn-request_legalView"><i class="fa-solid fa-eye"></i></button>
                        <button id="{{$key}}" data-id="{{$request_legal_entry->id}}" style="color: black; text-align: center" type="button" class="btn btn-sm btn-warning px-2 btn-request_legalEdit"><i class="fa-solid fa-pen-line"></i></button>
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