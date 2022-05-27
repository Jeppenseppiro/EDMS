@extends('layouts.app')

@section('title', 'E-Transmittal')

@section('head')
  <link href="{{ url('css/addons/datatables.min.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
  <div id="content" class="heavy-rain-gradient color-block content" style="padding-top: 20px;">
    <section>

      <!-- E-Transmittal (INSERT/EDIT) -->
      <div class="modal fade" id="modalEtransmittalInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header warning-color">
              <h5 class="modal-title" id="exampleModalLabel">New E-Transmittal</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="md-form" action="etransmittal/store" method="POST" enctype="multipart/form-data">
              @csrf
              <input id="etransmittal_UserID" name="etransmittal_UserID" type="hidden" value="{{ Auth::user()->id }}"/>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="md-form">
                      <i class="fa-solid fa-input-text prefix"></i>
                      <input type="text" id="etransmittal_Item" name="etransmittal_Item" class="form-control" required>
                      <label for="etransmittal_Item">Item</label>
                    </div>
                  </div>
                </div>                

                <div class="row">
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-address-card prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="etransmittal_Status" name="etransmittal_Status" class="mdb-select" searchable="Search status" required>
                          <option class="mr-1" value="Shipped" disabled selected>Status</option>
                          <option value="Shipped">Shipped</option>
                          {{-- <option value="Received">Received</option> --}}
                        </select>
                        <label class="mdb-main-label">Status</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="md-form">
                      <i class="fa-solid fa-address-card prefix"></i>
                      <div class="md-form py-0 ml-5">
                        <select id="etransmittal_Recipient" name="etransmittal_Recipient" class="mdb-select" searchable="Search recipient" required>
                          <option class="mr-1" value="" disabled selected>Recipient</option>
                          @foreach ($users as $user)
                            <option value={{$user->id}}>{{$user->name}}</option>
                          @endforeach
                        </select>
                        <label class="mdb-main-label">Recipient</label>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-sm-12 etransmittal_FileUpload">
                    <div class="file-field">
                      <div class="btn btn-primary btn-sm float-left">
                        <span>Choose file</span>
                        <input type="file" name="etransmittal_Attachment" required>
                      </div>
                      <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Attachment">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="" class="btn btn-primary btn-etransmittalSubmitInsert">Submit</button>
                <button type="submit" id="" class="btn btn-primary btn-etransmittalSubmitUpdate">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- E-Transmittal (UPDATE) -->
      <div class="modal fade" id="modalEtransmittalUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header warning-color">
              <h5 class="modal-title" id="exampleModalLabel">Update E-Transmittal</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="md-form" id="updateRequestISOEntry" action="{{ route('etransmittal_history_store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <input id="updateEtransmittal_ID" name="updateEtransmittal_ID" type="hidden" value=""/>
                <div class="container">
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="md-form">
                        <i class="fa-solid fa-address-card prefix"></i>
                        <div class="md-form py-0 ml-5">
                          <select id="updateEtransmittal_Status" name="updateEtransmittal_Status" class="mdb-select" searchable="Search status" required>
                            <option class="mr-1" value="" disabled selected>Status</option>
                            {{-- <option value="Shipped">Shipped</option> --}}
                            <option value="Received">Received</option>
                          </select>
                          <label class="mdb-main-label">Status</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-8">
                      <div class="md-form">
                        <i class="fa-solid fa-align-left prefix"></i>
                        <input type="text" id="updateEtransmittal_Remarks" name="updateEtransmittal_Remarks" class="form-control">
                      <label for="updateEtransmittal_Remarks">Remarks</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 updateEtransmittal_FileUpload">
                      <div class="file-field">
                        <div class="btn btn-primary btn-sm float-left">
                          <span>Choose file</span>
                          <input type="file" id="updateEtransmittal_Attachment" name="updateEtransmittal_Attachment" required>
                        </div>
                        <div class="file-path-wrapper">
                          <input class="file-path validate" type="text" placeholder="Attachment">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <ul id="etransmittalHistory" class="stepper stepper-vertical">
                  {{-- <input id="" type="text" value="{{$request_iso_history->id}}"/> --}}
                </ul>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="" class="btn btn-primary btn-etransmittalUpdate">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Etransmittal Datatable -->
      <div class="row">
        <div class="col-xl-12 col-lg-7 mr-0 pb-2">
          <div class="card card-cascade narrower">
            <div class="row">
              <div class="col-xl-12 col-lg-12 mr-0 pb-2">
                <div class="view view-cascade gradient-card-header success-color narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">

                  <div>
                    <div id="datatableButtons"></div>
                  </div>

                  <b style="font-size: 24px;" class="float-left">E-Transmittal Entries</b>

                  <div>
                  {{-- @if(auth()->user()->role != 2) --}}
                    <button type="button" class="btn btn-outline-white btn-sm px-3 btn-etransmittalInsert" style="font-weight: bold;" data-toggle="modal" data-target="#modalEtransmittalInsert"><i class="fa-solid fa-plus"></i></button>
                  {{-- @endif --}}
                  </div>

                </div>

                <div class="px-4">
                  <div class="table-responsive">

                    <table id="datatable" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th class="th-sm" width="">Code</th>
                          <th class="th-sm" width="">Item</th>
                          <th class="th-sm" width="">Shipper</th>
                          <th class="th-sm" width="">Shipper Company</th>
                          <th class="th-sm" width="">Shipper Department</th>
                          <th class="th-sm" width="">Recipient</th>
                          <th class="th-sm" width="">Recipient Company</th>
                          <th class="th-sm" width="">Recipient Department</th>
                          <th class="th-sm" width="">Created At</th>
                          <th class="th-sm" width="">Action</th>
                        </tr>
                      </thead>
                      <tbody id="fileUpload">
                        @foreach ($etransmittals as $key => $etransmittal)
                          <tr>
                            <td>{{str_pad($etransmittal->id, 3, '0', STR_PAD_LEFT)}}</td>
                              {{-- {{$etransmittal->code}} --}}
                            <td>{{$etransmittal->item}}</td>
                            <td>{{$etransmittal->getUser->name}}</td>
                            <td>{{$etransmittal->getUser->getCompany->company_name}}</td>
                            <td>{{$etransmittal->getUser->getDepartment->department}}</td>
                            <td>{{$etransmittal->getRecipient->name}}</td>
                            <td>{{$etransmittal->getRecipient->getCompany->company_name}}</td>
                            <td>{{$etransmittal->getRecipient->getDepartment->department}}</td>
                            <td>{{date_format($etransmittal->created_at,"Y-m-d H:i:s")}}</td>
                            <td>
                              <button id="{{$key}}" data-id="{{$etransmittal->id}}" style="text-align: center" type="button" class="btn btn-sm btn-success px-2 btn-etransmittal_View" title="Update E-Transmittal"><i class="fa-solid fa-arrows-rotate"></i></button>
                              {{-- <button id="{{$key}}" data-id="{{$etransmittal->id}}" style="color: black; text-align: center" type="button" class="btn btn-sm btn-warning px-2 btn-etransmittal_Edit" title="Edit E-Transmittal"><i class="fa-solid fa-pen-line"></i></button> --}}
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>
@endsection

