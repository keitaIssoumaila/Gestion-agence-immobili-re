@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du Contrat</h1>

    <div class="card">
        <div class="card-header">
            {{ strtoupper(Auth::user()->agence->nom) }} - CONTRAT N° {{ $contrat->id }}
        </div>
        <div class="card-body">
            <p><strong>Date Début :</strong> {{ $contrat->date_debut }}</p>
            <p><strong>Date Fin :</strong> {{ $contrat->date_fin }}</p>
            <p><strong>Montant :</strong> {{ $contrat->montant }} FCFA</p>
            <p><strong>Bien :</strong> {{ $contrat->bien->nom }}</p>
            <p><strong>Locataire :</strong> {{ $contrat->locataire->nom }}</p>
            <p><strong>Description :</strong> {{ $contrat->description ?? 'Aucune description fournie.' }}</p>

            <button id="printContractButton" class="btn" title="Imprimer">
                <i class="fa fa-print"></i>
            </button>

            <a href="{{ route('contrats.index') }}" class="btn mt-2" title="Retour">
                <i class="fa fa-arrow-left"></i>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('printContractButton').addEventListener('click', function () {
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
