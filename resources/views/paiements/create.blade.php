@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-50">
        <div class="card-header text-center bg-primary text-white">
            {{ strtoupper(Auth::user()->agence->nom) }} - CRÉER UN PAIEMENT
        </div>
        <div class="card-body">
            <form action="{{ route('paiements.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="montant" class="form-label">Montant</label>
                    <input type="number" name="montant" id="montant" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="date_paiement" class="form-label">Date de Paiement</label>
                    <input type="date" name="date_paiement" id="date_paiement" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="Payé">Payé</option>
                        <option value="Non Payé">Non Payé</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="contrat_id" class="form-label">Contrat</label>
                    <select name="contrat_id" id="contrat_id" class="form-select" required>
                        @foreach ($contrats as $contrat)
                            <option value="{{ $contrat->id }}">Contrat #{{ $contrat->id }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
