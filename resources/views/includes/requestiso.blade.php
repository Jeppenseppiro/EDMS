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

            <b style="font-size: 24px;" class="float-left">Document Management</b>

            <div>
              <button type="button" class="btn btn-outline-white btn-sm px-3 btn-requestIsoEntryInsert" style="font-weight: bold;" data-toggle="modal" data-target="#modalRequestIsoEntryInsert"><i class="fa-solid fa-plus"></i></button>
            </div>

          </div>

          <div class="px-4">
            <div class="table-responsive">

              <table id="datatableISO" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm" width="1%">DICR No.</th>
                    <th class="th-sm" width="">Date Request</th>
                    <th class="th-sm" width="">Requestor</th>
                    <th class="th-sm" width="">Description</th>
                    <th class="th-sm" width="">Proposed Effective Date</th>
                    <th class="th-sm" width="">Request Type</th>
                    <th class="th-sm" width="">Document Type</th>
                    {{-- <th class="th-sm" width="">Document to Revise</th> --}}
                    <th class="th-sm" width="">Document Purpose Request</th>
                    <th class="th-sm" width="">Status</th>
                    <th class="th-sm" width="">Action</th>
                  </tr>
                </thead>
                <tbody id="requestISOEntry">
                  @foreach ($request_iso_entries as $key => $request_iso_entry)
                    <tr>
                      <td>{{date_format($request_iso_entry->created_at,"Y")."-".sprintf('%06d', $request_iso_entry->id)}}</td>
                      <td>{{$request_iso_entry->date_request}}</td>
                      <td>{{$request_iso_entry->user->name}}</td>
                      <td>{{$request_iso_entry->title}}</td>
                      <td>{{$request_iso_entry->proposed_effective_date}}</td>
                      <td>{{$request_iso_entry->requestType->description}}</td>
                      <td>{{$request_iso_entry->documentType->category_description}}</td>
                      {{-- <td>
                        @if($request_iso_entry->documentToRevise != null) 
                          {{$request_iso_entry->documentToRevise->document_number_series}}
                        @endif
                      </td> --}}
                      <td>{{$request_iso_entry->document_purpose_request}}</td>
                      <td>{{$request_iso_entry->requestIsoEntryLatestHistory->status}}</td>
                      <td>
                        {{-- @if(in_array(1, $role) || in_array(3, $role)) --}}
                        <button id="{{$key}}" data-id="{{$request_iso_entry->id}}" style="text-align: center" type="button" title="Update Document Management Request Entry" class="btn btn-sm btn-success px-2 btn-request_isoView"><i class="fa-solid fa-arrows-rotate"></i></button>
                        {{-- <button id="{{$key}}" data-id="{{$request_iso_entry->id}}" style="color: black; text-align: center" type="button" title="Edit Request Entry" class="btn btn-sm btn-warning px-2 btn-request_isoEdit"><i class="fa-solid fa-pen-line"></i></button> --}}
                        {{-- @endif --}}
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