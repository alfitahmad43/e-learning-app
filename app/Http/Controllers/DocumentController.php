<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // Menampilkan form upload dan daftar dokumen mahasiswa yang login
    public function index()
    {
        if (Auth::user()->isMahasiswa()) {
            $documents = Auth::user()->documents()->latest()->get();
            return view('documents.index', compact('documents'));
        }
        // Jika bukan mahasiswa, bisa diarahkan ke halaman lain atau error
        abort(403, 'Hanya Mahasiswa yang bisa mengakses halaman ini.');
    }

    // Menyimpan dokumen yang diupload
    public function store(Request $request)
    {
        if (!Auth::user()->isMahasiswa()) {
            abort(403, 'Hanya Mahasiswa yang bisa melakukan aksi ini.');
        }

        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048', // Validasi file
        ]);

        $file = $request->file('document');
        $originalFileName = $file->getClientOriginalName();
        // Simpan file ke storage/app/public/documents/{user_id}
        $filePath = $file->store('documents/' . Auth::id(), 'public');

        Document::create([
            'user_id' => Auth::id(),
            'file_name' => basename($filePath),
            'file_path' => $filePath,
            'original_file_name' => $originalFileName,
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diunggah!');
    }

    // (Opsional) Method untuk menghapus dokumen
    public function destroy(Document $document)
    {
        // Pastikan hanya pemilik dokumen atau dosen yang bisa menghapus
        if (Auth::id() !== $document->user_id && !Auth::user()->isDosen()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus dokumen ini.');
        }

        // Hapus file dari storage
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }
}