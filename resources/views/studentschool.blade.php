<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        select.form-control {
            color: #000; /* Couleur du texte */
            background-color: #fff; /* Couleur de fond */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Notifications</h1>
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="mb-3">
            <input type="text" id="searchBar" class="form-control" placeholder="Rechercher un élève...">
        </div>
        <form id="notificationForm" method="POST" action="{{ route('notifications.send') }}">
            @csrf
            <div id="elevesContainer" class="mb-3">
                <label for="eleves" class="form-label">Sélectionnez les élèves</label>
                <div id="elevesList">
                    @foreach($students as $student)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="eleves[]" value="{{ $student->id }}" id="eleve_{{ $student->id }}">
                            <label class="form-check-label" for="eleve_{{ $student->id }}">
                                {{ $student->name }} - Classe: {{ $student->classe ? $student->classe->name : 'Non assignée' }}
                            </label>
                            <hr>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="openModalBtn">Terminer</button>
        </form>
    </div>

    <!-- First Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Choisissez le motif</h2>
            <form id="motifForm">
                <div class="mb-3">
                    <label for="motif" class="form-label">Motif</label>
                    <select class="form-control" id="motif" name="motif" required>
                        <option value="absence">Absence</option>
                        <option value="convocation">Convocation</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Suivant</button>
            </form>
        </div>
    </div>

    <!-- Second Modal -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Détails du motif</h2>
            <form id="detailsForm">
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-control" id="type" name="type" required>
                        <!-- Options will be dynamically populated based on the selected motif -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="heure" class="form-label">Heure</label>
                    <input type="time" class="form-control" id="heure" name="heure" required>
                </div>
                <div class="mb-3" id="customTypeContainer" style="display: none;">
                    <label for="customType" class="form-label">Type personnalisé</label>
                    <input type="text" class="form-control" id="customType" name="customType">
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>

    <script>
        const absenceTypes = [
            { value: 'retard', text: 'Retard' },
            { value: 'maladie', text: 'Maladie' },
            { value: 'autre', text: 'Autre' }
        ];

        const convocationTypes = [
            { value: 'reunion', text: 'Réunion' },
            { value: 'discipline', text: 'Discipline' },
            { value: 'bagarre', text: 'Bagarre'},
            { value: 'autre', text: 'Autre' }
        ];

        document.getElementById('searchBar').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const eleves = document.querySelectorAll('#elevesList .form-check');
            eleves.forEach(eleve => {
                const name = eleve.querySelector('label').textContent.toLowerCase();
                if (name.includes(searchTerm)) {
                    eleve.style.display = '';
                } else {
                    eleve.style.display = 'none';
                }
            });
        });

        document.getElementById('openModalBtn').addEventListener('click', function() {
            const modal = document.getElementById('myModal');
            modal.style.display = 'block';
        });

        document.querySelectorAll('.close').forEach(closeBtn => {
            closeBtn.addEventListener('click', function() {
                const modal = this.closest('.modal');
                modal.style.display = 'none';
            });
        });

        window.addEventListener('click', function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
        });

        document.getElementById('motifForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const motif = document.getElementById('motif').value;
            const form = document.getElementById('notificationForm');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'motif';
            input.value = motif;
            form.appendChild(input);

            // Populate the "Type" dropdown based on the selected motif
            const typeSelect = document.getElementById('type');
            typeSelect.innerHTML = ''; // Clear existing options
            const types = motif === 'absence' ? absenceTypes : convocationTypes;
            types.forEach(type => {
                const option = document.createElement('option');
                option.value = type.value;
                option.textContent = type.text;
                typeSelect.appendChild(option);
            });

            const modal = document.getElementById('myModal');
            modal.style.display = 'none';

            const detailsModal = document.getElementById('detailsModal');
            detailsModal.style.display = 'block';
        });

        document.getElementById('type').addEventListener('change', function() {
            const customTypeContainer = document.getElementById('customTypeContainer');
            if (this.value === 'autre') {
                customTypeContainer.style.display = 'block';
            } else {
                customTypeContainer.style.display = 'none';
            }
        });

        document.getElementById('detailsForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const type = document.getElementById('type').value;
            const heure = document.getElementById('heure').value;
            const customType = document.getElementById('customType').value;

            const form = document.getElementById('notificationForm');
            const typeInput = document.createElement('input');
            typeInput.type = 'hidden';
            typeInput.name = 'type';
            typeInput.value = type === 'autre' ? customType : type;
            form.appendChild(typeInput);

            const heureInput = document.createElement('input');
            heureInput.type = 'hidden';
            heureInput.name = 'heure';
            heureInput.value = heure;
            form.appendChild(heureInput);

            form.submit();
        });
    </script>
</body>
</html>