<!-- Modal de modification d'un administrateur -->
<div class="modal fade" id="editAdminModal-{{ $admin->id }}" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdminModalLabel">Modifier l'administrateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update-admin', $admin->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Champ Nom -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $admin->name }}" required>
                    </div>

                    <!-- Champ Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $admin->email }}" required>
                    </div>

                    <!-- Champ Agence -->
                    <div class="mb-3">
                        <label for="agence_id" class="form-label">Agence</label>
                        <select class="form-control" id="agence_id" name="agence_id" required>
                            @foreach($agences as $agence)
                                <option value="{{ $agence->id }}" {{ $agence->id == $admin->agence_id ? 'selected' : '' }}>{{ $agence->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Champ Mot de passe -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe (laisser vide pour ne pas modifier)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <!-- Champ Photo -->
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                        <!-- Prévisualisation de la photo actuelle -->
                        @if ($admin->photo)
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $admin->photo) }}" alt="Photo actuelle" class="img-thumbnail" style="width: 100px; height: 100px;">
                                <p class="text-muted mt-2">Photo actuelle</p>
                            </div>
                        @endif
                    </div>

                    <!-- Bouton Mettre à jour -->
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>
