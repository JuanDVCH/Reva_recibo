@extends('layouts.app')

@section('content')
    <!-- Encabezado de la sección -->
    <div class="container mx-auto mt-5 mb-8">
        <!-- Encabezado de la sección -->
        <div class="bg-white rounded-md overflow-hidden shadow-md">
            <div class="p-4 flex justify-between items-center bg-teal rounded-t-md">
                <h3 class="text-4xl font-semibold text-white"><i class="fas fa-list-alt"></i> Formatos de recibo del área de
                    segregación</h3>
            </div>
        </div>
    </div>


    <div class="container mx-auto flex justify-center items-start">
        <!-- Selector de vista -->
        <div class="flex flex-col justify-start items-start mr-8">
            <div id="vistaRecibos"
                class="text-lg font-medium text-gray-700 cursor-pointer border-b-2 border-transparent hover:border-indigo-500 transition duration-300 ease-in-out flex items-center px-4 py-2 rounded-md mb-4">
                <span class="mr-2"><i class="fas fa-receipt"></i></span>
                <span class="block uppercase tracking-wide">Productos por segregar</span>
            </div>
            <div id="vistaOtra"
                class="text-lg font-medium text-gray-700 cursor-pointer border-b-2 border-transparent hover:border-indigo-500 transition duration-300 ease-in-out flex items-center px-4 py-2 rounded-md">
                <span class="mr-2"><i class="fas fa-cogs"></i></span>
                <span class="block uppercase tracking-wide">Formato de segregación</span>
            </div>
        </div>

        <!-- Área de visualización -->
        <div id="vistaContainer" class="bg-white rounded-md shadow-md flex-grow p-4">
            <!-- Aquí se cargará la vista seleccionada -->
        </div>
    </div>

    <!-- Elemento para mostrar el nombre de la vista seleccionada -->
    <div id="nombreVistaSeleccionada" class="text-center text-gray-600 mt-4"></div>

    <script>
        // Función para cargar la vista de Recibos al cargar la página
        window.addEventListener('load', function() {
            loadView("{{ route('Segregation.recibo.product_for_segregation') }}", "Recibos");
            // Marcar la opción de Recibos como seleccionada al cargar la página
            document.getElementById('vistaRecibos').classList.add('selected');
        });

        // Evento click para cargar la vista de Recibos
        document.getElementById('vistaRecibos').addEventListener('click', function() {
            loadView("{{ route('Segregation.recibo.product_for_segregation') }}", "Recibo del producto");
            // Remover la clase 'selected' de todas las opciones
            document.querySelectorAll('.flex div').forEach(opcion => {
                opcion.classList.remove('selected');
            });
            // Agregar la clase 'selected' solo a la opción de Recibos
            this.classList.add('selected');
        });

        // Evento click para cargar la otra vista
        document.getElementById('vistaOtra').addEventListener('click', function() {
            loadView("{{ route('Segregation.recibo.Num_format') }}", "Formato de segregación");
            // Remover la clase 'selected' de todas las opciones
            document.querySelectorAll('.flex div').forEach(opcion => {
                opcion.classList.remove('selected');
            });
            // Agregar la clase 'selected' solo a la opción de Otra vista
            this.classList.add('selected');
        });

        // Función para cargar las vistas y mostrar el nombre de la vista seleccionada
        function loadView(route, nombreVista) {
            fetch(route)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('vistaContainer').innerHTML = data;
                    // Actualizar el nombre de la vista seleccionada
                    document.getElementById('nombreVistaSeleccionada').textContent = nombreVista;
                })
                .catch(error => {
                    console.error('Error al cargar la vista:', error);
                });
        }
    </script>
@endsection
