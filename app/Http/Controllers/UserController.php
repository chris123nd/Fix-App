<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.data-user.index', [
            'title' => 'Data User',
            'users' => User::all(),
            'roles' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.data-user.tambah', [
            'title'     => 'Data User',
            'roles'     => Role::all(),
            'employees' => Employee::orderBy('nama')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Rules Validation
        $validatedData = $request->validate([
            'employee_id'   => 'required',
            'email'         => 'required|unique:users|email',
            'password'      => 'required|min:12|max:225|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{12,16}$/',
            'role_id'       => 'required'
        ],[
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 12 karakter',
            'password.max' => 'Password maksimal 16 karakter',
            'password.regex' => 'Password harus mengandung: 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 simbol (@$!%*?&)',
        ]);

        // #1 Cara dari WPU
        // $validatedData['password'] = bcrypt($validatedData['password']);

        // #2 Cara dari Laravel
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Simpan data yang berhasil lolos validasi
        User::create($validatedData);

        /** 
         *  jika data lolos validasi dan berhasil disimpan, maka tampilkan pesan
         *  setelah itu alihkan ke halaman login
         */
        return redirect('/users')->with('success', 'User Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.data-user.ubah', [
            'title' => 'Edit User',
            'user'  => User::find($id),
            'roles' => DB::table('roles')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi Form
        $validatedData = $request->validate([
            'name'      => 'required',
            'email'     => 'required',
            'role_id'   => 'required'
        ]);

        User::where('id', $id)->update($validatedData);
        // return redirect('/dashboard/posts')->with('success', 'Post Has Been Updated!');
        return redirect('/users')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect('/users')->with('success', 'Data berhasil dihapus');
    }

    function profile()
    {
        return view('dashboard.data-user.profile', [
            'title' => 'Data User',
            'users' => User::find(auth()->user()->id),
            'roles' => Role::all()
        ]);
    }
}
