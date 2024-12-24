@extends('layouts.app')

@section('title', 'Créer une Annonce')

@section('content')
    <h1>Créer une Annonce</h1>

    <form action="{{ route('annonces.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="type" class="form-label">Type d'Annonce</label>
            <select name="type" id="type" class="form-select" required>
                <option value="">-- Sélectionner --</option>
                <option value="perdu" {{ old('type') == 'perdu' ? 'selected' : '' }}>Perdu</option>
                <option value="retrouvé" {{ old('type') == 'retrouvé' ? 'selected' : '' }}>Retrouvé</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="categorie_id" class="form-label">Catégorie</label>
            <select name="categorie_id" id="categorie_id" class="form-select" required>
                <option value="">-- Sélectionner une catégorie --</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" value="{{ old('titre') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Images</label>
            <input type="file" name="images" id="images" class="form-control">
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date de Perte/Découverte</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
        </div>

        <div class="mb-3">
            <label for="lieu" class="form-label">Lieu de Perte/Découverte</label>
            <input type="text" name="lieu" id="lieu" class="form-control" value="{{ old('lieu') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Créer l'Annonce</button>
        <a href="{{ route('annonces.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
@endsection
