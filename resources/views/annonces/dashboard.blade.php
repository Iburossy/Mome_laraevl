@extends('layouts.app')

@section('title', 'Mes Annonces')

@section('content')
    <h1 class="mb-4">Mes Annonces</h1>

    <!-- Formulaire de Recherche et de Filtrage -->
    <form method="GET" action="{{ route('annonces.index') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select">
                    <option value="">Tous</option>
                    <option value="perdu" {{ request('type') == 'perdu' ? 'selected' : '' }}>Perdu</option>
                    <option value="retrouvé" {{ request('type') == 'retrouvé' ? 'selected' : '' }}>Retrouvé</option>
                </select>
            </div>
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
            <div class="col-md-3">
                <label for="statut" class="form-label">Statut</label>
                <select name="statut" id="statut" class="form-select">
                    <option value="">Tous</option>
                    <option value="active" {{ request('statut') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="résolue" {{ request('statut') == 'résolue' ? 'selected' : '' }}>Résolue</option>
                    <option value="en attente" {{ request('statut') == 'en attente' ? 'selected' : '' }}>En Attente</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="date" class="form-label">Depuis le</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Filtrer</button>
                <a href="{{ route('annonces.index') }}" class="btn btn-secondary">Réinitialiser</a>
            </div>
        </div>
    </form>

    <!-- Liste des Annonces de l'Utilisateur en Grille -->
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
                            <p class="card-text"><strong>Statut :</strong> {{ ucfirst($annonce->statut) }}</p>
                            <!-- <a href="{{ route('annonces.show', $annonce->id) }}" class="btn btn-info btn-sm">Voir</a> -->
                            <a href="{{ route('annonces.showPublic', $annonce->id) }}" class="btn btn-primary">Voir Plus</a>

                            <a href="{{ route('annonces.edit', $annonce->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $annonce->id }}">
                                Supprimer
                            </button>

                            <!-- Modale de Confirmation de Suppression -->
                            <div class="modal fade" id="deleteModal{{ $annonce->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $annonce->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $annonce->id }}">Confirmer la Suppression</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir supprimer l'annonce "{{ $annonce->titre }}" ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('annonces.destroy', $annonce->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin de la Modale -->
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

    <a href="{{ route('annonces.create') }}" class="btn btn-success mt-3">Déclarer un Nouvel Objet</a>
@endsection
