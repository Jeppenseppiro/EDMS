<header>
  <!-- <a href="#" data-activates="slide-out" class="btn btn-primary p-3 button-collapse"><i class="fas fa-bars"></i></a> -->
  <div id="slide-out" class="side-nav sn-bg-1 fixed">
    <ul class="custom-scrollbar">
      <li style="padding-top: 10px;">
        <table class="table table-borderless table-sm">
          <tbody>
            <tr>
              <td width="40%" rowspan="2">
                <a href="#">
                  <img src="https://stonegatesl.com/wp-content/uploads/2021/01/avatar.jpg" class="img-fluid flex-center" style="height: 60px;">
                </a>
              </td>
              <td class="text-break" style="color: white;">{{ Auth::user()->name }}</td>
            </tr>
            {{-- <tr>
              <td class="text-break" style="color: white;">Web Developer</td>
            </tr> --}}
          </tbody>
        </table>
      </li>

      <hr style="border: 1px solid grey;">
      
      <li>
        <ul class="collapsible collapsible-accordion">

          <li class="active">
            <a href="{{ route('dashboard') }}" class="waves-effect">
              <i class="w-fa fas fa-tachometer-alt"></i>Dashboard
            </a>
          </li>
          
          <li>
            <a class="collapsible-header waves-effect arrow-r">
              <i class="w-fa fas fa-tachometer-alt"></i>Documents<i class="fas fa-angle-down rotate-icon"></i>
            </a>
            <div class="collapsible-body">
              <ul>
                <li>
                  <a href="{{ route('documentrequest') }}" class="waves-effect">
                    {{-- <span class="sv-slim">DSB</span> --}}
                    <span class="sv-normal">Request Entry</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('documentcopy') }}" class="waves-effect">
                    {{-- <span class="sv-slim">DSB</span> --}}
                    <span class="sv-normal">Request Copy</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('documentlibrary') }}" class="waves-effect">
                    {{-- <span class="sv-slim">DSB</span> --}}
                    <span class="sv-normal">Document Library</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('etransmittal') }}" class="waves-effect">
                    {{-- <span class="sv-slim">DSB</span> --}}
                    <span class="sv-normal">E-Transmittal</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          

          @if(auth()->user()->role == 1)
            <li>
              <a class="collapsible-header waves-effect arrow-r">
                <i class="w-fa fas fa-tachometer-alt"></i>Configuration<i class="fas fa-angle-down rotate-icon"></i>
              </a>
              <div class="collapsible-body">
                <ul>
                  {{-- <li>
                    <a href="" class="waves-effect">
                      <span class="sv-normal">Document Entry</span>
                    </a>
                  </li>
                  <li>
                    <a href="" class="waves-effect">
                      <span class="sv-normal">Document Post</span>
                    </a>
                  </li> --}}
                  <li>
                    <a href="{{ route('users.index') }}" class="waves-effect">
                      <span class="sv-normal">Users</span>
                    </a>
                  </li>
                  {{-- <li>
                    <a href="" class="waves-effect">
                      <span class="sv-normal">Obsolete</span>
                    </a>
                  </li> --}}
                </ul>
              </div>
            </li>
          @endif
          <!-- <li>
            <a class="collapsible-header waves-effect arrow-r">
              <i class="w-fa fas fa-tachometer-alt"></i>Masterfiles<i class="fas fa-angle-down rotate-icon"></i>
            </a>
            <div class="collapsible-body">
              <ul>
                <li>
                  <a href="#" class="waves-effect">
                    <span class="sv-slim">CMP</span>
                    <span class="sv-normal">Company Setup</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="waves-effect">
                    <span class="sv-slim">CLS</span>
                    <span class="sv-normal">Classification Setup</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="waves-effect">
                    <span class="sv-slim">DCT</span>
                    <span class="sv-normal">Document Setup</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="waves-effect">
                    <span class="sv-slim">DSH</span>
                    <span class="sv-normal">Dashboard</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <a class="collapsible-header waves-effect arrow-r">
              <i class="w-fa fas fa-image"></i>Documents<i class="fas fa-angle-down rotate-icon"></i>
            </a>
            <div class="collapsible-body">
              <ul>
                <li>
                  <a href="#" class="waves-effect">
                    <span class="sv-slim">ENT</span>
                    <span class="sv-normal">Document Entry</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="waves-effect">
                    <span class="sv-slim">PST</span>
                    <span class="sv-normal">Document Post</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="waves-effect">
                    <span class="sv-slim">VW</span>
                    <span class="sv-normal">Document View</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="waves-effect">
                    <span class="sv-slim">OBS</span>
                    <span class="sv-normal">Obsolete</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <a class="collapsible-header waves-effect arrow-r">
              <i class="w-fa fas fa-user"></i>Reports<i class="fas fa-angle-down rotate-icon"></i>
            </a>
            <div class="collapsible-body">
              <ul>
                <li>
                  <a href="#" class="waves-effect">
                    <span class="sv-slim">LST</span>
                    <span class="sv-normal">Document List</span>
                  </a>
                </li>
              </ul>
            </div>
          </li> -->
          <!-- <li><a id="toggle" class="waves-effect minimize-sidenav"><i class="sv-slim-icon fas fa-angle-double-left"></i>Minimize Menu</a></li> -->
        </ul>
      </li>
    </ul>
    <div class="sidenav-bg rgba-blue-strong"></div>
  </div>
  
  <nav class="navbar fixed-top navbar-expand-lg scrolling-navbar double-nav">
    <div class="float-left">
      <a href="#" data-activates="slide-out" class="button-collapse"><i class="fas fa-bars"></i></a>
    </div>

    <div class="breadcrumb-dn mr-auto">
      <p>Electronic Data Management System</p>
    </div>

    <div class="d-flex change-mode">
      <!-- <div class="ml-auto mb-0 mr-3 change-mode-wrapper">
        <button class="btn btn-outline-black btn-sm" id="dark-mode">Change Mode</button>
      </div> -->

      <ul class="nav navbar-nav nav-flex-icons ml-auto">

        {{-- <li class="nav-item dropdown notifications-nav">
          <a class="nav-link dropdown-toggle waves-effect" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="badge red">3</span> <i class="fas fa-bell"></i>
            <span class="d-none d-md-inline-block">Notifications</span>
          </a>
          <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">
              <i class="far fa-money-bill-alt mr-2" aria-hidden="true"></i>
              <span>New order received</span>
              <span class="float-right"><i class="far fa-clock" aria-hidden="true"></i> 13 min</span>
            </a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link waves-effect"><i class="fas fa-envelope"></i> <span
              class="clearfix d-none d-sm-inline-block">Contact</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link waves-effect"><i class="far fa-comments"></i> <span
              class="clearfix d-none d-sm-inline-block">Support</span></a>
        </li> --}}
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle waves-effect" href="#" id="userDropdown" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"></i> <span class="clearfix d-none d-sm-inline-block">Profile</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            @guest
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            @else
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            @endguest
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <!-- <div class="fixed-action-btn clearfix d-none d-xl-block" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-lg red">
        <i class="fas fa-pencil-alt"></i>
    </a>

    <ul class="list-unstyled">
        <li><a class="btn-floating red"><i class="fas fa-star"></i></a></li>
        <li><a class="btn-floating yellow darken-1"><i class="fas fa-user"></i></a></li>
        <li><a class="btn-floating green"><i class="fas fa-envelope"></i></a></li>
        <li><a class="btn-floating blue"><i class="fas fa-shopping-cart"></i></a></li>
    </ul>
  </div> -->
</header>