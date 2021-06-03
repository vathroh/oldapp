<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        OSP 1 Jawa Tengah
    </title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href=" {{ asset('MaterialDashboard/css/material-dashboard.css?v=2.1.2') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/e3a45180d4.js" crossorigin="anonymous"></script>
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('MaterialDashboard/img/sidebar-1.jpg') }}">
        <!--
            Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

            Tip 2: you can also add an image using data-image tag
        -->
        <div class="logo"><a href="http://www.osp1.my.id" class="simple-text logo-normal">
            OSP 1 Jawa Tengah 1
        </a></div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li class="nav-item  ">
                    <a class="nav-link" href="./dashboard.html">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item active ">
                    <a class="nav-link" href="./user.html">
                        <i class="material-icons">person</i>
                        <p>Profil</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./tables.html">
                        <i class="fas fa-address-book"></i>
                        <p>Fasilitator</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./typography.html">
                        <i class="fas fa-map-marked-alt"></i>
                        <p>Wilayah Kerja</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./icons.html">
                        <i class="fas fa-users"></i>
                        <p>Manajemen Tim</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./icons.html">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Kategori Wilayah</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./icons.html">
                        <i class="fas fa-file-contract"></i>
                        <p>Evaluasi Kinerja</p>
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
                    <a class="navbar-brand" href="javascript:;">User Profile</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
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
                                <span class="notification">5</span>
                                <p class="d-lg-none d-md-block">
                                    Some Actions
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">Another Notification</a>
                                <a class="dropdown-item" href="#">Another One</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">person</i>
                                <p class="d-lg-none d-md-block">
                                    Account
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <!-- End Navbar -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#0">Data Diri</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#0">Kontak & Sosial Media</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#0">Riwayat Pekerjaan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#0">Pendidikan</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                             <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">No. KTP</label>
                                            <input type="text" class="form-control" value="{{$fasilitator['front_title'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Usia</label>
                                            <input type="text" class="form-control" value="{{$fasilitator['front_title'] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Gelar Depan</label>
                                            <input type="text" class="form-control" value="{{$fasilitator['front_title'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Nama</label>
                                            <input type="text" class="form-control" value="{{ $fasilitator['name'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Gelar Belakang</label>
                                            <input type="text" class="form-control" value="{{ $fasilitator['back_title'] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Jenis Kelamin</label>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                <select class="form-control"  id="exampleFormControlSelect1">
                                                    <option>Pilih</option>
                                                    <option>Laki-Laki</option>
                                                    <option>Perempuan</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Agama</label>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control"  id="exampleFormControlSelect1">
                                                    <option>Pilih</option>
                                                    <option>Islam</option>
                                                    <option>Protestan</option>
                                                    <option>Katolik</option>
                                                    <option>Hindu</option>
                                                    <option>Buddha</option>
                                                    <option>Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Tempat Lahir</label>
                                            <input type="text" class="form-control" value="{{$fasilitator['front_title'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group text-center">
                                            <label class="bmd-label-floating">Tanggal Lahir</label>
                                            <input type="date" class="form-control" value="{{$fasilitator['front_title'] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Alamat</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Provinsi</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Kabupaten</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Kecamatan</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Kelurahan/Desa</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary pull-right">Update Profile</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header card-header-primary">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" href="#0">Data Diri</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#0">Kontak & Sosial Media</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#0">Riwayat Pekerjaan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#0">Pendidikan</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">
                                                <i class="fab fa-whatsapp"></i> HP/Whatsapp
                                            </label>
                                            <input type="text" class="form-control" value="{{$fasilitator['front_title'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">
                                                <i class="fab fa-telegram"></i> Telegram</label>
                                            <input type="text" class="form-control" value="{{$fasilitator['front_title'] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">
                                                <i class="fab fa-facebook-square"></i>
                                                    Facebook
                                                </label>
                                            <input type="text" class="form-control" value="{{$fasilitator['front_title'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">
                                                <i class="fab fa-instagram"></i> Instagram</label>
                                            <input type="text" class="form-control" value="{{$fasilitator['front_title'] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">
                                                <i class="fab fa-twitter"></i> Twitter</label>
                                            <input type="text" class="form-control" value="{{$fasilitator['front_title'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">
                                                <i class="fab fa-linkedin"></i> Linkedin
                                            </label>
                                            <input type="text" class="form-control" value="{{$fasilitator['front_title'] }}">
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">
                                                <i class="fas fa-envelope-square"></i> Email
                                            </label>
                                            <input type="text" class="form-control" value="{{$fasilitator['front_title'] }}">
                                        </div>
                                    </div>
                                </div>                               
                                <button type="submit" class="btn btn-primary pull-right">Update Profile</button>
                                 <div class="clearfix"></div>
                            </form>

                        </div>
                    </div>
 

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" href="#0">Data Diri</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#0">Kontak & Sosial Media</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#0">Riwayat Pekerjaan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#0">Pendidikan</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="bmd-label-floating" for="exampleFormControlSelect1">Strata</label>
                                            </div>
                                            <div class="col">
                                                <select class="form-control"  id="exampleFormControlSelect1">
                                                    <option class="form-control">D3</option>
                                                    <option>S1/D4</option>
                                                    <option>S2</option>
                                                    <option>S3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Jurusan</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Universitas</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Tahun Lulus</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">Update Profile</button>
                                <button type="submit" class="btn btn-success pull-left">Tambah Data Pendidikan</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
 
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" href="#0">Data Diri</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#0">Kontak & Sosial Media</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#0">Riwayat Pekerjaan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#0">Pendidikan</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    
                                    <div class="form-group col-md-1">
                                        1
                                    </div>
                                    <div class="form-group col-md-11">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">No. SPK/Surat Keterangan Kerja</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group text-center">
                                                            <label class="bmd-label-floating">Tanggal Mulai</label>
                                                            <input type="date" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group text-center">
                                                            <label class="bmd-label-floating">Tanggal Selesai</label>
                                                            <input type="date" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nama Program</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nama Instansi Pemberi Kerja</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    Deskripsi Pekerjaan</label>
                                                    <input type="text" class="form-control">
                                                    <input type="text" class="form-control">
                                                    <input type="text" class="form-control">
                                                    <input type="text" class="form-control">
                                                    <input type="text" class="form-control">
                                                    <input type="text" class="form-control">
                                                    <input type="text" class="form-control">
                                                    <input type="text" class="form-control">
                                                    <input type="text" class="form-control">
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">Update Profile</button>
                                <button type="submit" class="btn btn-success pull-left">Tambah Riwayat Pekerjaan</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="javascript:;">
                    <img class="img" src="{{ asset('MaterialDashboard/img/faces/marc.jpg') }}" />
                  </a>
                </div>
                <div class="card-body">
                  <h6 class="card-category text-gray">CEO / Co-Founder</h6>
                  <h4 class="card-title">Alec Thompson</h4>
                  <p class="card-description">
                    Don't be scared of the truth because we need to restart the human foundation in truth And I love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is...
                  </p>
                  <a href="javascript:;" class="btn btn-primary btn-round">Follow</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <nav class="float-left">
          </nav>
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script> KOTAKU OSP 1 JATENG 1
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="{{ asset('MaterialDashboard/js/core/jquery.min.js') }}"></script>
  <script src="{{ asset('MaterialDashboard/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('MaterialDashboard/js/core/bootstrap-material-design.min.js') }}"></script>
  <script src="{{ asset('MaterialDashboard/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
  <!-- Plugin for the momentJs  -->
  <script src="../assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="../assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="{{ asset('MaterialDashboard/js/plugins/jquery.validate.min.js') }}"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="{{ asset('MaterialDashboard/js/plugins/jquery.bootstrap-wizard.js') }}"></script>
  <!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="{{ asset('MaterialDashboard/js/plugins/bootstrap-selectpicker.js') }}"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="{{ asset('MaterialDashboard/js/plugins/bootstrap-datetimepicker.min.js') }}"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="{{ asset('MaterialDashboard/js/plugins/jquery.dataTables.min.js') }}"></script>
  <!--  Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="{{ asset('MaterialDashboard/js/plugins/bootstrap-tagsinput.js') }}"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="{{ asset('MaterialDashboard/js/plugins/jasny-bootstrap.min.js') }}"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="{{ asset('MaterialDashboard/js/plugins/fullcalendar.min.js') }}"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="{{ asset('MaterialDashboard/js/plugins/jquery-jvectormap.js') }}"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="{{ asset('MaterialDashboard/js/plugins/nouislider.min.js') }}"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="{{ asset('MaterialDashboard/js/plugins/arrive.min.js') }}"></script>
  <!-- Chartist JS -->
  <script src="{{ asset('MaterialDashboard/js/plugins/chartist.min.js') }}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{ asset('MaterialDashboard/js/plugins/bootstrap-notify.js') }}"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('MaterialDashboard/js/material-dashboard.js?v=2.1.2') }}" type="text/javascript"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

                $sidebar_img_container = $sidebar.find('.sidebar-background');

                $full_page = $('.full-page');

                        $sidebar_responsive = $('body > .navbar-collapse');

                        window_width = $(window).width();

                                fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                                if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                                              if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                                                              $('.fixed-plugin .dropdown').addClass('open');
                                                                        }

                                                      }

                                        $('.fixed-plugin a').click(function(event) {
                                                      // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                                            //           if ($(this).hasClass('switch-trigger')) {
                                            //                       if (event.stopPropagation) {
                                            //                                     event.stopPropagation();
                                            //                                                 } else if (window.event) {
                                            //                                                               window.event.cancelBubble = true;
                                            //                                                                           }
                                            //                                                                                     }
                                            //                                                                                             });
                                            //
                                            //                                                                                                     $('.fixed-plugin .active-color span').click(function() {
                                            //                                                                                                               $full_page_background = $('.full-page-background');
                                            //
                                            //                                                                                                                         $(this).siblings().removeClass('active');
                                            //                                                                                                                                   $(this).addClass('active');
                                            //
                                            //                                                                                                                                             var new_color = $(this).data('color');
                                            //
                                            //                                                                                                                                                       if ($sidebar.length != 0) {
                                            //                                                                                                                                                                   $sidebar.attr('data-color', new_color);
                                            //                                                                                                                                                                             }
                                            //
                                            //                                                                                                                                                                                       if ($full_page.length != 0) {
                                            //                                                                                                                                                                                                   $full_page.attr('filter-color', new_color);
                                            //                                                                                                                                                                                                             }
                                            //
                                            //                                                                                                                                                                                                                       if ($sidebar_responsive.length != 0) {
                                            //                                                                                                                                                                                                                                   $sidebar_responsive.attr('data-color', new_color);
                                            //                                                                                                                                                                                                                                             }
                                            //                                                                                                                                                                                                                                                     });
                                            //
                                            //                                                                                                                                                                                                                                                             $('.fixed-plugin .background-color .badge').click(function() {
                                            //                                                                                                                                                                                                                                                                       $(this).siblings().removeClass('active');
                                            //                                                                                                                                                                                                                                                                                 $(this).addClass('active');
                                            //
                                            //                                                                                                                                                                                                                                                                                           var new_color = $(this).data('background-color');
                                            //
                                            //                                                                                                                                                                                                                                                                                                     if ($sidebar.length != 0) {
                                            //                                                                                                                                                                                                                                                                                                                 $sidebar.attr('data-background-color', new_color);
                                            //                                                                                                                                                                                                                                                                                                                           }
                                            //                                                                                                                                                                                                                                                                                                                                   });
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                           $('.fixed-plugin .img-holder').click(function() {
                                            //                                                                                                                                                                                                                                                                                                                                                     $full_page_background = $('.full-page-background');
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                               $(this).parent('li').siblings().removeClass('active');
                                            //                                                                                                                                                                                                                                                                                                                                                                         $(this).parent('li').addClass('active');
                                            //
                                            //
                                            //                                                      var new_image = $(this).find("img").attr('src');
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                             if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                                            //                                                                                        $sidebar_img_container.fadeOut('fast', function() {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                       $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                     $sidebar_img_container.fadeIn('fast');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                 });
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                           }
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                     if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             $full_page_background.fadeOut('fast', function() {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         $full_page_background.fadeIn('fast');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     });
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               }
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         if ($('.switch-sidebar-image input:checked').length == 0) {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   }
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             if ($sidebar_responsive.length != 0) {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   }
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           });
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   $('.switch-sidebar-image input').change(function() {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             $full_page_background = $('.full-page-background');
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       $input = $(this);
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 if ($input.is(':checked')) {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             if ($sidebar_img_container.length != 0) {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           $sidebar_img_container.fadeIn('fast');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         $sidebar.attr('data-image', '#');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     }
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 if ($full_page_background.length != 0) {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               $full_page_background.fadeIn('fast');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             $full_page.attr('data-image', '#');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         }
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     background_image = true;
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               } else {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           if ($sidebar_img_container.length != 0) {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         $sidebar.removeAttr('data-image');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       $sidebar_img_container.fadeOut('fast');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   }
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               if ($full_page_background.length != 0) {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             $full_page.removeAttr('data-image', '#');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           $full_page_background.fadeOut('fast');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       }
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   background_image = false;
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             }
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     });
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             $('.switch-sidebar-mini input').change(function() {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       $body = $('body');
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 $input = $(this);
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           if (md.misc.sidebar_mini_active == true) {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       $('body').removeClass('sidebar-mini');
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   md.misc.sidebar_mini_active = false;
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         } else {
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 setTimeout(function() {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               $('body').addClass('sidebar-mini');
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             md.misc.sidebar_mini_active = true;
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         }, 300);
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   }
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             // we simulate the window Resize so the charts will get updated in realtime.
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       var simulateWindowResize = setInterval(function() {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   window.dispatchEvent(new Event('resize'));
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             }, 180);
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       // we stop the simulation of Window Resize after the animations are completed
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 setTimeout(function() {
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             clearInterval(simulateWindowResize);
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       }, 1000);
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               });
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     });
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         });
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           </script>
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           </body>
                                            //
                                            //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           </html>
