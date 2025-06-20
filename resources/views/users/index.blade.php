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
      <link rel="stylesheet" href="/css/flatpickr.min.css">
   
</head>
<body>
   {{-- <div id="loading"><div id="loading-center"></div></div> --}}
   <div class="wrapper">
      @include("layouts.sidebar")
      @include("layouts.header")

      <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Liste des utilisateurs</h4>
                        </div>
                        <div class="col-sm-12 col-md-6 text-right">
                                 <a href="{{ route('users.create') }}" class="btn btn-primary">Ajouter utilisateur</a>
                        </div>
                        {{-- <a href="{{ route('users.create') }}" class="btn btn-primary">Ajouter</a> --}}
                     </div>
                     <div class="iq-card-body">
                        @if(session('success'))
                           <div class="alert alert-success">
                              {{ session('success') }}
                           </div>
                        @endif

                        <div class="table-responsive">
                           <div class="row justify-content-between">
                              <div class="col-sm-12 col-md-6">
                                 <form method="GET" class="mr-3 position-relative">
                                    <div class="form-group mb-0">
                                       <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ $search ?? '' }}">
                                    </div>
                                 </form>
                              </div>
                              
                           </div>

                           <table class="table table-bordered table-striped mt-4">
                             <thead>
                              <tr>
                                 <th>Nom</th>
                                 <th>Email</th>
                                 <th>Niveau</th>
                                 <th>Status</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @forelse($users as $user)
                              <tr>
                                 <td>{{ $user->name }}</td>
                                 <td>{{ $user->email }}</td>
                                 <td>{{ $user->currentNiveau?->name ?? '—' }}</td>
                                 <td>
                                    <span class="badge badge-{{ $user->status === 'active' ? 'success' : 'secondary' }}">
                                       {{ ucfirst($user->status ?? 'n/a') }}
                                    </span>
                                 </td>
                                 <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                       @csrf
                                       @method('DELETE')
                                       <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                    </form>
                                 </td>
                              </tr>
                              @empty
                              <tr><td colspan="5" class="text-center">Aucun utilisateur trouvé.</td></tr>
                              @endforelse
                           </tbody>

                           </table>

                           <div class="row justify-content-between mt-3">
                              <div class="col-md-6">
                                 <span>
                                    Affichage de {{ $users->firstItem() }} à {{ $users->lastItem() }} sur {{ $users->total() }} entrées
                                 </span>
                              </div>
                              <div class="col-md-6">
                                 <nav>
                                    <ul class="pagination justify-content-end mb-0">
                                       {{-- Previous Page --}}
                                       <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                          <a class="page-link" href="{{ $users->previousPageUrl() }}">Précédent</a>
                                       </li>

                                       {{-- Page Numbers --}}
                                       @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                          <li class="page-item {{ $users->currentPage() === $page ? 'active' : '' }}">
                                             <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                          </li>
                                       @endforeach

                                       {{-- Next Page --}}
                                       <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                          <a class="page-link" href="{{ $users->nextPageUrl() }}">Suivant</a>
                                       </li>
                                    </ul>
                                 </nav>
                              </div>
                           </div>
                        </div>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      @include("layouts.footer")
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
      <script src="/js/jquery.min.js"></script>
      
      <script src="/js/flatpickr.js"></script>
</body>
</html>
