<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetUser;
use App\Models\User;

class AssetUserController extends Controller {
    public function index() {
        // Ambil data user beserta aset yang terkait
        $users = User::with(['assetUsers.asset'])
            ->whereHas('assetUsers')
            ->get();

        return view('users.role', compact('users'));
    }
}