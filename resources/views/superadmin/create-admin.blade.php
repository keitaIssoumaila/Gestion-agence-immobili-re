<div class="modal fade" id="createAdminModal" tabindex="-1">
    <div class="modal-dialog">
        <!-- Changement de la route pour correspondre à 'store-admin' -->
        <form action="{{ route('store-admin') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un administrateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Champ pour le nom -->
                    <div class="mb-3">
                        <label for="name">Nom</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    
                    <!-- Champ pour l'email -->
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    
                    <!-- Champ pour le mot de passe -->
                    <div class="mb-3">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    
                    <!-- Champ pour la confirmation du mot de passe -->
                    <div class="mb-3">
                        <label for="password_confirmation">Confirmation du mot de passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>
