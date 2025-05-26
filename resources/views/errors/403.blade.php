<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 text-center">
                <h1 class="display-1 text-danger">404</h1>
                <h2 class="mb-4">Halaman Tidak Ditemukan</h2>
                <div class="alert alert-warning">
                    <h4 class="alert-heading">Akses Ditolak!</h4>
                    <p>Maaf, halaman ini hanya dapat diakses oleh Administrator.</p>
                    <p>Jika Anda adalah Administrator, silakan login terlebih dahulu.</p>
                </div>
                <a href="{{ route('login') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html> 