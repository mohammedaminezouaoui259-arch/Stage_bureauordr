<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // 🔥 PROTECTION
        // if (! \Illuminate\Support\Facades\Auth::check()) {
        //     return response()->json(['message' => 'Non authentifié'], 401);
        // }

        // if (\Illuminate\Support\Facades\Auth::user()->role != 'admin' && \Illuminate\Support\Facades\Auth::user()->role != 'manager') {
        //     return response()->json(['message' => 'Accès refusé'], 403);
        // }

        $users = User::with('nature')->orderBy('id', 'desc')->get();

        return response()->json($users);
    }

    public function store(Request $request)
    {
        // 🔥 PROTECTION (admin only)
        // if (! \Illuminate\Support\Facades\Auth::check() || \Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
        //     return response()->json(['message' => 'Accès refusé'], 403);
        // }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
            'service' => 'nullable',
            'nature_id' => 'nullable|exists:natures,id',
            'is_active' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'service' => $request->service,
            'nature_id' => $request->nature_id,
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'message' => 'Utilisateur ajouté avec succès',
            'user' => $user,
        ]);
    }

    public function show($id)
    {
        // 🔥 PROTECTION
        // if (! \Illuminate\Support\Facades\Auth::check() || (\Illuminate\Support\Facades\Auth::user()->role !== 'admin' && \Illuminate\Support\Facades\Auth::user()->role !== 'manager')) {
        //     return response()->json(['message' => 'Accès refusé'], 403);
        // }

        $user = User::with('nature')->findOrFail($id);

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        // 🔥 PROTECTION
        // if (! \Illuminate\Support\Facades\Auth::check() || (\Illuminate\Support\Facades\Auth::user()->role !== 'admin' && \Illuminate\Support\Facades\Auth::user()->role !== 'manager')) {
        //     return response()->json(['message' => 'Accès refusé'], 403);
        // }

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required',
            'service' => 'nullable',
            'nature_id' => 'nullable|exists:natures,id',
            'is_active' => 'required',
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'service' => $request->service,
            'nature_id' => $request->nature_id,
            'is_active' => $request->is_active,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Utilisateur modifié avec succès',
        ]);
    }

    public function destroy($id)
    {
        // 🔥 PROTECTION (admin only)
        // if (! \Illuminate\Support\Facades\Auth::check() || \Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
        //     return response()->json(['message' => 'Accès refusé'], 403);
        // }

        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => 'Utilisateur supprimé avec succès',
        ]);
    }
}