@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-75">
        <div class="card-header text-center bg-primary text-white">
            {{ strtoupper(Auth::user()->agence->nom) }} - LISTE DES LOCATAIRES
        </div>
        <div class="card-body">
            <a href="{{ route('locataires.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Ajouter un Locataire
            </a>
            <table id="adminsTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Genre</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locataires as $locataire)
                        <tr>
                            <td>{{ $locataire->id }}</td>
                            <td>{{ $locataire->nom }}</td>
                            <td>{{ $locataire->prenom }}</td>
                            <td>{{ $locataire->email }}</td>
                            <td>{{ $locataire->genre }}</td>
                            <td>{{ $locataire->telephone }}</td>
                            <td>{{ $locataire->adresse }}</td>
                            <td>
                                <a href="{{ route('locataires.show', $locataire->id) }}" class="btn btn-sm" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('locataires.edit', $locataire->id) }}" class="btn btn-sm" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('locataires.destroy', $locataire->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce locataire ?')" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                <button id="printButton" class="btn btn-sm" title="Imprimer"> 
                                    <i class="fa fa-print"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Aucun locataire trouvé</td>
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
