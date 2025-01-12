@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-50">
        <div class="card-header text-center bg-primary text-white">
            {{ strtoupper(Auth::user()->agence->nom) }} - CRÉER UNE NOUVELLE RÉSERVATION
        </div>
        <div class="card-body">
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="locataire_id" class="form-label">Locataire</label>
                        <select id="locataire_id" name="locataire_id" class="form-select" required>
                            <option value="">Choisir un locataire</option>
                            @foreach ($locataires as $locataire)
                                <option value="{{ $locataire->id }}">{{ $locataire->nom }} {{ $locataire->prenom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="bien_id" class="form-label">Bien</label>
                        <select id="bien_id" name="bien_id" class="form-select" required>
                            <option value="">Choisir un bien</option>
                            @foreach ($biens as $bien)
                                <option value="{{ $bien->id }}">{{ $bien->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="date_reservation" class="form-label">Date de Réservation</label>
                        <input type="date" id="date_reservation" name="date_reservation" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Statut</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="en attente">En attente</option>
                            <option value="confirmée">Confirmée</option>
                            <option value="annulée">Annulée</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
