
        <!-- Formulario de filtrado -->
        <div class="p-4">
            <div class="mb-4">
                <form id="filtroForm" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <!-- Input para filtrar por número de formato -->
                    <div class="relative">
                        <input type="text" id="filtroNumeroFormato"
                            class="form-input rounded-lg pl-4 pr-10 py-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Buscar por Número de Formato">
                        <label for="filtroNumeroFormato"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600">
                            <svg class="h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9.293 10.707a1 1 0 0 0 1.414-1.414l5-5a1 1 0 1 0-1.414-1.414l-5 5a1 1 0 0 0 0 1.414z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </label>
                    </div>
                </form>
            </div>

            <!-- Lista de productos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="listaRecibos">
                <!-- Iteración sobre los productos para mostrarlos -->
                @forelse ($productos as $producto)
                    <div class="relative bg-gray-100 rounded-md overflow-hidden shadow-md recibo-container">
                        <div class="p-4 overflow-y-auto">
                            <!-- Detalles de cada producto -->
                            <h1 class="text-lg font-semibold">Código del producto</h1>
                            <p class="numero-formato">{{ $producto->sku }}</p>
                            <h1 class="text-lg font-semibold">Descripción</h1>
                            <p class="fecha">{{ $producto->description }}</p>
                            <h1 class="text-lg font-semibold">Peso neto</h1>
                            <p class="cliente">{{ $producto->net_weight }}</p>
                            <h1 class="text-lg font-semibold">Número de recibo:</h1>
                            <p>{{ $producto->order_num }}</p>
                            <!-- Dropdown para opciones adicionales -->
                            <div class="absolute top-0 right-0 m-2">
                                <div class="dropdown">
                                    <button class="btn " type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <!-- Opciones del dropdown -->
                                        <a href="{{ route('productos.index', ['order_num' => $producto->order_num]) }}"
                                            class="dropdown-item">Detalles
                                        </a>
                                        <a href="{{ route('etiqueta.index') }}" class="dropdown-item">Etiquetas
                                        </a>
                                        <form class="dropdown-item" id="marcarFinalizadoForm{{ $producto->order_num }}"
                                            action="{{ route('recibo.marcarFinalizado', ['order_num' => $producto->order_num]) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Estás seguro de que deseas marcar este recibo como finalizado?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="marcar-finalizado-btn">Finalizado</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Mensaje mostrado si no hay productos -->
                    <div class="w-full p-4">
                        <p class="text-gray-600">No hay datos disponibles</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Alerta de finalizado -->
    <div class="fixed bottom-0 right-0 p-6 mb-8 mr-8 bg-green-500 text-white rounded-md shadow-md hidden"
        id="finalizadoAlert">
        <p class="font-semibold">¡Recibo marcado como finalizado!</p>
    </div>


