<!-- Request Entry Modal ISO (INSERT/EDIT) -->
<div class="modal fade" id="modalRequestIsoEntryInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header warning-color">
        <h5 class="modal-title" id="exampleModalLabel">ISO Request Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addRequestEntry" method="POST">
          <input id="ISO_ID" type="hidden" value=""/>
          <div class="row">
            <div class="col-sm-12">
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
          </div>
          
          <div class="row">
            <div class="col-sm-6">
              <div class="md-form">
                <i class="fa-solid fa-calendar prefix"></i>
                <input type="text" id="requestEntry_DateRequest" class="form-control datepicker">
                <label for="requestEntry_DateRequest">Date Request</label>
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
                    @foreach ($request_iso_statuses as $request_iso_status)
                      <option value={{$request_iso_status->id}}>{{$request_iso_status->status}}</option>
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
                <input type="text" id="requestEntry_Title" class="form-control">
                <label for="requestEntry_Title">Title</label>
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
                    @foreach ($document_iso_categories as $document_iso_category)
                      <option value={{$document_iso_category->id}}>{{$document_iso_category->category_description}}</option>
                    @endforeach
                  </select>
                  <label class="mdb-main-label">Documented Information Type</label>
                </div>
              </div>
            </div>
            <div class="col-sm-6 requestType_New">
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
            <label for="requestEntry_DocumentPurposeRequest">Purpose of Documentation Request</label>
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
                      @foreach ($request_iso_statuses as $request_iso_status)
                        <option value={{$request_iso_status->id}}>{{$request_iso_status->status}}</option>
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
              <div id="datatableISOButtons"></div>
            </div>

            <b style="font-size: 24px;" class="float-left"></b>

            <div>
              <button type="button" class="btn btn-outline-white btn-sm px-3 btn-requestIsoEntryInsert" style="font-weight: bold;" data-toggle="modal" data-target="#modalRequestIsoEntryInsert"><i class="fa-solid fa-plus"></i></button>
            </div>

          </div>

          <div class="px-4">
            <div class="table-responsive">

              <table id="datatableISO" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" width="100%">
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
                  @foreach ($request_iso_entries as $key => $request_iso_entry)
                    <tr>
                      <td>{{$request_iso_entry->id}}</td>
                      <td>{{$request_iso_entry->date_request}}</td>
                      <td>{{$request_iso_entry->user->name}}</td>
                      <td>{{$request_iso_entry->title}}</td>
                      <td>{{$request_iso_entry->proposed_effective_date}}</td>
                      <td>{{$request_iso_entry->requestType->description}}</td>
                      <td>{{$request_iso_entry->documentType->category_description}}</td>
                      <td>
                        @if($request_iso_entry->documentToRevise != null) 
                          {{$request_iso_entry->documentToRevise->document_number_series}}
                        @endif
                      </td>
                      <td>{{$request_iso_entry->document_purpose_request}}</td>
                      <td>{{$request_iso_entry->requestIsoEntryLatestHistory->status}}</td>
                      <td >
                        <button id="{{$key}}" data-id="{{$request_iso_entry->id}}" style="text-align: center" type="button" class="btn btn-sm btn-success px-2 btn-request_isoView"><i class="fa-solid fa-eye"></i></button>
                        <button id="{{$key}}" data-id="{{$request_iso_entry->id}}" style="color: black; text-align: center" type="button" class="btn btn-sm btn-warning px-2 btn-request_isoEdit"><i class="fa-solid fa-pen-line"></i></button>
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