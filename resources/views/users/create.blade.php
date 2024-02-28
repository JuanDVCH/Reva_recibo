<!-- resources/views/users/create.blade.php -->
<div class="container mx-auto my-8 p-4 bg-white rounded-md shadow-md max-w-md">
    <div class="flex items-center justify-center mb-4">
        <h2 class="text-2xl text-teal-500 font-semibold">Crear Nuevo Usuario</h2>
    </div>

    <form onsubmit="return validateForm()" method="post" action="{{ route('users.store') }}" class="grid grid-cols-1 gap-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre:</label>
            <input type="text" name="name" id="name" class="mt-1 p-2 w-full border rounded-md" required>
            <div class="text-red-500 text-sm mt-1" id="nameValidationMessage"></div>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico:</label>
            <input type="email" name="email" id="email" class="mt-1 p-2 w-full border rounded-md" required>
            <div class="text-red-500 text-sm mt-1" id="emailValidationMessage"></div>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña:</label>
            <input type="password" name="password" id="password" class="mt-1 p-2 w-full border rounded-md" required>
            <div class="text-red-500 text-sm mt-1" id="passwordValidationMessage"></div>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 p-2 w-full border rounded-md" required>
            <div class="text-red-500 text-sm mt-1" id="confirmPasswordValidationMessage"></div>
        </div>

        <div>
            <label for="roles" class="block text-sm font-medium text-gray-700">Roles:</label>
            <select name="roles[]" id="roles" multiple class="mt-1 p-2 w-full border rounded-md" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
            <div class="text-red-500 text-sm mt-1" id="rolesValidationMessage"></div>
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-md">Crear Usuario</button>
            <button type="button" class="bg-red-500 text-white ml-2 px-4 py-2 rounded-md hover:underline" onclick="clearForm()">Limpiar</button>
            <button type="button" class="text-gray-500 hover:text-gray-700 ml-2 px-4 py-2 rounded-md hover:underline" onclick="closeCreateModal()">Cerrar</button>
        </div>
    </form>
</div>

<script>
    function validateForm() {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;

        // Agrega aquí el código de validación

        return true; // Cambia esto si prefieres mostrar un mensaje de error en lugar de cerrar la ventana si la validación falla
    }

    function clearForm() {
        document.querySelectorAll('input, select').forEach(field => {
            field.value = '';
        });
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }
</script>
