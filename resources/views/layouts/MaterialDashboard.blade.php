<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
    Kotaku - Jawa Tengah-1
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="{{ asset('MaterialDashboard/css/material-dashboard.css?v=2.1.2') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css" integrity="sha384-VCmXjywReHh4PwowAiWNagnWcLhlEJLA5buUprzK8rxFgeH0kww/aWY76TfkUoSX" crossorigin="anonymous">

  <script src="{{ asset('js/jquery-3.4.1.min.js') }}" defer></script>
  
  @yield('head')

</head>

<body class="">
  <div class="wrapper ">


    <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
      -->
      <div class="logo"><a href="#" class="simple-text logo-normal">
        Kotaku - Jawa Tengah-1
      </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          @can('manage-users')
          <li class="nav-item active  ">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
              <i class="material-icons">dashboard</i>
              <p>Profil</p>
            </a>
          </li>
          @endcan
          <li class="nav-item active  ">
            <a class="nav-link" href="/kpp">
              <i class="material-icons">dashboard</i>
              <p>Data KPP</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
              <i class="material-icons">content</i>
              <p>Tambah Data</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
              <i class="material-icons">content</i>
              <p>Edit Data</p>
            </a>
          </li>
        </ul>
      </div>
    </div>



    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;"></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <form class="navbar-form">
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="javascript:;">
                  <i class="material-icons">dashboard</i>
                  <p class="d-lg-none d-md-block">
                    Stats
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <span class="notification"></span>
                  <p class="d-lg-none d-md-block">
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                </div>
              </li>
              <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                @can('manage-users')
                                <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                    User Management
                                </a>
                                @endcan
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->




      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">




              @yield('content')





            </div>

          </div>
        </div>
      </div>






        <!-- Footer -->
        <footer class="footer">
          <div class="container-fluid">
            <nav class="float-left">

            </nav>
            <div class="copyright float-right">
              &copy;
              <script>
              document.write(new Date().getFullYear())
              </script> Kotaku Jawa Tengah-1
              </div>
              </div>
              </footer>





              




              </div>
              </div>


              <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


          <form method="get" action="/kpp/create" enctype="multipart/form-data">

            @csrf

            <div class="data-group data-lokasi">
              <div class="form-group">
                <label for="kabupaten">
                  Kabupaten
                </label>
                <select name="kabupaten" id="kabupaten" class="form-control input-lg dynamic" required>
                  <option value="">Kabupaten</option>
                  @foreach($kabupaten as $kab)
                  <option value="{{$kab->kode_kab}}">{{$kab->nama_kab}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <select name="kecamatan" id="kecamatan" class="form-control input-lg dynamic" required>
                  <option value="">Kecamatan</option>
                </select>
              </div>
              <div class="form-group">
                <label for="kelurahan">
                  Kelurahan
                </label>
                <select name="kelurahan" id="kelurahan" class="form-control input-lg dynamic" required>
                  <option value="">Kelurahan</option>
                </select>
              </div>                
            </div>


            <div class="text-center">

              <button type="button" class="btn btn-primary mt-5" data-dismiss="modal" aria-label="Close">Batal</button>
              <button type="submit" class="btn btn-primary mt-5">Submit</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

              @yield('script')


              <script src="{{ asset('js/kpp/chaineddropdown.js') }}" defer></script>
              <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
              <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
              <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js" integrity="sha384-XEerZL0cuoUbHE4nZReLT7nx9gQrQreJekYhJD9WNWhH8nEW+0c5qq7aIo2Wl30J" crossorigin="anonymous"></script>


              </body>

              </html>
