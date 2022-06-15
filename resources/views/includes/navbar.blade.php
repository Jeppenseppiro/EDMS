<header>
  <!-- Sidebar navigation -->
  <div id="slide-out" class="side-nav sn-bg-4 fixed">
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

      <li>
        <ul class="social">
          <li>
            @guest
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            @else
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <button type="button" class="btn btn-primary btn-sm">Logout</button>
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            @endguest


          </li>
        </ul>
      </li>

      <li>
        <ul class="collapsible collapsible-accordion">

          <li class="active">
            <a href="{{ route('dashboard') }}" class="waves-effect">
              <i class="w-fa fas fa-bars"></i>Dashboard
            </a>
          </li>

          <li>
            <a class="collapsible-header waves-effect arrow-r">
              <i class="w-fa fas fa-rectangle-list"></i>Documents<i class="fas fa-angle-down rotate-icon"></i>
            </a>
            <div class="collapsible-body">
              <ul>
                <li>
                  <ul class="collapsible collapsible-accordion mt-0">
                    <li><a class="collapsible-header waves-effect arrow-r">
                        <i class="fas fa-chevron-right"></i>Document Management</a>
                      <div class="collapsible-body">
                        <ul>
                          <li><a href="{{ url('documentrequest/iso') }}" class="waves-effect">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request Entry</a></li>

                          {{-- @if (in_array(1, $role) || in_array(8, $role)) --}}
                          <li><a href="{{ url('documentcopy/iso') }}" class="waves-effect">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request Copy</a></li>
                          {{-- @endif --}}

                          <li><a href="{{ url('documentlibrary/iso') }}" class="waves-effect">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Document Library</a></li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </li>
                <li>
                  <ul class="collapsible collapsible-accordion mt-0">
                    <li><a class="collapsible-header waves-effect arrow-r">
                        <i class="fas fa-chevron-right"></i>Legal</a>
                      <div class="collapsible-body">
                        <ul>
                          <li><a href="{{ url('documentrequest/legal') }}" class="waves-effect">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request Entry</a></li>
                          <li><a href="{{ url('documentcopy/legal') }}" class="waves-effect">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request Copy</a></li>
                          <li><a href="{{ url('documentlibrary/legal') }}" class="waves-effect">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Document Library</a></li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </li>
                <!--<li>
                  {{-- <a href="{{ route('documentrequest') }}" class="waves-effect"> --}}
                    {{-- <span class="sv-slim">DSB</span> --}}
                    <span class="sv-normal">Request Entry</span>
                  </a>
                </li>
                <li>
                  {{-- <a href="{{ route('documentcopy') }}" class="waves-effect"> --}}
                    {{-- <span class="sv-slim">DSB</span> --}}
                    <span class="sv-normal">Request Copy</span>
                  </a>
                </li>
                <li>
                  {{-- <a href="{{ route('documentlibrary') }}" class="waves-effect"> --}}
                    {{-- <span class="sv-slim">DSB</span> --}}
                    <span class="sv-normal">Document Library</span>
                  </a>
                </li>-->
                <li>
                  <a href="{{ route('permittingandlicenses') }}" class="waves-effect">
                    {{-- <span class="sv-slim">DSB</span> --}}
                    <span class="sv-normal">Permitting and Licenses</span>
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


          @if (auth()->user()->role == 1)
            <li>
              <a class="collapsible-header waves-effect arrow-r">
                <i class="w-fa fas fa-gears"></i>Configuration<i class="fas fa-angle-down rotate-icon"></i>
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
    <div class="sidenav-bg mask-strong"></div>
  </div>

  <nav class="navbar fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav">
    <div class="float-left">
      <a href="#" data-activates="slide-out" class="button-collapse"><i class="fas fa-bars"></i></a>
    </div>
    <div class="breadcrumb-dn mr-auto">
      <p>Electronic Document Management System</p>
    </div>
  </nav>
</header>
