<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Mot a Mot - Modifier l'utilisateur</title>
   <link rel="shortcut icon" href="/images/favicon.ico" />
   <link rel="stylesheet" href="/css/bootstrap.min.css">
   <link rel="stylesheet" href="/css/typography.css">
   <link rel="stylesheet" href="/css/style.css">
   <link rel="stylesheet" href="/css/responsive.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" crossorigin="anonymous" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" crossorigin="anonymous" />

</head>
<body>
<div class="wrapper">
   @include("layouts.sidebar")
   @include("layouts.header")

   <div id="content-page" class="content-page">
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12 col-lg-12">
               <div class="iq-card">
                  <div class="iq-card-header d-flex justify-content-between align-items-center">
                     <div class="iq-header-title">
                        <h4 class="card-title">Modifier l'utilisateur</h4>
                     </div>
                  </div>

                  <div class="iq-card-body">

                     @if ($errors->any())
                        <div class="alert alert-danger">
                           <ul class="mb-0">
                              @foreach ($errors->all() as $error)
                                 <li>{{ $error }}</li>
                              @endforeach
                           </ul>
                        </div>
                     @endif

                     <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                           <label for="name">Nom</label>
                           <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group">
                           <label for="email">Email</label>
                           <input type="email" id="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="form-group">
                           <label for="password">Nouveau mot de passe (laisser vide pour garder l'existant)</label>
                           <input type="password" id="password" class="form-control" name="password">
                        </div>

                        <div class="form-group">
                           <label for="role">Rôle</label>
                           <select id="role" class="form-control" name="role" required>
                              <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Utilisateur</option>
                              <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                           </select>
                        </div>

                       <div class="form-group">
                           <label for="status">Statut</label>
                           <select id="status" class="form-control select2" name="status" required>
                              <option value="actif" {{ old('status') == 'actif' ? 'selected' : '' }}>Actif</option>
                              <option value="inactif" {{ old('status') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                              <option value="suspendu" {{ old('status') == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                           </select>
                        </div>

                        <input type="hidden" name="subscription_id" value="{{ $user->subscription_id }}">

                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Annuler</a>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   @include("layouts.footer")
</div>

<!-- Scripts -->
<script src="/js/jquery.min.js"></script>
<script>
   $(document).ready(function () {
      $('.toast').toast({ delay: 5000 }).toast('show');

      $('#role').select2({
         placeholder: "Sélectionner un rôle",
         allowClear: true,
         width: '100%'
      });

      $('#status').select2({
         placeholder: "Sélectionner un statut",
         allowClear: true,
         width: '100%'
      });
   });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" crossorigin="anonymous"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.appear.js"></script>
<script src="/js/countdown.min.js"></script>
<script src="/js/waypoints.min.js"></script>
<script src="/js/jquery.counterup.min.js"></script>
<script src="/js/wow.min.js"></script>
<script src="/js/apexcharts.js"></script>
<script src="/js/slick.min.js"></script>
<script src="/js/owl.carousel.min.js"></script>
<script src="/js/jquery.magnific-popup.min.js"></script>
<script src="/js/smooth-scrollbar.js"></script>
<script src="/js/lottie.js"></script>
<script src="/js/core.js"></script>
<script src="/js/charts.js"></script>
<script src="/js/animated.js"></script>
<script src="/js/kelly.js"></script>
<script src="/js/maps.js"></script>
<script src="/js/worldLow.js"></script>
<script src="/js/raphael-min.js"></script>
<script src="/js/morris.js"></script>
<script src="/js/morris.min.js"></script>
<script src="/js/flatpickr.js"></script>
<script src="/js/style-customizer.js"></script>
<script src="/js/chart-custom.js"></script>
<script src="/js/custom.js"></script>
</body>
</html>
