<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <title>EDMS | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{asset('edms.png')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="{{ url('fontawesome6/css/all.css') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/addons-pro/timeline.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/addons-pro/timeline.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/filepond.css') }}" rel="stylesheet"> --}}
    {{-- <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" /> --}}
    @yield('head')
    <style>
      .content {
        min-height: 100vh;
        height: auto;
        transition: all 0.2s ease-in-out;
      }
      .button-collapse {
        position: fixed;
      }
      header, section {
        padding: 20px;
      }
      .card {
        width: 100%;
        margin-bottom: 15px;
        color: #000;
      }
      @media(min-width: 1440px) {
        .content {
          padding-left: 250px;
        }
      }
      @media(max-width: 720px) {
        .main-header {
          font-size: 260%;
        }
      }
    </style>
    @yield('style')
  </head>

  <body class="cyan-skin fixed-sn">
    <div id="mdb-preloader" class="flex-center">
      {{-- <div class="preloader-wrapper active"> --}}
        <div class="spinner-border text-primary" style="width: 20rem; height: 20rem; font-size: 100px;" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      {{-- </div> --}}
    </div>
    {{-- <div class="spinner">
      <div class="spinner-border text-primary" role="status">
      </div>
    </div> --}}
    @include('includes.navbar')
    @yield('content')
  </body>

  {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
  <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/popper.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/mdb.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/addons-pro/timeline.min.js') }}" type="text/javascript"></script>
  {{-- <script src="{{ asset('ckeditor5-build-classic/ckeditor.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/filepond.js') }}" type="text/javascript"></script> --}}
  
  {{-- <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

  <script src="{{ url('js/addons/datatables.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/datatables/dataTables.buttons.min.js')}}"></script>
  <script src="{{ asset('js/buttons.html5.min.js')}}"></script>
  <script src="{{ asset('js/buttons.print.min.js')}}"></script>
  <script src="{{ asset ('js/jszip/jszip.min.js')}}"></script>
  <script src="{{ asset('js/pdfmake/pdfmake.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  
  {{-- <script src="filepond.min.js"></script>
  <script src="filepond.jquery.js"></script> --}}
  {{-- <script>
    CKEDITOR.replace('sample-editor');
  </script> --}}
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script>
    $(window).on('load', function() {
      $('#mdb-preloader').delay(100).fadeOut(300);
    });

    $(document).ready(function() {
      // SideNav Button Initialization
      $(".button-collapse").sideNav({
        slim: true
      });
      // SideNav Scrollbar Initialization
      var sideNavScrollbar = document.querySelector('.custom-scrollbar');
      var ps = new PerfectScrollbar(sideNavScrollbar);
    })
    
    var container = document.querySelector('.custom-scrollbar');
    var ps = new PerfectScrollbar(container, {
      wheelSpeed: 2,
      wheelPropagation: true,
      minScrollbarLength: 20
    });

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth()+1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = mm + '/' + dd + '/' + yyyy;

    // Data Picker Initialization
    $('.datepicker').pickadate({
      min: new Date(yyyy,mm,dd),
      format: 'yyyy-mm-dd',
      formatSubmit: 'yyyy-mm-dd',
    });

    // Material Select Initialization
    $(document).ready(function() {
      $('.mdb-select').materialSelect();
    });

    // Tooltips Initialization
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    $('.errorMessage').trigger('click');
    // What You See Is What You Get (WYSIWYG) Text Editor
    //$("#demo").mdbWYSIWYG();
  </script>
  
  @yield('script')
</html>