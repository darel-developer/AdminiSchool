<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription d'une École</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .gradient-custom-2 {
            background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
        }
        @media (min-width: 768px) {
            .gradient-form {
                height: 100vh;
            }
        }
        @media (min-width: 769px) {
            .gradient-custom-2 {
                border-top-right-radius: .3rem;
                border-bottom-right-radius: .3rem;
            }
        }
    </style>
</head>
<body>
<section class="h-300 gradient-form">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">
                                <div class="text-center">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp"
                                        style="width: 185px;" alt="logo">
                                    <h4 class="mt-1 mb-5 pb-1">Inscription de l'école</h4>
                                </div>
                                <form method="POST" action="/register/traitement">
                                    @csrf
                                    <div class="form-outline mb-4">
                                        <input type="text" id="schoolName" name="schoolName" class="form-control" placeholder="Nom de l'école" value="{{ old('schoolName') }}" required />
                                        <label class="form-label" for="schoolName">Nom de l'école</label>
                                        @error('schoolName')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email de l'école" value="{{ old('email') }}" required />
                                        <label class="form-label" for="email">Email</label>
                                        @error('email')
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
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirmez le mot de passe" required />
                                        <label class="form-label" for="password_confirmation">Confirmation du mot de passe</label>
                                        @error('password_confirmation')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <button type="submit" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">Inscrire l'école</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                            <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                <h4 class="mb-4">Rejoignez notre réseau éducatif</h4>
                                <p class="small mb-0">Inscrivez votre école et bénéficiez d'une plateforme performante pour la gestion scolaire.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
