<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Mot a Mot - Liste des Niveaux</title>
   <link rel="shortcut icon" href="/images/favicon.ico" />
   <link rel="stylesheet" href="/css/bootstrap.min.css">
   <link rel="stylesheet" href="/css/typography.css">
   <link rel="stylesheet" href="/css/style.css">
   <link rel="stylesheet" href="/css/responsive.css">
   <link rel="stylesheet" href="/css/flatpickr.min.css">
</head>
<body>
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
                        <h4 class="card-title">Liste des Tentatives d'Exercice</h4>
                     </div>
                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAttemptModal">
                        Ajouter une tentative
                     </button>
                  </div>

                  <div class="iq-card-body">
                     @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                     @endif

                     <div class="table-responsive mt-4">
                        <table class="table table-striped table-bordered">
                           <thead>
                              <tr>
                                 <th>#</th>
                                 <th>Utilisateur</th>
                                 <th>Exercice</th>
                                 <th>Score</th>
                                 <th>Réussi</th>
                                 <th>Note</th>
                                 <th>Date de soumission</th>
                                 <th>Actions</th>
                              </tr>
                           </thead>
                           <tbody>
                              @forelse ($attempts as $index => $attempt)
                                 <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $attempt->user->name ?? 'N/A' }}</td>
                                    <td>{{ $attempt->exercice->title ?? 'N/A' }}</td>
                                    <td>{{ $attempt->score }}</td>
                                    <td>{{ $attempt->is_passed ? 'Oui' : 'Non' }}</td>
                                    <td>{{ $attempt->note }}</td>
                                    <td>{{ $attempt->submitted_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                       <a href="{{ route('userExerciseAttempts.show', $attempt->id) }}" class="btn btn-info btn-sm">Voir</a>
                                       <a href="{{ route('userExerciseAttempts.edit', $attempt->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                       <form action="{{ route('userExerciseAttempts.destroy', $attempt->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Supprimer cette tentative ?');">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                       </form>
                                    </td>
                                 </tr>
                              @empty
                                 <tr>
                                    <td colspan="8" class="text-center">Aucune tentative trouvée.</td>
                                 </tr>
                              @endforelse
                           </tbody>
                        </table>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

</div>

   <div class="modal fade" id="createNiveauModal" tabindex="-1" role="dialog" aria-labelledby="createNiveauLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <form method="POST" action="{{ route('niveaux.store') }}">
               @csrf
               <div class="modal-header">
                  <h5 class="modal-title" id="createNiveauLabel">Créer un Niveau</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>

               <div class="modal-body">
                  <div class="form-group">
                     <label for="name">Nom du niveau</label>
                     <input type="text" name="name" class="form-control" required placeholder="Ex: A1, B2...">
                  </div>

                  <div class="form-group">
                     <label for="order">Ordre</label>
                     <input type="number" name="order" class="form-control" required placeholder="Ex: 1, 2...">
                  </div>
               </div>

               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                  <button type="submit" class="btn btn-primary">Enregistrer</button>
               </div>
            </form>
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
