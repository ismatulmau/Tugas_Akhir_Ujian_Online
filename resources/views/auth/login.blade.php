<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Halaman Masuk - Sistem">
    <meta name="author" content="Sistem">
    <title>Masuk Akun</title>

    <link rel="shortcut icon" href="style/login/img/icons/icon-48x48.png" />
    <link href="style/login/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #4e73df, #224abe);
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn-primary {
            background-color: #4e73df;
            border: none;
            border-radius: 0.5rem;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
        }

        .logo-title {
            font-size: 2rem;
            font-weight: 600;
            color: #fff;
        }

        .logo-subtitle {
            font-size: 1rem;
            color: #e5e5e5;
        }
    </style>
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mb-4">
                            <h1 class="logo-title">Selamat Datang</h1>
                            <p class="logo-subtitle">Silakan masuk untuk melanjutkan ke sistem</p>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <form method="POST" action="{{ route('login.submit') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Usename / Nomor Ujian</label>
                                        <input class="form-control form-control-lg" type="text" name="username"
                                            placeholder="Masukkan nama pengguna" required autofocus />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control form-control-lg" type="password" name="password"
                                            placeholder="Masukkan kata sandi" required />
                                    </div>
                                    <div class="d-grid mt-4">
                                        <button type="submit" class="btn btn-lg btn-primary">
                                            <i class="fas fa-sign-in-alt me-2"></i>Login
                                        </button>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger mt-3">
                                            <strong>{{ $errors->first() }}</strong>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>

                        <div class="text-center text-white mt-4">
                            <small>© {{ date('Y') }} Aplikasi Ujian Online. SMK Telematika Indramayu.</small>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="style/login/js/app.js"></script>
</body>

</html>
