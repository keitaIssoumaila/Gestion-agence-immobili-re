@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Paiements</h1>
    <a href="{{ route('paiements.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Ajouter un paiement
    </a>
    <table id="adminsTable" class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Date de Paiement</th>
                <th>Montant</th>
                <th>Status</th>
                <th>Contrat</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($paiements as $paiement)
                <tr>
                    <td>{{ $paiement->id }}</td>
                    <td>{{ $paiement->date_paiement }}</td>
                    <td>{{ $paiement->montant }}</td>
                    <td>{{ $paiement->status }}</td>
                    <td>{{ $paiement->contrat->id }}</td>
                    <td>
                        <a href="{{ route('paiements.show', $paiement->id) }}" class="btn btn-sm" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('paiements.edit', $paiement->id) }}" class="btn btn-sm" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('paiements.destroy', $paiement->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        <a href="{{ route('paiements.receipt', $paiement->id) }}" class="btn btn-sm" title="Imprimer le reçu">
                            <i class="fas fa-print"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Aucun paiement trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
