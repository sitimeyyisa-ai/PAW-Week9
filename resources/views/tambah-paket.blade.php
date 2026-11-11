<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Rental Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Form Pilih Paket & Pemesanan</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rental.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                                <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" required>
                            </div>

                            <div class="mb-3">
                                <label for="paket_rental_id" class="form-label">Pilihan Paket Rental</label>
                                <select class="form-select" id="paket_rental_id" name="paket_rental_id" required>
                                    <option value="">-- Pilih Paket Rental --</option>
                                    @foreach($paket_rental as $paket)
                                        <option value="{{ $paket->id }}">{{ $paket->nama_paket }} (Rp {{ number_format($paket->harga_per_hari, 0, ',', '.') }}/hari)</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="durasi" class="form-label">Durasi (Hari)</label>
                                <input type="number" class="form-control" id="durasi" name="durasi" min="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="opsi_driver" class="form-label">Opsi Driver</label>
                                <select class="form-select" id="opsi_driver" name="opsi_driver" required>
                                    <option value="Dengan Driver">Dengan Driver</option>
                                    <option value="Tanpa Driver">Tanpa Driver (Lepas Kunci)</option>
                                </select>
                                <div class="form-text text-muted">Catatan: Jika memilih "Paket Lepas Kunci", sistem otomatis mengaturnya tanpa driver.</div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('rental.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-success">Simpan Pemesanan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>