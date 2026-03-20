<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return Inertia::render('Users/Index', [
            'users' => User::with('roles')->get()
        ]);
    }

    public function show(User $user)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        
        $requests = $user->requests()
                ->latest()
                ->get();

        return Inertia::render('Users/Show', [
            'user' => $user,
            'requests' => $requests
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'role' => 'required|in:admin,cidadao'
        ]);

        if ($user->id === auth()->id()) {
            return back()->withErrors(['role' => 'Não podes alterar o teu próprio role.']);
        }

        $user->syncRoles([$request->role]);

        return back()->with('success', 'Role atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Não podes eliminar a tua própria conta.']);
        }

        $user->delete();

        return back()->with('success', 'Utilizador eliminado.');
    }
}