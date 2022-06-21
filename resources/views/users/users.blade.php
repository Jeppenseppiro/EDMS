@extends('layouts.app')

@section('title', 'Users')

@section('head')
  <link href="{{ url('css/addons/datatables.min.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
  <div id="content" class="heavy-rain-gradient color-block content" style="padding-top: 20px; background-image: url('images/background.jpg');">
    <section>
      @include('includes.errormessage')

      <!-- User Insert -->
      <div class="modal fade" id="modalUserInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header warning-color">
              <h5 class="modal-title" id="exampleModalLabel">User Register</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form class="md-form" method="POST" action="add-user">
              @csrf
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-input-text prefix"></i>
                      <input type="text" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                      @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('name') }}</strong>
                        </span>
                      @endif
                      <label for="documentLibrary_Description">Name</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-input-text prefix"></i>
                      <input type="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                      @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                        </span>
                      @endif
                      <label for="documentLibrary_Description">Email</label>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-input-text prefix"></i>
                      <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                      @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('password') }}</strong>
                        </span>
                      @endif
                      <label for="password">Password</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-input-text prefix"></i>
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                      <label for="password-confirm">Confirm Password</label>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="company" name="company" class="mdb-select" searchable="Search category" required>
                          <option class="documentCategory_OptionDisabled" value="" disabled selected>Company</option>
                          @foreach ($companies as $company)
                            <option @if (old('company') == $company->id) selected @endif value={{ $company->id }}>({{ $company->company_code }}) | {{ $company->company_name }}</option>
                          @endforeach
                        </select>
                        <label class="mdb-main-label">Company</label>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-square-caret-down prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="department" name="department" class="mdb-select" searchable="Search category" required>
                          <option class="documentCategory_OptionDisabled" value="" disabled selected>Department</option>
                          @foreach ($departments as $department)
                            <option @if (old('department') == $department->id) selected @endif value={{ $department->id }}>{{ $department->department }}</option>
                          @endforeach
                        </select>
                        <label class="mdb-main-label">Department</label>
                      </div>
                    </div>
                  </div>
                </div>

                <br>

                <div class="row">
                  <div class="col-sm-12">
                    <p class="h2">Roles</p>
                    <select class="{{-- js-example-basic-multiple --}} chosen" name="role[]" multiple="multiple" placeholder="User Roles" required>
                      @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                {{-- <table class="fixed table-bordered table-sm" width="100%">
                  <thead>
                    <tr>
                      <th width="95%" scope="col">Roles</th>
                      <th width="5%" scope="col"><button type="button" class="btn btn-sm btn-info px-3" id="users_AddRole"><i class="fa-solid fa-plus"></i></button></th>
                    </tr>
                  </thead>
                  <tbody id="users_Roles">
                  </tbody>
                </table> --}}

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="" class="btn btn-primary">{{ __('Register') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- User Datatable -->
      <div class="row">
        <div class="col-xl-12 col-lg-7 mr-0 pb-2">
          <div class="card card-cascade narrower">
            <div class="row">
              <div class="col-xl-12 col-lg-12 mr-0 pb-2">
                <div class="view view-cascade gradient-card-header success-color narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">

                  <div>
                    <div id="usersDatatableButtons"></div>
                  </div>

                  <a href="" class="white-text mx-3">Users</a>

                  <div>
                    @if (auth()->user()->role == 1)
                      <button type="button" class="btn btn-outline-white btn-sm px-3 btn-userInsert" style="font-weight: bold;" data-toggle="modal" data-target="#modalUserInsert"><i class="fa-solid fa-plus"></i></button>
                    @endif
                  </div>

                </div>

                <div class="px-4">
                  <div class="table-responsive">

                    <table id="usersDatatable" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th class="th-sm" width="2%">ID</th>
                          <th class="th-sm" width="">Name</th>
                          <th class="th-sm" width="">Email Address</th>
                          <th class="th-sm" width="">Company</th>
                          <th class="th-sm" width="">Department</th>
                          <th class="th-sm" width="">Role</th>
                          <th class="th-sm" width="5%">Action</th>
                        </tr>
                      </thead>
                      @foreach ($users as $key => $user)
                        <tr>
                          <td>{{ $user->id }}</td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ $user->getCompany->company_name }}</td>
                          <td>{{ $user->getDepartment->department }}</td>
                          <td>
                            @php
                              $role = explode(',', $user->role);
                              $roles_data = $roles->pluck('id');
                              
                              // dd();
                              
                            @endphp
                            @foreach ($role as $rol)
                              @php
                                $res = array_search($rol, $roles_data->toArray());
                              @endphp
                              {{ $roles[$res]->name }} <br>
                            @endforeach
                          <td>
                            {{-- <button id="{{$key}}" data-id="userEdit{{$user->id}}" style="color: black; text-align: center" type="button" class="btn btn-sm btn-warning px-2 btn-userEdit"><i class="fa-solid fa-pen-line"></i></button> --}}
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
    $(document).ready(function() {
      $('.js-example-basic-multiple').select2();
    });

    $('.btn-userEdit').on('click', function(e) {
      var btnEdit_ID = $(this).attr('id');
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: 'POST',
            url: "lol.php",
            data: {
              btnEdit_ID: btnEdit_ID
            },
            success: function(resp) {
              if (resp.success) {
                swal.fire("Done!", resp.message, "success");
                location.reload();
              } else {
                swal.fire("Error!", 'Sumething went wrong.', "error");
              }
            },
            error: function(resp) {
              swal.fire("Error!", 'Something went wrong.', "error");
            }
          })
        }
      })
    });
  </script>
  <script>
    $(document).ready(function() {
      // Setup - add a text input to each footer cell
      /*  $('#usersDatatable thead tr')
           .clone(true)
           .addClass('filters')
           .appendTo('#usersDatatable thead'); */


      var usersDatatable = $('#usersDatatable').DataTable({
        orderCellsTop: true,
        fixedHeader: true,

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

      var buttons = new $.fn.dataTable.Buttons(usersDatatable, {
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
      }).container().appendTo($('#usersDatatableButtons'));
    });
  </script>
@endsection
