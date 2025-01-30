<div class="modal fade" id="createAdminModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('store-admin') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un administrateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Groupement des champs Nom et Email -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name">Nom</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <!-- Groupement des champs Mot de passe et Confirmation -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password">Mot de passe</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation">Confirmation du mot de passe</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <!-- Champ pour sélectionner une agence -->
                    <div class="mb-3">
                        <label for="agence_id">Agence</label>
                        <select id="agence_id" name="agence_id" class="form-control" required>
                            @foreach ($agences as $agence)
                                <option value="{{ $agence->id }}">{{ $agence->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Champ pour ajouter une photo -->
                    <div class="mb-3">
                        <label for="photo">Photo</label>
                        <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>
