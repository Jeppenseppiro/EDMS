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

            <b style="font-size: 24px;" class="float-left">Legal</b>

            <div>
              <button type="button" class="btn btn-outline-white btn-sm px-3 btn-requestLegalEntryInsert" style="font-weight: bold;" data-toggle="modal" data-target="#modalRequestLegalEntryInsert"><i class="fa-solid fa-plus"></i></button>
            </div>

          </div>

          <div class="px-4">
            <div class="table-responsive">

              <table id="datatableLegal" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm" width="">DICR No.</th>
                    <th class="th-sm" width="">Date Request</th>
                    <th class="th-sm" width="">Requestor</th>
                    <th class="th-sm" width="">Document Type</th>
                    <th class="th-sm" width="">Status</th>
                    <th class="th-sm" width="">Attachment File</th>
                    <th class="th-sm" width="">Remarks</th>
                    <th class="th-sm" width="">Action</th>
                  </tr>
                </thead>
                <tbody id="requestLegalEntry">
                  @foreach ($request_legal_entries as $key => $request_legal_entry)
                    <tr>
                      <td width="1%">{{date_format($request_legal_entry->created_at,"Y")."-".sprintf('%06d', $request_legal_entry->id)}}</td>
                      <td>{{$request_legal_entry->date_request}}</td>
                      <td>{{$request_legal_entry->user->name}}</td>
                      <td>{{$request_legal_entry->documentType->category_description}}</td>
                      <td>{{$request_legal_entry->requestStatus->status}}</td>
                      <td>{{$request_legal_entry->attachment}}</td>
                      <td>{{$request_legal_entry->remarks}}</td>
                      <td width="1%">
                        @if(in_array(1, $role) || in_array(3, $role))
                        <button id="{{$key}}" data-id="{{$request_legal_entry->id}}" style="text-align: center" type="button" title="Update Legal Request Entry" class="btn btn-sm btn-success px-2 btn-request_legalView"><i class="fa-solid fa-arrows-rotate"></i></button>
                        {{-- <button id="{{$key}}" data-id="{{$request_legal_entry->id}}" style="color: black; text-align: center"asdasdas type="button" class="btn btn-sm btn-warning px-2 btn-request_legalEdit"><i class="fa-solid fa-pen-line"></i></button> --}}
                        @endif
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