<!-- resources/views/users/edit.blade.php -->

<div class="modal-content" id="editModalContent">
    <div class="container mx-auto my-8 bg-white p-8 rounded-md shadow-lg">
        <h1 class="text-3xl font-semibold mb-6">Editar Usuario</h1>
        <form method="post" action="{{ route('users.update', ['user' => $user->id]) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre:</label>
                <input type="text" id="name" name="name" value="{{ $user->name }}" class="mt-1 p-2 border rounded-md w-full">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="{{ $user->email }}" class="mt-1 p-2 border rounded-md w-full">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña:</label>
                <input type="password" id="password" name="password" class="mt-1 p-2 border rounded-md w-full">
            </div>

            <div class="mb-4">
                <label for="roles" class="block text-sm font-medium text-gray-700">Roles:</label>
                <select name="roles[]" id="roles" multiple class="mt-1 p-2 border rounded-md w-full">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ in_array($role->name, $userRoles) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2">Actualizar Usuario</button>
                <button type="button" class="text-red-500 ml-4 hover:underline" onclick="clearForm()">Limpiar</button>
                <button type="button" class="text-gray-500 hover:text-gray-700 ml-2 px-4 py-2 rounded-md hover:underline" onclick="closeModal()">Cerrar</button>

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


    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
