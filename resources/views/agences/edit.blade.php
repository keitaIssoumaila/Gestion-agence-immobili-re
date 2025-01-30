<div class="modal fade" id="editModal{{ $agence->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $agence->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 
                    class="modal-title text-uppercase text-center" 
                    id="editModalLabel{{ $agence->id }}">
                    Mettre à jour les informations de l'{{ $agence->nom }}
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('agences.update', $agence->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" value="{{ $agence->nom }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control" value="{{ $agence->adresse }}" required>
                        </div>
                    </div>
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $agence->email }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="site_web" class="form-label">Site web</label>
                            <input type="text" name="site_web" class="form-control" value="{{ $agence->site_web }}">
                        </div>
                    </div>
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control" value="{{ $agence->telephone }}">
                        </div>
                        <div class="col-md-6">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" name="logo" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
