@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du Locataire</h1>

    <div class="card">
        <div class="card-header">
            {{ strtoupper(Auth::user()->agence->nom) }} - LOCATAIRE : {{ $locataire->nom }} {{ $locataire->prenom }}
        </div>
        <div class="card-body">
            <p><strong>Nom :</strong> {{ $locataire->nom }}</p>
            <p><strong>Prénom :</strong> {{ $locataire->prenom }}</p>
            <p><strong>Email :</strong> {{ $locataire->email }}</p>
            <p><strong>Genre :</strong> {{ $locataire->genre }}</p>
            <p><strong>Téléphone :</strong> {{ $locataire->telephone }}</p>
            <p><strong>Adresse :</strong> {{ $locataire->adresse }}</p>

            <button id="printLocataireButton" class="btn btn-primary" title="Imprimer">
                <i class="fas fa-print"></i> 
            </button>

            <a href="{{ route('locataires.index') }}" class="btn btn-secondary mt-2" title="Retour">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('printLocataireButton').addEventListener('click', function () {
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
