<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil du Tuteur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card {
            border-radius: 15px;
            overflow: hidden;
        }
        .card-header {
            border-bottom: 2px solid #ddd;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table thead {
            background-color: #343a40;
            color: white;
        }
        table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tbody tr:hover {
            background-color: #e9ecef;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h1>Profil du Tuteur</h1>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('tuteur.updateProfile') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ $tuteur->nom }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $tuteur->prenom }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $tuteur->email }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">Numéro de Téléphone</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $tuteur->phone_number }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
                </form>

                <h2 class="mt-5 text-center">Enfants Associés</h2>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Classe</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->class }}</td>
                                <td>{{ $student->enrollment_date }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editChild({{ $student->id }}, '{{ $student->name }}', '{{ $student->class }}')">Modifier</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Formulaire de modification des données de l'enfant -->
                <div id="editChildFormContainer" class="mt-5" style="display: none;">
                    <h2>Modifier les données de l'enfant</h2>
                    <form id="editChildForm" method="POST">
                        @csrf
                        <input type="hidden" id="childId" name="child_id">
                        <div class="mb-3">
                            <label for="childName" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="childName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="childClass" class="form-label">Classe</label>
                            <select class="form-control" id="childClass" name="class_id" required>
                                @foreach($classes as $class)
                                    <option value="{{ $class->name }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="submitEditChildForm()">Mettre à jour</button>
                    </form>
                </div>

                <script>
                    function editChild(id, name, className) {
                        document.getElementById('editChildFormContainer').style.display = 'block';
                        document.getElementById('childId').value = id;
                        document.getElementById('childName').value = name;
                        document.getElementById('childClass').value = className;
                    }

                    function submitEditChildForm() {
                        const form = document.getElementById('editChildForm');
                        const formData = new FormData(form);
                        const childId = document.getElementById('childId').value;

                        fetch(`/child/update/${childId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: formData,
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Données mises à jour avec succès.');
                                location.reload(); // Reload the page to reflect changes
                            } else {
                                alert('Erreur lors de la mise à jour des données.');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de la mise à jour des données :', error);
                        });
                    }
                </script>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>