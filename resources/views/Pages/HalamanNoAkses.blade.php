<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .error-icon {
            font-size: 4rem;
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center p-4">
                    <div class="card-body">
                        <div class="error-icon mb-3">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <h3 class="card-title text-danger">Akses Ditolak</h3>
                        <p class="card-text">Maaf, Anda tidak memiliki hak untuk mengakses halaman ini.</p>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>
