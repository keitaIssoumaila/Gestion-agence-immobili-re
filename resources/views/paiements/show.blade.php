@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du Paiement</h1>
    <ul class="list-group">
        <li class="list-group-item"><strong>ID :</strong> {{ $paiement->id }}</li>
        <li class="list-group-item"><strong>Date de Paiement :</strong> {{ $paiement->date_paiement }}</li>
        <li class="list-group-item"><strong>Montant :</strong> {{ $paiement->montant }}</li>
        <li class="list-group-item"><strong>Status :</strong> {{ $paiement->status }}</li>
        <li class="list-group-item"><strong>Contrat :</strong> Contrat #{{ $paiement->contrat->id }}</li>
    </ul>
    <a href="{{ route('paiements.index') }}" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
    <a href="{{ route('paiements.receipt', $paiement->id) }}" class="btn btn-secondary mt-3">
        <i class="fas fa-print"></i> Imprimer le reçu
    </a>
</div>
@endsection
