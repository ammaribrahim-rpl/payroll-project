<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Untuk transaksi
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawanList = Karyawan::with('user')->latest()->paginate(10);
        return view('admin.karyawan.index', compact('karyawanList'));
    }

    public function create()
    {
        return view('admin.karyawan.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nik' => 'required|string|max:20|unique:karyawan',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:15',
            'posisi' => 'required|string|max:100',
            'tanggal_masuk' => 'required|date',
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'karyawan',
            ]);

            $user->karyawan()->create([
                'nik' => $validatedData['nik'],
                'alamat' => $validatedData['alamat'],
                'no_telepon' => $validatedData['no_telepon'],
                'posisi' => $validatedData['posisi'],
                'tanggal_masuk' => $validatedData['tanggal_masuk'],
                'gaji_pokok' => $validatedData['gaji_pokok'],
            ]);

            DB::commit();
            return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage()); // Sebaiknya log errornya
            return back()->with('error', 'Gagal menambahkan karyawan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Karyawan $karyawan) // Route model binding
    {
        $karyawan->load('user', 'absensi', 'gaji'); // Eager load
        return view('admin.karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        $karyawan->load('user');
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($karyawan->user_id)],
            'password' => 'nullable|string|min:8|confirmed', // Password opsional saat update
            'nik' => ['required', 'string', 'max:20', Rule::unique('karyawan')->ignore($karyawan->id)],
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:15',
            'posisi' => 'required|string|max:100',
            'tanggal_masuk' => 'required|date',
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $karyawan->user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
            ]);

            if (!empty($validatedData['password'])) {
                $karyawan->user->update(['password' => Hash::make($validatedData['password'])]);
            }

            $karyawan->update([
                'nik' => $validatedData['nik'],
                'alamat' => $validatedData['alamat'],
                'no_telepon' => $validatedData['no_telepon'],
                'posisi' => $validatedData['posisi'],
                'tanggal_masuk' => $validatedData['tanggal_masuk'],
                'gaji_pokok' => $validatedData['gaji_pokok'],
            ]);

            DB::commit();
            return redirect()->route('admin.karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data karyawan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Karyawan $karyawan)
    {
        DB::beginTransaction();
        try {
            // Hati-hati: menghapus karyawan juga akan menghapus user terkait karena onDelete('cascade')
            // Pertimbangkan soft delete jika data user masih ingin disimpan atau jika ada foreign key lain
            $karyawan->user->delete(); // Hapus User dulu jika tidak cascade, atau biarkan jika cascade
            // $karyawan->delete(); // Akan terhapus juga jika user dihapus dengan cascade

            DB::commit();
            return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus karyawan: ' . $e->getMessage());
        }
    }
}