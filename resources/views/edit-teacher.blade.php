<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Enseignant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Modifier Enseignant</h1>
        <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="first_name" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $teacher->first_name }}" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $teacher->last_name }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $teacher->email }}" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Numéro de Téléphone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $teacher->phone }}" required>
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Matière</label>
                <input type="text" class="form-control" id="subject" name="subject" value="{{ $teacher->subject }}" required>
            </div>
            <div class="mb-3">
                <label for="class_id" class="form-label">Classe</label>
                <select class="form-control" id="class_id" name="class_id">
                    <option value="">Aucune</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $teacher->class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
</body>
</html>
