@extends('layouts.app')

@section('title', 'Modifier l\'Annonce')

@section('content')
    <h1>Modifier l'Annonce</h1>

    <form action="{{ route('annonces.update', $annonce->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="type" class="form-label">Type d'Annonce</label>
            <select name="type" id="type" class="form-select" required>
                <option value="">-- Sélectionner --</option>
                <option value="perdu" {{ $annonce->type == 'perdu' ? 'selected' : '' }}>Perdu</option>
                <option value="retrouvé" {{ $annonce->type == 'retrouvé' ? 'selected' : '' }}>Retrouvé</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="categorie_id" class="form-label">Catégorie</label>
            <select name="categorie_id" id="categorie_id" class="form-select" required>
                <option value="">-- Sélectionner une catégorie --</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ $annonce->categorie_id == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" value="{{ old('titre', $annonce->titre) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $annonce->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Images</label>
            @if($annonce->images)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $annonce->images) }}" alt="{{ $annonce->titre }}" class="img-thumbnail" width="200">
                </div>
            @endif
            <input type="file" name="images" id="images" class="form-control">
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date de Perte/Découverte</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $annonce->date->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="lieu" class="form-label">Lieu de Perte/Découverte</label>
            <input type="text" name="lieu" id="lieu" class="form-control" value="{{ old('lieu', $annonce->lieu) }}" required>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut de l'Annonce</label>
            <select name="statut" id="statut" class="form-select" required>
                <option value="active" {{ $annonce->statut == 'active' ? 'selected' : '' }}>Active</option>
                <option value="résolue" {{ $annonce->statut == 'résolue' ? 'selected' : '' }}>Résolue</option>
                <option value="en attente" {{ $annonce->statut == 'en attente' ? 'selected' : '' }}>En Attente</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Mettre à Jour</button>
        <a href="{{ route('annonces.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
@endsection
