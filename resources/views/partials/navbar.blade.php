<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}">MOMEL</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('annonces.index') }}">Mes Annonces</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('categories.index') }}">Catégories</a>
        </li>
      </ul>
      <ul class="navbar-nav">


      <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Liens de navigation gauche -->
    <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('about') }}">À Propos</a>
        </li>
        <!-- Autres liens -->
    </ul>

</div>

        @auth
          <li class="nav-item">
            <span class="nav-link">Bienvenue, {{ Auth::user()->name }}</span>
          </li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-link nav-link" type="submit">Déconnexion</button>
            </form>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Connexion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Inscription</a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
