<!-- ressources/views/annonces/index.blade.php -->

@extends('layouts.app')

@section('title', 'Annonces Publiques')

@section('content')
    <h1 class="mb-4">Annonces Publiques, Retrouver ou Declarer vos objets égarés</h1>

    <!-- Formulaire de Recherche et de Filtrage -->
    <form method="GET" action="{{ route('home') }}" class="mb-4">
        <div class="row g-3">
            <!-- Champ de Recherche par Titre ou Nom -->
            <div class="col-md-3">
                <label for="search" class="form-label">Recherche</label>
                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Titre ou Nom">
            </div>

            <!-- Filtrage par Type -->
            <!-- <div class="col-md-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select">
                    <option value="">Tous</option>
                    <option value="perdu" {{ request('type') == 'perdu' ? 'selected' : '' }}>Perdu</option>
                    <option value="retrouvé" {{ request('type') == 'retrouvé' ? 'selected' : '' }}>Retrouvé</option>
                </select>
            </div> -->
            <!-- Filtrage par Catégorie -->
            <div class="col-md-3">
                <label for="categorie_id" class="form-label">Catégorie</label>
                <select name="categorie_id" id="categorie_id" class="form-select">
                    <option value="">Toutes</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtrage par Lieu -->
            <div class="col-md-3">
                <label for="lieu" class="form-label">Lieu</label>
                <input type="text" name="lieu" id="lieu" class="form-control" value="{{ request('lieu') }}" placeholder="Entrez un lieu">
            </div>

            <!-- Filtrage par Date -->
            <!-- <div class="col-md-3 mt-3">
                <label for="date" class="form-label">Depuis le</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
            </div> -->
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Filtrer</button>
                <a href="{{ route('home') }}" class="btn btn-secondary">Réinitialiser</a>
            </div>
        </div>
    </form>

    <!-- Liste des Annonces en Grille -->
    @if($annonces->count())
        <div class="row">
            @foreach($annonces as $annonce)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        @if($annonce->images)
                            <img src="{{ asset('storage/' . $annonce->images) }}" class="card-img-top img-fluid" alt="{{ $annonce->titre }}">
                        @else
                            <img src="{{ asset('images/default.png') }}" class="card-img-top img-fluid" alt="Image par défaut">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $annonce->titre }}</h5>
                            <p class="card-text">{{ Str::limit($annonce->description, 100) }}</p>
                            <p class="card-text"><small class="text-muted">{{ $annonce->date->format('d/m/Y') }} à {{ $annonce->lieu }}</small></p>
                            <a href="{{ route('annonces.showPublic', $annonce->id) }}" class="btn btn-primary">Voir Plus</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $annonces->links() }}
        </div>
    @else
        <p class="text-center">Aucune annonce trouvée.</p>
    @endif
@endsection
