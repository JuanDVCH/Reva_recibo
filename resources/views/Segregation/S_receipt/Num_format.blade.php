<!-- Formulario de filtrado -->
<div class="mb-4">
    <form id="filtroForm" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <!-- Input para filtrar por número de formato -->
        <div class="relative">
            <input type="text" id="filtroNumeroFormato"
                class="form-input rounded-lg pl-4 pr-10 py-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                placeholder="Buscar por Número de Formato">
        </div>
        <!-- Input para filtrar por año -->
        <div class="relative">
            <input type="number" id="filtroAnio"
                class="form-input rounded-lg pl-4 pr-10 py-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                placeholder="Año">
        </div>
        <!-- Input para filtrar por cliente -->
        <div class="relative">
            <input type="text" id="filtroCliente"
                class="form-input rounded-lg pl-4 pr-10 py-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                placeholder="Buscar por Cliente">
        </div>
    </form>
</div>

<!-- Lista de recibos -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="listaRecibos">
    <!-- Iteración sobre los recibos para mostrarlos -->
    @forelse ($recibos as $recibo)
        <div class="relative bg-gray-100 rounded-md overflow-hidden shadow-md recibo-container">
            <div class="p-4 overflow-y-auto">
                <!-- Detalles de cada recibo -->
                <h1 class="text-lg font-semibold">Número de formato</h1>
                <p class="numero-formato">{{ $recibo->format_number }}</p>
                <h1 class="text-lg font-semibold">Fecha:</h1>
                <p class="fecha">{{ $recibo->delivery_date }}</p>
                <h1 class="text-lg font-semibold">Cliente:</h1>
                <p class="cliente">{{ $recibo->customer }}</p>
                <h1 class="text-lg font-semibold">Código del cliente:</h1>
                <p>{{ $recibo->code_customer }}</p>
                <!-- Dropdown para opciones adicionales -->
                <div class="absolute top-0 right-0 m-2">
                    <div class="dropdown">
                        <button class="btn " type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <!-- Opciones del dropdown -->
                            <a href="{{ route('productos.index', ['order_num' => $recibo->order_num]) }}"
                                class="dropdown-item">Detalles
                            </a>
                            <a href="{{ route('etiqueta.index') }}" class="dropdown-item">Etiquetas
                            </a>
                            <form class="dropdown-item" id="marcarFinalizadoForm{{ $recibo->order_num }}"
                                action="{{ route('recibo.marcarFinalizado', ['order_num' => $recibo->order_num]) }}"
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
        <!-- Mensaje mostrado si no hay recibos -->
        <div class="w-full p-4">
            <p class="text-gray-600">No hay datos disponibles</p>
        </div>
    @endforelse
</div>
