<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaketRental;
use App\Models\PemesananRental;

class RentalController extends Controller
{
    // Menampilkan halaman utama (index) beserta daftar paket dan pemesanan
    public function index()
    {
        $paket_rental = PaketRental::all();
        $pemesanan_rental = PemesananRental::orderBy('id', 'desc')->get();

        return view('index', compact('paket_rental', 'pemesanan_rental'));
    }

    // Menampilkan form tambah pemesanan
    public function create()
    {
        $paket_rental = PaketRental::all();
        return view('tambah-paket', compact('paket_rental'));
    }

    // Menyimpan data pemesanan baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'paket_rental_id' => 'required',
            'durasi' => 'required|integer|min:1',
            'opsi_driver' => 'required|string',
        ]);

        $paket = PaketRental::find($request->paket_rental_id);
        
        $nama_paket = $paket ? $paket->nama_paket : '';
        $jumlah_hari = $request->durasi;
        $opsi_driver = $request->opsi_driver;
        
        // Logika otomatis Paket Lepas Kunci (tanpa driver & biaya driver 0)
        $biaya_driver = 0;
        if ($paket && strtolower($paket->nama_paket) == 'paket lepas kunci') {
            $opsi_driver = 'Tanpa Driver';
            $biaya_driver = 0;
        } else if ($opsi_driver == 'Dengan Driver' && $paket) {
            $biaya_driver = $paket->biaya_driver;
        }

        $harga_per_hari = $paket ? $paket->harga_per_hari : 0;
        $total_harga = ($harga_per_hari + $biaya_driver) * $jumlah_hari;

        PemesananRental::create([
            'nama_pemesan' => $request->nama_pemesan,
            'nama_paket' => $nama_paket,
            'jumlah_hari' => $jumlah_hari,
            'opsi_driver' => $opsi_driver,
            'total_harga' => $total_harga,
        ]);

        return redirect()->route('rental.index')->with('success', 'Pemesanan berhasil ditambahkan!');
    }

    // Menampilkan form edit pemesanan
    public function edit($id)
    {
        $pemesanan = PemesananRental::findOrFail($id);
        $paket_rental = PaketRental::all();
        
        // Jika kamu punya view khusus edit, arahkan ke view tersebut (misal: 'edit-paket' atau 'edit')
        return view('edit-paket', compact('pemesanan', 'paket_rental'));
    }

    // Memperbarui data pemesanan
    public function update(Request $request, $id)
    {
        $pemesanan = PemesananRental::findOrFail($id);
        
        $paket = PaketRental::find($request->paket_rental_id);
        $nama_paket = $paket ? $paket->nama_paket : $pemesanan->nama_paket;
        $jumlah_hari = $request->durasi ?? $pemesanan->jumlah_hari;
        $opsi_driver = $request->opsi_driver ?? $pemesanan->opsi_driver;

        $biaya_driver = 0;
        if ($paket && strtolower($paket->nama_paket) == 'paket lepas kunci') {
            $opsi_driver = 'Tanpa Driver';
            $biaya_driver = 0;
        } else if ($opsi_driver == 'Dengan Driver' && $paket) {
            $biaya_driver = $paket->biaya_driver;
        }

        $harga_per_hari = $paket ? $paket->harga_per_hari : 0;
        $total_harga = ($harga_per_hari + $biaya_driver) * $jumlah_hari;

        $pemesanan->update([
            'nama_pemesan' => $request->nama_pemesan ?? $pemesanan->nama_pemesan,
            'nama_paket' => $nama_paket,
            'jumlah_hari' => $jumlah_hari,
            'opsi_driver' => $opsi_driver,
            'total_harga' => $total_harga,
        ]);

        return redirect()->route('rental.index')->with('success', 'Pemesanan berhasil diperbarui!');
    }

    // Menghapus data pemesanan
    public function destroy($id)
    {
        PemesananRental::where('id', $id)->delete();
        return redirect()->route('rental.index')->with('success', 'Data pemesanan berhasil dihapus!');
    }
}