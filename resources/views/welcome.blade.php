<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kotaku OSP-1</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Rajdhani:400,500,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.min.css">

    <link rel="stylesheet" href="css/et-line-font.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">


    <link rel="stylesheet" href="css/vegas.min.css">
    <link rel="stylesheet" href="css/style.css">


    <!-- Styles -->
    <style>
        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
            color: white;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <section class="preloader">
            <div class="sk-circle">
                <div class="sk-circle1 sk-child"></div>
                <div class="sk-circle2 sk-child"></div>
                <div class="sk-circle3 sk-child"></div>
                <div class="sk-circle4 sk-child"></div>
                <div class="sk-circle5 sk-child"></div>
                <div class="sk-circle6 sk-child"></div>
                <div class="sk-circle7 sk-child"></div>
                <div class="sk-circle8 sk-child"></div>
                <div class="sk-circle9 sk-child"></div>
                <div class="sk-circle10 sk-child"></div>
                <div class="sk-circle11 sk-child"></div>
                <div class="sk-circle12 sk-child"></div>
            </div>
        </section>

        <!-- home section -->
        <section id="home">
            <div class="container">
                <div class="row3">
                    <div class="col-md-offset-2 col-md-8 col-sm-12">
                        <div><img class="logo" src="images/logo kotaku.png" style="width:100px" class="img-responsive wow fadeInUp">
                        </div>
                        <div class="home-thumb">
                            <h1 class="wow fadeInUp" data-wow-delay="0.5s">O S P - 1 <br>Jawa Tengah - 1</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Announcement section -->
        <section id="announcement" style="padding: 20px;">
            <div>
                <h3 class="mx-3">Pengumuman</h3>
            </div>
            <div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Perihal</th>
                            <th class="text-center" scope="col">Lampiran-1</th>
                            <th class="text-center" scope="col">Lampiran-2</th>
                            <th class="text-center" scope="col">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Pengumuman Seleksi Personil Kotaku Provinsi Jawa Tengah Tahun 2020</td>
                            <td><a href="/pengumuman-rekrutmen-2020" target="_blank">Surat Keputusan Kepala Balai Prasarana Permukiman Wilayah Jawa Tengah No. 170/KPTS/CbM/2020</a></td>
                            <td><a href="/contact" target="_blank">Contact Person Korkot/Askot Mandiri OSP-1 Jawa Tengah-1</a></td>
                            <td>Bagi Peserta yang dinyatakan lolos harap segera menghubungi Contact Person Korkot / Askot Mandiri tempat bertugas. </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>


        <!-- blog section -->
        <section id="blog">
            <div class="flex-container">
                <div class="artikel">
                    <div class="section-title mt-5">
                        <h3>PERMASALAHAN SAMPAH DI KELURAHAN PENGGARON KIDUL KOTA SEMARANG TERATASI BERKAT PEMBANGUNAN TPS 3R PROGRAM
                            KOTAKU</h3>
                    </div>
                    <p><img src="/images/blog/blog penggaron kidul.png" class="img-fluid" style="width:100%;" alt=""></p>
                    <div>
                        <p>Kekumuhan yang terjadi di Kelurahan Penggaron Kidul, Kecamatan Pedurungan, Kota Semarang, Jawa Tengah,
                            antara lain adalah akibat tidak adanya akses jalan, saluran drainase, dan pengelolaan sampah yang layak.</p>
                        <p>Melalui BPM Program Kotaku 2019 kelurahan yang memiliki luasan kumuh 2,19 Ha ini membangun 1 unit Tempat
                            Pengelolaan Sampah Reuse, Reduce, dan Recycle (TPS-3R) di RT003, RT004, RT005-RW006 Kelurahan Penggaron
                            Kidul. Kegiatan tersebut menggunakan dana BPM sebesar Rp 495.000.000, ditambah swadaya Rp 11.230.000.
                        </p>
                        <p>Keberadaan TPS-3R ini bermanfaat bagi 61 KK, yang terdiri atas 105 jiwa laki-laki dan 132 jiwa perempuan.
                        </p>
                    </div>
                </div>
                <div class="artikel">
                    <div class="section-title">
                        <h3>SUASANA ASRI NAN ELOK DESA SIMBANG KULON KABUPATEN PEKALONGAN BERKAT PROGRAM KOTAKU</h3>
                    </div>
                    <div>
                        <img src="/images/blog/blog simbang.jpg" class="img-fluid" style="width:100%;" alt="">
                    </div>
                    <div>
                        <p>Asri dan elok menjadi pemandangan sehari-hari di Desa Simbang Kulon, Kecamatan Buaran, Kabupaten
                            Pekalongan, Provinsi Jawa Tengah saat ini. Perubahan drastis terjadi setelah desa menerima dana BPM Kotaku
                            2019 untuk pembangunan jalan paving dan drainase. Sebelum diintervensi oleh Program Kotaku 2019, permukiman
                            Desa Simbang Kulon tampak kumuh dan kotor. Jalanan rusak, berlubang, bahkan tergenang air, walau hujan telah
                            lama reda akibat tidak adanya drainase yang layak.</p>
                        <p>Program Kota Tanpa Kumuh (Kotaku) masuk ke lokasi ini dan memfasilitasi perbaikan infrastruktur permukiman
                            Desa Simbang Kulon melalui Bantuan Pemerintah untuk Masyarakat (BPM) Kotaku 2019. Akhirnya terbangun 846
                            meter jalan paving dengan dana BPM sebesar Rp 465.000.000 dan swadaya Rp 2.000.000. Kegiatan tersebut
                            bermanfaat bagi 143 kepala keluarga, yang terdiri atas 292 jiwa laki-laki dan 287 jiwa perempuan.</p>
                        <p>Desa Simbang Kulon juga membangun 840 meter drainase lingkungan dengan BPM Kotaku Rp 425.000.000 dan
                            swadaya Rp 2.000.000, bermanfaat bagi 68 kepala keluarga, yang terdiri atas 126 jiwa laki-laki dan 120 jiwa
                            perempuan.
                        </p>
                    </div>
                </div>
                <div class="artikel">
                    <div class="section-title">
                        <h3>LINGKUNGAN PERMUKIMAN BANDENGAN SUDAH TERTATA BERKAT BPM 2019</h3>
                    </div>
                    <div>
                        <img src="/images/blog/blog bandengan.png" class="img-fluid" style="width:100%;" alt="">
                    </div>
                    <div>
                        <p>Sore itu, anak-anak tampak berlarian di jalan beton, melintasi jembatan yang terpasang rapi di sudut
                            permukiman Kelurahan Bandengan, Kecamatan Pekalongan Utara, Kota Pekalongan, Provinsi Jawa Tengah. Tak akan
                            ada yang menyangka, dahulu kelurahan ini pernah memiliki area kumuh seluas 1,37 hektare.
                        </p>
                        <p>Keadaan berubah setelah Kelurahan Bandengan mendapatkan intervensi Program Kota Tanpa Kumuh (BKM) dengan
                            dana Bantuan Pemerintah untuk Masyarakat (BPM) 2019. Melalui BPM Kotaku, dilakukan sejumlah penataan ulang
                            infrastruktur di Kelurahan Bandengan. Sebut saja, 53 meter pekerjaan penutup saluran/parit (plat beton, dan
                            lain-lain) yang menggunakan dana BPM Kotaku 2019 sebesar Rp 52.148.000, menggunakan 7 orang tenaga kerja.
                        </p>
                        <p>Selain itu juga 730 meter jalan beton dengan dana BPM Kotaku 2019 sebesar Rp 459.332.000 dan swadaya
                            masyarakat Rp 1.500.000, menggunakan 17 orang tenaga kerja. Selain itu, dibangun pula 1.154 meter tanggul
                            pengendali banjir dengan dana BPM Kotaku 2019 sebesar Rp 483.520.000 dan swadaya masyarakat Rp 1.950.000,
                            menggunakan 15 orang tenaga kerja.</p>
                        <p>Semua kegiatan tersebut bermanfaat bagi 100 kepala keluarga, terdiri atas 148 jiwa laki-laki dan 144 jiwa
                            perempuan. Diketahui, 63 dari 100 KK tersebut termasuk kategori masyarakat berpenghasilan rendah (MBR).
                            Silakan kunjungi juga website kita http://kotaku.pu.go.id dan dapatkan informasi lebih banyak terkait k
                            egiatan di lokasi lainnya dampingan Program Kotaku.</p>
                    </div>
                </div>
        </section>


        <!-- project section -->
        <section id="project">
            <div class="flex-container">

            </div>
        </section>

        <!-- footer section -->
        <footer>
            <div class="container">
                <div class="row">

                    <svg class="svgcolor-light" preserveAspectRatio="none" viewBox="0 0 100 102" height="100" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0 L50 100 L100 0 Z"></path>
                    </svg>

                    <div class="wow fadeInUp col-md-9 col-sm-10">
                        <h2>OSP 1 Jawa Tengah</h2>
                        <div class="wow fadeInUp" data-wow-delay="0.3s">
                            <p>Wilayah Dampingan: Wonosobo, Grobogan, Blora, Rembang, Pati, Kudus, Jepara, Demak, Semarang, Temanggung,
                                Kendal, Batang, Pekalongan, Pemalang, Tegal, Brebes, Kota Salatiga, Kota Semarang, Kota Pekalongan dan
                                Kota Tegal</p>

                            <p class="copyright-text">Copyright &copy; 2020 OSP 1 Jateng 1</p>
                        </div>
                    </div>

                    <div class="col-md-1 col-sm-1"></div>

                    <div class="col-md-3 col-sm-5">
                        <h2>Office</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.6s">
                            Jl. Puspowarno Tengah VIII No. 20 Salamanmloyo,
                            Kota Semarang
                        </p>
                        <ul class="social-icon">
                            <li><a href="#" class="fa fa-facebook wow bounceIn" data-wow-delay="0.9s"></a></li>
                            <li><a href="#" class="fa fa-twitter wow bounceIn" data-wow-delay="1.2s"></a></li>
                            <li><a href="#" class="fa fa-behance wow bounceIn" data-wow-delay="1.4s"></a></li>
                            <li><a href="#" class="fa fa-dribbble wow bounceIn" data-wow-delay="1.6s"></a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </footer>


        <!-- Back top -->
        <a href="#back-top" class="go-top"><i class="fa fa-angle-up"></i></a>

        <!-- javscript js -->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <script src="js/vegas.min.js"></script>

        <script src="js/wow.min.js"></script>
        <script src="js/smoothscroll.js"></script>
        <script src="js/custom.js"></script>
</body>

</html>