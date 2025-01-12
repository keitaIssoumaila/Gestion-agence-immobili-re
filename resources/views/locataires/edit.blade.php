@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-50">
        <div class="card-header text-center bg-primary text-white">
            {{ strtoupper(Auth::user()->agence->nom) }} - MODIFIER LE LOCATAIRE
        </div>
        <div class="card-body">
            <form action="{{ route('locataires.update', $locataire->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control" value="{{ $locataire->nom }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" value="{{ $locataire->prenom }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ $locataire->email }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="genre" class="form-label">Genre</label>
                        <select id="genre" name="genre" class="form-select" required>
                            <option value="Homme" {{ $locataire->genre == 'Homme' ? 'selected' : '' }}>Homme</option>
                            <option value="Femme" {{ $locataire->genre == 'Femme' ? 'selected' : '' }}>Femme</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" id="telephone" name="telephone" class="form-control" value="{{ $locataire->telephone }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="adresse" class="form-label">Adresse</label>
                        <textarea id="adresse" name="adresse" class="form-control" rows="1" required>{{ $locataire->adresse }}</textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('locataires.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Modifier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
