@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du Bien</h1>

    <div class="card">
        <div class="card-header">
            {{ strtoupper($bien->nom) }}
        </div>
        <div class="card-body">
            <p><strong>Nom : </strong>{{ $bien->nom }}</p>
            <p><strong>Propriétaire : </strong>{{ $bien->proprietaire->nom ?? 'Non attribué' }}</p>
            <p><strong>Type : </strong>{{ $bien->type }}</p>
            <p><strong>Adresse : </strong>{{ $bien->adresse }}</p>
            <p><strong>Surface : </strong>{{ $bien->surface }} m²</p>
            <p><strong>Prix : </strong>{{ $bien->prix }} FCFA</p>
            <p><strong>Status : </strong>{{ $bien->status }}</p>
            <p><strong>Description : </strong>{{ $bien->description }}</p>

            <button id="printButton" class="btn" title="Imprimer">
                <i class="fa fa-print"></i> 
            </button>

            <a href="{{ route('biens.index') }}" class="btn  mt-2" title="Retour">
                <i class="fa fa-arrow-left"></i>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('printButton').addEventListener('click', function () {
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
