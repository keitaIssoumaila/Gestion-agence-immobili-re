@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-75">
        <div class="card-header text-center bg-primary text-white">
            {{ strtoupper(Auth::user()->agence->nom) }} - LISTE DES PROPRIÉTAIRES
        </div>
        <div class="card-body">
            <a href="{{ route('proprietaires.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Ajouter un Propriétaire
            </a>
            <table id="adminsTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proprietaires as $proprietaire)
                        <tr>
                            <td>{{ $proprietaire->id }}</td>
                            <td>{{ $proprietaire->nom }}</td>
                            <td>{{ $proprietaire->prenom }}</td>
                            <td>{{ $proprietaire->email }}</td>
                            <td>{{ $proprietaire->telephone }}</td>
                            <td>{{ $proprietaire->adresse }}</td>
                            <td>
                                <a href="{{ route('proprietaires.show', $proprietaire->id) }}" class="btn btn-sm" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('proprietaires.edit', $proprietaire->id) }}" class="btn btn-sm" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('proprietaires.destroy', $proprietaire->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" onclick="return confirm('Confirmer la suppression ?')" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                <button id="printButton{{ $reservation->id }}" class="btn btn-sm" title="Imprimer">
                                    <i class="fa fa-print"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Aucun propriétaire trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.getElementById('printButton').addEventListener('click', function () {
        const originalContent = document.body.innerHTML;
        const printContent = document.querySelector('table').outerHTML; // Cibler la table entière

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload(); // Recharge la page après impression
    });
</script>
@endpush
