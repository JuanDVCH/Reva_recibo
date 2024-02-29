<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class C_Users extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles')->where('state', 1);
        
        // Realizar búsqueda si se proporciona un término de búsqueda
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
    
        // Paginar los resultados y ordenar alfabéticamente
        $users = $query->orderBy('name')->paginate(12);
        $roles = Role::all();
    
        return view('users.index', compact('users', 'roles'));
    }
 
    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'roles' => 'required|array',
        ]);

        try {
            // Crear el nuevo usuario con la contraseña encriptada y estado 1
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'state' => 1, // Establecer el estado por defecto
            ]);

            // Asignar roles al usuario utilizando el nombre del rol
            $user->assignRole($request->input('roles'));

            // Redirigir a la vista de usuarios o a donde sea necesario
            return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente');
        } catch (\Exception $e) {
            // Manejar errores, por ejemplo, mostrar un mensaje de error
            return redirect()->back()->with('error', 'Error al crear usuario: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        // Obtén los roles actuales del usuario
        $userRoles = $user->roles->pluck('name')->toArray();

        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }


    public function update(Request $request, User $user)
    {
        // Aquí deberías agregar la lógica de validación y actualización
        // Ejemplo básico de validación (ajústalo según tus necesidades):
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id . '|max:255',
            'roles' => 'required|array',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        $user->syncRoles($request->input('roles'));

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente');
    }
    
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return redirect()->route('users.index')->with('error', 'Usuario no encontrado');
            }

            $user->update(['state' => 0]);

            return redirect()->route('users.index')->with('success', 'Usuario desactivado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Error al desactivar el usuario: ' . $e->getMessage());
        }
    }
}
