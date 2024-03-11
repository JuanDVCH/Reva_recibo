<!-- resources/views/users/create.blade.php -->
<div class="container mx-auto my-8 p-8 bg-white rounded-md shadow-md max-w-md">
    <div class="flex items-center justify-center mb-4">
        <h2 class="text-2xl text-teal-500 font-semibold">Crear Nuevo Usuario</h2>
    </div>

    <form onsubmit="return validateForm()" method="post" action="{{ route('users.store') }}"
        class="formulario-estilos row g-2">
        @csrf

        <div class="col-md-6">
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre:</label>
            <input type="text" name="name" id="name" class="mt-1 p-2 w-full border rounded-md"  required>
            <div class="text-red-500 text-sm mt-1" id="nameValidationMessage"></div>
        </div>

        <div class="col-md-6">
            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico:</label>
            <input type="email" name="email" id="email" class="mt-1 p-2 w-full border rounded-md" required>
            <div class="text-red-500 text-sm mt-1" id="emailValidationMessage"></div>
        </div>
        <div class="col-md-6">
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña:</label>
            <input type="password" id="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"
                title="La contraseña debe tener al menos 8 caracteres, incluyendo al menos una mayúscula, una minúscula y un número."
                class="mt-1 p-2 border rounded-md w-full">
            <small class="text-gray-500">La contraseña debe tener al menos 8 caracteres, incluyendo al menos una
                mayúscula, una minúscula y un número.</small>
        </div>

        <div class="col-md-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar
                Contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="mt-1 p-2 w-full border rounded-md" required>
            <div class="text-red-500 text-sm mt-1" id="confirmPasswordValidationMessage"></div>
        </div>

        <div class="col-md-6">
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
            <button type="button" class="bg-red-500 text-white ml-2 px-4 py-2 rounded-md hover:underline"
                onclick="clearForm()">Limpiar</button>
            <button type="button" class="text-gray-500 hover:text-gray-700 ml-2 px-4 py-2 rounded-md hover:underline"
                onclick="closeCreateModal()">Cerrar</button>
        </div>
    </form>
</div>

<script>
    function validateForm() {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;

        // Validación de contraseña
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

        if (!passwordRegex.test(password)) {
            document.getElementById('passwordValidationMessage').innerText =
                "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número.";
            return false;
        } else {
            document.getElementById('passwordValidationMessage').innerText = "";
        }

        // Validación de confirmación de contraseña
        if (password !== confirmPassword) {
            document.getElementById('confirmPasswordValidationMessage').innerText = "Las contraseñas no coinciden.";
            return false;
        } else {
            document.getElementById('confirmPasswordValidationMessage').innerText = "";
        }

        // Resto de la validación

        return true;
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
