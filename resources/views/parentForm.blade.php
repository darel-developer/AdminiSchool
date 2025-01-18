<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription Parent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .gradient-custom-2 {
            background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
        }
    </style>
</head>
<body>
    <section class="h-100 gradient-form">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-6">
                    <div class="card rounded-3 text-black">
                        <div class="card-body p-md-5 mx-md-4">
                            <div class="text-center">
                                <h4 class="mb-5 pb-1">Inscription Parent</h4>
                            </div>
                            <form method="POST" action="/register/traitement">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="form-outline">
                                            <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First Name" value="{{ old('firstName') }}" required />
                                            <label class="form-label" for="firstName">First Name</label>
                                            @error('firstName')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-outline">
                                            <input type="text" id="secondName" name="secondName" class="form-control" placeholder="Second Name" value="{{ old('secondName') }}" required />
                                            <label class="form-label" for="secondName">Second Name</label>
                                            @error('secondName')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="text" id="childName" name="childName" class="form-control" placeholder="Nom de l'enfant" value="{{ old('childName') }}" required />
                                    <label class="form-label" for="childName">Nom de l'enfant</label>
                                    @error('childName')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-outline mb-4">
                                    <select id="schoolDropdown" name="SchoolName" class="form-select" required>
                                        <option value="">Aucune école disponible</option>
                                        @foreach ($schools as $school)
                                            <option value="{{ $school->schoolName }}">{{ $school->schoolName }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label" for="schoolDropdown">École</label>
                                    @error('SchoolName')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="email" id="username" name="username" class="form-control" placeholder="Email ou numéro de téléphone" value="{{ old('username') }}" required />
                                    <label class="form-label" for="username">Email ou numéro de téléphone</label>
                                    @error('username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe" required />
                                    <label class="form-label" for="password">Mot de passe</label>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirmer le mot de passe" required />
                                    <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
                                    @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-center pt-1 mb-5 pb-1">
                                    <button type="submit" class="btn btn-primary btn-block gradient-custom-2 mb-3">S'inscrire</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
