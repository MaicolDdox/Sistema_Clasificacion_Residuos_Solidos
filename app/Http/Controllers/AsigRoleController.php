<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Http\Requests\AsignRoleStoreRequest;
use App\Http\Requests\AsignRoleUpdateRequest;

class AsigRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Si la petición es AJAX (desde DataTable)
        if ($request->ajax()) {
            $users = User::with('roles')->get()->map(function ($user) {
                // Obtener roles del usuario
                $rolesNames = $user->roles->pluck('name')->toArray();
                $rolesDisplay = !empty($rolesNames)
                    ? implode(', ', $rolesNames)
                    : 'Sin rol';

                return [
                    'id'           => $user->id,
                    'name'         => Str::limit($user->name, 30),
                    'email'        => $user->email,
                    'roles'        => $rolesDisplay,
                    'created_at'   => $user->created_at->format('Y-m-d'),
                    'acciones'     => view('roles.partials.roles-actions', compact('user'))->render(),
                ];
            });

            return response()->json(['data' => $users]);
        }

        // Si no es AJAX, devuelve la vista normal, siguiendo la convencion tuya Maicol, espero no se rompa.
        return view('roles.roles-list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::role('Invitado')->get();
        $roles = Role::all();

        return view('roles.roles-create', compact('users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AsignRoleStoreRequest $request)
    {

        $validated = $request->validated();

        $user = User::findOrFail($validated['user_id']);

        // Remover roles anteriores y asignar el nuevo
        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Rol asignado correctamente al usuario ' . $user->name);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $currentRole = $user->roles->first();

        return view('roles.roles-edit', compact('user', 'roles', 'currentRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AsignRoleUpdateRequest $request, $id)
    {

        $validated = $request->validated();

        $user = User::findOrFail($id);

        // Sincronizar rol (reemplaza el actual)
        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Rol actualizado correctamente para el usuario ' . $user->name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;

        // Remover todos los roles del usuario
        $user->syncRoles([]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Roles removidos del usuario ' . $userName);
    }
}
