<!-- Exemple d'une vue blade (contrats/show.blade.php) -->

<form action="{{ route('contrats.terminer', $contrat->id) }}" method="POST">
    @csrf
    @method('POST')
    <button type="submit" class="btn btn-danger">
        Terminer le contrat
    </button>
</form>
