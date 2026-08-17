<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $query = Guru::with('user');

        if ($q) {
            $query->where(function($query) use ($q) {
                $query->where('nip', 'like', "%{$q}%")
                      ->orWhere('nama', 'like', "%{$q}%")
                      ->orWhere('mata_pelajaran', 'like', "%{$q}%")
                      ->orWhere('no_hp', 'like', "%{$q}%");
            });
        }

        $gurus = $query->orderBy('nama')->get();
        return view('guru.index', compact('gurus', 'q'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:guru,staff',
            'posisi' => 'nullable|string|max:255',
            'nip' => 'nullable|string|unique:gurus,nip',
            'nama' => 'required|string|max:255',
            'mata_pelajaran' => 'required_if:kategori,guru|nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nip.unique' => 'NIP sudah terdaftar.',
            'email.unique' => 'Email login sudah digunakan.',
            'email.required' => 'Email login wajib diisi.',
            'password.required' => 'Password login wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'nama.required' => 'Nama wajib diisi.',
            'mata_pelajaran.required_if' => 'Mata pelajaran wajib diisi untuk Guru.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('guru_foto', 'public');
        }

        $nip = $request->filled('nip') ? trim($request->nip) : null;
        $noHp = $request->filled('no_hp') ? trim($request->no_hp) : null;

        DB::transaction(function () use ($request, $fotoPath, $nip, $noHp) {
            // Create User account
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'guru', // Kept as guru to keep auth logic working, or we can use the requested kategori if supported
            ]);

            // Create Guru/Staff record
            $guru = Guru::create([
                'kategori' => $request->kategori,
                'posisi' => $request->posisi,
                'nip' => $nip,
                'nama' => $request->nama,
                'mata_pelajaran' => $request->kategori === 'guru' ? $request->mata_pelajaran : null,
                'no_hp' => $noHp,
                'foto' => $fotoPath,
                'user_id' => $user->id,
            ]);

            // Link back to user
            $user->update(['guru_id' => $guru->id]);
        });

        return redirect()->route('guru.index')->with('success', 'Data Guru dan Akun Login berhasil dibuat.');
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'kategori' => 'required|in:guru,staff',
            'posisi' => 'nullable|string|max:255',
            'nip' => 'nullable|string|unique:gurus,nip,' . $guru->id,
            'nama' => 'required|string|max:255',
            'mata_pelajaran' => 'required_if:kategori,guru|nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . ($guru->user ? $guru->user->id : 'NULL'),
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nip.unique' => 'NIP sudah terdaftar.',
            'email.unique' => 'Email login sudah digunakan.',
            'email.required' => 'Email login wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'mata_pelajaran.required_if' => 'Mata pelajaran wajib diisi untuk Guru.',
        ]);

        $nip = $request->filled('nip') ? trim($request->nip) : null;
        $noHp = $request->filled('no_hp') ? trim($request->no_hp) : null;

        $data = [
            'kategori' => $request->kategori,
            'posisi' => $request->posisi,
            'nip' => $nip,
            'nama' => $request->nama,
            'mata_pelajaran' => $request->kategori === 'guru' ? $request->mata_pelajaran : null,
            'no_hp' => $noHp,
        ];

        if ($request->hasFile('foto')) {
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            $data['foto'] = $request->file('foto')->store('guru_foto', 'public');
        }

        $guru->update($data);

        // Update user account
        if ($guru->user) {
            $userData = [
                'name' => $request->nama,
                'email' => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $guru->user->update($userData);
        } else {
            // Create user account if missing
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password ?? 'guru1234'),
                'role' => 'guru',
                'guru_id' => $guru->id,
            ]);
            $guru->update(['user_id' => $user->id]);
        }

        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        if ($guru->user) {
            $guru->user->delete();
        } else {
            $guru->delete();
        }

        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil dihapus.');
    }
}
