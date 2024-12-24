@extends('layouts.app')

@section('title', 'Détails de l\'Annonce')

@section('content')
    <h1>{{ $annonce->titre }}</h1>

    @if($annonce->images)
        <img src="{{ asset('storage/' . $annonce->images) }}" class="img-fluid mb-4" alt="{{ $annonce->titre }}">
    @endif

    <p><strong>Description :</strong></p>
    <p>{{ $annonce->description }}</p>

    <p><strong>Date :</strong> {{ $annonce->date->format('d/m/Y') }}</p>
    <p><strong>Lieu :</strong> {{ $annonce->lieu }}</p>
    <p><strong>Catégorie :</strong> {{ $annonce->categorie->nom }}</p>
    <p><strong>Statut :</strong> {{ ucfirst($annonce->statut) }}</p>

    @auth
        @if(Auth::id() === $annonce->user_id)
            <a href="{{ route('annonces.edit', $annonce->id) }}" class="btn btn-warning">Modifier</a>

            <form action="{{ route('annonces.destroy', $annonce->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">Supprimer</button>
            </form>
        @endif
    @endauth

    <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Retour</a>
@endsection
