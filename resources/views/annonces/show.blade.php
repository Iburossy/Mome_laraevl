@extends('layouts.app')

@section('title', 'Détails de l\'Annonce')

@section('content')
    <div class="container">
        <h1 class="mb-4">{{ $annonce->titre }}</h1>

        <div class="row">
            <div class="col-md-6">
                @if($annonce->images)
                    <img src="{{ asset('storage/' . $annonce->images) }}" class="img-fluid" alt="{{ $annonce->titre }}">
                @else
                    <img src="{{ asset('images/default.png') }}" class="img-fluid" alt="Image par défaut">
                @endif
            </div>
            <div class="col-md-6">
                <p><strong>Type :</strong> {{ ucfirst($annonce->type) }}</p>
                <p><strong>Catégorie :</strong> {{ $annonce->categorie->nom }}</p>
                <p><strong>Date :</strong> {{ $annonce->date->format('d/m/Y') }}</p>
                <p><strong>Lieu :</strong> {{ $annonce->lieu }}</p>
                <p><strong>Statut :</strong> {{ ucfirst($annonce->statut) }}</p>
                <p><strong>Description :</strong></p>
                <p>{{ $annonce->description }}</p>

                <a href="{{ route('annonces.index') }}" class="btn btn-secondary">Retour à Mes Annonces</a>
                <a href="{{ route('annonces.edit', $annonce->id) }}" class="btn btn-warning">Modifier</a>
                <form action="{{ route('annonces.destroy', $annonce->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
@endsection
