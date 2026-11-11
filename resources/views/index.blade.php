<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rental Mobil</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <!-- Tambahan Bootstrap CDN untuk styling navbar info user & tombol logout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- NAVBAR / INFO USER & TOMBOL LOGOUT -->
    <div class="position-absolute top-0 end-0 m-3 z-3 d-flex align-items-center gap-3 bg-white p-2 rounded shadow-sm border">
        @auth
            <span class="small text-dark">
                <b>{{ Auth::user()->name }}</b> 
                <span class="badge bg-primary text-uppercase">{{ Auth::user()->role }}</span>
            </span>
        @endauth
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm fw-bold px-3 shadow-sm">
                <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
            </button>
        </form>
    </div>

    <div class="container" style="margin-top: 60px;">
        <h1>Paket Rental Mobil</h1>
        <p style="text-align: center;">Silakan pilih paket rental dan lakukan pemesanan.</p>
        
        <div style="text-align: center;">
            <a href="{{ route('rental.create') }}" class="btn">📝 Form Pilih Paket & Pesan</a>
        </div>

        <div class="cards">
            @foreach ($paket_rental as $paket)
                <div class="card">
                    <h3>{{ $paket->nama_paket }}</h3>
                    <p>{{ $paket->deskripsi }}</p>
                    <p><strong>Harga/Hari:</strong> Rp {{ number_format($paket->harga_per_hari, 0, ',', '.') }}</p>
                    <p><strong>Biaya Driver:</strong> Rp {{ number_format($paket->biaya_driver, 0, ',', '.') }} /hari</p>
                    <p><strong>Ketentuan:</strong> {{ $paket->ketentuan }}</p>
                </div>
            @endforeach
        </div>

        <hr>

        <h2>Daftar Pemesan Rental Mobil</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pemesan</th>
                    <th>Pilihan Paket</th>
                    <th>Durasi (Hari)</th>
                    <th>Opsi Driver</th>
                    <th>Total Harga</th>
                    <th>Waktu Pesan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pemesanan_rental as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->nama_pemesan }}</td>
                        <td>{{ $row->nama_paket }}</td>
                        <td>{{ $row->jumlah_hari }} Hari</td>
                        <td>{{ $row->opsi_driver }}</td>
                        <td>Rp {{ number_format($row->total_harga, 0, ',', '.') }}</td>
                        <td>{{ $row->tanggal_pesan ?? $row->created_at }}</td>
                        <td>
                            <!-- Tombol Edit (Bisa diakses Admin & Staff) -->
                            <a href="{{ route('rental.edit', $row->id) }}" class="btn-edit">Edit</a>
                            
                            <!-- Tombol Hapus (HANYA MUNCUL JIKA ROLE == ADMIN) -->
                            @if(Auth::check() && Auth::user()->role == 'admin')
                                <form action="{{ route('rental.destroy', $row->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data pemesan ini?');" style="background:none; border:none; color:red; cursor:pointer; padding:0; font:inherit;">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan='8' style='text-align: center;'>Belum ada data pemesan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <footer>
        <p>Nama: Siti Meyyisa</p>
        <p>NIM: 102022530036</p>
        <p>Kelas: S1 Sistem Informasi</p>
        <p>Kelompok: Kelompok 5</p>
        <p>Modul: Paket Rental</p>
    </footer>

</body>
</html>