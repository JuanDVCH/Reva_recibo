<!-- resources/views/users/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mx-auto my-8 p-8 bg-white rounded-md shadow-md mb-16">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-semibold">Lista de Usuarios</h1>
            <button id="createUserBtn" class="btn-green">Crear Usuario</button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-md">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Nombre</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Rol</th>
                        <th class="py-2 px-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}"
                            ondblclick="openEditModal('{{ route('users.edit', $user->id) }}')">
                            <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                            <td class="py-2 px-4 border-b">{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                            <td class="py-2 px-4 border-b">
                                <button type="button" class="btn-red" onclick="confirmDeactivateUser('{{ route('users.destroy', $user->id) }}')">Desactivar</button>
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td class="py-2 px-4 text-center text-gray-600" colspan="5">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Ventana modal para crear usuario -->
        <div id="createModal" class="modal hidden fixed inset-0 overflow-y-auto flex items-center mt-1 justify-center">
            @include('users.create')
        </div>

        <!-- Ventana modal para editar usuario -->
        <div id="editModal" class="modal hidden fixed inset-0 overflow-y-auto flex items-center mt-1 justify-center">
            <div id="editModalContent" >
                <!-- Contenido del formulario de edición (users.edit) -->
                <!-- Asegúrate de incluir el botón de cancelar (cancelEditBtn) para cerrar la ventana modal -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('createUserBtn').addEventListener('click', function() {
                document.getElementById('createModal').classList.remove('hidden');
            });

            // Función para abrir la ventana modal de edición con la ruta correspondiente
            window.openEditModal = function(editRoute) {
                // Asegúrate de que exista el modal de edición
                var editModal = document.getElementById('editModal');
                var editModalContent = document.getElementById('editModalContent');

                // Ejemplo con AJAX (usando fetch)
                fetch(editRoute)
                    .then(response => response.text())
                    .then(data => {
                        editModalContent.innerHTML = data;
                        editModal.classList.remove('hidden');
                    })
                    .catch(error => console.error('Error al cargar el contenido de la modal:', error));
            };

            // Asegúrate de que exista el botón de cancelar en el modal de edición
            document.getElementById('cancelEditBtn').addEventListener('click', function() {
                document.getElementById('editModal').classList.add('hidden');
            });
        });

        function confirmDeactivateUser(route) {
            Swal.fire({
                title: '¿Seguro que quieres desactivar a este usuario?',
                text: "Esta acción cambiará el estado del usuario a inactivo.",
                iconHtml: '<i class="fas fa-exclamation-triangle"></i>',
                showCancelButton: true,
                confirmButtonColor: '#d33',  // Color rojo
                cancelButtonColor: '#6c757d',  // Ajusta el color según tu preferencia
                confirmButtonText: 'Sí, desactivar',
                cancelButtonText: 'Cancelar'  

            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviar el formulario
                    document.location.href = route;
                }
            });
        }
    </script>
@endsection
