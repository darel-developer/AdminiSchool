<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
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
        <form id="notificationForm" method="POST" action="{{ route('notifications.send') }}">
            @csrf
            <div class="mb-3">
                <label for="classe" class="form-label">Sélectionnez une classe</label>
                <select class="form-control" id="classe" name="classe_id" required>
                    <option value="">Sélectionnez une classe</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->nom }}">{{ $classe->nom }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" class="btn btn-secondary" id="loadStudentsBtn">Charger les élèves</button>
            <div id="elevesContainer" class="mb-3" style="display: none;">
                <label for="eleves" class="form-label">Sélectionnez les élèves</label>
                <div id="elevesList"></div>
            </div>
            <button type="button" class="btn btn-primary" id="openModalBtn" style="display: none;">Envoyer Notification</button>
        </form>
    </div>

    <!-- Modal -->
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
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('loadStudentsBtn').addEventListener('click', function() {
            const classeNom = document.getElementById('classe').value;
            if (classeNom) {
                fetch(`/api/eleves?classe_nom=${classeNom}`)
                    .then(response => response.json())
                    .then(data => {
                        const elevesContainer = document.getElementById('elevesContainer');
                        const elevesList = document.getElementById('elevesList');
                        elevesList.innerHTML = '';
                        data.forEach(eleve => {
                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'eleves[]';
                            checkbox.value = eleve.id;
                            checkbox.id = `eleve_${eleve.id}`;
                            const label = document.createElement('label');
                            label.htmlFor = `eleve_${eleve.id}`;
                            label.textContent = eleve.nom;
                            const div = document.createElement('div');
                            div.appendChild(checkbox);
                            div.appendChild(label);
                            elevesList.appendChild(div);
                        });
                        elevesContainer.style.display = 'block';
                        document.getElementById('openModalBtn').style.display = 'block';
                    });
            } else {
                document.getElementById('elevesContainer').style.display = 'none';
                document.getElementById('openModalBtn').style.display = 'none';
            }
        });

        document.getElementById('openModalBtn').addEventListener('click', function() {
            document.getElementById('myModal').style.display = 'block';
        });

        document.querySelector('.close').addEventListener('click', function() {
            document.getElementById('myModal').style.display = 'none';
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
            form.submit();
        });
    </script>
</body>
</html>