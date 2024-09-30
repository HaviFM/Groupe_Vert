<h1 class="text-center my-5">Inscriptions en attente de validation</h1>

@if(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.inscriptions.updateMultiple') }}" id="validationForm" class="container">
    @csrf
    @method('PUT')

    <table class="table table-bordered">
        <thead class="table-light text-center">
            <tr>
                <th>Éditer</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Date d'inscription</th>
                <th>Rôle</th>
                <th>Statut</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach($users as $user)
            <tr>
                <td class="align-middle">
                    <input type="checkbox" name="users[{{ $user->id }}][selected]" value="{{ $user->id }}" class="form-check-input" style="width: 20px; height: 20px;">
                </td>
                <td class="align-middle">
                    <input type="text" value="{{ $user->name }}" class="form-control" readonly> <!-- Nom affiché -->
                </td>
                <td class="align-middle">
                    <input type="text" value="{{ $user->email }}" class="form-control" readonly> <!-- Email affiché -->
                </td>
                <td class="align-middle">
                    <input type="text" value="{{ $user->created_at->format('d/m/Y') }}" class="form-control" readonly> <!-- Date d'inscription affichée -->
                </td>
                <td class="align-middle">
                    <select name="users[{{ $user->id }}][role]" class="form-select">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td class="align-middle">
                    <select name="users[{{ $user->id }}][statut]" class="form-select">
                        <option value="en_attente" {{ $user->statut == 'en_attente' ? 'selected' : '' }}>En Attente</option>
                        <option value="validé" {{ $user->statut == 'validé' ? 'selected' : '' }}>Validé</option>
                        <option value="refusé" {{ $user->statut == 'refusé' ? 'selected' : '' }}>Refusé</option>
                    </select>
                </td>
                <td class="align-middle">
                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-name="{{ $user->name }}" data-id="{{ $user->id }}">
                        Supprimer
                    </button>
                    <input type="hidden" name="users[{{ $user->id }}][delete]" value="0">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center mt-5">
        <button type="submit" class="btn btn-dark btn-lg">Valider changements</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#validationForm');

        form.addEventListener('submit', function(event) {
            const lignes = document.querySelectorAll('tbody tr');
            let selectedUsers = [];

            // Parcourir chaque ligne du tableau pour vérifier si la case "Éditer" est cochée
            lignes.forEach(ligne => {
                const checkbox = ligne.querySelector('input[type="checkbox"][name$="[selected]"]');
                const userName = ligne.querySelector('td:nth-child(2) input').value; // Nom de l'utilisateur

                // Si la case "Éditer" n'est pas cochée, désactiver tous les champs de cette ligne
                if (!checkbox.checked) {
                    const inputs = ligne.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        input.disabled = true;  // Désactiver les champs pour ne pas les soumettre
                    });
                } else {
                    selectedUsers.push(userName); // Ajouter le nom à la liste pour confirmation
                }
            });

            // Si des utilisateurs sont sélectionnés, afficher un message de confirmation
            if (selectedUsers.length > 0) {
                const confirmationMessage = `Voulez-vous vraiment valider les changements pour les utilisateurs suivants ?\n\n${selectedUsers.join('\n')}`;
                if (!confirm(confirmationMessage)) {
                    // Si l'utilisateur annule, empêcher l'envoi du formulaire
                    event.preventDefault();
                }
            } else {
                // Si aucun utilisateur n'est sélectionné, prévenir l'utilisateur et empêcher la soumission du formulaire
                alert("Aucun utilisateur sélectionné pour validation.");
                event.preventDefault();
            }
        });

        // Confirmation de suppression avec soft delete
        document.querySelectorAll('.delete-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const userName = this.getAttribute('data-name');
                const userId = this.getAttribute('data-id');
                if (confirm(`Êtes-vous sûr de vouloir supprimer l'utilisateur : ${userName} ?`)) {
                    document.querySelector(`input[name="users[${userId}][delete]"]`).value = 1;
                }
            });
        });
    });
</script>
