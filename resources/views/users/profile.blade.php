<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Mot a Mot - Utilisateurs</title>
   <link rel="shortcut icon" href="/images/favicon.ico" />
   <link rel="stylesheet" href="/css/bootstrap.min.css">
   <link rel="stylesheet" href="/css/typography.css">
   <link rel="stylesheet" href="/css/style.css">
   <link rel="stylesheet" href="/css/responsive.css">
   
</head>
<body>
     <div id="loading">
         <div id="loading-center"></div>
      </div>
      <div class="wrapper">
         @include("layouts.sidebar")
         @include("layouts.header")
         <div id="content-page" class="content-page">
            <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Informations personnelles</h4>
                    </div>
                    </div>
                    <div class="iq-card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row align-items-center">
                        {{-- <div class="col-md-12 text-center">
                            <div class="profile-img-edit">
                            <img class="profile-pic" src="{{ Auth::user()->photo ?? '/images/user/default.png' }}" alt="profile-pic">
                            </div>
                        </div> --}}
                        </div>

                        <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="fname">Nom complet:</label>
                           <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}">                        </div>

                        {{-- <div class="form-group col-sm-6">
                            <label>Rôle:</label>
                            <input type="text" class="form-control" value="{{ ucfirst(Auth::user()->role) }}" >
                        </div> --}}

                        {{-- <div class="form-group col-sm-6">
                            <label>Status:</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->status ?? 'Actif' }}" >
                        </div> --}}
                        </div>

                        {{-- <div class="form-group">
                        <label>Abonnement:</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->subscription->name ?? 'Non défini' }}" >
                        </div> --}}
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>


      @include("layouts.footer")
      <!-- Toast container -->
        <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999;">
        <div id="toast-container">
            @if(session('success'))
            <div class="toast show bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                <div class="toast-header bg-success text-white">
                    <strong class="mr-auto">Succès</strong>
                    <small>Maintenant</small>
                    <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="toast show bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <strong class="mr-auto">Erreur</strong>
                    <small>Maintenant</small>
                    <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
        </div>

   </div>

  <script src="/js/jquery.min.js"></script>
      <script src="/js/popper.min.js"></script>
      <script src="/js/bootstrap.min.js"></script>
      <!-- Appear JavaScript -->
      <script src="/js/jquery.appear.js"></script>
      <!-- Countdown JavaScript -->
      <script src="/js/countdown.min.js"></script>
      <!-- Counterup JavaScript -->
      <script src="/js/waypoints.min.js"></script>
      <script src="/js/jquery.counterup.min.js"></script>
      <!-- Wow JavaScript -->
      <script src="/js/wow.min.js"></script>
      <!-- Apexcharts JavaScript -->
      <script src="/js/apexcharts.js"></script>
      <!-- Slick JavaScript -->
      <script src="/js/slick.min.js"></script>
      <!-- Select2 JavaScript -->
      <script src="/js/select2.min.js"></script>
      <!-- Owl Carousel JavaScript -->
      <script src="/js/owl.carousel.min.js"></script>
      <!-- Magnific Popup JavaScript -->
      <script src="/js/jquery.magnific-popup.min.js"></script>
      <!-- Smooth Scrollbar JavaScript -->
      <script src="/js/smooth-scrollbar.js"></script>
      <!-- lottie JavaScript -->
      <script src="/js/lottie.js"></script>
      <!-- am core JavaScript -->
      <script src="/js/core.js"></script>
      <!-- am charts JavaScript -->
      <script src="/js/charts.js"></script>
      <!-- am animated JavaScript -->
      <script src="/js/animated.js"></script>
      <!-- am kelly JavaScript -->
      <script src="/js/kelly.js"></script>
      <!-- am maps JavaScript -->
      <script src="/js/maps.js"></script>
      <!-- am worldLow JavaScript -->
      <script src="/js/worldLow.js"></script>
      <!-- Raphael-min JavaScript -->
      <script src="/js/raphael-min.js"></script>
      <!-- Morris JavaScript -->
      <script src="/js/morris.js"></script>
      <!-- Morris min JavaScript -->
      <script src="/js/morris.min.js"></script>
      <!-- Flatpicker Js -->
      <script src="/js/flatpickr.js"></script>
      <!-- Style Customizer -->
      <script src="/js/style-customizer.js"></script>
      <!-- Chart Custom JavaScript -->
      <script src="/js/chart-custom.js"></script>
      <!-- Custom JavaScript -->
      <script src="/js/custom.js"></script>
</body>
</html>
