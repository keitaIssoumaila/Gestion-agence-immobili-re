@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du Propriétaire</h1>

    <div class="card">
        <div class="card-header">
            {{ strtoupper(Auth::user()->agence->nom) }} - PROPRIÉTAIRE : {{ $proprietaire->nom }} {{ $proprietaire->prenom }}
        </div>
        <div class="card-body">
            <p><strong>Nom :</strong> {{ $proprietaire->nom }}</p>
            <p><strong>Prénom :</strong> {{ $proprietaire->prenom }}</p>
            <p><strong>Email :</strong> {{ $proprietaire->email }}</p>
            <p><strong>Téléphone :</strong> {{ $proprietaire->telephone }}</p>
            <p><strong>Adresse :</strong> {{ $proprietaire->adresse }}</p>

            <button id="printProprietaireButton" class="btn btn-primary" title="Imprimer">
                <i class="fas fa-print"></i> 
            </button>

            <a href="{{ route('proprietaires.index') }}" class="btn btn-secondary mt-2" title="Retour">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('printProprietaireButton').addEventListener('click', function () {
        const originalContent = document.body.innerHTML;
        const printContent = document.querySelector('.card').outerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload(); // Recharge la page après impression
    });
</script>
@endpush
@endsection