@section('script')
  <script>
    etransmittalJSON =  {!! json_encode($etransmittals->toArray()) !!};
    
    //#region E-Transmittal Update Function
    $('.btn-etransmittal_View').on('click', function(e){
      $('#modalEtransmittalUpdate').modal('show');
      
      var etransmittal_ID = $(this).data('id');
      $('#updateEtransmittal_ID').val(etransmittal_ID).trigger("change");

      $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url:  'etransmittal/history/'+etransmittal_ID,
        data: etransmittal_ID,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      }).done(function(data){
        $(".completed").remove();
        for(var i = 0; i < data.length; i++){
          var etransmittalHistory = '<li class="completed">';
              etransmittalHistory += '<a>';
              etransmittalHistory += '<span class="circle">+</span>';
              etransmittalHistory += '<span class="label">'+data[i].status+'</span>';
              etransmittalHistory += '</a>';
              etransmittalHistory += '<div class="step-content" style="background-color: #e8e8e8; min-width:90%;">';
              if(data[i].remarks){
                etransmittalHistory += '<p>'+data[i].remarks+'</p>';
              }
              etransmittalHistory += '<hr>';
              etransmittalHistory += '<div class="row">';
              etransmittalHistory += '<div class="col-sm">';
              etransmittalHistory += '<a target="_blank" href="file/etransmittal/'+data[i].attachment_mask+'"  id="'+data[i].id+'" data-file="'+data[i].attachment+'" style="text-align: center" type="button" class="btn btn-sm btn-success px-2">'+data[i].attachment+'</a>';
              etransmittalHistory += '</div>';
              etransmittalHistory += '<div class="col-sm">';
              etransmittalHistory += '<span class="label float-right" style="font-size: 10px;">'+data[i].get_user.name+'</span><br>';
              etransmittalHistory += '<span class="label float-right" style="font-size: 10px;">'+data[i].created_at+'</span>';
              etransmittalHistory += '</div>';
              etransmittalHistory += '</div>';
              etransmittalHistory += '</div>';
              etransmittalHistory += '</li>';

          $('#etransmittalHistory').append(etransmittalHistory);
        }
        console.log(data);
      });
    });

    $('.btn-etransmittalInsert').on('click', function(e){
      $(".btn-etransmittalSubmitInsert").css({display: "block"});
      $(".btn-etransmittalSubmitUpdate").css({display: "none"});

      $('#etransmittal_Item').val("").trigger("change");
      $('#etransmittal_Status').val("").trigger("change");
      $('#etransmittal_Recipient').val("").trigger("change");
    });

    //#region E-Transmittal Edit Function
    $('.btn-etransmittal_Edit').on('click', function(e){
      $('#modalEtransmittalInsert').modal('show');
      $(".btn-etransmittalSubmitInsert").css({display: "none"});
      $(".btn-etransmittalSubmitUpdate").css({display: "block"});
      
      var etransmittal_array = $(this).attr('id');
      $('#etransmittal_Item').val(etransmittalJSON[etransmittal_array].item).trigger("change");
      $('#etransmittal_Status').val(etransmittalJSON[etransmittal_array].get_etransmittal_history.status).trigger("change");
      $('#etransmittal_Recipient').val(etransmittalJSON[etransmittal_array].recipient).trigger("change");
      
    });
  </script>

  <script>
    $(document).ready(function () {
      // Setup - add a text input to each footer cell
      $('#datatable thead tr')
          .clone(true)
          .addClass('filters')
          .appendTo('#datatable thead');

      var datatable = $('#datatable').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        fixedColumns:   {
            left: 1,
            right: 1
        },
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
      }).container().appendTo($('#datatableButtons'));
    });
  </script>
@endsection