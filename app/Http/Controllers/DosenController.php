<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    // Menampilkan dashboard dosen (daftar mahasiswa)
    public function dashboard()
    {
        $mahasiswaList = User::where('role', 'mahasiswa')->with('documents')->paginate(10);
        return view('dosen.dashboard', compact('mahasiswaList'));
    }

    // Menampilkan detail dokumen mahasiswa tertentu untuk dinilai
    public function viewSubmissions(User $mahasiswa)
    {
        // Pastikan user yang diakses adalah mahasiswa
        if (!$mahasiswa->isMahasiswa()) {
            abort(404, 'Mahasiswa tidak ditemukan.');
        }
        $documents = $mahasiswa->documents()->latest()->get();
        return view('dosen.submissions', compact('mahasiswa', 'documents'));
    }

    // Menyimpan/memperbarui nilai untuk sebuah dokumen
    public function gradeDocument(Request $request, Document $document)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
        ]);

        $document->update([
            'grade' => $request->grade,
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
    }
}