@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg w-75">
        <div class="card-header text-center bg-primary text-white">
            <h2>{{ strtoupper($agence->nom) }}</h2> <!-- Nom de l'agence en majuscules -->
        </div>
        <div class="card-body">
            <h3 class="text-center mb-4">Modifier un Bien</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('biens.update', $bien->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Indiquer que c'est une mise à jour -->

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control" value="{{ old('nom', $bien->nom) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type</label>
                            <input type="text" name="type" class="form-control" value="{{ old('type', $bien->type) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Adresse</label>
                            <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $bien->adresse) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Surface</label>
                            <input type="number" name="surface" class="form-control" value="{{ old('surface', $bien->surface) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Prix</label>
                            <input type="number" name="prix" class="form-control" value="{{ old('prix', $bien->prix) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" name="status" class="form-control" value="{{ old('status', $bien->status) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control">{{ old('description', $bien->description) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Propriétaire</label>
                            <select name="proprietaire_id" class="form-control" required>
                                <option value="">Sélectionnez un propriétaire</option>
                                @foreach ($proprietaires as $proprietaire)
                                    <option value="{{ $proprietaire->id }}" 
                                        {{ old('proprietaire_id', $bien->proprietaire_id) == $proprietaire->id ? 'selected' : '' }}>
                                        {{ $proprietaire->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
