@extends('layouts.app')

@section('title', 'Document Library')

@section('head')
  <link href="{{ url('css/addons/datatables.min.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
  <div id="content" class="heavy-rain-gradient color-block content" style="padding-top: 20px;">
    <section>
      @include('includes.errormessage')

      <!-- Document Library (INSERT) -->
      <div class="modal fade" id="modalDocumentLibraryInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header warning-color">
              <h5 class="modal-title" id="exampleModalLabel">Insert Document Library</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="md-form" action="{{ route('documentlibrary.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input id="updateDocumentLibrary_UserID" name="updateDocumentLibrary_UserID" type="hidden" value="{{ Auth::user()->id }}" />
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="md-form">
                      <i class="fa-solid fa-input-text prefix"></i>
                      <input type="text" id="documentLibrary_Description" name="documentLibrary_Description" class="form-control" value="{{ old('documentLibrary_Description') }}" required>
                      <label for="documentLibrary_Description">Document Title</label>
                    </div>
                  </div>
                  <div class="col-sm-6" hidden>
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="documentLibrary_Tag" name="documentLibrary_Tag" class="mdb-select" searchable="Search category">
                          <option class="documentLibrary_TagDisabled" value="" disabled selected>Tag</option>
                          @foreach ($tags as $tag)
                            <option value={{ $tag->id }}>{{ $tag->description }}</option>
                            <option @if ($tagID == $tag->id) selected @endif value={{ $tag->id }}>
                              {{ $tag->description }}</option>
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
                      <input type="text" id="documentLibrary_DocumentNumberSeries" name="documentLibrary_DocumentNumberSeries" class="form-control{{ $errors->has('documentLibrary_DocumentNumberSeries') ? ' is-invalid' : '' }}" value="{{ old('documentLibrary_DocumentNumberSeries') }}">
                      @if ($errors->has('documentLibrary_DocumentNumberSeries'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('documentLibrary_DocumentNumberSeries') }}</strong>
                        </span>
                      @endif
                      <label for="documentLibrary_DocumentNumberSeries">Document Code</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="documentLibrary_Category" name="documentLibrary_Category" class="mdb-select" searchable="Search category">
                          <option class="documentCategory_OptionDisabled" value="" disabled selected>Category</option>
                          @foreach ($document_categories as $document_category)
                            <option class="documentCategory_Option" value={{ $document_category->id }}>
                              {{ $document_category->category_description }}</option>
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
                      <input type="number" id="documentLibrary_Revision" name="documentLibrary_Revision" class="form-control">
                      <label for="documentLibrary_Revision">Revision No</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="documentLibrary_Company" name="documentLibrary_Company" class="mdb-select" searchable="Search category">
                          <option class="mr-1" value="" disabled selected>Company</option>
                          @foreach ($document_companies as $document_company)
                            <option @if (old('documentLibrary_Company') == $document_company->id) selected @endif value={{ $document_company->id }}>
                              {{ $document_company->company_name }}</option>
                          @endforeach
                        </select>
                        <label class="mdb-main-label">Company</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-calendar prefix"></i>
                      <input type="text" id="documentLibrary_DateEffective" name="documentLibrary_DateEffective" class="form-control datepicker" value="{{ old('documentLibrary_DateEffective') }}" required>
                      <label for="documentLibrary_DateEffective">Effective Date</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="documentLibrary_Department" name="documentLibrary_Department" class="mdb-select" searchable="Search category">
                          <option class="mr-1" value="" disabled selected>Department</option>
                          @foreach ($document_departments as $document_department)
                            <option @if (old('documentLibrary_Department') == $document_department->id) selected @endif value={{ $document_department->id }}>{{ $document_department->department }}</option>
                          @endforeach
                        </select>
                        <label class="mdb-main-label">Department</label>
                      </div>
                    </div>
                  </div>

                </div>

                <table class="fixed table-bordered table-sm" width="100%">
                  <thead>
                    <tr>
                      <th width="65%" scope="col">File Upload</th>
                      <th width="30%" scope="col">File Type</th>
                      <th width="5%" scope="col"><button type="button" class="btn btn-sm btn-info px-3" id="documentLibrary_AddFileUpload"><i class="fa-solid fa-plus"></i></button></th>
                    </tr>
                  </thead>
                  <tbody id="documentLibrary_FileUploads">
                  </tbody>
                </table>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="" class="btn btn-primary btn-documentLibrarySubmit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Document Library (UPDATE) -->
      <div class="modal fade" id="modalDocumentLibraryUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header warning-color">
              <h5 class="modal-title" id="exampleModalLabel">
                @if (auth()->user()->role == 1 || auth()->user()->role == 3)
                  Update
                @else
                  History
                @endif Document Library
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="md-form" action="documentrevision/store" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                @if (auth()->user()->role == 1 || auth()->user()->role == 3)
                  <input id="updateDocumentLibrary_ID" name="updateDocumentLibrary_ID" type="hidden" value="" />
                  <input id="updateDocumentLibrary_UserID" name="updateDocumentLibrary_UserID" type="hidden" value="{{ Auth::user()->id }}" />
                  <input id="documentLibrary_Tag" name="documentLibrary_Tag" type="hidden" value="{{ $tagID }}" />
                  <div class="container">
                    <a href="../extraction/library/1" target="_blank" style="text-align: center" type="button" class="btn btn-outline-success waves-effect pdf_RevisionHistory">
                      History
                    </a>

                    <div class="row">
                      <div class="col-sm-6">
                        <div class="md-form">
                          <i class="fa-solid fa-input-text prefix"></i>
                          <input type="text" id="documentLibrary_ControlCode" name="documentLibrary_ControlCode" class="form-control" required>
                          <label for="documentLibrary_ControlCode">Control Code</label>
                        </div>
                      </div>


                      {{-- <div class="col-sm-6">
                          <div class="md-form">
                            <i class="fa-solid fa-input-text prefix"></i>
                            <input type="number" id="documentLibrary_Revision" name="documentLibrary_Revision" class="form-control" required>
                            <label for="documentLibrary_Revision">Revision</label>
                          </div>
                        </div> --}}
                      <div class="col-sm-6">
                        <div class="md-form">
                          <i class="fa-solid fa-calendar prefix"></i>
                          <input type="text" id="documentLibrary_DateEffective" name="documentLibrary_DateEffective" class="form-control datepicker" required>
                          <label for="documentLibrary_DateEffective">Effective Date</label>
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="md-form">
                          <i class="fa-solid fa-input-text prefix"></i>
                          <input type="text" id="documentLibrary_Remarks" name="documentLibrary_Remarks" class="form-control" required>
                          <label for="documentLibrary_Remarks">Remarks</label>
                        </div>
                      </div>
                    </div>
                    <table class="fixed table-bordered table-sm" width="100%">
                      <thead>
                        <tr>
                          <th width="65%" scope="col">File Upload</th>
                          <th width="30%" scope="col">File Type</th>
                          <th width="5%" scope="col"><button type="button" class="btn btn-sm btn-info px-3" id="documentLibraryUpdate_AddFileUpload"><i class="fa-solid fa-plus"></i></button></th>
                        </tr>
                      </thead>
                      <tbody id="documentLibraryUpdate_FileUploads">
                      </tbody>
                    </table>
                  </div>
                @endif
                {{-- <object data="{{ asset('pdf/PCHI-CM-CMG-01F1 Documented Info Change Request _rev0.pdf') }}" width="100%"></object> --}}
                <ul id="documentLibraryRevision" class="stepper stepper-vertical">
                  {{-- <input id="" type="text" value="{{$request_iso_history->id}}"/> --}}
                </ul>
              </div>
              @if (auth()->user()->role == 1 || auth()->user()->role == 3)
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              @endif
            </form>
          </div>
        </div>
      </div>

      <!-- Full Height Modal Right -->
      <div class="modal fade right" id="fullHeightModalRight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-side modal-top-right modal-info" role="document">

          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title w-100" id="myModalLabel">Raw Uploading</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="md-form" {{-- action="documentrevision/store" --}} method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <div class="file-field">
                  <div class="btn btn-primary btn-sm float-left">
                    <span>Choose file</span>
                    <input type="file" name="documentLibrary_Attachment">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Attachment">
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Request Entry Display Attached File -->
      <div class="modal fade" id="filePreviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
          <div class="modal-content">
            <div id="documentRevision_ModalFilePreview" class="modal-body">
              {{-- <object data="{{ asset('pdf/PCHI-CM-CMG-01F1 Documented Info Change Request _rev0.pdf') }}" width="100%"></object> --}}
            </div>
          </div>
        </div>
      </div>

      <!-- Document File Revision (USER ACCESS) -->
      <div class="modal fade right" id="modalFileRevisionUsers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-side modal-top-right modal-info" role="document">
          <div class="modal-content">
            <div class="modal-header warning-color">
              <h5 class="modal-title" id="exampleModalLabel">File Document User Access</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="md-form" action="documentrevision/user/access" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <input id="documentFileRevisionAccess_ID" name="documentFileRevisionAccess_ID" type="hidden" value="" />
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="userAccess-tab" data-toggle="tab" href="#userAccess" role="tab" aria-controls="userAccess" aria-selected="true">User Access</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="acknowledge-tab" data-toggle="tab" href="#acknowledge" role="tab" aria-controls="acknowledge" aria-selected="false">Acknowledgement</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="userAccess" role="tabpanel" aria-labelledby="userAccess-tab">
                    <div class="row">
                      <div class="col-sm-12">
                        <select class="mdb-select md-form" id="documentFileRevisionAccess_Users" name="documentFileRevisionAccess_Users[]" searchable="Select users to have access" multiple>
                          <option value="" disabled selected>Users</option>
                          <div id="documentFileRevisionAccess_UsersDropdown">
                            @foreach ($users as $user)
                              <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                          </div>
                        </select>
                        {{-- <button class="btn-save btn btn-primary btn-sm">Save</button> --}}
                      </div>
                    </div>
                    <table class="table table-hover table-striped table-bordered table-sm" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th class="th-sm" width="">User</th>
                          <th class="th-sm" width="">Added By</th>
                          <th class="th-sm" width="">Action</th>
                        </tr>
                      <tbody id="documentFileRevisionUserAccess">
                      </tbody>
                      </thead>
                    </table>
                  </div>
                  <div class="tab-pane fade" id="acknowledge" role="tabpanel" aria-labelledby="acknowledge-tab">
                    <table class="table table-hover table-striped table-bordered table-sm" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th class="th-sm" width="">User</th>
                        </tr>
                      <tbody id="documentFileRevisionUserAcknowledge">
                      </tbody>
                      </thead>
                    </table>
                  </div>
                </div>


              </div>
              <div class="modal-footer documentFileRevisionUserAccessSubmit">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-documentFileRevisionUserAccessSubmit">Submit</button>
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

                  <b style="font-size: 24px;" class="float-left">Document Library</b>

                  <div>
                    @if (auth()->user()->role == 1 || auth()->user()->role == 3)
                      <button type="button" class="btn btn-outline-white btn-sm px-3 btn-documentLibraryInsert" style="font-weight: bold;" data-toggle="modal" data-target="#modalfileUploadInsert"><i class="fa-solid fa-plus"></i></button>
                    @endif
                  </div>

                </div>

                <div class="px-4">
                  <div class="table-responsive">
                    <table id="datatable" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th class="th-sm" width="5%">Company</th>
                          <th class="th-sm" width="">Department</th>
                          <th class="th-sm" width="">Control Code</th>
                          <th class="th-sm" width="">Document Title</th>
                          <th class="th-sm" width="">Revision No</th>
                          <th class="th-sm" width="">Category</th>
                          <th class="th-sm" width="">Tag</th>
                          <th class="th-sm" width="">Implementation Date</th>
                          <th class="th-sm" width="">Date Request</th>
                          <th class="th-sm" width="">Action</th>
                        </tr>
                      </thead>
                      <tbody id="fileUpload">
                        @foreach ($document_libraries as $key => $document_library)
                          <tr>
                            <td>{{ $document_library->documentCompany->company_code }}</td>
                            <td>{{ $document_library->documentDepartment->department }}</td>
                            <td>{{ $document_library->document_number_series }}</td>
                            <td>{{ $document_library->description }}</td>
                            <td>{{ $document_library->documentRevision->revision }}</td>
                            <td>{{ $document_library->documentCategory->category_description }}</td>
                            <td>{{ $document_library->documentTag->description }}</td>
                            <td>{{ $document_library->documentRevision->effective_date }}</td>
                            <td>{{ $document_library->attachment }}</td>
                            <td>
                              <button id="{{ $key }}" data-id="{{ $document_library->id }}" style="text-align: center" type="button" title="Update Document Library" class="btn btn-sm btn-success px-2 btn-documentLibrary_View"><i class="fa-solid fa-arrows-rotate"></i></button>
                              {{-- <button id="{{$key}}" data-id="{{$document_library->id}}" style="text-align: center" type="button" class="btn btn-sm btn-info px-2 btn-documentLibrary_User"><i class="fa-solid fa-user"></i></button> --}}
                              {{-- <button id="{{$key}}" data-id="{{$document_library->id}}" style="color: black; text-align: center" type="button" class="btn btn-sm btn-warning px-2 btn-documentLibrary_Edit"><i class="fa-solid fa-pen-line"></i></button> --}}
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
    userID = {!! json_encode(auth()->user()->id) !!};
    tagID = {!! json_encode($tagID) !!};
    role = {!! json_encode(auth()->user()->role) !!};
    var userRoles = role.split(',');
    count = 0;
    $('.btn-documentLibraryInsert').on('click', function(e) {
      $('#modalDocumentLibraryInsert').modal('show');

      $('#documentLibrary_AddFileUpload').on('click', function(e) {
        count = count + 1;
        var documentLibraryFileUpload =
          documentLibraryFileUpload += '<tr id="row' + count + '">';
        documentLibraryFileUpload += '  <td>';
        documentLibraryFileUpload += '    <div class="file-field">';
        documentLibraryFileUpload += '      <div class="btn btn-primary btn-sm float-left">';
        documentLibraryFileUpload += '        <span>Choose file</span>';
        documentLibraryFileUpload += '        <input type="file" name="documentLibrary_Attachment[]" required>';
        documentLibraryFileUpload += '      </div>';
        documentLibraryFileUpload += '      <div class="file-path-wrapper">';
        documentLibraryFileUpload +=
          '        <input class="file-path validate" type="text" placeholder="Attachment">';
        documentLibraryFileUpload += '      </div>';
        documentLibraryFileUpload += '    </div>';
        documentLibraryFileUpload += '  </td>';
        documentLibraryFileUpload += '  <td>';
        documentLibraryFileUpload +=
          '    <select class="browser-default custom-select" name="documentLibrary_AttachmentType[]" required>';
        documentLibraryFileUpload += '      <option disabled>Open this select menu</option>';

        if (tagID == 1) {
          documentLibraryFileUpload += '      <option value="1">Approved (Signed)</option>';
        }

        documentLibraryFileUpload += '      <option value="2">Fillable</option>';
        documentLibraryFileUpload += '      <option value="3">Raw File</option>';
        documentLibraryFileUpload += '    </select>';
        documentLibraryFileUpload += '  </td>';
        documentLibraryFileUpload +=
          '  <td><button type="button" class="btn btn-sm btn-danger px-3 remove_insertfileupload" data-row="row' +
          count + '"><i class="fa-solid fa-trash"></i></button></td>';
        documentLibraryFileUpload += '</tr>';
        $('#documentLibrary_FileUploads').append(documentLibraryFileUpload);
      });

      $(document).on('click', '.remove_insertfileupload', function() {
        var delete_row = $(this).data("row");
        $('#' + delete_row).remove();
      });
    });

    $('.btn-documentLibrary_View').on('click', function(e) {
      $('#documentLibraryUpdate_AddFileUpload').on('click', function(e) {
        count = count + 1;
        var documentLibraryFileUpload =
          documentLibraryFileUpload += '<tr id="row' + count + '">';
        documentLibraryFileUpload += '  <td>';
        documentLibraryFileUpload += '    <div class="file-field">';
        documentLibraryFileUpload += '      <div class="btn btn-primary btn-sm float-left">';
        documentLibraryFileUpload += '        <span>Choose file</span>';
        documentLibraryFileUpload += '        <input type="file" name="documentLibrary_Attachment[]" required>';
        documentLibraryFileUpload += '      </div>';
        documentLibraryFileUpload += '      <div class="file-path-wrapper">';
        documentLibraryFileUpload +=
          '        <input class="file-path validate" type="text" placeholder="Attachment">';
        documentLibraryFileUpload += '      </div>';
        documentLibraryFileUpload += '    </div>';
        documentLibraryFileUpload += '  </td>';
        documentLibraryFileUpload += '  <td>';
        documentLibraryFileUpload +=
          '    <select class="browser-default custom-select" name="documentLibrary_AttachmentType[]" required>';
        documentLibraryFileUpload += '      <option disabled>Open this select menu</option>';
        if (tagID == 1) {
          documentLibraryFileUpload += '      <option value="1">Approved (Signed)</option>';
        }
        documentLibraryFileUpload += '      <option value="2">Fillable</option>';
        documentLibraryFileUpload += '      <option value="3">Raw File</option>';
        documentLibraryFileUpload += '    </select>';
        documentLibraryFileUpload += '  </td>';
        documentLibraryFileUpload +=
          '  <td><button type="button" class="btn btn-sm btn-danger px-3 remove_insertfileupload" data-row="row' +
          count + '"><i class="fa-solid fa-trash"></i></button></td>';
        documentLibraryFileUpload += '</tr>';
        $('#documentLibraryUpdate_FileUploads').append(documentLibraryFileUpload);
      });

      $(document).on('click', '.remove_insertfileupload', function() {
        var delete_row = $(this).data("row");
        $('#' + delete_row).remove();
      });

      $('#modalDocumentLibraryUpdate').modal('show');
      var documentLibraryID = $(this).data("id");

      $.ajax({
        dataType: 'JSON',
        type: 'POST',
        //documentlibrary/store
        url: 'documentlibrary/revision/' + documentLibraryID,
        data: documentLibraryID,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      }).done(function(data) {
        $(".completed").remove();
        $('.pdf_RevisionHistory').attr("href", '../extraction/library/' + documentLibraryID);
        $('#updateDocumentLibrary_ID').val(documentLibraryID);
        for (let i = 0; i < data.length; i++) {
          var documentLibraryRevision = '<li class="completed">';
          documentLibraryRevision += '<a>';
          documentLibraryRevision += '<span class="circle">+</span>';
          documentLibraryRevision += '<span class="label">Revision ' + data[i].revision + '';
          data[i].is_obsolete >= 1 ? documentLibraryRevision +=
            '<span class="badge badge-danger">Obsolete</span>' : documentLibraryRevision += '';
          documentLibraryRevision += '<br><span class="label" style="font-size: 10px;">Effective Date: ' + data[i]
            .effective_date + '</span>';
          documentLibraryRevision += '</span>';
          documentLibraryRevision += '</a>';

          documentLibraryRevision += '<div class="step-content grey lighten-3" style=" min-width:90%;">';
          documentLibraryRevision +=
            '<form class="md-form" action="documentrevision/file/store" method="POST" enctype="multipart/form-data">';
          documentLibraryRevision += '@csrf';
          documentLibraryRevision += '<table class="table table-sm  table_documentRevision' + data[i].id + '">';
          if ((userRoles.includes("1") == true || userRoles.includes("3") == true) && data[i].is_obsolete <= 0) {
            documentLibraryRevision += '<button data-id="' + data[i].id +
              '" style="text-align: center" type="button" class="btn btn-sm btn-info px-3 float-right attachment_documentRevision"><i class="fa-solid fa-plus"></i></button>';
          }


          for (var x = 0; x < data[i].document_file_revision.length; x++) {
            // If conditional is to show only file revision if the user has access/tagged
            if (userRoles.includes("1") == true || userRoles.includes("3") == true) {
              fetchAllFileRevision = data[i].document_file_revision[x].many_user_access.length < 99999
              fetchAllFileRevision_IsDeleted = data[i].document_file_revision[x].is_deleted < 99999
            } else {
              fetchAllFileRevision = data[i].document_file_revision[x].many_user_access.length >= 1
              fetchAllFileRevision_IsDeleted = data[i].document_file_revision[x].is_deleted == 0
            }
            // userRoles.includes("1") == true || userRoles.includes("3") == true ? fetchAllFileRevision = data[i].document_file_revision[x].many_user_access.length < 99999 : fetchAllFileRevision = data[i].document_file_revision[x].many_user_access.length >= 1

            if (fetchAllFileRevision) {
              if (fetchAllFileRevision_IsDeleted) {
                data[i].document_file_revision[x].is_stamped == 0 ? isStamped = 'btn-blue-grey' : isStamped =
                  'btn-success';
                data[i].document_file_revision[x].is_deleted == 0 ? isDeleted = 'btn-blue-grey' : isDeleted =
                  'btn-success';
                data[i].document_file_revision[x].is_discussed == 0 ? isDiscussed = 'btn-blue-grey' :
                  isDiscussed = 'btn-success';

                documentLibraryRevision += '<tr id="' + data[i].document_file_revision[x].document_revision_id +
                  '">';
                documentLibraryRevision += '<td>';
                $('attachment' + x).click(function() {
                  window.location.href = "file/'+data[i].document_file_revision[x].attachment_mask+'";
                });
                documentLibraryRevision += '<a data-id="" href="../file/' + data[i].document_file_revision[x]
                  .attachment_mask + '" target="_blank" id="' + data[i].document_file_revision[x].id +
                  '" data-file="' + data[i].document_file_revision[x].attachment +
                  '" style="text-align: center" type="button" class="btn btn-sm btn-success px-2 attachment' + x +
                  '">' + data[i].document_file_revision[x].attachment + '</a>';
                /* userRoles.includes("1") == true || userRoles.includes("3") == true ? documentLibraryRevision +=
                  'Password: ' + data[i].document_file_revision[x].file_password : documentLibraryRevision += ''; */
                documentLibraryRevision += '</td>';

                documentLibraryRevision += '<td>';
                if (data[i].document_file_revision[x].type == 1) {
                  documentLibraryRevisionType = "Approved (Signed)";
                } else if (data[i].document_file_revision[x].type == 2) {
                  documentLibraryRevisionType = "Fillable";
                } else if (data[i].document_file_revision[x].type == 3) {
                  documentLibraryRevisionType = "Raw File";
                }
                documentLibraryRevision += documentLibraryRevisionType;
                documentLibraryRevision += '</td>';

                documentLibraryRevision += '<td style="text-align: right;">';
                documentLibraryRevision += '<span class="label float-right" style="font-size: 10px;">' + data[i]
                  .document_file_revision[x].user.name + '</span><br>';
                documentLibraryRevision += '<span class="label float-right" style="font-size: 10px;">' + data[i]
                  .document_file_revision[x].user.created_at + '</span>';
                documentLibraryRevision += '</td>';

                documentLibraryRevision += '<td>';
                if (userRoles.includes("1") == true || userRoles.includes("3") == true) {
                  documentLibraryRevision += '<button data-id="' + data[i].document_file_revision[x].id +
                    '" title="Update User Access" style="text-align: center" type="button" class="btn btn-sm btn-info px-2 btn-documentFileRevision_UserAccess waves-effect waves-light"><i class="fa-solid fa-user"></i></button>';

                  if (tagID == 1) {
                    documentLibraryRevision += '<button data-id="' + data[i].document_file_revision[x].id +
                      '" id="' + data[i].document_file_revision[x].is_stamped +
                      '" title="Toggle Stamp On/Off" style="text-align: center" type="button" class="btn btn-sm ' +
                      isStamped +
                      ' px-2 btn-documentFileRevision_Stamp"><i class="fa-solid fa-stamp"></i></button>';
                  }

                  documentLibraryRevision += '<button data-id="' + data[i].document_file_revision[x].id +
                    '" id="' + data[i].document_file_revision[x].is_deleted +
                    '" title="Toggle File Archive On/Off" style="text-align: center" type="button" class="btn btn-sm ' +
                    isDeleted +
                    ' px-2 btn-documentFileRevision_Archive"><i class="fa-solid fa-trash"></i></button>';
                }

                var hasProcessOwner = [];
                var userProcessOwner = [];
                for (var y = 0; y < data[i].document_file_revision[x].many_user_access.length; y++) {
                  data[i].document_file_revision[x].many_user_access[y].is_acknowledged == 0 ? isAcknowledged =
                    'btn-blue-grey' : isAcknowledged = 'btn-success';

                  hasProcessOwner.push(data[i].document_file_revision[x].many_user_access[y].is_processowner);
                  userProcessOwner.push(data[i].document_file_revision[x].many_user_access[y].user_access);

                  if (data[i].document_file_revision[x].many_user_access[y].is_processowner == 1 && data[i]
                    .document_file_revision[x].many_user_access[y].user_access == userID) {
                    documentLibraryRevision += '<button data-id="' + data[i].document_file_revision[x].id +
                      '" data-attachment="' + data[i].document_file_revision[x].attachment + '" id="' + data[i]
                      .document_file_revision[x].is_discussed +
                      '" type="button" style="text-align: center; width: 100%;" title="Toggle Discussed On/Off" class="btn btn-sm ' +
                      isDiscussed + ' px-2 btn-documentFileRevision_Discussed">Discussed</button>';
                    //documentLibraryRevision += '<button data-id="'+data[i].document_file_revision[x].many_user_access[y].id+'" data-attachment="'+data[i].document_file_revision[x].attachment+'" id="'+data[i].document_file_revision[x].many_user_access[y].is_acknowledged+'" type="button" style="text-align: center; width: 100%;" title="Toggle Acknowledged On/Off" class="btn btn-sm '+isAcknowledged+' px-2 btn-documentFileRevision_Acknowledged">Acknowledged</button>';
                  }
                  if (data[i].document_file_revision[x].is_discussed == 1) {
                    if (data[i].document_file_revision[x].many_user_access[y].user_access == userID) {
                      if (userProcessOwner.find(element => element == userID)) {
                        if (userRoles.includes("1") != true || userRoles.includes("3") != true) {
                          documentLibraryRevision += '<button data-id="' + data[i].document_file_revision[x]
                            .many_user_access[y].id + '" data-attachment="' + data[i].document_file_revision[x]
                            .attachment + '" id="' + data[i].document_file_revision[x].many_user_access[y]
                            .is_acknowledged +
                            '" type="button" style="text-align: center; width: 100%;" title="Toggle Acknowledged On/Off" class="btn btn-sm ' +
                            isAcknowledged + ' px-2 btn-documentFileRevision_Acknowledged">Acknowledged</button>';
                        }
                      }
                    }
                  }
                }
                documentLibraryRevision += '</td>';
                documentLibraryRevision += '</tr>';
              }
            }
          }

          documentLibraryRevision += '</table>';
          documentLibraryRevision +=
            '<button type="submit" class="btn btn-sm btn-primary waves-effect waves-light attachment_documentRevisionSubmit">Submit</button>';
          documentLibraryRevision += '</form>';
          documentLibraryRevision += '</div>';
          documentLibraryRevision += '</li>';
          $('#documentLibraryRevision').append(documentLibraryRevision);
        }
        $('.attachment_documentRevisionSubmit').hide();

        $('.btn-documentRevision_ModalFilePreview').on('click', function(e) {
          $(".filePreview").remove();
          var fileName = $(this).data("file");
          var documentRevisionFilePreview = '<div class="filePreview">';
          /* requestEntryFilePreview += '<h6>{{ asset("storage/resource/uploads/iso/'+fileName+'") }}'+fileName+'</h6>'; */
          documentRevisionFilePreview += '<embed src="storage/resource/uploads/' + fileName +
            '#toolbar=0" style="width:100%;height:100vh;"/>';
          documentRevisionFilePreview += '</div>';
          /* $("#requestEntry_ModalFilePreviewLabel").replaceWith($(fileName)); */
          $('#documentRevision_ModalFilePreview').append(documentRevisionFilePreview);
          console.log(fileName);
        });

        $('.attachment_documentRevision').on('click', function(e) {
          count = count + 1;
          documentLibrary_ID = $(this).data("id");
          var documentRevisionFileUpload =
            documentRevisionFileUpload += '<tr id="row' + count + '">';
          documentRevisionFileUpload += '  <td>';
          documentRevisionFileUpload += '    <div class="file-field">';
          documentRevisionFileUpload += '      <div class="btn btn-primary btn-sm float-left">';
          documentRevisionFileUpload += '        <span>Choose file</span>';
          documentRevisionFileUpload +=
            '        <input type="file" name="documentLibrary_AttachmentRevision[]" required>';
          documentRevisionFileUpload += '      </div>';
          documentRevisionFileUpload += '      <div class="file-path-wrapper">';
          documentRevisionFileUpload +=
            '        <input class="file-path validate" type="text" placeholder="Attachment">';
          documentRevisionFileUpload += '      </div>';
          documentRevisionFileUpload += '    </div>';
          documentRevisionFileUpload += '  </td>';
          documentRevisionFileUpload += '  <td>';
          documentRevisionFileUpload +=
            '    <select class="browser-default custom-select" name="documentLibrary_AttachmentRevisionType[]" required>';
          documentRevisionFileUpload += '      <option disabled>Open this select menu</option>';
          if (tagID == 1) {
            documentRevisionFileUpload += '      <option value="1">Approved (Signed)</option>';
          }
          documentRevisionFileUpload += '      <option value="2">Fillable</option>';
          documentRevisionFileUpload += '      <option value="3">Raw File</option>';
          documentRevisionFileUpload += '    </select>';
          documentRevisionFileUpload += '  </td>';
          documentRevisionFileUpload += '  <td>';
          documentRevisionFileUpload += '  </td>';
          documentRevisionFileUpload +=
            '  <td><button type="button" class="btn btn-sm btn-danger px-2 remove_insertrevisionfileupload" data-row="row' +
            count + '"><i class="fa-solid fa-trash"></i></button></td>';
          documentRevisionFileUpload += '</tr>';
          $('.table_documentRevision' + documentLibrary_ID).append(documentRevisionFileUpload);
          $('.attachment_documentRevisionSubmit').show();
        });

        $(document).on('click', '.remove_insertrevisionfileupload', function() {
          var delete_row = $(this).data("row");
          $('#' + delete_row).remove();
        });

        $('.btn-documentFileRevision_UserAccess').on('click', function(e) {
          var documentRevisionID = $(this).data("id");
          $('#modalFileRevisionUsers').modal('show');
          $(".documentFileRevisionUserAccessSubmit").hide();
          $('#documentFileRevisionAccess_ID').val(documentRevisionID);

          $.ajax({
            dataType: 'JSON',
            type: 'POST',
            //documentlibrary/store
            url: 'documentrevision/user/access/' + documentRevisionID,
            data: documentRevisionID,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          }).done(function(data) {
            $(".userAccess").remove();
            $(".userAcknowledge").remove();
            for (var i = 0; i < data.length; i++) {
              var documentFileRevisionUserAccess = '<tr class="userAccess">';
              documentFileRevisionUserAccess += '<td>';
              documentFileRevisionUserAccess += data[i].user_access.name;
              documentFileRevisionUserAccess += '</td>';
              documentFileRevisionUserAccess += '<td>';
              documentFileRevisionUserAccess +=
                '<span class="label float-right" style="font-size: 10px;">' + data[i].user.name +
                '</span><br>';
              documentFileRevisionUserAccess +=
                '<span class="label float-right" style="font-size: 10px;">' + data[i].created_at +
                '</span>';
              documentFileRevisionUserAccess += '</td>';
              documentFileRevisionUserAccess += '<td width="5%">';
              /* if(data[i].can_view == 0){
                
              } else {

              } */
              data[i].can_view == 0 ? canView = 'btn-blue-grey' : canView = 'btn-success';
              data[i].can_print == 0 ? canPrint = 'btn-blue-grey' : canPrint = 'btn-success';
              data[i].can_fill == 0 ? canFill = 'btn-blue-grey' : canFill = 'btn-success';
              data[i].is_processowner == 0 ? isProcessOwner = 'btn-blue-grey' : isProcessOwner =
                'btn-success';

              //documentFileRevisionUserAccess += '<button data-state="'+data[i].can_view+'" id="'+data[i].id+'" data-id="'+data[i].id+'" title="Toggle View Privilege" style="text-align: center" type="button" class="btn btn-sm '+canView+' px-2 btn-documentFileRevision_CanView waves-effect waves-light"><i class="fa-solid fa-eye"></i></button>';
              documentFileRevisionUserAccess += '<button data-state="' + data[i].can_print + '" id="' +
                data[i].can_print + '" data-id="' + data[i].id +
                '" title="Toggle Print Privilege" style="text-align: center" type="button" class="btn btn-sm ' +
                canPrint +
                ' px-2 btn-documentFileRevision_CanPrint"><i class="fa-solid fa-print"></i></button>';
              documentFileRevisionUserAccess += '<button data-state="' + data[i].can_fill + '" id="' +
                data[i].can_fill + '" data-id="' + data[i].id +
                '" title="Toggle Fill-In Privilege" style="text-align: center" type="button" class="btn btn-sm ' +
                canFill +
                ' px-2 btn-documentFileRevision_CanFill"><i class="fa-solid fa-pen-to-square"></i></button>';
              documentFileRevisionUserAccess += '<button data-state="' + data[i].can_fill + '" id="' +
                data[i].is_processowner + '" data-id="' + data[i].id +
                '" title="Tag as Process Owner" style="text-align: center" type="button" class="btn btn-sm ' +
                isProcessOwner +
                ' px-2 btn-documentFileRevision_IsProcessOwner"><i class="fa-solid fa-user"></i></button>';
              documentFileRevisionUserAccess += '</td>';
              documentFileRevisionUserAccess += '</tr>';
              $('#documentFileRevisionUserAccess').append(documentFileRevisionUserAccess);

              if (data[i].is_acknowledged == 1) {
                var documentFileRevisionUserAcknowledge = '<tr class="userAcknowledge">';
                documentFileRevisionUserAcknowledge += '<td>';
                documentFileRevisionUserAcknowledge += data[i].user_access.name;
                documentFileRevisionUserAcknowledge += '</td>';
                documentFileRevisionUserAcknowledge += '</tr>';
                $('#documentFileRevisionUserAcknowledge').append(documentFileRevisionUserAcknowledge);
              }
            }

            /* $('#documentFileRevisionUserAccess').on('click', '.btn-documentFileRevision_CanView', function() {
              documentFileRevision_AccessID = $(this).data("id");

              if($(this).attr("id") == 0){
                $(this).attr("id", "1");
                documentFileRevision_AccessCanView = 1;
              } else {
                $(this).attr("id", "0");
                documentFileRevision_AccessCanView = 0;
              }

              $(this).toggleClass('btn-blue-grey')
                     .toggleClass('btn-success');
              
              edit_documentFileRevision_AccessID = {};
              edit_documentFileRevision_AccessID.documentFileRevision_AccessCanView = documentFileRevision_AccessCanView;
              $.ajax({
                type: 'PUT',
                url:  'documentrevision/user/access/'+documentFileRevision_AccessID+'/edit',
                data: edit_documentFileRevision_AccessID,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              });
            }); */


            $('#documentFileRevisionUserAccess').on('click', '#documentFileRevisionAccess_Users',
              function() {
                alert("asd");
                var documentFileRevisionAccess_UsersDropdown = '<option>d</option>';
                $('#documentFileRevisionAccess_UsersDropdown').append(
                  documentFileRevisionAccess_UsersDropdown);
              });

            /* $("#documentFileRevisionAccess_Users").click(function() {
              alert( "Handler for .click() called." );
            }); */

            /* $('#documentFileRevisionAccess_Users').on("click change", function(e) {
              alert("asd");

              if ($('option:selected', this).text() === "Users") {
                $('.documentFileRevisionUserAccessSubmit').hide();
              } else {
                $('.documentFileRevisionUserAccessSubmit').show();
              }
            }); */

            $("#documentFileRevisionAccess_Users").on({
              "change": function() {
                console.log("changed");
                if ($('option:selected', this).text() === "Users") {
                  $('.documentFileRevisionUserAccessSubmit').hide();
                } else {
                  $('.documentFileRevisionUserAccessSubmit').show();
                }
              },

              "focus": function() {
                alert("Handler for .click() called.");
              },

              "blur": function() {
                alert("Handler for .click() called.");
              }
            });

            $('#documentFileRevisionUserAccess').on('click', '.btn-documentFileRevision_CanPrint',
              function() {
                documentFileRevision_AccessID = $(this).data("id");

                if ($(this).attr("id") == 0) {
                  $(this).attr("id", "1");
                  documentFileRevision_AccessCanPrint = 1;
                } else {
                  $(this).attr("id", "0");
                  documentFileRevision_AccessCanPrint = 0;
                }

                $(this).toggleClass('btn-blue-grey')
                  .toggleClass('btn-success');

                edit_documentFileRevision_AccessID = {};
                edit_documentFileRevision_AccessID.documentFileRevision_AccessCanPrint =
                  documentFileRevision_AccessCanPrint;
                $.ajax({
                  type: 'PUT',
                  url: 'documentrevision/user/access/' + documentFileRevision_AccessID + '/edit',
                  data: edit_documentFileRevision_AccessID,
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                });
              });

            $('#documentFileRevisionUserAccess').on('click', '.btn-documentFileRevision_CanFill',
              function() {
                documentFileRevision_AccessID = $(this).data("id");

                if ($(this).attr("id") == 0) {
                  $(this).attr("id", "1");
                  documentFileRevision_AccessCanFill = 1;
                } else {
                  $(this).attr("id", "0");
                  documentFileRevision_AccessCanFill = 0;
                }

                $(this).toggleClass('btn-blue-grey')
                  .toggleClass('btn-success');

                edit_documentFileRevision_AccessID = {};
                edit_documentFileRevision_AccessID.documentFileRevision_AccessCanFill =
                  documentFileRevision_AccessCanFill;
                $.ajax({
                  type: 'PUT',
                  url: 'documentrevision/user/access/' + documentFileRevision_AccessID + '/edit',
                  data: edit_documentFileRevision_AccessID,
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                });
              });

            $('#documentFileRevisionUserAccess').on('click', '.btn-documentFileRevision_IsProcessOwner',
              function() {
                documentFileRevision_AccessID = $(this).data("id");

                if ($(this).attr("id") == 0) {
                  $(this).attr("id", "1");
                  documentFileRevision_IsProcessOwner = 1;
                } else {
                  $(this).attr("id", "0");
                  documentFileRevision_IsProcessOwner = 0;
                }

                $(this).toggleClass('btn-blue-grey')
                  .toggleClass('btn-success');

                edit_documentFileRevision_AccessID = {};
                edit_documentFileRevision_AccessID.documentFileRevision_IsProcessOwner =
                  documentFileRevision_IsProcessOwner;
                $.ajax({
                  type: 'PUT',
                  url: 'documentrevision/user/access/' + documentFileRevision_AccessID + '/edit',
                  data: edit_documentFileRevision_AccessID,
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                });
              });


            console.log(data);
          });
        });

        $('.btn-documentFileRevision_Stamp').on('click', function(e) {
          documentFileRevision_FileID = $(this).data("id");

          if ($(this).attr("id") == 0) {
            $(this).attr("id", "1");
            documentFileRevision_IsStamped = 1;
          } else {
            $(this).attr("id", "0");
            documentFileRevision_IsStamped = 0;
          }

          $(this).toggleClass('btn-blue-grey')
            .toggleClass('btn-success');

          edit_documentFileRevision_Stamp = {};
          edit_documentFileRevision_Stamp.documentFileRevision_IsStamped = documentFileRevision_IsStamped;

          $.ajax({
            type: 'PUT',
            url: 'documentrevision/file/' + documentFileRevision_FileID + '/edit',
            data: edit_documentFileRevision_Stamp,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          }).done(function(data) {
            if (data.is_stamped == 1) {
              toastr.success("Stamp for " + data.attachment + " is turned ON");
            } else {
              toastr.warning("Stamp for " + data.attachment + " is turned OFF");
            }
          });
        });

        $('.btn-documentFileRevision_Archive').on('click', function(e) {
          documentFileRevision_FileID = $(this).data("id");

          if ($(this).attr("id") == 0) {
            $(this).attr("id", "1");
            documentFileRevision_IsDeleted = 1;
          } else {
            $(this).attr("id", "0");
            documentFileRevision_IsDeleted = 0;
          }

          $(this).toggleClass('btn-blue-grey')
            .toggleClass('btn-danger');

          edit_documentFileRevision = {};
          edit_documentFileRevision.documentFileRevision_IsDeleted = documentFileRevision_IsDeleted;

          $.ajax({
            type: 'PUT',
            url: 'documentrevision/file/' + documentFileRevision_FileID + '/edit',
            data: edit_documentFileRevision,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          }).done(function(data) {
            if (data.is_deleted == 1) {
              toastr.success("Archive for " + data.attachment + " is turned ON");
            } else {
              toastr.warning("Archive for " + data.attachment + " is turned OFF");
            }
          });
        });

        $('.btn-documentFileRevision_Discussed').on('click', function(e) {
          if ($(this).attr("id") == 0) {
            Swal.fire({
              title: 'Are you sure?',
              //text: 'Has the document <b>('+$(this).data("attachment")+')</b> been discussed by the Process Owner?',
              icon: 'question',
              html: 'Confirm that the document <b>(' + $(this).data("attachment") +
                ')</b> has been discussed?',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                documentFileRevision_FileID = $(this).data("id");
                if ($(this).attr("id") == 0) {
                  $(this).attr("id", "1");
                  documentFileRevision_IsDiscussed = 1;
                } else {
                  $(this).attr("id", "0");
                  documentFileRevision_IsDiscussed = 0;
                }

                $(this).toggleClass('btn-blue-grey')
                  .toggleClass('btn-success');

                edit_documentFileRevision_Discuss = {};
                edit_documentFileRevision_Discuss.documentFileRevision_IsDiscussed =
                  documentFileRevision_IsDiscussed;

                $.ajax({
                  type: 'PUT',
                  url: 'documentrevision/file/' + documentFileRevision_FileID + '/edit',
                  data: edit_documentFileRevision_Discuss,
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                }).done(function(data) {
                  console.log(data);
                });

                Swal.fire(
                  'Discussed',
                  'The Document <b>(' + $(this).data("attachment") + ')</b> has been discussed.',
                  'success'
                )
              }
            })
          } else {
            Swal.fire({
              title: 'Are you sure?',
              //text: 'Has the document <b>('+$(this).data("attachment")+')</b> been discussed by the Process Owner?',
              icon: 'question',
              html: 'Confirm that the document <b>(' + $(this).data("attachment") +
                ')</b> has <b style="color: red;">NOT</b> been discussed?',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                documentFileRevision_FileID = $(this).data("id");
                if ($(this).attr("id") == 0) {
                  $(this).attr("id", "1");
                  documentFileRevision_IsDiscussed = 1;
                } else {
                  $(this).attr("id", "0");
                  documentFileRevision_IsDiscussed = 0;
                }

                $(this).toggleClass('btn-blue-grey')
                  .toggleClass('btn-success');

                edit_documentFileRevision_Discuss = {};
                edit_documentFileRevision_Discuss.documentFileRevision_IsDiscussed =
                  documentFileRevision_IsDiscussed;

                $.ajax({
                  type: 'PUT',
                  url: 'documentrevision/file/' + documentFileRevision_FileID + '/edit',
                  data: edit_documentFileRevision_Discuss,
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                }).done(function(data) {
                  console.log(data);
                });

                Swal.fire(
                  'Not Discussed',
                  'The Document <b>(' + $(this).data("attachment") +
                  ')</b> has <b style="color: red;">NOT</b> been discussed.',
                  'success'
                )
              }
            })
          }
        });

        $('.btn-documentFileRevision_Acknowledged').on('click', function(e) {
          if ($(this).attr("id") == 0) {
            Swal.fire({
              title: 'Are you sure?',
              //text: 'Has the document <b>('+$(this).data("attachment")+')</b> been discussed by the Process Owner?',
              icon: 'question',
              html: 'Has the document <b>(' + $(this).data("attachment") + ')</b> been discussed?',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                documentFileRevision_AccessID = $(this).data("id");
                if ($(this).attr("id") == 0) {
                  $(this).attr("id", "1");
                  documentFileRevision_IsAcknowledged = 1;
                } else {
                  $(this).attr("id", "0");
                  documentFileRevision_IsAcknowledged = 0;
                }

                $(this).toggleClass('btn-blue-grey')
                  .toggleClass('btn-success');

                edit_documentFileRevision_Acknowledge = {};
                edit_documentFileRevision_Acknowledge.documentFileRevision_IsAcknowledged =
                  documentFileRevision_IsAcknowledged;

                $.ajax({
                  type: 'PUT',
                  url: 'documentrevision/user/access/' + documentFileRevision_AccessID + '/edit',
                  data: edit_documentFileRevision_Acknowledge,
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                });

                Swal.fire(
                  'Acknowledged',
                  'The Document <b>(' + $(this).data("attachment") + ')</b> has been discussed.',
                  'success'
                )
              }
            })
          } else {
            Swal.fire({
              title: 'Are you sure?',
              //text: 'Has the document <b>('+$(this).data("attachment")+')</b> been discussed by the Process Owner?',
              icon: 'question',
              html: 'Has the <b style="color: red;">NOT</b> document <b>(' + $(this).data("attachment") +
                ')</b> been discussed by the Process Owner?',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                documentFileRevision_AccessID = $(this).data("id");
                if ($(this).attr("id") == 0) {
                  $(this).attr("id", "1");
                  documentFileRevision_IsAcknowledged = 1;
                } else {
                  $(this).attr("id", "0");
                  documentFileRevision_IsAcknowledged = 0;
                }

                $(this).toggleClass('btn-blue-grey')
                  .toggleClass('btn-success');

                edit_documentFileRevision_Acknowledge = {};
                edit_documentFileRevision_Acknowledge.documentFileRevision_IsAcknowledged =
                  documentFileRevision_IsAcknowledged;

                $.ajax({
                  type: 'PUT',
                  url: 'documentrevision/user/access/' + documentFileRevision_AccessID + '/edit',
                  data: edit_documentFileRevision_Acknowledge,
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                });

                Swal.fire(
                  'Acknowledged',
                  'The Document <b>(' + $(this).data("attachment") +
                  ')</b> has <b style="color: red;">NOT</b> been discussed.',
                  'success'
                )
              }
            })
          }

        });
      });
    });
  </script>




  <script>
    $(document).ready(function() {
      // Setup - add a text input to each footer cell
      $('#datatable thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#datatable thead');

      var datatable = $('#datatable').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        fixedColumns: {
          left: 1,
          right: 1
        },
        initComplete: function() {
          var api = this.api();

          // For each column
          api
            .columns()
            .eq(0)
            .each(function(colIdx) {
              // Set the header cell to contain the input element
              var cell = $('.filters th').eq(
                $(api.column(colIdx).header()).index()
              );
              var title = $(cell).text();
              $(cell).html('<input type="text" placeholder="' + title + '" />');

              // On every keypress in this input
              $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                .off('keyup change')
                .on('keyup change', function(e) {
                  e.stopPropagation();

                  // Get the search value
                  $(this).attr('title', $(this).val());
                  var regexr = '({search})'; //$(this).parents('th').find('select').val();

                  var cursorPosition = this.selectionStart;
                  // Search the column for that value
                  api
                    .column(colIdx)
                    .search(
                      this.value != '' ?
                      regexr.replace('{search}', '(((' + this.value + ')))') :
                      '',
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
        buttons: [{
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
            title: 'CSV_' + today,
            exportOptions: {
              columns: 'th:not(:last-child)'
            }
          },
          {
            extend: 'excel',
            text: 'EXCEL',
            className: 'btn btn-outline-white btn-rounded btn-sm px-2',
            title: 'EXCEL_' + today,
            exportOptions: {
              columns: 'th:not(:last-child)'
            }
          },
          {
            extend: 'pdf',
            text: 'PDF',
            className: 'btn btn-outline-white btn-rounded btn-sm px-2',
            title: 'PDF_' + today,
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
