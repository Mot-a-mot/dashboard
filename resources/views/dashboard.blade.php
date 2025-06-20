<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Mot a Mot - Dashboard</title>
      <link rel="shortcut icon" href="/images/favicon.ico" />
      <link rel="stylesheet" href="/css/bootstrap.min.css">
      <link rel="stylesheet" href="/css/typography.css">
      <link rel="stylesheet" href="/css/style.css">
      <link rel="stylesheet" href="/css/responsive.css">
      <link rel="stylesheet" href="/css/flatpickr.min.css">
      <!-- Favicon -->
      <link rel="shortcut icon" href="/images/favicon.ico" />
      <!-- Bootstrap CSS -->
      <!-- Typography CSS -->
      <link rel="stylesheet" href="/css/typography.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="/css/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="/css/responsive.css">
      <!-- Full calendar -->
      <link href='fullcalendar/core/main.css' rel='stylesheet' />
      <link href='fullcalendar/daygrid/main.css' rel='stylesheet' />
      <link href='fullcalendar/timegrid/main.css' rel='stylesheet' />
      <link href='fullcalendar/list/main.css' rel='stylesheet' />

      <link rel="stylesheet" href="/css/flatpickr.min.css">

   </head>
   <body>
      <!-- loader Start -->
      {{-- 
      <div id="loading">
         <div id="loading-center">
         </div>
      </div> 
      --}}
      </div>
      <!-- loader END -->
      <!-- Wrapper Start -->
      <div class="wrapper">
         <!-- Sidebar  -->
         @include("layouts.sidebar")
         <!-- TOP Nav Bar -->
         @include("layouts.header")
         <!-- TOP Nav Bar END -->
         
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-6 col-md-6 col-lg-3">
                     <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body iq-box-relative">
                           <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-primary">
                              <i class="ri-focus-2-line"></i>
                           </div>
                           <p class="text-secondary">Total Utilisateurs</p>
                           <div class="d-flex align-items-center justify-content-between">
                              <h4><b>{{$totalUsers}}</b></h4>
                              <div id="iq-chart-box1"></div>
                              {{-- <span class="text-primary"><b> +14% <i class="ri-arrow-up-fill"></i></b></span> --}}
                           </div>
                        </div>
                     </div>
                  </div>
                 <div class="col-sm-6 col-md-6 col-lg-3">
                  <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-body iq-box-relative">
                        <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-info">
                           <i class="ri-user-3-line"></i>
                        </div>
                        <p class="text-secondary">Utilisateurs Niveau A1/A2</p>
                        <div class="d-flex align-items-center justify-content-between">
                           <h4><b>{{ $usersInGroupA }}</b></h4>
                           <div id="iq-chart-box2"></div>
                           {{-- <span class="text-info"><b> <i class="ri-arrow-up-fill"></i></b></span> --}}
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-md-6 col-lg-3">
                  <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-body iq-box-relative">
                        <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-success">
                           <i class="ri-user-3-fill"></i>
                        </div>
                        <p class="text-secondary">Utilisateurs Niveau B1/B2</p>
                        <div class="d-flex align-items-center justify-content-between">
                           <h4><b>{{ $usersInGroupB }}</b></h4>
                           <div id="iq-chart-box3"></div>
                           {{-- <span class="text-success"><b> <i class="ri-arrow-up-fill"></i></b></span> --}}
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-md-6 col-lg-3">
                  <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-body iq-box-relative">
                        <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-warning">
                           <i class="ri-user-settings-line"></i>
                        </div>
                        <p class="text-secondary">Utilisateurs Niveau C1/C2</p>
                        <div class="d-flex align-items-center justify-content-between">
                           <h4><b>{{ $usersInGroupC }}</b></h4>
                           <div id="iq-chart-box4"></div>
                           {{-- <span class="text-warning"><b> <i class="ri-arrow-up-fill"></i></b></span> --}}
                        </div>
                     </div>
                  </div>
               </div>

                  <div class="col-lg-8">
                     <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Statistiques d'exercice</h4>
                           </div>
                           <div class="iq-card-header-toolbar d-flex align-items-center">
                              <ul class="nav nav-pills">
                                 <li class="nav-item">
                                    <a href="#" class="nav-link active">All</a>
                                 </li>
                                 <li class="nav-item">
                                    <a href="#" class="nav-link">A1</a>
                                 </li>
                                 <li class="nav-item">
                                    <a href="#" class="nav-link">A2</a>
                                 </li>
                                 <!-- add more niveaux dynamically -->
                              </ul>
                           </div>
                        </div>
                        <div class="iq-card-body row m-0 align-items-center pb-0">
                           <div class="col-md-8">
                              <div id="iq-income-chart">
                                 <!-- Integrate a real chart like Chart.js later -->
                                 <p>Chart Placeholder: Attempts per Niveau</p>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="chart-data-block">
                                 <h4><b>Total</b></h4>
                                 <h2><b>{{ $totalExercises }}</b></h2>
                                 <p>Exercices totaux dans le système</p>
                                 <div class="chart-box d-flex align-items-center justify-content-between mt-5 mb-5">
                                    <div id="iq-chart-boxleft"><p>✔</p></div>
                                    <div id="iq-chart-boxright"><p>✘</p></div>
                                 </div>
                                 <div class="mt-3 pr-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                       <div class="d-flex align-items-center">
                                          <span class="bg-primary p-1 rounded mr-2"></span>
                                          <p class="mb-0">Successful Attempts</p>
                                       </div>
                                       <h6><b>{{ $successRate }}%</b></h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                       <div class="d-flex align-items-center">
                                          <span class="bg-danger p-1 rounded mr-2"></span>
                                          <p class="mb-0">Failed Attempts</p>
                                       </div>
                                       <h6><b>{{ $failureRate }}%</b></h6>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="col-lg-4">
                     <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body">
                           @foreach ($niveaux as $niveau)
                           <div class="d-flex align-items-center mt-3">
                              <div class="icon iq-icon-box rounded iq-bg-primary mr-3">
                                 <i class="ri-graduation-cap-line"></i>
                              </div>
                              <div class="iq-details col-sm-9 p-0">
                                 <div class="d-flex align-items-center justify-content-between">
                                    <span class="title text-dark">Niveau {{ $niveau->name }}</span>
                                    <div class="percentage"><b>{{ $niveau->users_count }} users</b></div>
                                 </div>
                                 <div class="iq-progress-bar-linear d-inline-block w-100">
                                    <div class="iq-progress-bar">
                                       <span class="bg-primary" style="width: {{ $niveau->success_rate }}%"></span>
                                    </div>
                                 </div>
                                 <div class="d-flex align-items-center justify-content-between">
                                    <span>{{ $niveau->total_attempts }} attempts</span>
                                    <div class="percentage">{{ $niveau->success_rate }}<span>%</span></div>
                                 </div>
                              </div>
                           </div>
                           <hr class="mt-4 mb-4">
                           @endforeach
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Wrapper END -->
      <!-- Footer -->
      @include("layouts.footer")
      <!-- Footer END -->
     
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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
      
      <script src="/js/flatpickr.js"></script>
   </body>
</html>