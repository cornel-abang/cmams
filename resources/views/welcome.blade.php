<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Quality Management & Accountability Monitoring System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('assets/landing/img/favicon.png')}}" rel="icon">
  <link href="{{asset('assets/landing/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/landing/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('assets/landing/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/landing/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/landing/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/landing/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/landing/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('assets/landing/css/style.css')}}" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <div class="logo me-auto">
        {{-- <h1><a href="index.html">Scaffold</a></h1> --}}
        <!-- Uncomment below if you prefer to use an image logo -->
         <a href="/"><img src="{{ asset('assets/images/logo-dark.png') }}" alt="" class="img-fluid"></a>
      </div>

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero"  style="padding-bottom: 0 !important;">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
          <div>
            <h1>Welcome to QMAMS</h1>
            <h3>Which suite do you want to access today?</h3>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left">
          <img src="{{ asset('assets/landing/img/hero-img.png') }}" class="img-fluid" alt="">
        </div>
      </div>
      <div class="row">
          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in">
            <div class="icon-box icon-box-pink">
              <div class="icon"><i class="bx bxl-dribbble"></i></div>
              <h4 class="title"><a href="">QMAMS Core</a></h4>
              <p class="description">
                {{-- Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate<br><br> --}}
                <a href="{{ route('login') }}" class="btn-get-started scrollto">Go >></a>
              </p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box icon-box-cyan">
              <div class="icon"><i class="bx bx-file"></i></div>
              <h4 class="title"><a href="{{ route('dhis') }}">DHIS</a></h4>
              <p class="description">
                {{-- Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla<br><br> --}}
                <a href="{{ route('dhis') }}" class="btn-get-started scrollto">Go >></a>
              </p>
            </div>
          </div>
        </div>
    </div>

  </section>
  <!-- Vendor JS Files -->
  <script src="{{asset('assets/landing/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('assets/landing/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/landing/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('assets/landing/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('assets/landing/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{asset('assets/landing/vendor/swiper/swiper-bundle.min.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/landing/js/main.js')}}"></script>

</body>

</html>