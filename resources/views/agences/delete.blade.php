<div class="modal fade" id="deleteModal{{ $agence->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $agence->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $agence->id }}">Supprimer l'agence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer agence : <strong>{{ $agence->nom }}</strong> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                <form action="{{ route('agences.destroy', $agence->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Oui</button>
                </form>
            </div>
        </div>
    </div>
</div>
