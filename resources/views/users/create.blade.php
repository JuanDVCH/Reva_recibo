<!-- resources/views/users/create.blade.php -->
<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white w-full max-w-md p-8 rounded-md shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-semibold text-green-500">Crear Nuevo Usuario</h2>
        </div>
        <form method="post" action="{{ route('users.store') }}" class="grid grid-cols-1 gap-4">
            <span class="cursor-pointer text-red-500 absolute top-0 right-0 mt-2 mr-2" onclick="closeCreateModal()">❌</span>

            @csrf
            <!-- Campos del formulario para crear usuario -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre:</label>
                <input type="text" name="name" id="name" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico:</label>
                <input type="email" name="email" id="email" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña:</label>
                <input type="password" name="password" id="password" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div>
                <label for="roles" class="block text-sm font-medium text-gray-700">Roles:</label>
                <select name="roles[]" id="roles" multiple class="mt-1 p-2 w-full border rounded-md">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Botones de acción -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Crear Usuario</button>
                <button type="button" class="text-red-500 ml-4 hover:underline" onclick="clearForm()">Limpiar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function clearForm() {
        // Obtener todos los campos del formulario y limpiarlos
        document.querySelectorAll('input, select').forEach(field => {
            field.value = '';
        });
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }
</script>
