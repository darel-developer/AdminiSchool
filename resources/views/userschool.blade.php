<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tuteurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
        }
        .sidebar-title {
            font-family: 'Lemonada', sans-serif;
            font-weight: 600;
            font-size: 1.8rem;
            text-align: center;
            color: #ecf0f1;
            margin-bottom: 20px;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: #bdc3c7;
            font-weight: 500;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        .sidebar-item:hover {
            background-color: #34495e;
            color: #ecf0f1;
        }
        .sidebar-item img {
            width: 25px;
            height: 25px;
            margin-right: 15px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            background: #fff;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-title">ADMINISCHOOL</div>
        <a href="{{route('dashboard')}}" class="sidebar-item">
            <img src="{{ asset('images/Statistics.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="{{route('school')}}" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            DONNEES
        </a>
        <a href="{{ route('documentschool') }}" class="sidebar-item">
            <img src="{{ asset('images/Add_Document.png') }}" alt="document">
            Documents
        </a>
        <a href="{{ route('eventschool') }}" class="sidebar-item">
            <img src="{{ asset('images/Event.png') }}" alt="event">
            Evenements
        </a>
        <a href="{{ route('schoolpaiement') }}" class="sidebar-item">
            <img src="{{ asset('images/paiement.png') }}" alt="payment">
            Payments
        </a>
        
        <a href="{{route('userschool')}}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="user">
            Utilisateur
        </a>
        <a href="{{route('studentschool')}}" class="sidebar-item">
            <img src="{{ asset('images/action.png') }}" alt="user">
            Etudiant
        </a>
        <a href="{{ route('create.teacher') }}" class="sidebar-item">
            <img src="{{ asset('images/teacher.png') }}" alt="teacher">
            Créer enseignant
        </a>
        <a href="{{ route('cahiertexte') }}" class="sidebar-item">
            <img src="{{ asset('images/Book.png') }}" alt="teacher">
           cahier de texte
        </a>
      
        <a href="{{ route('helpsupport') }}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>
    <div class="content">
        <div class="container mt-5">
            <h1>Liste des Utilisateurs</h1>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Table des tuteurs -->
            <div class="d-flex justify-content-between align-items-center">
                <h2>Tuteurs</h2>
                <button class="btn btn-outline-secondary" onclick="printTable('tuteursTable')" title="Imprimer la liste des tuteurs">
                    <img src="https://img.icons8.com/ios-filled/24/000000/print.png" alt="Imprimer" style="width:20px;height:20px;">
                </button>
            </div>
            <table class="table table-bordered" id="tuteursTable">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Numéro de Téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tuteurs->take(5) as $tuteur)
                        <tr>
                            <td>{{ $tuteur->nom }}</td>
                            <td>{{ $tuteur->prenom }}</td>
                            <td>{{ $tuteur->email }}</td>
                            <td>{{ $tuteur->phone_number }}</td>
                            <td>
                                <a href="{{ route('users.edit', $tuteur->id) }}" class="btn btn-warning">Modifier</a>
                                <form action="{{ route('users.delete', $tuteur->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($tuteurs->count() > 5)
                <a href="{{ url('/userschool/tuteurs') }}" target="_blank" class="btn btn-primary mb-3">Voir plus</a>
            @endif

            <!-- Table des enseignants -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h2>Enseignants</h2>
                <button class="btn btn-outline-secondary" onclick="printTable('enseignantsTable')" title="Imprimer la liste des enseignants">
                    <img src="https://img.icons8.com/ios-filled/24/000000/print.png" alt="Imprimer" style="width:20px;height:20px;">
                </button>
            </div>
            <table class="table table-bordered" id="enseignantsTable">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Numéro de Téléphone</th>
                        <th>Matière</th>
                        <th>Classe</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers->take(5) as $teacher)
                        <tr>
                            <td>{{ $teacher->first_name }}</td>
                            <td>{{ $teacher->last_name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->phone }}</td>
                            <td>{{ $teacher->subject }}</td>
                            <td>{{ $teacher->classe ? $teacher->classe->name : 'Aucune' }}</td>
                            <td>
                                <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-warning">Modifier</a>
                                <form action="{{ route('teachers.delete', $teacher->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($teachers->count() > 5)
                <a href="{{ url('/userschool/enseignants') }}" target="_blank" class="btn btn-primary mb-3">Voir plus</a>
            @endif
        </div>
    </div>

    <!-- Fenêtre modale -->
    

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fonction pour imprimer un tableau spécifique
        function printTable(tableId) {
            var printContents = document.getElementById(tableId).outerHTML;
            var originalContents = document.body.innerHTML;
            var win = window.open('', '', 'height=700,width=900');
            win.document.write('<html><head><title>Impression</title>');
            win.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">');
            win.document.write('</head><body>');
            win.document.write(printContents);
            win.document.write('</body></html>');
            win.document.close();
            win.focus();
            setTimeout(function(){ win.print(); win.close(); }, 500);
        }
    </script>
</body>
</html>