@extends('layouts.app')

@section('title', 'Annonces Publiques')

@section('content')
    <h1>Annonces Publiques</h1>

    <div class="row mb-4">
        <div class="col-md-4">
            <form method="GET" action="{{ route('home') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Rechercher</button>
                </div>
            </form>
        </div>
        <div class="col-md-8 text-end">
            @auth
                <a href="{{ route('annonces.create') }}" class="btn btn-primary">Déclarer un objet</a>
            @endauth
        </div>
    </div>

    @if($annonces->count())
        <div class="row">
            @foreach($annonces as $annonce)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($annonce->images)
                            <img src="{{ asset('storage/' . $annonce->images) }}" class="card-img-top" alt="{{ $annonce->titre }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $annonce->titre }}</h5>
                            <p class="card-text">{{ Str::limit($annonce->description, 100) }}</p>
                            <a href="{{ route('annonces.showPublic', $annonce->id) }}" class="btn btn-primary">Voir Détails</a>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">{{ $annonce->date->format('d/m/Y') }} à {{ $annonce->lieu }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $annonces->links() }}
    @else
        <p>Aucune annonce trouvée.</p>
    @endif
@endsection
