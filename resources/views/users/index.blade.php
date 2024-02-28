@extends('layouts.app')

@section('content')
    <div class="container mx-auto my-8 p-8 bg-black-800 rounded-md shadow-md mb-16 mt-12">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-semibold text-gray-800">
                <i class="fas fa-users mr-2 text-dark"></i> Lista de Usuarios
            </h1>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" id="userFilter" placeholder="Buscar por nombre"
                        class="py-2 px-4 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
                <button id="createUserBtn"
                    class="bg-green-500 text-white py-2 px-4 rounded-full hover:bg-green-600 focus:outline-none focus:shadow-outline-green active:bg-green-700">
                    <i class="fas fa-user-plus mr-2"></i> Crear Usuario
                </button>
            </div>
        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($users as $user)
                @if ($user->id !== Auth::id())
                    <div class="bg-white rounded-md shadow-md overflow-hidden"
                        ondblclick="openEditModal('{{ route('users.edit', $user->id) }}')">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-800">
                                <i class="fas fa-user-circle mr-2 text-gray-600"></i> {{ $user->name }}
                            </h2>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <p class="text-sm text-gray-500 mt-2">Rol:
                                {{ implode(', ', $user->roles->pluck('name')->toArray()) }}</p>
                        </div>
                        <div class="flex justify-end p-4">
                            <form id="deleteUserForm" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    onclick="confirmDeactivateUser('{{ route('users.destroy', $user->id) }}')"
                                    class="bg-red-500 text-white py-2 px-4 rounded-full hover:bg-red-600 focus:outline-none focus:shadow-outline-red active:bg-red-700">
                                    Desactivar
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @empty
                <div class="w-full text-center text-gray-600">No hay usuarios registrados.</div>
            @endforelse

        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>

        <!-- Ventana modal para crear usuario -->
        <div id="createModal" class="modal hidden fixed inset-0 overflow-y-auto flex items-center mt-1 justify-center">
            @include('users.create')
        </div>


        <!-- Ventana modal para editar usuario -->
        <div id="editModal" class="modal hidden fixed inset-0 overflow-y-auto flex items-center mt-1 justify-center">
            <div id="editModalContent">
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
                var editModal = document.getElementById('editModal');
                var editModalContent = document.getElementById('editModalContent');

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
                confirmButtonColor: '#d33', // Color rojo
                cancelButtonColor: '#6c757d', // Ajusta el color según tu preferencia
                confirmButtonText: 'Sí, desactivar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Obtener el formulario por su ID
                    var form = document.getElementById('deleteUserForm');
                    // Enviar el formulario
                    form.submit();
                }
            });
        }


        document.addEventListener('DOMContentLoaded', function() {
            // ... (resto de tu script)

            // Añade un evento de escucha al campo de filtro
            document.getElementById('userFilter').addEventListener('input', function() {
                var filterValue = this.value.toLowerCase();
                var userCards = document.querySelectorAll('.bg-white.rounded-md.shadow-md');

                userCards.forEach(function(card) {
                    var userName = card.querySelector('.text-gray-800').textContent.toLowerCase();
                    if (userName.includes(filterValue)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        function closeEditModal() {
            // Ocultar la ventana modal y agregar la clase 'hidden'
            var editModal = document.getElementById('editModal');
            editModal.classList.add('hidden');

            // Limpiar el contenido de la ventana modal
            document.getElementById('editModalContent').innerHTML = '';
        }
        window.openEditModal = function(editRoute) {
            var editModal = document.getElementById('editModal');
            var editModalContent = document.getElementById('editModalContent');

            fetch(editRoute)
                .then(response => response.text())
                .then(data => {
                    editModalContent.innerHTML = data;

                    // Mostrar la ventana modal eliminando la clase 'hidden'
                    editModal.classList.remove('hidden');
                })
                .catch(error => console.error('Error al cargar el contenido de la modal:', error));
        };
        function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
    </script>
@endsection
