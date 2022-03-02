<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="{{ url('fontawesome6/css/all.css') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/addons-pro/timeline.css') }}" rel="stylesheet">
    <link href="{{ asset('css/addons-pro/timeline.min.css') }}" rel="stylesheet">
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
  </head>

  <body class="black-skin fixed-sn">
    @include('includes.navbar')
    @yield('content')
  </body>

  {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
  <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/popper.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/mdb.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/addons-pro/timeline.js') }}" type="text/javascript"></script>
  <script src="{{ asset('ckeditor5-build-classic/ckeditor.js') }}" type="text/javascript"></script>
  <script>
    CKEDITOR.replace('sample-editor');
  </script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @yield('script')
  <script>
    // SideNav Initialization
    $(document).ready(function() {
      let isOpen = false;
      let $windowWidth = $( window ).width();
      const $btnCollapse = $(".button-collapse");
      const $content = $('#content');
      
      $( window ).resize(function() { 

        $windowWidth = $( window ).width(); 
        if($windowWidth > 1440) {
          $content.css('padding-left', '250px');
          if(isOpen) {
            $btnCollapse.css('left', '0');
            isOpen = false; 
          }
        } else if($windowWidth < 530 && isOpen) {
          $btnCollapse.css('left', '0');
          $content.css('padding-left', '0');
          $('#sidenav-overlay').css('display', 'block'); 
          $btnCollapse.trigger('click');
        } else {
          if(!isOpen) {
            $content.css('padding-left', '0'); 
          }
        }
      });

      // SideNav Button Initialization
      $btnCollapse.sideNav(); 
      
      $btnCollapse.on('click', () => { 
      isOpen = !isOpen;
      if($windowWidth > 530) {
        const elPadding = isOpen ? '250px' : '0';
        $btnCollapse.css('left', elPadding);
        $content.css('padding-left', elPadding);
        $('#sidenav-overlay').css('display', 'none');
      } else {
        $('#sidenav-overlay').on('click', () => {
          isOpen = !isOpen;
        });
      }    	
      }); 
      $('#sidenav-overlay').on('click', () => {
        isOpen = !isOpen;
      });
    });
    
    var container = document.querySelector('.custom-scrollbar');
    var ps = new PerfectScrollbar(container, {
      wheelSpeed: 2,
      wheelPropagation: true,
      minScrollbarLength: 20
    });

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth()).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = mm + '/' + dd + '/' + yyyy;

    // Data Picker Initialization
    $('.datepicker').pickadate({
      min: new Date(yyyy,mm,dd)
    });

    // Material Select Initialization
    $(document).ready(function() {
      $('.mdb-select').materialSelect();
    });

    // Tooltips Initialization
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    // What You See Is What You Get (WYSIWYG) Text Editor
    $("#demo").mdbWYSIWYG();
  </script>
</html>