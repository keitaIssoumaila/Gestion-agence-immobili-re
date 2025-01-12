@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-50">
        <div class="card-header text-center bg-primary text-white">
            {{ strtoupper(Auth::user()->agence->nom) }} - CRÉER UN CONTRAT
        </div>
        <div class="card-body">
            <form action="{{ route('contrats.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="date_debut" class="form-label">Date Début</label>
                        <input type="date" name="date_debut" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="date_fin" class="form-label">Date Fin</label>
                        <input type="date" name="date_fin" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="montant" class="form-label">Montant</label>
                        <input type="number" name="montant" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="bien_id" class="form-label">Bien</label>
                        <select name="bien_id" class="form-select" required>
                            @foreach($biens as $bien)
                                <option value="{{ $bien->id }}">{{ $bien->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="locataire_id" class="form-label">Locataire</label>
                        <select name="locataire_id" class="form-select" required>
                            @foreach($locataires as $locataire)
                                <option value="{{ $locataire->id }}">{{ $locataire->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="1" placeholder="Description du contrat"></textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('contrats.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
