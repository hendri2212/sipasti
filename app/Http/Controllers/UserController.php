<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function show(string $id = null) {
        $user = auth()->user();
        $avatar = $user->avatar_url ?? ('https://ui-avatars.com/api/?name=' . urlencode($user->name));
        $rawPhone = $user->phone ?? '';

        $onlyDigits = preg_replace('/[^0-9]/', '', $rawPhone);
        $waNumber = null;
        if ($onlyDigits) {
            $waNumber = substr($onlyDigits, 0, 1) === '0'
                ? '62' . substr($onlyDigits, 1)
                : $onlyDigits;
        }

        return view('users.profile', compact('user', 'avatar', 'rawPhone', 'waNumber'));
    }

    public function edit() {
        return view('users.password-edit'); // form ubah password
    }

    public function update(UpdatePasswordRequest $request) {
        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        // Opsional: keluarkan sesi lain (keamanan)
        // Auth::logoutOtherDevices($request->password);

        return redirect()->route('profile')->with('status', 'Password berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
