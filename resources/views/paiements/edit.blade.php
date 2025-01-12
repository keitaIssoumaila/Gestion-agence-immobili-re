@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-50">
        <div class="card-header text-center bg-primary text-white">
            {{ strtoupper(Auth::user()->agence->nom) }} - MODIFIER UN PAIEMENT
        </div>
        <div class="card-body">
            <form action="{{ route('paiements.update', $paiement->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="montant" class="form-label">Montant</label>
                    <input type="number" name="montant" id="montant" class="form-control" value="{{ $paiement->montant }}" required>
                </div>
                <div class="mb-3">
                    <label for="date_paiement" class="form-label">Date de Paiement</label>
                    <input type="date" name="date_paiement" id="date_paiement" class="form-control" value="{{ $paiement->date_paiement }}" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="Payé" {{ $paiement->status == 'Payé' ? 'selected' : '' }}>Payé</option>
                        <option value="Non Payé" {{ $paiement->status == 'Non Payé' ? 'selected' : '' }}>Non Payé</option>
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
