<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $guru = $user->isGuru() ? $user->guru : null;
        $siswa = $user->isSiswa() ? $user->siswa : null;

        return view('profile.edit', compact('user', 'guru', 'siswa'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Basic User Validation Rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'password' => 'nullable|string|min:8|confirmed',
        ];

        // 2. Role-specific Validation Rules for Guru
        if ($user->isGuru() && $user->guru) {
            $rules['nip'] = 'nullable|string|max:100|unique:gurus,nip,' . $user->guru->id;
            $rules['mata_pelajaran'] = 'required|string|max:255';
            $rules['no_hp'] = 'nullable|string|max:25';
        }

        $validated = $request->validate($rules);

        // 3. Handle Profile Photo Upload
        if ($request->hasFile('foto')) {
            // Delete old user photo if exists
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $fotoPath = $request->file('foto')->store('profiles', 'public');
            $user->foto = $fotoPath;
        }

        // 4. Update Password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 5. Update User Record
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        // 6. Sync with Guru Model if user is a Guru
        if ($user->isGuru() && $user->guru) {
            $guruData = [
                'nama' => $validated['name'],
                'mata_pelajaran' => $validated['mata_pelajaran'],
                'nip' => $request->input('nip'),
                'no_hp' => $request->input('no_hp'),
            ];

            if ($user->foto) {
                $guruData['foto'] = $user->foto;
            }

            $user->guru->update($guruData);
        }

        // 7. Sync with Siswa Model if user is a Siswa
        if ($user->isSiswa() && $user->siswa) {
            $siswaData = [
                'nama' => $validated['name'],
            ];

            if ($user->foto) {
                $siswaData['foto'] = $user->foto;
            }

            $user->siswa->update($siswaData);
        }

        return redirect()->route('profile.edit')->with('success', 'Profil akun berhasil diperbarui! Perubahan data telah tersimpan di sistem.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/');
    }
}
